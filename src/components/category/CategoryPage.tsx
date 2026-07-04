import type { PhotoSlot } from "@/components/ui/Photo";
import type { PhotoGridItem } from "@/components/ui/PhotoGrid";
import type { PhotoShowcaseItem } from "@/components/ui/PhotoShowcase";
import type { Point } from "@/components/ui/PointList";
import { PageHero } from "@/components/ui/PageHero";
import { PointList } from "@/components/ui/PointList";
import { PhotoGridSection } from "@/components/ui/PhotoGridSection";
import { PhotoShowcase } from "@/components/ui/PhotoShowcase";
import { CtaSection } from "@/components/ui/CtaSection";

export type CategoryPageProps = {
  eyebrow: string;
  heroHeading: string;
  heroPhoto: PhotoSlot;
  reasonsLead: string;
  reasons: Point[];
  standardItems: PhotoGridItem[];
  caseItems: PhotoShowcaseItem[];
  combinations: PhotoGridItem[];
  ctaHeading: string;
  ctaButtonLabel: string;
};

/**
 * Shared 6-section template for category pages: Hero, FORTが選ぶ理由,
 * 標準仕様, 施工事例, おすすめの組み合わせ, CTA. Used by every category
 * page except TOP and 洗面, which have their own bespoke layouts.
 */
export function CategoryPage({
  eyebrow,
  heroHeading,
  heroPhoto,
  reasonsLead,
  reasons,
  standardItems,
  caseItems,
  combinations,
  ctaHeading,
  ctaButtonLabel,
}: CategoryPageProps) {
  return (
    <main>
      <PageHero eyebrow={eyebrow} heading={heroHeading} photo={heroPhoto} />

      <PointList heading="FORTが選ぶ理由" lead={reasonsLead} items={reasons} />

      <PhotoGridSection
        heading="標準仕様"
        items={standardItems}
        aspectClassName="aspect-square"
        columnsClassName="grid-cols-2 sm:grid-cols-3"
      />

      <PhotoShowcase heading="施工事例" items={caseItems} />

      <PhotoGridSection
        heading="おすすめの組み合わせ"
        items={combinations}
        aspectClassName="aspect-[4/5]"
        columnsClassName="grid-cols-2 sm:grid-cols-3"
      />

      <CtaSection
        heading={ctaHeading}
        buttonLabel={ctaButtonLabel}
        href="/contact"
      />
    </main>
  );
}
