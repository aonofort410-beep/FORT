import type { PhotoSlot } from "@/components/ui/Photo";
import type { Point } from "@/components/ui/PointList";
import type { PhotoGridItem } from "@/components/ui/PhotoGrid";
import type { PhotoShowcaseItem } from "@/components/ui/PhotoShowcase";

export const exteriorPhotos = {
  hero: { alt: "外装の施工写真:外観全景" },
  standardWall: { alt: "標準仕様:外壁材" },
  standardRoof: { alt: "標準仕様:屋根材" },
  standardEaves: { alt: "標準仕様:軒天・破風" },
  standardSash: { alt: "標準仕様:サッシ・玄関ドア" },
  caseOverview: { alt: "施工事例:外観" },
  caseEvening: { alt: "施工事例:夕景" },
  caseDetail: { alt: "施工事例:素材のディテール" },
  comboA: { alt: "組み合わせ:ダークグレー外壁 × 木目調ドア" },
  comboB: { alt: "組み合わせ:白い塗り壁 × 黒サッシ" },
  comboC: { alt: "組み合わせ:ガルバリウム × 石調アクセント" },
} satisfies Record<string, PhotoSlot>;

export const exteriorReasons: Point[] = [
  { title: "意匠の一貫性", note: "街並みに馴染む佇まいを保つ" },
  { title: "耐候性", note: "風雨に強く、経年でも美しく" },
  { title: "メンテナンス性", note: "長く付き合える手間で" },
];

export const exteriorStandardItems: PhotoGridItem[] = [
  { label: "外壁材", photo: exteriorPhotos.standardWall },
  { label: "屋根材", photo: exteriorPhotos.standardRoof },
  { label: "軒天・破風", photo: exteriorPhotos.standardEaves },
  { label: "サッシ・玄関ドア", photo: exteriorPhotos.standardSash },
];

export const exteriorCaseItems: PhotoShowcaseItem[] = [
  { photo: exteriorPhotos.caseOverview, caption: "外観" },
  { photo: exteriorPhotos.caseEvening, caption: "夕景" },
  { photo: exteriorPhotos.caseDetail, caption: "素材のディテール" },
];

export const exteriorCombinations: PhotoGridItem[] = [
  { label: "ダークグレー外壁 × 木目調ドア", photo: exteriorPhotos.comboA },
  { label: "白い塗り壁 × 黒サッシ", photo: exteriorPhotos.comboB },
  { label: "ガルバリウム × 石調アクセント", photo: exteriorPhotos.comboC },
];
