"use client";

import * as React from "react";
import { useRouter } from "next/navigation";
import { Button } from "@/components/ui/button";
import { Textarea } from "@/components/ui/textarea";
import { Label } from "@/components/ui/label";
import { BASES, REPORT_SLOTS } from "@/lib/constants";
import type { DailyReport } from "@/types/database";
import { saveDailyReport } from "./actions";
import { Save, Send, Check } from "lucide-react";

export function ReportForm({
  date,
  report,
  defaultBase,
}: {
  date: string;
  report: DailyReport | null;
  defaultBase: string | null;
}) {
  const router = useRouter();
  const [pending, setPending] = React.useState<null | "draft" | "submit">(null);
  const [message, setMessage] = React.useState<string | null>(null);
  const [error, setError] = React.useState<string | null>(null);

  async function handle(intent: "draft" | "submit", formEl: HTMLFormElement) {
    setPending(intent);
    setMessage(null);
    setError(null);
    const fd = new FormData(formEl);
    fd.set("intent", intent);
    const res = await saveDailyReport(fd);
    setPending(null);
    if (res.ok) {
      setMessage(res.submitted ? "提出しました。" : "下書きを保存しました。");
      router.refresh();
    } else {
      setError(res.error ?? "保存に失敗しました。");
    }
  }

  return (
    <form
      className="space-y-6"
      onSubmit={(e) => {
        e.preventDefault();
      }}
    >
      <input type="hidden" name="report_date" value={date} />

      {/* 拠点 */}
      <div className="max-w-xs space-y-1.5">
        <Label htmlFor="base">その日の主な拠点</Label>
        <select
          id="base"
          name="base"
          defaultValue={report?.base ?? defaultBase ?? ""}
          className="flex h-9 w-full rounded-md border border-line bg-card px-3 text-sm text-ink shadow-card focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
        >
          <option value="">選択しない</option>
          {BASES.map((b) => (
            <option key={b} value={b}>
              {b}
            </option>
          ))}
        </select>
      </div>

      {/* 予定・実績 */}
      <div className="space-y-5">
        {REPORT_SLOTS.map((slot) => (
          <div key={slot.key} className="fort-card p-4">
            <p className="eyebrow mb-3">{slot.label}</p>
            <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
              <div className="space-y-1.5">
                <Label htmlFor={`plan_${slot.key}`}>予定</Label>
                <Textarea
                  id={`plan_${slot.key}`}
                  name={`plan_${slot.key}`}
                  defaultValue={
                    (report?.[`plan_${slot.key}` as keyof DailyReport] as
                      | string
                      | null) ?? ""
                  }
                  placeholder="例：【岡山】10:00〜 堀田様邸 打合せ"
                />
              </div>
              <div className="space-y-1.5">
                <Label htmlFor={`result_${slot.key}`}>実績</Label>
                <Textarea
                  id={`result_${slot.key}`}
                  name={`result_${slot.key}`}
                  defaultValue={
                    (report?.[`result_${slot.key}` as keyof DailyReport] as
                      | string
                      | null) ?? ""
                  }
                  placeholder="実際に行ったこと"
                />
              </div>
            </div>
          </div>
        ))}
      </div>

      {/* メッセージ */}
      {message && (
        <div className="flex items-center gap-2 rounded-md bg-[#EAEEE7] px-4 py-2.5 text-sm text-[#5B7355]">
          <Check className="h-4 w-4" />
          {message}
        </div>
      )}
      {error && (
        <div className="rounded-md bg-[#F3E4E2] px-4 py-2.5 text-sm text-[#A85A52]">
          {error}
        </div>
      )}

      {/* 操作 */}
      <div className="flex flex-wrap items-center gap-3">
        <Button
          type="button"
          variant="outline"
          disabled={pending !== null}
          onClick={(e) => handle("draft", e.currentTarget.form!)}
        >
          <Save className="h-4 w-4" />
          {pending === "draft" ? "保存中…" : "下書き保存"}
        </Button>
        <Button
          type="button"
          disabled={pending !== null}
          onClick={(e) => handle("submit", e.currentTarget.form!)}
        >
          <Send className="h-4 w-4" />
          {pending === "submit" ? "提出中…" : "提出する"}
        </Button>
        {report?.submitted && (
          <span className="text-xs text-sub">
            提出済み（あとから修正・再提出できます）
          </span>
        )}
      </div>
    </form>
  );
}
