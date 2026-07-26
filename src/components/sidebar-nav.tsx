"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { cn } from "@/lib/utils";
import { NAV_ITEMS } from "@/components/nav-items";

/**
 * サイドバー内のナビゲーション。現在地をハイライトする。
 * 濃色（--dark）面の上に置く前提の配色。
 */
export function SidebarNav({ onNavigate }: { onNavigate?: () => void }) {
  const pathname = usePathname();

  return (
    <nav className="flex flex-col gap-0.5 px-3">
      {NAV_ITEMS.map((item) => {
        const active =
          item.href === "/"
            ? pathname === "/"
            : pathname.startsWith(item.href);
        const Icon = item.icon;
        return (
          <Link
            key={item.href}
            href={item.href}
            onClick={onNavigate}
            className={cn(
              "group flex items-center gap-3 rounded-md px-3 py-2 text-sm transition-colors",
              active
                ? "bg-white/10 text-white"
                : "text-white/60 hover:bg-white/5 hover:text-white/90",
            )}
          >
            <Icon
              className={cn(
                "h-[18px] w-[18px] shrink-0",
                active ? "text-bronze" : "text-white/50",
              )}
            />
            <span className="flex-1 truncate">{item.label}</span>
            {item.comingSoon && (
              <span className="rounded-full bg-white/10 px-1.5 py-0.5 text-[10px] font-medium text-white/50">
                準備中
              </span>
            )}
          </Link>
        );
      })}
    </nav>
  );
}
