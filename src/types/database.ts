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
