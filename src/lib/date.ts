/**
 * 日付ユーティリティ。社内利用は日本時間（Asia/Tokyo）基準で扱う。
 */

const TZ = "Asia/Tokyo";
const WEEKDAYS = ["日", "月", "火", "水", "木", "金", "土"];

/** JST の「今日」を YYYY-MM-DD で返す */
export function todayJST(): string {
  return ymdInTZ(new Date());
}

/** Date を JST の YYYY-MM-DD に変換 */
export function ymdInTZ(d: Date): string {
  // en-CA ロケールは YYYY-MM-DD 形式
  return new Intl.DateTimeFormat("en-CA", {
    timeZone: TZ,
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
  }).format(d);
}

/** "YYYY-MM-DD" を安全にパース（ローカルタイムのズレを避ける） */
function parseYmd(ymd: string): Date {
  const [y, m, d] = ymd.split("-").map(Number);
  return new Date(Date.UTC(y, m - 1, d));
}

/** YYYY-MM-DD に日数を加算した YYYY-MM-DD を返す */
export function addDays(ymd: string, days: number): string {
  const dt = parseYmd(ymd);
  dt.setUTCDate(dt.getUTCDate() + days);
  return ymifromDate(dt);
}

function ymifromDate(dt: Date): string {
  const y = dt.getUTCFullYear();
  const m = String(dt.getUTCMonth() + 1).padStart(2, "0");
  const d = String(dt.getUTCDate()).padStart(2, "0");
  return `${y}-${m}-${d}`;
}

/** 曜日ラベル（日〜土） */
export function weekdayJP(ymd: string): string {
  return WEEKDAYS[parseYmd(ymd).getUTCDay()];
}

/** 例：7月26日（日） */
export function formatDateJP(ymd: string): string {
  const dt = parseYmd(ymd);
  return `${dt.getUTCMonth() + 1}月${dt.getUTCDate()}日（${weekdayJP(ymd)}）`;
}

/** 例：2026年7月26日（日） */
export function formatDateFullJP(ymd: string): string {
  const dt = parseYmd(ymd);
  return `${dt.getUTCFullYear()}年${formatDateJP(ymd)}`;
}

/** 例：2026年7月（当月ラベル） */
export function formatMonthJP(ym: string): string {
  const [y, m] = ym.split("-").map(Number);
  return `${y}年${m}月`;
}

/** その月（YYYY-MM）の開始日・終了日を返す */
export function monthRange(ym: string): { start: string; end: string } {
  const [y, m] = ym.split("-").map(Number);
  const start = `${y}-${String(m).padStart(2, "0")}-01`;
  const lastDay = new Date(Date.UTC(y, m, 0)).getUTCDate();
  const end = `${y}-${String(m).padStart(2, "0")}-${String(lastDay).padStart(2, "0")}`;
  return { start, end };
}

/** YYYY-MM に月を加算 */
export function addMonths(ym: string, months: number): string {
  const [y, m] = ym.split("-").map(Number);
  const dt = new Date(Date.UTC(y, m - 1 + months, 1));
  return `${dt.getUTCFullYear()}-${String(dt.getUTCMonth() + 1).padStart(2, "0")}`;
}

/** JST の当月 YYYY-MM */
export function currentMonthJST(): string {
  return todayJST().slice(0, 7);
}

/** JST の現在時刻を HH:MM で返す */
export function timeNowJST(): string {
  return new Intl.DateTimeFormat("en-GB", {
    timeZone: TZ,
    hour: "2-digit",
    minute: "2-digit",
    hour12: false,
  }).format(new Date());
}

/** "HH:MM:SS" や "HH:MM" を "HH:MM" に整形（null 可） */
export function shortTime(t: string | null | undefined): string {
  if (!t) return "—";
  return t.slice(0, 5);
}

/** date が [start, end]（両端含む）に入るか（YYYY-MM-DD 文字列比較） */
export function withinRange(date: string, start: string, end: string): boolean {
  return date >= start && date <= end;
}
