import { Container } from "@/components/ui/Container";
import { PhotoGrid, type PhotoGridItem } from "@/components/ui/PhotoGrid";

type PhotoGridSectionProps = {
  heading: string;
  lead?: string;
  items: PhotoGridItem[];
  aspectClassName?: string;
  columnsClassName?: string;
};

/** Heading (+ optional short lead) above a quiet photo grid. */
export function PhotoGridSection({
  heading,
  lead,
  items,
  aspectClassName,
  columnsClassName,
}: PhotoGridSectionProps) {
  return (
    <section className="py-24 sm:py-32 lg:py-40">
      <Container>
        <h2 className="font-serif text-2xl text-std-ink sm:text-3xl">
          {heading}
        </h2>
        {lead ? (
          <p className="mt-4 max-w-xl text-base leading-[1.9] text-std-ink">
            {lead}
          </p>
        ) : null}

        <div className="mt-10">
          <PhotoGrid
            items={items}
            aspectClassName={aspectClassName}
            columnsClassName={columnsClassName}
          />
        </div>
      </Container>
    </section>
  );
}
