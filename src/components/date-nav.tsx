import Link from "next/link";
import { ChevronLeft, ChevronRight } from "lucide-react";
import { addDays, addMonths, formatDateFullJP, formatMonthJP } from "@/lib/date";

/** 日付を前後に動かすナビ（?date= を切り替える） */
export function DayNav({
  basePath,
  date,
  extraParams,
}: {
  basePath: string;
  date: string;
  extraParams?: Record<string, string>;
}) {
  const qs = (d: string) => {
    const p = new URLSearchParams({ ...extraParams, date: d });
    return `${basePath}?${p.toString()}`;
  };
  return (
    <div className="flex items-center gap-2">
      <Link
        href={qs(addDays(date, -1))}
        className="flex h-8 w-8 items-center justify-center rounded-md border border-line bg-card text-ink hover:bg-muted"
        aria-label="前の日"
      >
        <ChevronLeft className="h-4 w-4" />
      </Link>
      <span className="min-w-[11rem] text-center text-sm font-medium text-ink">
        {formatDateFullJP(date)}
      </span>
      <Link
        href={qs(addDays(date, 1))}
        className="flex h-8 w-8 items-center justify-center rounded-md border border-line bg-card text-ink hover:bg-muted"
        aria-label="次の日"
      >
        <ChevronRight className="h-4 w-4" />
      </Link>
    </div>
  );
}

/** 月を前後に動かすナビ（?month= を切り替える） */
export function MonthNav({
  basePath,
  month,
  extraParams,
}: {
  basePath: string;
  month: string;
  extraParams?: Record<string, string>;
}) {
  const qs = (m: string) => {
    const p = new URLSearchParams({ ...extraParams, month: m });
    return `${basePath}?${p.toString()}`;
  };
  return (
    <div className="flex items-center gap-2">
      <Link
        href={qs(addMonths(month, -1))}
        className="flex h-8 w-8 items-center justify-center rounded-md border border-line bg-card text-ink hover:bg-muted"
        aria-label="前の月"
      >
        <ChevronLeft className="h-4 w-4" />
      </Link>
      <span className="min-w-[7rem] text-center text-sm font-medium text-ink">
        {formatMonthJP(month)}
      </span>
      <Link
        href={qs(addMonths(month, 1))}
        className="flex h-8 w-8 items-center justify-center rounded-md border border-line bg-card text-ink hover:bg-muted"
        aria-label="次の月"
      >
        <ChevronRight className="h-4 w-4" />
      </Link>
    </div>
  );
}
