import { canApprove, type Permission } from "@/lib/constants";

/** 勤怠セクションのタブ */
export function attendanceTabs(
  permission: Permission,
  active: "mine" | "leave" | "approvals",
) {
  const items = [
    { href: "/attendance", label: "勤怠", key: "mine" },
    { href: "/attendance/leave", label: "休暇", key: "leave" },
    { href: "/attendance/approvals", label: "承認", key: "approvals" },
  ];
  return items
    .filter((i) => i.key !== "approvals" || canApprove(permission))
    .map((i) => ({ href: i.href, label: i.label, active: i.key === active }));
}
