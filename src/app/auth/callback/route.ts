import { NextResponse } from "next/server";
import { createClient } from "@/lib/supabase/server";
import { isAllowedEmail } from "@/lib/constants";

/**
 * Google OAuth のコールバック。
 * - 認可コードをセッションに交換。
 * - @fort410.jp 以外はサインアウトして弾く（ドメイン二重チェックの一段）。
 * - 社員マスタに存在しない場合も弾く（招待リスト方式：最も堅い）。
 */
export async function GET(request: Request) {
  const { searchParams, origin } = new URL(request.url);
  const code = searchParams.get("code");
  const next = searchParams.get("next") ?? "/";

  if (!code) {
    return NextResponse.redirect(`${origin}/login?error=auth`);
  }

  const supabase = await createClient();
  const { error } = await supabase.auth.exchangeCodeForSession(code);
  if (error) {
    return NextResponse.redirect(`${origin}/login?error=auth`);
  }

  const {
    data: { user },
  } = await supabase.auth.getUser();

  // ドメイン検証（末尾一致だけに頼らない厳密判定）
  if (!user || !isAllowedEmail(user.email)) {
    await supabase.auth.signOut();
    return NextResponse.redirect(`${origin}/login?error=domain`);
  }

  // 招待リスト（employees.email 一致）に無ければ弾く
  const { data: employee } = await supabase
    .from("employees")
    .select("id")
    .ilike("email", user.email!)
    .maybeSingle();

  if (!employee) {
    await supabase.auth.signOut();
    return NextResponse.redirect(`${origin}/login?error=unregistered`);
  }

  return NextResponse.redirect(`${origin}${next}`);
}
