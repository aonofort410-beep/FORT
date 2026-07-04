import Link from "next/link";
import type { ReactNode } from "react";

type LinkButtonProps = {
  href: string;
  children: ReactNode;
  className?: string;
};

/** The one filled call-to-action style. Use at most once per screen. */
export function PrimaryButton({ href, children, className = "" }: LinkButtonProps) {
  return (
    <Link
      href={href}
      className={`inline-flex items-center justify-center gap-3 bg-std-accent px-9 py-4 text-sm tracking-[0.1em] text-white transition-opacity duration-300 hover:opacity-85 ${className}`}
    >
      {children}
    </Link>
  );
}

/** The only secondary style: an underlined text link with a quiet arrow. */
export function TextLink({ href, children, className = "" }: LinkButtonProps) {
  return (
    <Link
      href={href}
      className={`group inline-flex items-center gap-2 border-b border-std-line pb-0.5 text-sm tracking-[0.04em] text-std-ink transition-colors duration-300 hover:border-std-accent hover:text-std-accent ${className}`}
    >
      <span>{children}</span>
      <span
        aria-hidden
        className="transition-transform duration-300 group-hover:translate-x-1"
      >
        →
      </span>
    </Link>
  );
}
