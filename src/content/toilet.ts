import type { PhotoSlot } from "@/components/ui/Photo";
import type { Point } from "@/components/ui/PointList";
import type { PhotoGridItem } from "@/components/ui/PhotoGrid";
import type { PhotoShowcaseItem } from "@/components/ui/PhotoShowcase";

export const toiletPhotos = {
  hero: { alt: "トイレの施工写真:空間全体" },
  standardToilet: { alt: "標準仕様:便器" },
  standardStorage: { alt: "標準仕様:収納・手洗い" },
  standardFinish: { alt: "標準仕様:内装仕上げ" },
  caseOverview: { alt: "施工事例:トイレ空間" },
  caseDetail: { alt: "施工事例:便器のディテール" },
  caseCounter: { alt: "施工事例:収納・手洗いカウンター" },
  comboA: { alt: "組み合わせ:モノトーン × 真鍮アクセント" },
  comboB: { alt: "組み合わせ:ナチュラル × グリーン" },
  comboC: { alt: "組み合わせ:アクセントクロス × タイル床" },
} satisfies Record<string, PhotoSlot>;

export const toiletReasons: Point[] = [
  { title: "清潔性", note: "汚れに強い素材と形状" },
  { title: "節水性能", note: "環境にもコストにも配慮" },
  { title: "快適性", note: "暖房便座など基本装備" },
];

export const toiletStandardItems: PhotoGridItem[] = [
  { label: "便器", photo: toiletPhotos.standardToilet },
  { label: "収納・手洗い", photo: toiletPhotos.standardStorage },
  { label: "内装仕上げ", photo: toiletPhotos.standardFinish },
];

export const toiletCaseItems: PhotoShowcaseItem[] = [
  { photo: toiletPhotos.caseOverview, caption: "トイレ空間" },
  { photo: toiletPhotos.caseDetail, caption: "便器のディテール" },
  { photo: toiletPhotos.caseCounter, caption: "収納・手洗いカウンター" },
];

export const toiletCombinations: PhotoGridItem[] = [
  { label: "モノトーン × 真鍮アクセント", photo: toiletPhotos.comboA },
  { label: "ナチュラル × グリーン", photo: toiletPhotos.comboB },
  { label: "アクセントクロス × タイル床", photo: toiletPhotos.comboC },
];
