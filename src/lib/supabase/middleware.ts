import { createServerClient, type CookieOptions } from "@supabase/ssr";
import { NextResponse, type NextRequest } from "next/server";
import { isAllowedEmail } from "@/lib/constants";

/**
 * すべてのリクエストでセッションを更新し、認証ガードをかける。
 * - 未ログインでポータルへ来たら /login へ。
 * - @fort410.jp 以外のアカウントは即サインアウトさせ弾く（ドメイン二重チェックの一段）。
 */
export async function updateSession(request: NextRequest) {
  let supabaseResponse = NextResponse.next({ request });

  const url = process.env.NEXT_PUBLIC_SUPABASE_URL;
  const anonKey = process.env.NEXT_PUBLIC_SUPABASE_ANON_KEY;

  const pathnameEarly = request.nextUrl.pathname;
  const isAuthRouteEarly =
    pathnameEarly === "/login" || pathnameEarly.startsWith("/auth");

  // 環境変数が未設定（Supabase セットアップ前）の場合：
  // 保護ルートは 500 になるため、ログイン画面へ誘導する。
  if (!url || !anonKey) {
    if (isAuthRouteEarly) return supabaseResponse;
    const redirectUrl = request.nextUrl.clone();
    redirectUrl.pathname = "/login";
    return NextResponse.redirect(redirectUrl);
  }

  const supabase = createServerClient(url, anonKey, {
    cookies: {
      getAll() {
        return request.cookies.getAll();
      },
      setAll(
        cookiesToSet: {
          name: string;
          value: string;
          options: CookieOptions;
        }[],
      ) {
        cookiesToSet.forEach(({ name, value }) =>
          request.cookies.set(name, value),
        );
        supabaseResponse = NextResponse.next({ request });
        cookiesToSet.forEach(({ name, value, options }) =>
          supabaseResponse.cookies.set(name, value, options),
        );
      },
    },
  });

  const {
    data: { user },
  } = await supabase.auth.getUser();

  const pathname = request.nextUrl.pathname;
  const isAuthRoute =
    pathname === "/login" || pathname.startsWith("/auth");

  // ログイン済みだがドメイン不許可 → サインアウトして弾く
  if (user && !isAllowedEmail(user.email)) {
    await supabase.auth.signOut();
    const redirectUrl = request.nextUrl.clone();
    redirectUrl.pathname = "/login";
    redirectUrl.searchParams.set("error", "domain");
    return NextResponse.redirect(redirectUrl);
  }

  // 未ログインで保護ルートへ → /login
  if (!user && !isAuthRoute) {
    const redirectUrl = request.nextUrl.clone();
    redirectUrl.pathname = "/login";
    return NextResponse.redirect(redirectUrl);
  }

  // ログイン済みで /login に来たら → トップへ
  if (user && pathname === "/login") {
    const redirectUrl = request.nextUrl.clone();
    redirectUrl.pathname = "/";
    return NextResponse.redirect(redirectUrl);
  }

  return supabaseResponse;
}
