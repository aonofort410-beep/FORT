import Link from "next/link";
import { notFound, redirect } from "next/navigation";
import { getCurrentEmployee } from "@/lib/auth";
import { createClient } from "@/lib/supabase/server";
import { ReportForm } from "../report-form";
import { formatDateFullJP } from "@/lib/date";
import type { DailyReport } from "@/types/database";
import { ChevronLeft } from "lucide-react";

export const dynamic = "force-dynamic";

const DATE_RE = /^\d{4}-\d{2}-\d{2}$/;

export default async function ReportEditPage({
  params,
}: {
  params: Promise<{ date: string }>;
}) {
  const { date } = await params;
  if (!DATE_RE.test(date)) notFound();

  const employee = await getCurrentEmployee();
  if (!employee) redirect("/login?error=unregistered");

  const supabase = await createClient();
  const { data } = await supabase
    .from("daily_reports")
    .select("*")
    .eq("employee_id", employee.id)
    .eq("report_date", date)
    .maybeSingle();

  const report = (data as DailyReport | null) ?? null;

  return (
    <div className="max-w-3xl space-y-6">
      <Link
        href="/reports"
        className="inline-flex items-center gap-1 text-sm text-sub hover:text-ink"
      >
        <ChevronLeft className="h-4 w-4" />
        日報一覧へ
      </Link>

      <div>
        <p className="eyebrow">DAILY REPORT</p>
        <h1 className="mt-1 font-heading text-2xl font-semibold text-ink">
          {formatDateFullJP(date)}
        </h1>
        <p className="mt-2 text-sm text-sub">
          午前・午後・夜それぞれの「予定」と「実績」を記入します。
          「休み」の日は予定欄に「公休／有給／代休」等と記載してください。
        </p>
      </div>

      <ReportForm date={date} report={report} defaultBase={employee.base} />
    </div>
  );
}
