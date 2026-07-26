import { redirect } from "next/navigation";
import { getCurrentEmployee } from "@/lib/auth";
import { createClient } from "@/lib/supabase/server";
import { TabNav } from "@/components/ui/tabs";
import { DayNav } from "@/components/date-nav";
import { Pill } from "@/components/status-pill";
import { reportTabs } from "../tabs";
import { todayJST } from "@/lib/date";
import {
  canApprove,
  canViewAll,
  DEPARTMENTS,
  type Permission,
} from "@/lib/constants";
import type { DailyReport, Employee } from "@/types/database";

export const dynamic = "force-dynamic";

export default async function ReportStatusPage({
  searchParams,
}: {
  searchParams: Promise<{ date?: string }>;
}) {
  const employee = await getCurrentEmployee();
  if (!employee) redirect("/login?error=unregistered");
  const permission = employee.permission as Permission;
  if (!canApprove(permission)) redirect("/reports");

  const { date: dateParam } = await searchParams;
  const date = dateParam && /^\d{4}-\d{2}-\d{2}$/.test(dateParam) ? dateParam : todayJST();

  const supabase = await createClient();

  let empQuery = supabase
    .from("employees")
    .select("*")
    .eq("is_active", true)
    .order("employee_no");
  if (!canViewAll(permission)) empQuery = empQuery.eq("dept", employee.dept ?? "");
  const { data: empData } = await empQuery;
  const members = (empData ?? []) as Employee[];

  const { data: repData } = await supabase
    .from("daily_reports")
    .select("employee_id, submitted")
    .eq("report_date", date);
  const submittedIds = new Set(
    ((repData ?? []) as Pick<DailyReport, "employee_id" | "submitted">[])
      .filter((r) => r.submitted)
      .map((r) => r.employee_id),
  );

  // 部署別集計
  const depts = canViewAll(permission)
    ? [...DEPARTMENTS]
    : [employee.dept ?? "—"];
  const byDept = depts.map((d) => {
    const inDept = members.filter((m) => (m.dept ?? "—") === d);
    const done = inDept.filter((m) => submittedIds.has(m.id)).length;
    return { dept: d, total: inDept.length, done };
  });

  const notSubmitted = members.filter((m) => !submittedIds.has(m.id));
  const totalDone = members.filter((m) => submittedIds.has(m.id)).length;

  return (
    <div className="space-y-6">
      <div>
        <p className="eyebrow">REPORTS</p>
        <h1 className="mt-1 font-heading text-2xl font-semibold text-ink">日報</h1>
      </div>

      <TabNav items={reportTabs(permission, "status")} />

      <div className="flex flex-wrap items-center justify-between gap-3">
        <DayNav basePath="/reports/status" date={date} />
        <span className="text-sm text-ink">
          全体 {totalDone}／{members.length} 名 提出（未提出 {notSubmitted.length} 名）
        </span>
      </div>

      {/* 部署別提出率 */}
      <div className="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
        {byDept
          .filter((d) => d.total > 0)
          .map((d) => {
            const rate = d.total === 0 ? 0 : Math.round((d.done / d.total) * 100);
            return (
              <div key={d.dept} className="fort-card p-4">
                <div className="flex items-baseline justify-between">
                  <span className="font-medium text-ink">{d.dept}</span>
                  <span className="font-heading text-lg font-semibold text-ink">
                    {rate}
                    <span className="text-xs text-sub">%</span>
                  </span>
                </div>
                <div className="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-muted">
                  <div
                    className="h-full rounded-full bg-olive"
                    style={{ width: `${rate}%` }}
                  />
                </div>
                <p className="mt-1.5 text-xs text-sub">
                  {d.done}／{d.total} 名
                </p>
              </div>
            );
          })}
      </div>

      {/* 未提出者 */}
      <div>
        <h2 className="mb-2 text-sm font-semibold text-ink">未提出の人</h2>
        {notSubmitted.length === 0 ? (
          <div className="fort-card flex items-center gap-2 p-5 text-sm">
            <Pill tone="ok">全員提出済み</Pill>
            <span className="text-sub">この日は全員が日報を提出しています。</span>
          </div>
        ) : (
          <div className="fort-card flex flex-wrap gap-2 p-4">
            {notSubmitted.map((m) => (
              <span
                key={m.id}
                className="inline-flex items-center gap-1.5 rounded-full border border-line px-2.5 py-1 text-sm text-ink"
              >
                {m.name}
                <span className="text-xs text-sub">{m.dept}</span>
              </span>
            ))}
          </div>
        )}
      </div>
    </div>
  );
}
