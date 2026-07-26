"use client";

import * as React from "react";
import { useRouter } from "next/navigation";
import { Button } from "@/components/ui/button";
import { decideLeaveRequest } from "./actions";
import { Check, Undo2, X } from "lucide-react";
import type { LeaveStatus } from "@/types/database";

/** 承認・差戻し・却下ボタン群 */
export function ApproveButtons({ id }: { id: string }) {
  const router = useRouter();
  const [pending, setPending] = React.useState<null | string>(null);

  async function decide(decision: Exclude<LeaveStatus, "申請中">) {
    setPending(decision);
    const res = await decideLeaveRequest(id, decision);
    setPending(null);
    if (res.ok) router.refresh();
    else alert(res.error ?? "処理に失敗しました。");
  }

  return (
    <div className="flex flex-wrap gap-2">
      <Button size="sm" disabled={pending !== null} onClick={() => decide("承認")}>
        <Check className="h-4 w-4" />
        承認
      </Button>
      <Button
        size="sm"
        variant="outline"
        disabled={pending !== null}
        onClick={() => decide("差戻し")}
      >
        <Undo2 className="h-4 w-4" />
        差戻し
      </Button>
      <Button
        size="sm"
        variant="ghost"
        disabled={pending !== null}
        onClick={() => decide("却下")}
      >
        <X className="h-4 w-4" />
        却下
      </Button>
    </div>
  );
}
