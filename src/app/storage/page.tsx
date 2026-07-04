import type { Metadata } from "next";
import { CategoryPage } from "@/components/category/CategoryPage";
import {
  storagePhotos,
  storageReasons,
  storageStandardItems,
  storageCaseItems,
  storageCombinations,
} from "@/content/storage";

export const metadata: Metadata = {
  title: "収納 | FORT DESIGN STANDARD",
  description: "FORTの施工事例からご覧いただく、収納の標準仕様と考え方。",
};

export default function StoragePage() {
  return (
    <CategoryPage
      eyebrow="STORAGE"
      heroHeading="片づいた暮らしは、設計から生まれる。"
      heroPhoto={storagePhotos.hero}
      reasonsLead="量より配置。暮らしの動線から逆算しています。"
      reasons={storageReasons}
      standardItems={storageStandardItems}
      caseItems={storageCaseItems}
      combinations={storageCombinations}
      ctaHeading="気になる収納は、見つかりましたか。"
      ctaButtonLabel="この収納プランで相談する"
    />
  );
}
