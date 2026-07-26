"use client";

import * as React from "react";
import Link from "next/link";
import { Bell, Menu } from "lucide-react";
import {
  Sheet,
  SheetContent,
  SheetTitle,
  SheetTrigger,
} from "@/components/ui/sheet";
import { SidebarNav } from "@/components/sidebar-nav";
import { BaseSwitcher } from "@/components/base-switcher";
import { UserMenu } from "@/components/user-menu";
import type { Permission } from "@/lib/constants";

/** 今日の日付（例：2026年7月26日（日）） */
function formatToday() {
  const now = new Date();
  const days = ["日", "月", "火", "水", "木", "金", "土"];
  return `${now.getFullYear()}年${now.getMonth() + 1}月${now.getDate()}日（${days[now.getDay()]}）`;
}

export function AppHeader({
  name,
  dept,
  roleTitle,
  permission,
}: {
  name: string;
  dept: string | null;
  roleTitle: string | null;
  permission: Permission;
}) {
  const [open, setOpen] = React.useState(false);
  const [today, setToday] = React.useState("");

  // 日付はクライアントで確定させ、hydration mismatch を避ける
  React.useEffect(() => {
    setToday(formatToday());
  }, []);

  return (
    <header className="sticky top-0 z-40 flex h-16 items-center gap-3 border-b border-line bg-bg/80 px-4 backdrop-blur lg:px-8">
      {/* モバイル：ハンバーガー＋サイドバー */}
      <Sheet open={open} onOpenChange={setOpen}>
        <SheetTrigger className="rounded-md p-2 text-ink hover:bg-muted lg:hidden">
          <Menu className="h-5 w-5" />
          <span className="sr-only">メニューを開く</span>
        </SheetTrigger>
        <SheetContent side="left" className="w-64 border-none bg-dark p-0">
          <SheetTitle className="sr-only">ナビゲーション</SheetTitle>
          <div className="flex h-16 items-center px-6">
            <span className="font-heading text-lg font-extrabold tracking-widest text-white">
              FORT
            </span>
            <span className="ml-2 text-[10px] font-medium tracking-label text-white/40">
              PORTAL
            </span>
          </div>
          <div className="py-2">
            <SidebarNav onNavigate={() => setOpen(false)} />
          </div>
        </SheetContent>
      </Sheet>

      {/* モバイルロゴ */}
      <Link href="/" className="font-heading text-base font-extrabold tracking-widest text-ink lg:hidden">
        FORT
      </Link>

      {/* 日付 */}
      <div className="hidden flex-col md:flex">
        <span className="text-sm font-medium text-ink">{today || " "}</span>
      </div>

      <div className="flex-1" />

      {/* 拠点切替 */}
      <BaseSwitcher />

      {/* 通知（Phase 3 で実装） */}
      <button
        className="relative rounded-md p-2 text-ink hover:bg-muted"
        title="通知（準備中）"
        aria-label="通知（準備中）"
      >
        <Bell className="h-5 w-5" />
      </button>

      {/* ユーザー */}
      <UserMenu
        name={name}
        dept={dept}
        roleTitle={roleTitle}
        permission={permission}
      />
    </header>
  );
}
