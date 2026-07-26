import type { Permission } from "@/lib/constants";

/**
 * DB テーブルの型（Phase 0）。
 * 将来的には `supabase gen types` で自動生成に置き換えても良い。
 */

/** employees（社員マスタ） */
export interface Employee {
  id: string;
  auth_user_id: string | null;
  employee_no: string | null;
  name: string;
  name_kana: string | null;
  email: string | null;
  dept: string | null;
  role_title: string | null;
  base: string | null;
  employment: string | null;
  joined_on: string | null;
  tel: string | null;
  permission: Permission;
  is_active: boolean;
  created_at: string;
  updated_at: string;
}

/** fiscal_periods（会計期） */
export interface FiscalPeriod {
  id: string;
  label: string;
  start_date: string;
  end_date: string | null;
  created_at: string;
  updated_at: string;
}

// ── Phase 1：日報・勤怠 ──

/** 日報の時間帯 */
export type ReportSlot = "am" | "pm" | "ev";

/** daily_reports（日報） */
export interface DailyReport {
  id: string;
  employee_id: string;
  report_date: string;
  plan_am: string | null;
  plan_pm: string | null;
  plan_ev: string | null;
  result_am: string | null;
  result_pm: string | null;
  result_ev: string | null;
  base: string | null;
  submitted: boolean;
  submitted_at: string | null;
  created_at: string;
  updated_at: string;
}

/** report_project_links（日報↔案件） */
export interface ReportProjectLink {
  id: string;
  daily_report_id: string;
  project_id: string | null;
  slot: ReportSlot | null;
  note: string | null;
  created_at: string;
  updated_at: string;
}

/** attendance（勤怠） */
export interface Attendance {
  id: string;
  employee_id: string;
  work_date: string;
  clock_in: string | null;
  clock_out: string | null;
  break_minutes: number;
  overtime_minutes: number | null;
  status: string;
  note: string | null;
  created_at: string;
  updated_at: string;
}

/** 休暇申請のステータス */
export type LeaveStatus = "申請中" | "承認" | "差戻し" | "却下";

/** leave_requests（休暇申請） */
export interface LeaveRequest {
  id: string;
  employee_id: string;
  leave_type: string;
  start_date: string;
  end_date: string;
  reason: string | null;
  status: LeaveStatus;
  approver_id: string | null;
  decided_at: string | null;
  created_at: string;
  updated_at: string;
}

/** leave_balances（有給残） */
export interface LeaveBalance {
  id: string;
  employee_id: string;
  fiscal_label: string;
  granted_days: number;
  used_days: number;
  created_at: string;
  updated_at: string;
}
