import type { ReactNode } from "react";
import { Container } from "@/components/ui/Container";
import { Photo, type PhotoSlot } from "@/components/ui/Photo";

type PageHeroProps = {
  eyebrow: string;
  heading: ReactNode;
  photo: PhotoSlot;
};

/** Shared TOP/category hero: eyebrow label + heading, then one large photo. Use one per page. */
export function PageHero({ eyebrow, heading, photo }: PageHeroProps) {
  return (
    <section>
      <Container className="pt-28 sm:pt-36">
        <p className="text-xs tracking-[0.32em] text-std-accent">{eyebrow}</p>
        <h1 className="mt-6 max-w-2xl font-serif text-[clamp(2.1rem,6vw,3.4rem)] leading-[1.5] text-std-ink">
          {heading}
        </h1>
      </Container>

      <div className="relative mt-16 aspect-[4/5] w-full overflow-hidden sm:mt-20 sm:aspect-[16/10]">
        <Photo {...photo} priority sizes="100vw" />
      </div>
    </section>
  );
}
