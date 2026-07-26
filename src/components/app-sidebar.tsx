import Link from "next/link";
import { SidebarNav } from "@/components/sidebar-nav";

/**
 * PC 用の左サイドバー（常時表示・濃色）。
 * docs/03_design_system.md：PCは左サイドバー（濃色 #242424）。
 */
export function AppSidebar() {
  return (
    <aside className="fixed inset-y-0 left-0 hidden w-64 flex-col bg-dark lg:flex">
      <div className="flex h-16 items-center gap-2 px-6">
        <Link href="/" className="flex items-baseline gap-2">
          <span className="font-heading text-lg font-extrabold tracking-widest text-white">
            FORT
          </span>
          <span className="text-[10px] font-medium tracking-label text-white/40">
            PORTAL
          </span>
        </Link>
      </div>
      <div className="flex-1 overflow-y-auto py-2">
        <SidebarNav />
      </div>
      <div className="px-6 py-4">
        <p className="text-[10px] leading-relaxed text-white/30">
          社内ポータル ｜ Phase 0
          <br />
          岡山本社 ・ 福山スタジオ
        </p>
      </div>
    </aside>
  );
}
