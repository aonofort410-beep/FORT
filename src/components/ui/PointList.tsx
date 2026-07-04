import { Container } from "@/components/ui/Container";

export type Point = {
  title: string;
  note: string;
};

type PointListProps = {
  heading: string;
  lead?: string;
  items: Point[];
};

/** A quiet hairline list of short considerations — title + one short phrase, nothing more. */
export function PointList({ heading, lead, items }: PointListProps) {
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

        <div className="mt-10 grid grid-cols-1 gap-x-10 border-t border-std-line sm:grid-cols-2">
          {items.map((item) => (
            <div
              key={item.title}
              className="flex items-baseline justify-between gap-6 border-b border-std-line py-6"
            >
              <span className="text-base text-std-ink">{item.title}</span>
              <span className="text-right text-sm text-std-ink-soft">
                {item.note}
              </span>
            </div>
          ))}
        </div>
      </Container>
    </section>
  );
}
