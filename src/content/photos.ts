import type { PhotoSlot } from "@/components/ui/Photo";

/**
 * Every photo slot used on the site, in one place. To bring in a real photo:
 * drop the file in /public/images and set its `src` here — no component
 * changes required. Slots left without `src` render a quiet placeholder.
 */
export const photos = {
  heroConstruction: {
    alt: "FORTの施工写真:上質な佇まいの外観",
  },
  featuredPerformance: {
    alt: "標準仕様:断熱性能",
  },
  featuredInterior: {
    alt: "標準仕様:造作建具",
  },
  featuredWarranty: {
    alt: "標準仕様:保証・点検体制",
  },
  galleryExterior: {
    alt: "施工写真:外観",
  },
  galleryLiving: {
    alt: "施工写真:リビング",
  },
  galleryKitchen: {
    alt: "施工写真:キッチン",
  },
  galleryDetail: {
    alt: "施工写真:素材のディテール",
  },
} satisfies Record<string, PhotoSlot>;
