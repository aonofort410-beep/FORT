import { redirect } from "next/navigation";
import { getCurrentEmployee } from "@/lib/auth";
import { createClient } from "@/lib/supabase/server";
import { TabNav } from "@/components/ui/tabs";
import { DayNav } from "@/components/date-nav";
import { SubmitPill } from "@/components/status-pill";
import { reportTabs } from "../tabs";
import { todayJST } from "@/lib/date";
import {
  canApprove,
  canViewAll,
  DEPARTMENT_COLORS,
  REPORT_SLOTS,
  type Permission,
} from "@/lib/constants";
import type { DailyReport, Employee } from "@/types/database";

export const dynamic = "force-dynamic";

export default async function TeamReportsPage({
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

  // 閲覧対象の社員（総務・経営＝全員、管理職＝同部署）
  let empQuery = supabase
    .from("employees")
    .select("*")
    .eq("is_active", true)
    .order("employee_no");
  if (!canViewAll(permission)) {
    empQuery = empQuery.eq("dept", employee.dept ?? "");
  }
  const { data: empData } = await empQuery;
  const members = (empData ?? []) as Employee[];

  // その日の日報（RLS で閲覧可能なものだけ返る）
  const { data: repData } = await supabase
    .from("daily_reports")
    .select("*")
    .eq("report_date", date);
  const byEmp = new Map<string, DailyReport>();
  for (const r of (repData ?? []) as DailyReport[]) byEmp.set(r.employee_id, r);

  return (
    <div className="space-y-6">
      <div>
        <p className="eyebrow">REPORTS</p>
        <h1 className="mt-1 font-heading text-2xl font-semibold text-ink">日報</h1>
      </div>

      <TabNav items={reportTabs(permission, "team")} />

      <div className="flex items-center justify-between">
        <DayNav basePath="/reports/team" date={date} />
        <span className="text-sm text-sub">
          {members.filter((m) => byEmp.get(m.id)?.submitted).length}／
          {members.length} 名 提出
        </span>
      </div>

      <div className="space-y-3">
        {members.map((m) => {
          const r = byEmp.get(m.id);
          return (
            <div key={m.id} className="fort-card p-4">
              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2">
                  <span
                    className="inline-block h-2 w-2 rounded-full"
                    style={{
                      backgroundColor:
                        DEPARTMENT_COLORS[m.dept ?? ""] ?? "#B8B7B0",
                    }}
                  />
                  <span className="font-medium text-ink">{m.name}</span>
                  <span className="text-xs text-sub">
                    {m.dept}
                    {m.role_title ? ` ・ ${m.role_title}` : ""}
                  </span>
                </div>
                <SubmitPill submitted={!!r?.submitted} />
              </div>

              {r ? (
                <div className="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-3">
                  {REPORT_SLOTS.map((slot) => {
                    const plan = r[`plan_${slot.key}` as keyof DailyReport] as
                      | string
                      | null;
                    const result = r[
                      `result_${slot.key}` as keyof DailyReport
                    ] as string | null;
                    if (!plan && !result) {
                      return (
                        <div key={slot.key} className="text-xs text-sub/60">
                          <p className="eyebrow mb-1">{slot.label}</p>—
                        </div>
                      );
                    }
                    return (
                      <div key={slot.key} className="text-xs">
                        <p className="eyebrow mb-1">{slot.label}</p>
                        {plan && (
                          <p className="text-ink">
                            <span className="text-sub">予定：</span>
                            {plan}
                          </p>
                        )}
                        {result && (
                          <p className="mt-0.5 text-ink">
                            <span className="text-sub">実績：</span>
                            {result}
                          </p>
                        )}
                      </div>
                    );
                  })}
                </div>
              ) : (
                <p className="mt-2 text-xs text-sub">
                  この日の日報はまだありません。
                </p>
              )}
            </div>
          );
        })}
        {members.length === 0 && (
          <div className="fort-card p-8 text-center text-sm text-sub">
            対象の社員がいません。
          </div>
        )}
      </div>
    </div>
  );
}
