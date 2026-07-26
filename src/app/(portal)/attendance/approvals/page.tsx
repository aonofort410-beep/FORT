import { redirect } from "next/navigation";
import { getCurrentEmployee } from "@/lib/auth";
import { createClient } from "@/lib/supabase/server";
import { TabNav } from "@/components/ui/tabs";
import { LeaveStatusPill } from "@/components/status-pill";
import { attendanceTabs } from "../tabs";
import { ApproveButtons } from "../approve-buttons";
import { formatDateJP } from "@/lib/date";
import { canApprove, type Permission } from "@/lib/constants";
import type { LeaveRequest, Employee } from "@/types/database";

export const dynamic = "force-dynamic";

function rangeLabel(r: LeaveRequest): string {
  if (r.start_date === r.end_date) return formatDateJP(r.start_date);
  return `${formatDateJP(r.start_date)} 〜 ${formatDateJP(r.end_date)}`;
}

export default async function ApprovalsPage() {
  const employee = await getCurrentEmployee();
  if (!employee) redirect("/login?error=unregistered");
  const permission = employee.permission as Permission;
  if (!canApprove(permission)) redirect("/attendance");

  const supabase = await createClient();

  // 閲覧可能な休暇申請（RLS：本人・部署管理職・総務・経営）
  const { data: reqData } = await supabase
    .from("leave_requests")
    .select("*")
    .order("created_at", { ascending: false })
    .limit(100);
  const requests = (reqData ?? []) as LeaveRequest[];

  // 申請者・承認者の氏名解決
  const { data: empData } = await supabase
    .from("employees")
    .select("id, name, dept");
  const nameOf = new Map<string, Employee>();
  for (const e of (empData ?? []) as Employee[]) nameOf.set(e.id, e);

  const pending = requests.filter((r) => r.status === "申請中");
  const decided = requests.filter((r) => r.status !== "申請中");

  return (
    <div className="space-y-6">
      <div>
        <p className="eyebrow">ATTENDANCE</p>
        <h1 className="mt-1 font-heading text-2xl font-semibold text-ink">
          勤怠・休日
        </h1>
      </div>

      <TabNav items={attendanceTabs(permission, "approvals")} />

      {/* 承認待ち */}
      <div>
        <h2 className="mb-2 flex items-center gap-2 text-sm font-semibold text-ink">
          承認待ち
          {pending.length > 0 && (
            <span className="pill pill--warn">{pending.length}</span>
          )}
        </h2>
        {pending.length === 0 ? (
          <div className="fort-card p-8 text-center text-sm text-sub">
            承認待ちの申請はありません。
          </div>
        ) : (
          <div className="space-y-3">
            {pending.map((r) => {
              const applicant = nameOf.get(r.employee_id);
              return (
                <div
                  key={r.id}
                  className="fort-card flex flex-col gap-3 p-4 lg:flex-row lg:items-center lg:justify-between"
                >
                  <div>
                    <div className="flex items-center gap-2">
                      <span className="font-medium text-ink">
                        {applicant?.name ?? "―"}
                      </span>
                      <span className="text-xs text-sub">
                        {applicant?.dept}
                      </span>
                      <span className="pill pill--muted">{r.leave_type}</span>
                    </div>
                    <p className="mt-1 text-sm text-ink">{rangeLabel(r)}</p>
                    {r.reason && (
                      <p className="mt-0.5 text-xs text-sub">理由：{r.reason}</p>
                    )}
                  </div>
                  <ApproveButtons id={r.id} />
                </div>
              );
            })}
          </div>
        )}
      </div>

      {/* 処理済み */}
      {decided.length > 0 && (
        <div>
          <h2 className="mb-2 text-sm font-semibold text-ink">処理済み</h2>
          <ul className="fort-card divide-y divide-line">
            {decided.slice(0, 30).map((r) => {
              const applicant = nameOf.get(r.employee_id);
              const approver = r.approver_id ? nameOf.get(r.approver_id) : null;
              return (
                <li
                  key={r.id}
                  className="flex flex-wrap items-center justify-between gap-3 px-5 py-3"
                >
                  <div className="flex items-center gap-3">
                    <LeaveStatusPill status={r.status} />
                    <span className="text-sm font-medium text-ink">
                      {applicant?.name ?? "―"}
                    </span>
                    <span className="text-xs text-sub">{r.leave_type}</span>
                    <span className="text-sm text-sub">{rangeLabel(r)}</span>
                  </div>
                  {approver && (
                    <span className="text-xs text-sub">
                      承認者：{approver.name}
                    </span>
                  )}
                </li>
              );
            })}
          </ul>
        </div>
      )}
    </div>
  );
}
