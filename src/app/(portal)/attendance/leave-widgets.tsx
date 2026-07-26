"use client";

import * as React from "react";
import { useRouter } from "next/navigation";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Label } from "@/components/ui/label";
import { LEAVE_TYPES } from "@/lib/constants";
import { todayJST } from "@/lib/date";
import { createLeaveRequest, cancelLeaveRequest } from "./actions";
import { Plus, X } from "lucide-react";

/** 休暇申請フォーム */
export function LeaveForm() {
  const router = useRouter();
  const [open, setOpen] = React.useState(false);
  const [pending, setPending] = React.useState(false);
  const [error, setError] = React.useState<string | null>(null);
  const today = todayJST();

  async function onSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    setPending(true);
    setError(null);
    const res = await createLeaveRequest(new FormData(e.currentTarget));
    setPending(false);
    if (res.ok) {
      setOpen(false);
      router.refresh();
    } else {
      setError(res.error ?? "申請に失敗しました。");
    }
  }

  if (!open) {
    return (
      <Button onClick={() => setOpen(true)}>
        <Plus className="h-4 w-4" />
        休暇を申請
      </Button>
    );
  }

  return (
    <form onSubmit={onSubmit} className="fort-card space-y-4 p-5">
      <p className="eyebrow">新しい休暇申請</p>

      <div className="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div className="space-y-1.5">
          <Label htmlFor="leave_type">種類</Label>
          <select
            id="leave_type"
            name="leave_type"
            className="flex h-9 w-full rounded-md border border-line bg-card px-2 text-sm text-ink shadow-card focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
          >
            {LEAVE_TYPES.map((t) => (
              <option key={t} value={t}>
                {t}
              </option>
            ))}
          </select>
        </div>
        <div className="space-y-1.5">
          <Label htmlFor="start_date">開始日</Label>
          <Input id="start_date" name="start_date" type="date" defaultValue={today} required />
        </div>
        <div className="space-y-1.5">
          <Label htmlFor="end_date">終了日</Label>
          <Input id="end_date" name="end_date" type="date" defaultValue={today} />
        </div>
      </div>

      <div className="space-y-1.5">
        <Label htmlFor="reason">理由（任意）</Label>
        <Textarea id="reason" name="reason" placeholder="例：私用のため" />
      </div>

      {error && <p className="text-sm text-[#A85A52]">{error}</p>}

      <div className="flex gap-3">
        <Button type="submit" disabled={pending}>
          {pending ? "申請中…" : "申請する"}
        </Button>
        <Button type="button" variant="ghost" onClick={() => setOpen(false)}>
          キャンセル
        </Button>
      </div>
    </form>
  );
}

/** 申請取消ボタン（本人・申請中のみ） */
export function CancelLeaveButton({ id }: { id: string }) {
  const router = useRouter();
  const [pending, setPending] = React.useState(false);

  async function onClick() {
    if (!confirm("この申請を取り消しますか？")) return;
    setPending(true);
    const res = await cancelLeaveRequest(id);
    setPending(false);
    if (res.ok) router.refresh();
    else alert(res.error ?? "取消に失敗しました。");
  }

  return (
    <Button size="sm" variant="ghost" onClick={onClick} disabled={pending}>
      <X className="h-4 w-4" />
      取消
    </Button>
  );
}
