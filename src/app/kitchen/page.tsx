import type { Metadata } from "next";
import { CategoryPage } from "@/components/category/CategoryPage";
import {
  kitchenPhotos,
  kitchenReasons,
  kitchenStandardItems,
  kitchenCaseItems,
  kitchenCombinations,
} from "@/content/kitchen";

export const metadata: Metadata = {
  title: "キッチン | FORT DESIGN STANDARD",
  description: "FORTの施工事例からご覧いただく、キッチンの標準仕様と考え方。",
};

export default function KitchenPage() {
  return (
    <CategoryPage
      eyebrow="KITCHEN"
      heroHeading="使いやすさは、選び抜いた結果。"
      heroPhoto={kitchenPhotos.hero}
      reasonsLead="家事動線と美しさを、同時に叶えるために選んでいます。"
      reasons={kitchenReasons}
      standardItems={kitchenStandardItems}
      caseItems={kitchenCaseItems}
      combinations={kitchenCombinations}
      ctaHeading="気になるキッチンは、見つかりましたか。"
      ctaButtonLabel="このキッチンで相談する"
    />
  );
}
