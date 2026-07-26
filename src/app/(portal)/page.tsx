import Link from "next/link";
import { getCurrentEmployee } from "@/lib/auth";
import { createClient } from "@/lib/supabase/server";
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Pill, SubmitPill } from "@/components/status-pill";
import {
  PERMISSION_LABELS,
  canApprove,
  canViewAll,
  DEPARTMENT_COLORS,
  type Permission,
} from "@/lib/constants";
import { todayJST, shortTime } from "@/lib/date";
import type { Attendance, DailyReport, Employee } from "@/types/database";
import {
  CalendarOff,
  FileText,
  Clock,
  FileCheck2,
  CalendarCheck,
  AlertTriangle,
  ArrowRight,
} from "lucide-react";

export const dynamic = "force-dynamic";

function givenName(name: string) {
  const parts = name.trim().split(/[\s　]+/);
  return parts.length > 1 ? parts[parts.length - 1] : name;
}
function greeting() {
  const h = new Date(
    new Date().toLocaleString("en-US", { timeZone: "Asia/Tokyo" }),
  ).getHours();
  if (h < 5) return "おつかれさまです";
  if (h < 11) return "おはようございます";
  if (h < 18) return "こんにちは";
  return "おつかれさまです";
}

/** 次Phaseで中身が入るサマリー枠 */
function SoonSlot({
  eyebrow,
  title,
  icon: Icon,
  phase,
}: {
  eyebrow: string;
  title: string;
  icon: React.ComponentType<{ className?: string }>;
  phase: number;
}) {
  return (
    <Card>
      <CardHeader className="flex-row items-center justify-between space-y-0 pb-3">
        <div>
          <p className="eyebrow">{eyebrow}</p>
          <CardTitle className="mt-1 text-base">{title}</CardTitle>
        </div>
        <div className="flex h-9 w-9 items-center justify-center rounded-md bg-muted text-sub">
          <Icon className="h-[18px] w-[18px]" />
        </div>
      </CardHeader>
      <CardContent>
        <div className="flex items-center gap-2">
          <span className="pill pill--warn">準備中</span>
          <span className="text-xs text-sub">Phase {phase} で表示</span>
        </div>
      </CardContent>
    </Card>
  );
}

export default async function DashboardPage() {
  const employee = await getCurrentEmployee();
  const name = employee?.name ?? "";
  const permission = (employee?.permission ?? "member") as Permission;
  const today = todayJST();

  const supabase = await createClient();

  // 本日休みの人（全社共有・氏名のみ）
  const { data: offData } = await supabase.rpc("off_today");
  const offSeen = new Set<string>();
  const offToday = ((offData ?? []) as { employee_id: string; name: string; dept: string; label: string }[]).filter(
    (o) => {
      if (offSeen.has(o.employee_id)) return false;
      offSeen.add(o.employee_id);
      return true;
    },
  );

  // 自分の今日：日報・勤怠
  let myReport: DailyReport | null = null;
  let myAttendance: Attendance | null = null;
  if (employee) {
    const { data: r } = await supabase
      .from("daily_reports")
      .select("*")
      .eq("employee_id", employee.id)
      .eq("report_date", today)
      .maybeSingle();
    myReport = (r as DailyReport | null) ?? null;
    const { data: a } = await supabase
      .from("attendance")
      .select("*")
      .eq("employee_id", employee.id)
      .eq("work_date", today)
      .maybeSingle();
    myAttendance = (a as Attendance | null) ?? null;
  }

  // 管理職・総務・経営：未提出・承認待ちの集計
  let unsubmitted: Employee[] = [];
  let pendingApprovals = 0;
  const showTeam = employee ? canApprove(permission) : false;
  if (employee && showTeam) {
    let empQ = supabase
      .from("employees")
      .select("*")
      .eq("is_active", true)
      .order("employee_no");
    if (!canViewAll(permission)) empQ = empQ.eq("dept", employee.dept ?? "");
    const { data: emps } = await empQ;
    const members = (emps ?? []) as Employee[];

    const { data: reps } = await supabase
      .from("daily_reports")
      .select("employee_id, submitted")
      .eq("report_date", today);
    const submitted = new Set(
      ((reps ?? []) as Pick<DailyReport, "employee_id" | "submitted">[])
        .filter((x) => x.submitted)
        .map((x) => x.employee_id),
    );
    const offIds = new Set(offToday.map((o) => o.employee_id));
    unsubmitted = members.filter(
      (m) => !submitted.has(m.id) && !offIds.has(m.id),
    );

    const { data: pend } = await supabase
      .from("leave_requests")
      .select("id")
      .eq("status", "申請中");
    pendingApprovals = (pend ?? []).length;
  }

  return (
    <div className="space-y-8">
      {/* あいさつ */}
      <div>
        <p className="eyebrow">DASHBOARD</p>
        <h1 className="mt-1 font-heading text-2xl font-semibold text-ink">
          {greeting()}、{givenName(name)} さん。
        </h1>
        <p className="mt-2 text-sm text-sub">
          {[employee?.base, employee?.dept, employee?.role_title]
            .filter(Boolean)
            .join(" ・ ")}
          {employee && (
            <span className="ml-2 text-xs">
              （権限：{PERMISSION_LABELS[permission]}）
            </span>
          )}
        </p>
      </div>

      {/* 自分の今日 */}
      <section>
        <h2 className="mb-3 text-sm font-semibold text-ink">あなたの今日</h2>
        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
          {/* 日報 */}
          <Card>
            <CardHeader className="flex-row items-center justify-between space-y-0 pb-3">
              <div>
                <p className="eyebrow">MY REPORT</p>
                <CardTitle className="mt-1 text-base">今日の日報</CardTitle>
              </div>
              <div className="flex h-9 w-9 items-center justify-center rounded-md bg-muted text-sub">
                <FileText className="h-[18px] w-[18px]" />
              </div>
            </CardHeader>
            <CardContent className="flex items-center justify-between">
              <SubmitPill submitted={!!myReport?.submitted} />
              <Button asChild variant="ghost" size="sm">
                <Link href={`/reports/${today}`}>
                  {myReport?.submitted ? "修正する" : "書く"}
                  <ArrowRight className="h-4 w-4" />
                </Link>
              </Button>
            </CardContent>
          </Card>

          {/* 勤怠 */}
          <Card>
            <CardHeader className="flex-row items-center justify-between space-y-0 pb-3">
              <div>
                <p className="eyebrow">MY ATTENDANCE</p>
                <CardTitle className="mt-1 text-base">今日の勤怠</CardTitle>
              </div>
              <div className="flex h-9 w-9 items-center justify-center rounded-md bg-muted text-sub">
                <Clock className="h-[18px] w-[18px]" />
              </div>
            </CardHeader>
            <CardContent className="flex items-center justify-between">
              <span className="text-sm text-ink">
                出勤 {shortTime(myAttendance?.clock_in)} ／ 退勤{" "}
                {shortTime(myAttendance?.clock_out)}
              </span>
              <Button asChild variant="ghost" size="sm">
                <Link href="/attendance">
                  打刻
                  <ArrowRight className="h-4 w-4" />
                </Link>
              </Button>
            </CardContent>
          </Card>
        </div>
      </section>

      {/* 今日の状況 */}
      <section>
        <h2 className="mb-3 text-sm font-semibold text-ink">今日の状況</h2>
        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
          {/* 本日休み */}
          <Card>
            <CardHeader className="flex-row items-center justify-between space-y-0 pb-3">
              <div>
                <p className="eyebrow">OFF TODAY</p>
                <CardTitle className="mt-1 text-base">本日休みの人</CardTitle>
              </div>
              <div className="flex h-9 w-9 items-center justify-center rounded-md bg-muted text-sub">
                <CalendarOff className="h-[18px] w-[18px]" />
              </div>
            </CardHeader>
            <CardContent>
              {offToday.length === 0 ? (
                <p className="text-sm text-sub">全員出勤予定です。</p>
              ) : (
                <div className="flex flex-wrap gap-1.5">
                  {offToday.map((o) => (
                    <span
                      key={o.employee_id}
                      className="inline-flex items-center gap-1 rounded-full border border-line px-2 py-0.5 text-xs text-ink"
                    >
                      <span
                        className="inline-block h-1.5 w-1.5 rounded-full"
                        style={{
                          backgroundColor:
                            DEPARTMENT_COLORS[o.dept ?? ""] ?? "#B8B7B0",
                        }}
                      />
                      {o.name}
                    </span>
                  ))}
                </div>
              )}
            </CardContent>
          </Card>

          {/* 日報未提出（権限者のみ実値、他は準備中案内なし＝個人カードで代替） */}
          {showTeam ? (
            <Card>
              <CardHeader className="flex-row items-center justify-between space-y-0 pb-3">
                <div>
                  <p className="eyebrow">REPORTS</p>
                  <CardTitle className="mt-1 text-base">日報 未提出</CardTitle>
                </div>
                <div className="flex h-9 w-9 items-center justify-center rounded-md bg-muted text-sub">
                  <FileText className="h-[18px] w-[18px]" />
                </div>
              </CardHeader>
              <CardContent>
                {unsubmitted.length === 0 ? (
                  <Pill tone="ok">全員提出済み</Pill>
                ) : (
                  <>
                    <p className="font-heading text-2xl font-semibold text-ink">
                      {unsubmitted.length}
                      <span className="ml-1 text-sm text-sub">名</span>
                    </p>
                    <div className="mt-1.5 flex flex-wrap gap-1">
                      {unsubmitted.slice(0, 6).map((m) => (
                        <span key={m.id} className="text-xs text-sub">
                          {m.name}
                        </span>
                      ))}
                      {unsubmitted.length > 6 && (
                        <span className="text-xs text-sub">…</span>
                      )}
                    </div>
                    <Link
                      href="/reports/status"
                      className="mt-2 inline-flex items-center gap-1 text-xs text-bronze hover:underline"
                    >
                      提出状況を見る
                      <ArrowRight className="h-3 w-3" />
                    </Link>
                  </>
                )}
              </CardContent>
            </Card>
          ) : (
            <Card>
              <CardHeader className="flex-row items-center justify-between space-y-0 pb-3">
                <div>
                  <p className="eyebrow">REPORTS</p>
                  <CardTitle className="mt-1 text-base">日報</CardTitle>
                </div>
                <div className="flex h-9 w-9 items-center justify-center rounded-md bg-muted text-sub">
                  <FileText className="h-[18px] w-[18px]" />
                </div>
              </CardHeader>
              <CardContent>
                <Link
                  href="/reports"
                  className="inline-flex items-center gap-1 text-sm text-bronze hover:underline"
                >
                  自分の日報を見る
                  <ArrowRight className="h-3 w-3" />
                </Link>
              </CardContent>
            </Card>
          )}

          {/* 承認待ち（権限者のみ実値） */}
          {showTeam ? (
            <Card>
              <CardHeader className="flex-row items-center justify-between space-y-0 pb-3">
                <div>
                  <p className="eyebrow">APPROVALS</p>
                  <CardTitle className="mt-1 text-base">承認待ち</CardTitle>
                </div>
                <div className="flex h-9 w-9 items-center justify-center rounded-md bg-muted text-sub">
                  <FileCheck2 className="h-[18px] w-[18px]" />
                </div>
              </CardHeader>
              <CardContent>
                {pendingApprovals === 0 ? (
                  <Pill tone="ok">なし</Pill>
                ) : (
                  <Link href="/attendance/approvals" className="block">
                    <p className="font-heading text-2xl font-semibold text-ink">
                      {pendingApprovals}
                      <span className="ml-1 text-sm text-sub">件</span>
                    </p>
                    <span className="mt-1 inline-flex items-center gap-1 text-xs text-bronze hover:underline">
                      承認する
                      <ArrowRight className="h-3 w-3" />
                    </span>
                  </Link>
                )}
              </CardContent>
            </Card>
          ) : (
            <SoonSlot
              eyebrow="RESERVATIONS"
              title="本日の予約"
              icon={CalendarCheck}
              phase={2}
            />
          )}

          {/* 遅延案件（Phase 2） */}
          <SoonSlot
            eyebrow="DELAYED"
            title="遅延案件"
            icon={AlertTriangle}
            phase={2}
          />
        </div>
      </section>

      {/* これから入るエリア */}
      <section className="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <Card className="lg:col-span-2">
          <CardHeader>
            <p className="eyebrow">MY TASKS</p>
            <CardTitle className="text-base">やること・承認待ち</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="flex min-h-[120px] flex-col items-center justify-center gap-2 text-center">
              <span className="pill pill--warn">準備中</span>
              <p className="text-sm text-sub">
                タスクと承認は Phase 3 でここに集約されます。
              </p>
            </div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader>
            <p className="eyebrow">NOTICE</p>
            <CardTitle className="text-base">お知らせ</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="flex min-h-[120px] flex-col items-center justify-center gap-2 text-center">
              <span className="pill pill--muted">まだありません</span>
              <p className="text-sm text-sub">
                社内のお知らせは Phase 4 で表示されます。
              </p>
            </div>
          </CardContent>
        </Card>
      </section>
    </div>
  );
}
