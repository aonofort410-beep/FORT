import type { PhotoSlot } from "@/components/ui/Photo";
import type { Point } from "@/components/ui/PointList";
import type { PhotoGridItem } from "@/components/ui/PhotoGrid";
import type { PhotoShowcaseItem } from "@/components/ui/PhotoShowcase";

export const lightingPhotos = {
  hero: { alt: "照明の施工写真:夜の室内カット" },
  standardDownlight: { alt: "標準仕様:ダウンライト計画" },
  standardLed: { alt: "標準仕様:LED仕様" },
  standardDimming: { alt: "標準仕様:調光・シーン照明" },
  caseOverview: { alt: "施工事例:夜のリビング" },
  caseDetail: { alt: "施工事例:間接照明のディテール" },
  caseRoom: { alt: "施工事例:各部屋の照明配置" },
  comboA: { alt: "組み合わせ:ダウンライト × 間接照明" },
  comboB: { alt: "組み合わせ:ペンダント × ダウンライト" },
  comboC: { alt: "組み合わせ:スポットライト × 調光" },
} satisfies Record<string, PhotoSlot>;

export const lightingReasons: Point[] = [
  { title: "機能性", note: "必要な明るさを確保" },
  { title: "情緒性", note: "時間帯ごとの心地よさ" },
  { title: "省エネ性", note: "LED標準化によるランニングコスト" },
];

export const lightingStandardItems: PhotoGridItem[] = [
  { label: "ダウンライト計画", photo: lightingPhotos.standardDownlight },
  { label: "LED仕様", photo: lightingPhotos.standardLed },
  { label: "調光・シーン照明", photo: lightingPhotos.standardDimming },
];

export const lightingCaseItems: PhotoShowcaseItem[] = [
  { photo: lightingPhotos.caseOverview, caption: "夜のリビング" },
  { photo: lightingPhotos.caseDetail, caption: "間接照明のディテール" },
  { photo: lightingPhotos.caseRoom, caption: "各部屋の照明配置" },
];

export const lightingCombinations: PhotoGridItem[] = [
  { label: "ダウンライト × 間接照明", photo: lightingPhotos.comboA },
  { label: "ペンダント × ダウンライト", photo: lightingPhotos.comboB },
  { label: "スポットライト × 調光", photo: lightingPhotos.comboC },
];
