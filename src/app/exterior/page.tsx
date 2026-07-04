import type { Metadata } from "next";
import { CategoryPage } from "@/components/category/CategoryPage";
import {
  exteriorPhotos,
  exteriorReasons,
  exteriorStandardItems,
  exteriorCaseItems,
  exteriorCombinations,
} from "@/content/exterior";

export const metadata: Metadata = {
  title: "外装 | FORT DESIGN STANDARD",
  description: "FORTの施工事例からご覧いただく、外装まわりの標準仕様と考え方。",
};

export default function ExteriorPage() {
  return (
    <CategoryPage
      eyebrow="EXTERIOR"
      heroHeading="十年後も、美しくあるために。"
      heroPhoto={exteriorPhotos.hero}
      reasonsLead="意匠と耐候性、両方を妥協しないための外装仕様です。"
      reasons={exteriorReasons}
      standardItems={exteriorStandardItems}
      caseItems={exteriorCaseItems}
      combinations={exteriorCombinations}
      ctaHeading="気になる外観は、見つかりましたか。"
      ctaButtonLabel="この外観で相談する"
    />
  );
}
