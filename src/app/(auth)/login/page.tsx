import { LoginForm } from "./login-form";

const ERROR_MESSAGES: Record<string, string> = {
  domain:
    "@fort410.jp のGoogleアカウントでログインしてください。別ドメインのアカウントは利用できません。",
  unregistered:
    "このアカウントは社員マスタに登録されていません。総務にお問い合わせください。",
  auth: "ログインに失敗しました。もう一度お試しください。",
};

export default async function LoginPage({
  searchParams,
}: {
  searchParams: Promise<{ error?: string }>;
}) {
  const { error } = await searchParams;
  const message = error ? ERROR_MESSAGES[error] ?? ERROR_MESSAGES.auth : null;

  return (
    <main className="flex min-h-screen items-center justify-center bg-bg px-6">
      <div className="w-full max-w-sm">
        {/* ロゴ */}
        <div className="mb-10 text-center">
          <div className="mb-3 flex items-baseline justify-center gap-2">
            <span className="font-heading text-3xl font-extrabold tracking-widest text-ink">
              FORT
            </span>
            <span className="text-xs font-medium tracking-label text-sub">
              PORTAL
            </span>
          </div>
          <p className="text-sm text-sub">社内ポータル</p>
        </div>

        <div className="fort-card p-8">
          <p className="eyebrow">SIGN IN</p>
          <h1 className="mt-1 font-heading text-xl font-semibold text-ink">
            ログイン
          </h1>
          <p className="mt-2 text-sm leading-relaxed text-sub">
            会社のGoogleアカウント（@fort410.jp）でログインしてください。
          </p>

          {message && (
            <div className="mt-5 rounded-md bg-[#F3E4E2] px-4 py-3 text-sm text-[#A85A52]">
              {message}
            </div>
          )}

          <div className="mt-6">
            <LoginForm />
          </div>
        </div>

        <p className="mt-8 text-center text-xs leading-relaxed text-sub">
          ログインできない場合は総務までお問い合わせください。
          <br />
          岡山本社 ・ 福山スタジオ
        </p>
      </div>
    </main>
  );
}
