"use client";

import * as React from "react";
import Link from "next/link";
import { cn } from "@/lib/utils";

/**
 * URL ベースのシンプルなタブ（サーバーコンポーネントのページで使いやすい）。
 * 各タブは href を持ち、active を親が判定して渡す。
 */
export function TabNav({
  items,
  className,
}: {
  items: { href: string; label: string; active?: boolean }[];
  className?: string;
}) {
  return (
    <div className={cn("border-b border-line", className)}>
      <nav className="-mb-px flex gap-1 overflow-x-auto">
        {items.map((item) => (
          <Link
            key={item.href}
            href={item.href}
            className={cn(
              "whitespace-nowrap border-b-2 px-4 py-2.5 text-sm font-medium transition-colors",
              item.active
                ? "border-bronze text-ink"
                : "border-transparent text-sub hover:text-ink",
            )}
          >
            {item.label}
          </Link>
        ))}
      </nav>
    </div>
  );
}
