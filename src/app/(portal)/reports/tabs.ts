import { canViewAll, canApprove, type Permission } from "@/lib/constants";

/** 日報セクションのタブ（権限に応じて出し分け） */
export function reportTabs(
  permission: Permission,
  active: "mine" | "team" | "status",
) {
  const items = [
    { href: "/reports", label: "自分の日報", key: "mine" },
    { href: "/reports/team", label: "みんなの日報", key: "team" },
    { href: "/reports/status", label: "提出状況", key: "status" },
  ];
  const showTeam = canApprove(permission) || canViewAll(permission);
  return items
    .filter((i) => i.key === "mine" || showTeam)
    .map((i) => ({ href: i.href, label: i.label, active: i.key === active }));
}
