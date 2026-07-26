import { Construction } from "lucide-react";

/**
 * 未実装ページの「準備中」表示。
 * 次のPhaseで中身を差し込む（docs/06_roadmap.md）。
 */
export function ComingSoon({
  title,
  eyebrow,
  phase,
  description,
}: {
  title: string;
  eyebrow: string;
  phase: number;
  description?: string;
}) {
  return (
    <div className="flex min-h-[60vh] flex-col items-center justify-center text-center">
      <div className="flex h-14 w-14 items-center justify-center rounded-full bg-muted text-sub">
        <Construction className="h-6 w-6" />
      </div>
      <p className="eyebrow mt-6">{eyebrow}</p>
      <h1 className="mt-1 font-heading text-2xl font-semibold text-ink">
        {title}
      </h1>
      <span className="pill pill--warn mt-4">準備中</span>
      <p className="mt-4 max-w-sm text-sm leading-relaxed text-sub">
        {description ??
          `この機能は Phase ${phase} で実装予定です。土台（Phase 0）が整い次第、順番に追加していきます。`}
      </p>
    </div>
  );
}
