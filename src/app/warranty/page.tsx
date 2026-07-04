import type { Metadata } from "next";
import { CategoryPage } from "@/components/category/CategoryPage";
import {
  warrantyPhotos,
  warrantyReasons,
  warrantyStandardItems,
  warrantyCaseItems,
  warrantyCombinations,
} from "@/content/warranty";

export const metadata: Metadata = {
  title: "保証 | FORT DESIGN STANDARD",
  description: "FORTの施工事例からご覧いただく、保証・アフターサービスの考え方。",
};

export default function WarrantyPage() {
  return (
    <CategoryPage
      eyebrow="WARRANTY"
      heroHeading="選んだ基準を、守りつづける約束。"
      heroPhoto={warrantyPhotos.hero}
      reasonsLead="引き渡した後も、同じ基準で支え続けるために。"
      reasons={warrantyReasons}
      standardItems={warrantyStandardItems}
      caseItems={warrantyCaseItems}
      combinations={warrantyCombinations}
      ctaHeading="保証について、詳しく知りたくなりましたか。"
      ctaButtonLabel="保証について相談する"
    />
  );
}
