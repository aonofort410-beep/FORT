import { redirect } from "next/navigation";
import { getCurrentEmployee } from "@/lib/auth";
import { createClient } from "@/lib/supabase/server";
import { TabNav } from "@/components/ui/tabs";
import { MonthNav } from "@/components/date-nav";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { ClockCard, AttendanceForm } from "./attendance-widgets";
import { attendanceTabs } from "./tabs";
import {
  todayJST,
  currentMonthJST,
  monthRange,
  formatDateJP,
  shortTime,
} from "@/lib/date";
import type { Attendance } from "@/types/database";
import type { Permission } from "@/lib/constants";

export const dynamic = "force-dynamic";

/** 労働時間（分）を計算：退勤−出勤−休憩 */
function workedMinutes(a: Attendance): number | null {
  if (!a.clock_in || !a.clock_out) return null;
  const [ih, im] = a.clock_in.split(":").map(Number);
  const [oh, om] = a.clock_out.split(":").map(Number);
  const mins = oh * 60 + om - (ih * 60 + im) - (a.break_minutes ?? 0);
  return mins > 0 ? mins : 0;
}

function fmtHM(mins: number | null): string {
  if (mins == null) return "—";
  return `${Math.floor(mins / 60)}:${String(mins % 60).padStart(2, "0")}`;
}

export default async function AttendancePage({
  searchParams,
}: {
  searchParams: Promise<{ month?: string }>;
}) {
  const employee = await getCurrentEmployee();
  if (!employee) redirect("/login?error=unregistered");

  const { month: monthParam } = await searchParams;
  const month =
    monthParam && /^\d{4}-\d{2}$/.test(monthParam) ? monthParam : currentMonthJST();
  const { start, end } = monthRange(month);
  const today = todayJST();

  const supabase = await createClient();

  const { data: monthData } = await supabase
    .from("attendance")
    .select("*")
    .eq("employee_id", employee.id)
    .gte("work_date", start)
    .lte("work_date", end)
    .order("work_date", { ascending: false });
  const rows = (monthData ?? []) as Attendance[];
  const todayRecord = rows.find((r) => r.work_date === today) ?? null;

  const totalWorked = rows.reduce((sum, r) => sum + (workedMinutes(r) ?? 0), 0);

  return (
    <div className="space-y-6">
      <div>
        <p className="eyebrow">ATTENDANCE</p>
        <h1 className="mt-1 font-heading text-2xl font-semibold text-ink">
          勤怠・休日
        </h1>
      </div>

      <TabNav items={attendanceTabs(employee.permission as Permission, "mine")} />

      <div className="grid grid-cols-1 gap-4 lg:grid-cols-2">
        <ClockCard record={todayRecord} />
        <AttendanceForm today={today} record={todayRecord} />
      </div>

      {/* 月別一覧 */}
      <div className="space-y-3">
        <div className="flex flex-wrap items-center justify-between gap-3">
          <MonthNav basePath="/attendance" month={month} />
          <span className="text-sm text-sub">
            出勤 {rows.length} 日 ・ 合計 {fmtHM(totalWorked)}
          </span>
        </div>

        <div className="fort-card">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>日付</TableHead>
                <TableHead>状態</TableHead>
                <TableHead>出勤</TableHead>
                <TableHead>退勤</TableHead>
                <TableHead>休憩</TableHead>
                <TableHead>実働</TableHead>
                <TableHead>メモ</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {rows.length === 0 ? (
                <TableRow>
                  <TableCell colSpan={7} className="py-8 text-center text-sub">
                    この月の勤怠記録はまだありません。
                  </TableCell>
                </TableRow>
              ) : (
                rows.map((r) => (
                  <TableRow key={r.id}>
                    <TableCell className="whitespace-nowrap text-ink">
                      {formatDateJP(r.work_date)}
                    </TableCell>
                    <TableCell className="text-sub">{r.status}</TableCell>
                    <TableCell>{shortTime(r.clock_in)}</TableCell>
                    <TableCell>{shortTime(r.clock_out)}</TableCell>
                    <TableCell>{r.break_minutes ?? 0}分</TableCell>
                    <TableCell>{fmtHM(workedMinutes(r))}</TableCell>
                    <TableCell className="max-w-[16rem] truncate text-sub">
                      {r.note ?? ""}
                    </TableCell>
                  </TableRow>
                ))
              )}
            </TableBody>
          </Table>
        </div>
      </div>
    </div>
  );
}
