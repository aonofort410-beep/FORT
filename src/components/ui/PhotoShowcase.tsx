import { Container } from "@/components/ui/Container";
import { Photo, type PhotoSlot } from "@/components/ui/Photo";

export type PhotoShowcaseItem = {
  photo: PhotoSlot;
  caption: string;
};

type PhotoShowcaseProps = {
  heading: string;
  items: PhotoShowcaseItem[];
};

/** A handful of large, full-width photos stacked with generous space — no grid, no overlay text. */
export function PhotoShowcase({ heading, items }: PhotoShowcaseProps) {
  return (
    <section className="py-24 sm:py-32">
      <Container>
        <h2 className="font-serif text-2xl text-std-ink sm:text-3xl">
          {heading}
        </h2>
      </Container>

      <div className="mt-14 flex flex-col gap-16 sm:mt-16 sm:gap-24">
        {items.map((item) => (
          <figure key={item.caption}>
            <div className="relative aspect-[16/10] w-full overflow-hidden">
              <Photo {...item.photo} sizes="100vw" />
            </div>
            <figcaption className="mt-4 text-xs tracking-[0.14em] text-std-ink-soft">
              <Container>{item.caption}</Container>
            </figcaption>
          </figure>
        ))}
      </div>
    </section>
  );
}
