import type { Metadata } from "next";
import { CategoryPage } from "@/components/category/CategoryPage";
import {
  toiletPhotos,
  toiletReasons,
  toiletStandardItems,
  toiletCaseItems,
  toiletCombinations,
} from "@/content/toilet";

export const metadata: Metadata = {
  title: "トイレ | FORT DESIGN STANDARD",
  description: "FORTの施工事例からご覧いただく、トイレの標準仕様と考え方。",
};

export default function ToiletPage() {
  return (
    <CategoryPage
      eyebrow="TOILET"
      heroHeading="見えない配慮こそ、標準に。"
      heroPhoto={toiletPhotos.hero}
      reasonsLead="清潔さも快適さも、標準であるべきだと考えています。"
      reasons={toiletReasons}
      standardItems={toiletStandardItems}
      caseItems={toiletCaseItems}
      combinations={toiletCombinations}
      ctaHeading="気になるトイレは、見つかりましたか。"
      ctaButtonLabel="このトイレで相談する"
    />
  );
}
