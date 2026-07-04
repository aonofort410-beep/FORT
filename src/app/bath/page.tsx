import type { Metadata } from "next";
import { CategoryPage } from "@/components/category/CategoryPage";
import {
  bathPhotos,
  bathReasons,
  bathStandardItems,
  bathCaseItems,
  bathCombinations,
} from "@/content/bath";

export const metadata: Metadata = {
  title: "浴室 | FORT DESIGN STANDARD",
  description: "FORTの施工事例からご覧いただく、浴室の標準仕様と考え方。",
};

export default function BathPage() {
  return (
    <CategoryPage
      eyebrow="BATHROOM"
      heroHeading="くつろぎに、妥協はいらない。"
      heroPhoto={bathPhotos.hero}
      reasonsLead="くつろぎと安全、両方を基準に選んでいます。"
      reasons={bathReasons}
      standardItems={bathStandardItems}
      caseItems={bathCaseItems}
      combinations={bathCombinations}
      ctaHeading="気になる浴室は、見つかりましたか。"
      ctaButtonLabel="この浴室で相談する"
    />
  );
}
