"use client";

import * as React from "react";
import { Check, MapPin, ChevronDown } from "lucide-react";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { cn } from "@/lib/utils";

const OPTIONS = ["全社", "岡山", "福山"] as const;
type BaseFilter = (typeof OPTIONS)[number];

/**
 * ヘッダーの拠点切替（全社／岡山／福山）。
 * Phase 0 では見た目のみ（各機能のフィルタは各Phaseで接続）。
 */
export function BaseSwitcher() {
  const [value, setValue] = React.useState<BaseFilter>("全社");

  return (
    <DropdownMenu>
      <DropdownMenuTrigger className="flex items-center gap-1.5 rounded-md border border-line bg-card px-3 py-1.5 text-sm text-ink transition-colors hover:bg-muted focus:outline-none">
        <MapPin className="h-4 w-4 text-bronze" />
        <span className="font-medium">{value}</span>
        <ChevronDown className="h-4 w-4 text-sub" />
      </DropdownMenuTrigger>
      <DropdownMenuContent align="end">
        {OPTIONS.map((opt) => (
          <DropdownMenuItem
            key={opt}
            onSelect={() => setValue(opt)}
            className="justify-between"
          >
            {opt}
            <Check
              className={cn(
                "h-4 w-4 text-bronze",
                value === opt ? "opacity-100" : "opacity-0",
              )}
            />
          </DropdownMenuItem>
        ))}
      </DropdownMenuContent>
    </DropdownMenu>
  );
}
