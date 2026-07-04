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
        className={`absolute inset-0 overflow-hidden bg-[#e9e3d4] ${className}`}
      >
        <div
          className="absolute inset-0 opacity-40"
          style={{
            backgroundImage:
              "repeating-linear-gradient(135deg, #dcd3bf 0px, #dcd3bf 1px, transparent 1px, transparent 14px)",
          }}
        />
        <span className="absolute bottom-3 left-4 text-[10px] tracking-[0.14em] text-std-ink-soft/50">
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
