"use server";

import { revalidatePath } from "next/cache";
import { createClient } from "@/lib/supabase/server";
import { getCurrentEmployee } from "@/lib/auth";

/** フォーム文字列を trim して、空なら null */
function nz(v: FormDataEntryValue | null): string | null {
  const s = (v ?? "").toString().trim();
  return s === "" ? null : s;
}

/**
 * 日報の保存（下書き or 提出）。(employee_id, report_date) で upsert。
 */
export async function saveDailyReport(formData: FormData) {
  const employee = await getCurrentEmployee();
  if (!employee) return { ok: false, error: "社員情報が取得できませんでした。" };

  const reportDate = nz(formData.get("report_date"));
  if (!reportDate) return { ok: false, error: "日付が指定されていません。" };

  const intent = (formData.get("intent") ?? "draft").toString();
  const submitted = intent === "submit";

  const supabase = await createClient();

  const payload: Record<string, unknown> = {
    employee_id: employee.id,
    report_date: reportDate,
    plan_am: nz(formData.get("plan_am")),
    plan_pm: nz(formData.get("plan_pm")),
    plan_ev: nz(formData.get("plan_ev")),
    result_am: nz(formData.get("result_am")),
    result_pm: nz(formData.get("result_pm")),
    result_ev: nz(formData.get("result_ev")),
    base: nz(formData.get("base")),
    submitted,
    submitted_at: submitted ? new Date().toISOString() : null,
  };

  const { error } = await supabase
    .from("daily_reports")
    .upsert(payload, { onConflict: "employee_id,report_date" });

  if (error) {
    return { ok: false, error: error.message };
  }

  revalidatePath("/reports");
  revalidatePath(`/reports/${reportDate}`);
  revalidatePath("/");
  return { ok: true, submitted };
}
