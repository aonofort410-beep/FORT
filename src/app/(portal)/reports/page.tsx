import Link from "next/link";
import { redirect } from "next/navigation";
import { getCurrentEmployee } from "@/lib/auth";
import { createClient } from "@/lib/supabase/server";
import { TabNav } from "@/components/ui/tabs";
import { Button } from "@/components/ui/button";
import { SubmitPill } from "@/components/status-pill";
import { reportTabs } from "./tabs";
import { todayJST, formatDateJP } from "@/lib/date";
import type { DailyReport } from "@/types/database";
import type { Permission } from "@/lib/constants";
import { ChevronRight, PenLine } from "lucide-react";

export const dynamic = "force-dynamic";

export default async function MyReportsPage() {
  const employee = await getCurrentEmployee();
  if (!employee) redirect("/login?error=unregistered");

  const supabase = await createClient();
  const { data } = await supabase
    .from("daily_reports")
    .select("*")
    .eq("employee_id", employee.id)
    .order("report_date", { ascending: false })
    .limit(60);

  const reports = (data ?? []) as DailyReport[];
  const today = todayJST();
  const todayReport = reports.find((r) => r.report_date === today) ?? null;

  return (
    <div className="space-y-6">
      <div>
        <p className="eyebrow">REPORTS</p>
        <h1 className="mt-1 font-heading text-2xl font-semibold text-ink">日報</h1>
      </div>

      <TabNav items={reportTabs(employee.permission as Permission, "mine")} />

      {/* 今日の日報 */}
      <div className="fort-card flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <p className="text-sm text-sub">今日 ・ {formatDateJP(today)}</p>
          <p className="mt-1 flex items-center gap-2 font-medium text-ink">
            本日の日報
            <SubmitPill submitted={!!todayReport?.submitted} />
          </p>
        </div>
        <Button asChild>
          <Link href={`/reports/${today}`}>
            <PenLine className="h-4 w-4" />
            {todayReport ? "続きを書く・修正" : "今日の日報を書く"}
          </Link>
        </Button>
      </div>

      {/* 履歴 */}
      <div>
        <h2 className="mb-2 text-sm font-semibold text-ink">これまでの日報</h2>
        {reports.length === 0 ? (
          <div className="fort-card p-8 text-center text-sm text-sub">
            まだ日報がありません。まずは今日の日報を書いてみましょう。
          </div>
        ) : (
          <ul className="fort-card divide-y divide-line">
            {reports.map((r) => (
              <li key={r.id}>
                <Link
                  href={`/reports/${r.report_date}`}
                  className="flex items-center justify-between gap-3 px-5 py-3 hover:bg-muted/50"
                >
                  <span className="flex items-center gap-3">
                    <span className="w-28 text-sm text-ink">
                      {formatDateJP(r.report_date)}
                    </span>
                    <SubmitPill submitted={r.submitted} />
                    {r.base && (
                      <span className="text-xs text-sub">{r.base}</span>
                    )}
                  </span>
                  <ChevronRight className="h-4 w-4 text-sub" />
                </Link>
              </li>
            ))}
          </ul>
        )}
      </div>
    </div>
  );
}
