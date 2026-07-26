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

// ── Phase 1：日報・勤怠 ──

/** 日報の時間帯（表示ラベル付き） */
export const REPORT_SLOTS = [
  { key: "am", label: "午前" },
  { key: "pm", label: "午後" },
  { key: "ev", label: "夜" },
] as const;

/** 勤怠ステータス */
export const ATTENDANCE_STATUSES = [
  "出勤",
  "外出",
  "直行直帰",
  "在宅",
  "休暇",
] as const;

/** 休暇の種類 */
export const LEAVE_TYPES = [
  "有給",
  "半休",
  "代休",
  "公休",
  "特別休暇",
  "欠勤",
] as const;

/** 承認権限（休暇申請などを承認できる） */
export function canApprove(permission: Permission): boolean {
  return permission === "manager" || permission === "hr" || permission === "executive";
}

/** 全社の勤怠・提出状況などを横断的に見られるか（総務・経営） */
export function canViewAll(permission: Permission): boolean {
  return permission === "hr" || permission === "executive";
}

/**
 * 日報の記述から「休み」を示すキーワード。
 * 「本日休みの人」の自動集計に使う（docs/06_roadmap.md Phase 1-9）。
 */
export const REST_KEYWORDS = ["公休", "有給", "代休", "休み", "休暇", "欠勤"];

/** テキストに休みキーワードが含まれるか */
export function looksLikeRest(text: string | null | undefined): boolean {
  if (!text) return false;
  return REST_KEYWORDS.some((kw) => text.includes(kw));
}
