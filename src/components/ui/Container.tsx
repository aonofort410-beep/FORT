import type { ReactNode } from "react";

type ContainerProps = {
  children: ReactNode;
  className?: string;
};

/** Centers content at the design system's 1040px max width with generous side padding. */
export function Container({ children, className = "" }: ContainerProps) {
  return (
    <div className={`mx-auto w-full max-w-[1040px] px-6 sm:px-8 lg:px-10 ${className}`}>
      {children}
    </div>
  );
}
