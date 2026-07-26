import * as React from "react";
import { cva, type VariantProps } from "class-variance-authority";

import { cn } from "@/lib/utils";

const badgeVariants = cva(
  "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold transition-colors",
  {
    variants: {
      variant: {
        default: "bg-muted text-sub",
        ok: "bg-[#EAEEE7] text-[#5B7355]",
        warn: "bg-[#F3EEE3] text-[#B8A47E]",
        late: "bg-[#F5E9E0] text-[#B5714A]",
        urgent: "bg-[#F3E4E2] text-[#A85A52]",
        outline: "border border-line text-ink",
      },
    },
    defaultVariants: {
      variant: "default",
    },
  },
);

export interface BadgeProps
  extends React.HTMLAttributes<HTMLDivElement>,
    VariantProps<typeof badgeVariants> {}

function Badge({ className, variant, ...props }: BadgeProps) {
  return (
    <div className={cn(badgeVariants({ variant }), className)} {...props} />
  );
}

export { Badge, badgeVariants };
