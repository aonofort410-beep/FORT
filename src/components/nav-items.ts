import {
  LayoutDashboard,
  FileText,
  Clock,
  CalendarCheck,
  Building2,
  ListChecks,
  FileCheck2,
  Users,
  Award,
  BookOpen,
  Settings,
  type LucideIcon,
} from "lucide-react";

export interface NavItem {
  label: string; // 日本語ラベル
  eyebrow: string; // 英字ラベル
  href: string;
  icon: LucideIcon;
  /** Phase 0 時点で中身が未実装なら true（サイドバーに「準備中」を表示） */
  comingSoon?: boolean;
  /** 対応する機能フェーズ（docs/02_features.md） */
  phase: number;
}

/**
 * サイドバーの項目。docs/02_features.md / docs/05_architecture.md のフォルダ構成に対応。
 * Phase 0 で器のあるのは HOME のみ。他は「準備中」。
 */
export const NAV_ITEMS: NavItem[] = [
  { label: "ホーム", eyebrow: "HOME", href: "/", icon: LayoutDashboard, phase: 0 },
  { label: "日報", eyebrow: "REPORTS", href: "/reports", icon: FileText, comingSoon: true, phase: 1 },
  { label: "勤怠・休日", eyebrow: "ATTENDANCE", href: "/attendance", icon: Clock, comingSoon: true, phase: 1 },
  { label: "予約", eyebrow: "RESERVATIONS", href: "/reservations", icon: CalendarCheck, comingSoon: true, phase: 2 },
  { label: "案件", eyebrow: "PROJECTS", href: "/projects", icon: Building2, comingSoon: true, phase: 2 },
  { label: "タスク", eyebrow: "TASKS", href: "/tasks", icon: ListChecks, comingSoon: true, phase: 3 },
  { label: "申請", eyebrow: "APPROVALS", href: "/approvals", icon: FileCheck2, comingSoon: true, phase: 3 },
  { label: "社員", eyebrow: "STAFF", href: "/staff", icon: Users, comingSoon: true, phase: 3 },
  { label: "資格", eyebrow: "QUALIFICATIONS", href: "/qualifications", icon: Award, comingSoon: true, phase: 4 },
  { label: "ナレッジ", eyebrow: "KNOWLEDGE", href: "/knowledge", icon: BookOpen, comingSoon: true, phase: 4 },
  { label: "設定", eyebrow: "SETTINGS", href: "/settings", icon: Settings, comingSoon: true, phase: 3 },
];
