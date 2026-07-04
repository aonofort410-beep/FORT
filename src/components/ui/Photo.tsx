import Image from "next/image";

export type PhotoSlot = {
  /**
   * Path under /public, e.g. "/images/hero-exterior.jpg".
   * Leave undefined to render a placeholder — drop the real file in
   * and set this path when the photo is ready, no other changes needed.
   */
  src?: string;
  alt: string;
};

type PhotoProps = PhotoSlot & {
  className?: string;
  priority?: boolean;
  sizes?: string;
};

/**
 * Fills its positioned parent (use a `relative` wrapper with an aspect-ratio
 * class). Renders a quiet placeholder until `src` is supplied, so swapping in
 * real photography later never requires touching this component.
 */
export function Photo({ src, alt, className = "", priority, sizes }: PhotoProps) {
  if (!src) {
    return (
      <div
        role="img"
        aria-label={alt}
        className={`absolute inset-0 flex items-center justify-center bg-gradient-to-br from-[#efeadf] to-[#dcd3bf] ${className}`}
      >
        <span className="px-6 text-center text-xs tracking-[0.2em] text-std-ink-soft/70">
          {alt}
        </span>
      </div>
    );
  }

  return (
    <Image
      src={src}
      alt={alt}
      fill
      priority={priority}
      sizes={sizes ?? "100vw"}
      className={`object-cover ${className}`}
    />
  );
}
