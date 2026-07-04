import type { Metadata } from "next";
import { CategoryPage } from "@/components/category/CategoryPage";
import {
  interiorPhotos,
  interiorReasons,
  interiorStandardItems,
  interiorCaseItems,
  interiorCombinations,
} from "@/content/interior";

export const metadata: Metadata = {
  title: "内装 | FORT DESIGN STANDARD",
  description: "FORTの施工事例からご覧いただく、内装まわりの標準仕様と考え方。",
};

export default function InteriorPage() {
  return (
    <CategoryPage
      eyebrow="INTERIOR"
      heroHeading="触れるたびに、上質を感じる。"
      heroPhoto={interiorPhotos.hero}
      reasonsLead="毎日手が触れる場所だからこそ、素材から選んでいます。"
      reasons={interiorReasons}
      standardItems={interiorStandardItems}
      caseItems={interiorCaseItems}
      combinations={interiorCombinations}
      ctaHeading="気になる内装は、見つかりましたか。"
      ctaButtonLabel="この内装で相談する"
    />
  );
}
