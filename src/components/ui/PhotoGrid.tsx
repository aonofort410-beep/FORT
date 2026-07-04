import Link from "next/link";
import { Photo, type PhotoSlot } from "@/components/ui/Photo";

export type PhotoGridItem = {
  photo: PhotoSlot;
  label: string;
  href?: string;
};

type PhotoGridProps = {
  items: PhotoGridItem[];
  /** Tailwind aspect-ratio class for each tile. */
  aspectClassName?: string;
  /** Tailwind grid-cols classes across breakpoints. */
  columnsClassName?: string;
};

/** A quiet photo-led grid: image, then just a short caption. No descriptions, no boxes. */
export function PhotoGrid({
  items,
  aspectClassName = "aspect-[4/5]",
  columnsClassName = "grid-cols-2 sm:grid-cols-3",
}: PhotoGridProps) {
  return (
    <div className={`grid gap-x-6 gap-y-10 sm:gap-x-8 ${columnsClassName}`}>
      {items.map((item) => {
        const body = (
          <>
            <div className={`relative w-full overflow-hidden ${aspectClassName}`}>
              <Photo {...item.photo} sizes="(min-width: 640px) 33vw, 50vw" />
            </div>
            <p className="mt-3 text-sm tracking-[0.04em] text-std-ink">
              {item.label}
            </p>
          </>
        );

        if (item.href) {
          return (
            <Link key={item.label} href={item.href} className="group block">
              {body}
            </Link>
          );
        }

        return <figure key={item.label}>{body}</figure>;
      })}
    </div>
  );
}
