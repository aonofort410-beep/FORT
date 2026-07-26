/**
 * FORT 全体で使う定数。
 */

/** ログインを許可するメールドメイン（@fort410.jp のみ） */
export const ALLOWED_EMAIL_DOMAIN = "fort410.jp";

/** メールが許可ドメインかどうか（末尾一致だけに頼らず厳密に判定） */
export function isAllowedEmail(email: string | null | undefined): boolean {
  if (!email) return false;
  const parts = email.toLowerCase().trim().split("@");
  if (parts.length !== 2) return false;
  return parts[1] === ALLOWED_EMAIL_DOMAIN;
}

/** 権限ロール（docs/04_data_model.md） */
export type Permission = "executive" | "manager" | "hr" | "member";

export const PERMISSION_LABELS: Record<Permission, string> = {
  executive: "経営",
  manager: "管理職",
  hr: "総務",
  member: "一般",
};

/** 部署 */
export const DEPARTMENTS = ["経営", "営業", "設計", "工務", "総務"] as const;
export type Department = (typeof DEPARTMENTS)[number];

/** 部署カラー（docs/03_design_system.md） */
export const DEPARTMENT_COLORS: Record<string, string> = {
  経営: "#9A8060",
  営業: "#6F7565",
  設計: "#7C7A8A",
  工務: "#8A7560",
  総務: "#6B7A7C",
};

/** 拠点 */
export const BASES = ["岡山", "福山"] as const;
export type Base = (typeof BASES)[number];
