import { redirect } from "next/navigation";
import { getCurrentEmployee } from "@/lib/auth";
import { createClient } from "@/lib/supabase/server";
import { TabNav } from "@/components/ui/tabs";
import { LeaveStatusPill } from "@/components/status-pill";
import { attendanceTabs } from "../tabs";
import { LeaveForm, CancelLeaveButton } from "../leave-widgets";
import { formatDateJP } from "@/lib/date";
import type { LeaveRequest, LeaveBalance } from "@/types/database";
import type { Permission } from "@/lib/constants";

export const dynamic = "force-dynamic";

function rangeLabel(r: LeaveRequest): string {
  if (r.start_date === r.end_date) return formatDateJP(r.start_date);
  return `${formatDateJP(r.start_date)} 〜 ${formatDateJP(r.end_date)}`;
}

export default async function LeavePage() {
  const employee = await getCurrentEmployee();
  if (!employee) redirect("/login?error=unregistered");

  const supabase = await createClient();

  const { data: reqData } = await supabase
    .from("leave_requests")
    .select("*")
    .eq("employee_id", employee.id)
    .order("start_date", { ascending: false })
    .limit(50);
  const requests = (reqData ?? []) as LeaveRequest[];

  const { data: balData } = await supabase
    .from("leave_balances")
    .select("*")
    .eq("employee_id", employee.id)
    .order("fiscal_label", { ascending: false });
  const balances = (balData ?? []) as LeaveBalance[];

  return (
    <div className="space-y-6">
      <div>
        <p className="eyebrow">ATTENDANCE</p>
        <h1 className="mt-1 font-heading text-2xl font-semibold text-ink">
          勤怠・休日
        </h1>
      </div>

      <TabNav items={attendanceTabs(employee.permission as Permission, "leave")} />

      {/* 有給残 */}
      {balances.length > 0 && (
        <div className="grid grid-cols-1 gap-3 sm:grid-cols-3">
          {balances.map((b) => {
            const remain = Number(b.granted_days) - Number(b.used_days);
            return (
              <div key={b.id} className="fort-card p-4">
                <p className="eyebrow">{b.fiscal_label} ・ 有給残</p>
                <p className="mt-1 font-heading text-2xl font-semibold text-ink">
                  {remain}
                  <span className="ml-1 text-sm text-sub">日</span>
                </p>
                <p className="mt-0.5 text-xs text-sub">
                  付与 {b.granted_days} ／ 消化 {b.used_days}
                </p>
              </div>
            );
          })}
        </div>
      )}

      <LeaveForm />

      {/* 申請一覧 */}
      <div>
        <h2 className="mb-2 text-sm font-semibold text-ink">申請の履歴</h2>
        {requests.length === 0 ? (
          <div className="fort-card p-8 text-center text-sm text-sub">
            まだ休暇の申請はありません。
          </div>
        ) : (
          <ul className="fort-card divide-y divide-line">
            {requests.map((r) => (
              <li
                key={r.id}
                className="flex flex-wrap items-center justify-between gap-3 px-5 py-3"
              >
                <div className="flex items-center gap-3">
                  <LeaveStatusPill status={r.status} />
                  <span className="text-sm font-medium text-ink">
                    {r.leave_type}
                  </span>
                  <span className="text-sm text-sub">{rangeLabel(r)}</span>
                  {r.reason && (
                    <span className="text-xs text-sub">（{r.reason}）</span>
                  )}
                </div>
                {r.status === "申請中" && <CancelLeaveButton id={r.id} />}
              </li>
            ))}
          </ul>
        )}
      </div>
    </div>
  );
}
