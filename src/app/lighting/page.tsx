import type { Metadata } from "next";
import { CategoryPage } from "@/components/category/CategoryPage";
import {
  lightingPhotos,
  lightingReasons,
  lightingStandardItems,
  lightingCaseItems,
  lightingCombinations,
} from "@/content/lighting";

export const metadata: Metadata = {
  title: "照明 | FORT DESIGN STANDARD",
  description: "FORTの施工事例からご覧いただく、照明の標準仕様と考え方。",
};

export default function LightingPage() {
  return (
    <CategoryPage
      eyebrow="LIGHTING"
      heroHeading="灯りひとつで、暮らしが変わる。"
      heroPhoto={lightingPhotos.hero}
      reasonsLead="明るさだけでなく、時間帯ごとの心地よさを設計します。"
      reasons={lightingReasons}
      standardItems={lightingStandardItems}
      caseItems={lightingCaseItems}
      combinations={lightingCombinations}
      ctaHeading="気になる灯りは、見つかりましたか。"
      ctaButtonLabel="この照明プランで相談する"
    />
  );
}
