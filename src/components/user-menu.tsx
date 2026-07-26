"use client";

import { LogOut, User as UserIcon } from "lucide-react";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { PERMISSION_LABELS, type Permission } from "@/lib/constants";

/** 氏名からアバターの頭文字（姓の1文字） */
function initials(name: string) {
  const trimmed = name.trim();
  return trimmed ? trimmed[0] : "?";
}

export function UserMenu({
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
  return (
    <DropdownMenu>
      <DropdownMenuTrigger className="flex items-center gap-2 rounded-full focus:outline-none">
        <Avatar>
          <AvatarFallback>{initials(name)}</AvatarFallback>
        </Avatar>
      </DropdownMenuTrigger>
      <DropdownMenuContent align="end" className="min-w-56">
        <DropdownMenuLabel className="font-normal">
          <div className="flex flex-col gap-0.5">
            <span className="text-sm font-semibold text-ink">{name}</span>
            <span className="text-xs text-sub">
              {[dept, roleTitle].filter(Boolean).join(" ・ ") || "―"}
            </span>
            <span className="mt-1 text-[11px] text-sub">
              権限：{PERMISSION_LABELS[permission]}
            </span>
          </div>
        </DropdownMenuLabel>
        <DropdownMenuSeparator />
        <DropdownMenuItem disabled className="text-sub">
          <UserIcon className="h-4 w-4" />
          プロフィール（準備中）
        </DropdownMenuItem>
        <DropdownMenuSeparator />
        <form action="/auth/signout" method="post">
          <DropdownMenuItem
            asChild
            className="text-[#A85A52] focus:bg-[#F3E4E2] focus:text-[#A85A52]"
          >
            <button type="submit" className="w-full cursor-pointer">
              <LogOut className="h-4 w-4" />
              ログアウト
            </button>
          </DropdownMenuItem>
        </form>
      </DropdownMenuContent>
    </DropdownMenu>
  );
}
