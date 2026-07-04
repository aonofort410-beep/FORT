import type { Metadata } from "next";
import { PageHero } from "@/components/ui/PageHero";
import { Statement } from "@/components/ui/Statement";
import { PointList } from "@/components/ui/PointList";
import { CtaSection } from "@/components/ui/CtaSection";
import { StyleGallery } from "@/components/washroom/StyleGallery";
import { CaseDetail } from "@/components/washroom/CaseDetail";
import { washroomPhotos, washroomCoordinatePoints } from "@/content/washroom";

export const metadata: Metadata = {
  title: "洗面 | FORT DESIGN STANDARD",
  description:
    "FORTの施工事例からご覧いただく、洗面まわりのスタイルとコーディネートの考え方。",
};

export default function WashroomPage() {
  return (
    <main>
      <PageHero
        eyebrow="WASHROOM"
        heading="毎日使う場所だから、美しさと使いやすさを。"
        photo={washroomPhotos.hero}
      />

      <Statement>
        洗面は、ただ手を洗う場所ではなく、暮らしの印象を整える場所。
      </Statement>

      <StyleGallery />

      <CaseDetail />

      <PointList heading="コーディネートのポイント" items={washroomCoordinatePoints} />

      <CtaSection
        heading="気になる雰囲気は、見つかりましたか。"
        buttonLabel="この雰囲気で相談する"
        href="/contact"
      />
    </main>
  );
}
