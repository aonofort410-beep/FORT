"use server";

import { revalidatePath } from "next/cache";
import { createClient } from "@/lib/supabase/server";
import { getCurrentEmployee } from "@/lib/auth";
import { timeNowJST, todayJST } from "@/lib/date";
import { canApprove, type Permission } from "@/lib/constants";
import type { LeaveStatus } from "@/types/database";

function nz(v: FormDataEntryValue | null): string | null {
  const s = (v ?? "").toString().trim();
  return s === "" ? null : s;
}

/** 出勤／退勤の打刻（今日の勤怠に現在時刻を記録） */
export async function quickClock(intent: "in" | "out") {
  const employee = await getCurrentEmployee();
  if (!employee) return { ok: false, error: "社員情報が取得できませんでした。" };

  const supabase = await createClient();
  const workDate = todayJST();
  const now = timeNowJST();

  const { data: existing } = await supabase
    .from("attendance")
    .select("*")
    .eq("employee_id", employee.id)
    .eq("work_date", workDate)
    .maybeSingle();

  const payload: Record<string, unknown> = {
    employee_id: employee.id,
    work_date: workDate,
    status: existing?.status ?? "出勤",
    clock_in: intent === "in" ? now : (existing?.clock_in ?? null),
    clock_out: intent === "out" ? now : (existing?.clock_out ?? null),
    break_minutes: existing?.break_minutes ?? 0,
  };

  const { error } = await supabase
    .from("attendance")
    .upsert(payload, { onConflict: "employee_id,work_date" });

  if (error) return { ok: false, error: error.message };
  revalidatePath("/attendance");
  revalidatePath("/");
  return { ok: true };
}

/** 勤怠の手入力保存（指定日の出退勤・休憩・状態・メモ） */
export async function saveAttendance(formData: FormData) {
  const employee = await getCurrentEmployee();
  if (!employee) return { ok: false, error: "社員情報が取得できませんでした。" };

  const workDate = nz(formData.get("work_date"));
  if (!workDate) return { ok: false, error: "日付が指定されていません。" };

  const supabase = await createClient();
  const breakStr = nz(formData.get("break_minutes"));

  const payload: Record<string, unknown> = {
    employee_id: employee.id,
    work_date: workDate,
    clock_in: nz(formData.get("clock_in")),
    clock_out: nz(formData.get("clock_out")),
    break_minutes: breakStr ? Math.max(0, parseInt(breakStr, 10) || 0) : 0,
    status: nz(formData.get("status")) ?? "出勤",
    note: nz(formData.get("note")),
  };

  const { error } = await supabase
    .from("attendance")
    .upsert(payload, { onConflict: "employee_id,work_date" });

  if (error) return { ok: false, error: error.message };
  revalidatePath("/attendance");
  revalidatePath("/");
  return { ok: true };
}

/** 休暇申請の作成 */
export async function createLeaveRequest(formData: FormData) {
  const employee = await getCurrentEmployee();
  if (!employee) return { ok: false, error: "社員情報が取得できませんでした。" };

  const leaveType = nz(formData.get("leave_type"));
  const startDate = nz(formData.get("start_date"));
  const endDate = nz(formData.get("end_date")) ?? startDate;
  if (!leaveType || !startDate) {
    return { ok: false, error: "種類と開始日は必須です。" };
  }
  if (endDate && endDate < startDate) {
    return { ok: false, error: "終了日は開始日以降にしてください。" };
  }

  const supabase = await createClient();
  const { error } = await supabase.from("leave_requests").insert({
    employee_id: employee.id,
    leave_type: leaveType,
    start_date: startDate,
    end_date: endDate,
    reason: nz(formData.get("reason")),
    status: "申請中",
  });

  if (error) return { ok: false, error: error.message };
  revalidatePath("/attendance/leave");
  revalidatePath("/attendance/approvals");
  revalidatePath("/");
  return { ok: true };
}

/** 休暇申請の取消（本人・申請中のみ） */
export async function cancelLeaveRequest(id: string) {
  const employee = await getCurrentEmployee();
  if (!employee) return { ok: false, error: "社員情報が取得できませんでした。" };

  const supabase = await createClient();
  const { error } = await supabase
    .from("leave_requests")
    .delete()
    .eq("id", id)
    .eq("employee_id", employee.id)
    .eq("status", "申請中");

  if (error) return { ok: false, error: error.message };
  revalidatePath("/attendance/leave");
  revalidatePath("/");
  return { ok: true };
}

/** 休暇申請の承認・差戻し・却下（承認権限者のみ） */
export async function decideLeaveRequest(
  id: string,
  decision: Exclude<LeaveStatus, "申請中">,
) {
  const employee = await getCurrentEmployee();
  if (!employee) return { ok: false, error: "社員情報が取得できませんでした。" };
  if (!canApprove(employee.permission as Permission)) {
    return { ok: false, error: "承認する権限がありません。" };
  }

  const supabase = await createClient();
  const { error } = await supabase
    .from("leave_requests")
    .update({
      status: decision,
      approver_id: employee.id,
      decided_at: new Date().toISOString(),
    })
    .eq("id", id);

  if (error) return { ok: false, error: error.message };
  revalidatePath("/attendance/approvals");
  revalidatePath("/attendance/leave");
  revalidatePath("/");
  return { ok: true };
}
