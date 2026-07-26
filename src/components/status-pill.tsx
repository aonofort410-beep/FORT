import { cn } from "@/lib/utils";
import type { LeaveStatus } from "@/types/database";

type Tone = "ok" | "warn" | "late" | "urgent" | "muted";

const TONE_CLASS: Record<Tone, string> = {
  ok: "pill pill--ok",
  warn: "pill pill--warn",
  late: "pill pill--late",
  urgent: "pill pill--urgent",
  muted: "pill pill--muted",
};

export function Pill({
  tone,
  children,
  className,
}: {
  tone: Tone;
  children: React.ReactNode;
  className?: string;
}) {
  return <span className={cn(TONE_CLASS[tone], className)}>{children}</span>;
}

/** 休暇申請ステータスのピル */
export function LeaveStatusPill({ status }: { status: LeaveStatus }) {
  const tone: Tone =
    status === "承認"
      ? "ok"
      : status === "申請中"
        ? "warn"
        : status === "差戻し"
          ? "late"
          : "urgent"; // 却下
  return <Pill tone={tone}>{status}</Pill>;
}

/** 提出状況のピル */
export function SubmitPill({ submitted }: { submitted: boolean }) {
  return submitted ? (
    <Pill tone="ok">提出済</Pill>
  ) : (
    <Pill tone="warn">未提出</Pill>
  );
}
