import type { ReactNode } from "react";
import { Container } from "@/components/ui/Container";

type StatementProps = {
  children: ReactNode;
  supporting?: ReactNode;
};

/** A single centered statement of belief. Keep it to one sentence — this is not a place for paragraphs. */
export function Statement({ children, supporting }: StatementProps) {
  return (
    <section className="py-24 sm:py-32 lg:py-40">
      <Container className="text-center">
        <p className="mx-auto max-w-2xl font-serif text-[clamp(1.4rem,3.4vw,1.9rem)] leading-[1.7] text-std-ink">
          {children}
        </p>
        {supporting ? (
          <p className="mx-auto mt-6 max-w-md text-sm leading-[1.9] text-std-ink-soft">
            {supporting}
          </p>
        ) : null}
      </Container>
    </section>
  );
}
