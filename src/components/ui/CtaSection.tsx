import type { ReactNode } from "react";
import { Container } from "@/components/ui/Container";
import { PrimaryButton } from "@/components/ui/Button";

type CtaSectionProps = {
  heading: ReactNode;
  supporting?: ReactNode;
  buttonLabel: string;
  href: string;
};

/** The one dark, final-push section. One heading, one button. */
export function CtaSection({ heading, supporting, buttonLabel, href }: CtaSectionProps) {
  return (
    <section className="bg-std-bg-deep py-24 text-white sm:py-32 lg:py-40">
      <Container className="text-center">
        <h2 className="font-serif text-[clamp(1.6rem,4vw,2.3rem)] leading-[1.6]">
          {heading}
        </h2>
        {supporting ? (
          <p className="mx-auto mt-6 max-w-md text-sm leading-[1.9] text-white/70">
            {supporting}
          </p>
        ) : null}
        <div className="mt-12">
          <PrimaryButton href={href}>{buttonLabel}</PrimaryButton>
        </div>
      </Container>
    </section>
  );
}
