"use client";

import * as React from "react";
import { useRouter } from "next/navigation";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { ATTENDANCE_STATUSES } from "@/lib/constants";
import { shortTime } from "@/lib/date";
import type { Attendance } from "@/types/database";
import { quickClock, saveAttendance } from "./actions";
import { LogIn, LogOut, Check } from "lucide-react";

/** 今日の打刻カード（出勤・退勤ボタン） */
export function ClockCard({ record }: { record: Attendance | null }) {
  const router = useRouter();
  const [pending, setPending] = React.useState<null | "in" | "out">(null);
  const [error, setError] = React.useState<string | null>(null);

  async function clock(intent: "in" | "out") {
    setPending(intent);
    setError(null);
    const res = await quickClock(intent);
    setPending(null);
    if (res.ok) router.refresh();
    else setError(res.error ?? "記録に失敗しました。");
  }

  return (
    <div className="fort-card p-5">
      <p className="eyebrow">TODAY</p>
      <div className="mt-3 flex flex-wrap items-end gap-6">
        <div>
          <p className="text-xs text-sub">出勤</p>
          <p className="font-heading text-2xl font-semibold text-ink">
            {shortTime(record?.clock_in)}
          </p>
        </div>
        <div>
          <p className="text-xs text-sub">退勤</p>
          <p className="font-heading text-2xl font-semibold text-ink">
            {shortTime(record?.clock_out)}
          </p>
        </div>
        <div>
          <p className="text-xs text-sub">状態</p>
          <p className="text-base font-medium text-ink">
            {record?.status ?? "未記録"}
          </p>
        </div>
      </div>

      <div className="mt-4 flex gap-3">
        <Button onClick={() => clock("in")} disabled={pending !== null}>
          <LogIn className="h-4 w-4" />
          {pending === "in" ? "記録中…" : "出勤"}
        </Button>
        <Button
          variant="outline"
          onClick={() => clock("out")}
          disabled={pending !== null}
        >
          <LogOut className="h-4 w-4" />
          {pending === "out" ? "記録中…" : "退勤"}
        </Button>
      </div>
      {error && <p className="mt-2 text-xs text-[#A85A52]">{error}</p>}
    </div>
  );
}

/** 今日の勤怠を手入力で修正するフォーム */
export function AttendanceForm({
  today,
  record,
}: {
  today: string;
  record: Attendance | null;
}) {
  const router = useRouter();
  const [pending, setPending] = React.useState(false);
  const [message, setMessage] = React.useState<string | null>(null);
  const [error, setError] = React.useState<string | null>(null);

  async function onSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    setPending(true);
    setMessage(null);
    setError(null);
    const res = await saveAttendance(new FormData(e.currentTarget));
    setPending(false);
    if (res.ok) {
      setMessage("保存しました。");
      router.refresh();
    } else {
      setError(res.error ?? "保存に失敗しました。");
    }
  }

  return (
    <form onSubmit={onSubmit} className="fort-card space-y-4 p-5">
      <p className="eyebrow">手入力で修正（本日）</p>
      <input type="hidden" name="work_date" value={today} />

      <div className="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div className="space-y-1.5">
          <Label htmlFor="clock_in">出勤</Label>
          <Input
            id="clock_in"
            name="clock_in"
            type="time"
            defaultValue={shortTime(record?.clock_in) === "—" ? "" : shortTime(record?.clock_in)}
          />
        </div>
        <div className="space-y-1.5">
          <Label htmlFor="clock_out">退勤</Label>
          <Input
            id="clock_out"
            name="clock_out"
            type="time"
            defaultValue={shortTime(record?.clock_out) === "—" ? "" : shortTime(record?.clock_out)}
          />
        </div>
        <div className="space-y-1.5">
          <Label htmlFor="break_minutes">休憩(分)</Label>
          <Input
            id="break_minutes"
            name="break_minutes"
            type="number"
            min={0}
            defaultValue={record?.break_minutes ?? 60}
          />
        </div>
        <div className="space-y-1.5">
          <Label htmlFor="status">状態</Label>
          <select
            id="status"
            name="status"
            defaultValue={record?.status ?? "出勤"}
            className="flex h-9 w-full rounded-md border border-line bg-card px-2 text-sm text-ink shadow-card focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
          >
            {ATTENDANCE_STATUSES.map((s) => (
              <option key={s} value={s}>
                {s}
              </option>
            ))}
          </select>
        </div>
      </div>

      <div className="space-y-1.5">
        <Label htmlFor="note">メモ</Label>
        <Input
          id="note"
          name="note"
          defaultValue={record?.note ?? ""}
          placeholder="備考（任意）"
        />
      </div>

      <div className="flex items-center gap-3">
        <Button type="submit" variant="outline" disabled={pending}>
          {pending ? "保存中…" : "保存"}
        </Button>
        {message && (
          <span className="flex items-center gap-1 text-sm text-[#5B7355]">
            <Check className="h-4 w-4" />
            {message}
          </span>
        )}
        {error && <span className="text-sm text-[#A85A52]">{error}</span>}
      </div>
    </form>
  );
}
