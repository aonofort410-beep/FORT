import type { PhotoSlot } from "@/components/ui/Photo";
import type { Point } from "@/components/ui/PointList";
import type { PhotoGridItem } from "@/components/ui/PhotoGrid";
import type { PhotoShowcaseItem } from "@/components/ui/PhotoShowcase";

export const interiorPhotos = {
  hero: { alt: "内装の施工写真:リビング全体" },
  standardFloor: { alt: "標準仕様:床材" },
  standardDoor: { alt: "標準仕様:建具" },
  standardFurniture: { alt: "標準仕様:造作家具" },
  standardWall: { alt: "標準仕様:壁装仕上げ" },
  caseOverview: { alt: "施工事例:リビング" },
  caseDetail: { alt: "施工事例:床材のディテール" },
  caseFurniture: { alt: "施工事例:造作家具" },
  comboA: { alt: "組み合わせ:無垢床 × 白い壁" },
  comboB: { alt: "組み合わせ:モルタル調 × ブラック建具" },
  comboC: { alt: "組み合わせ:タイル × 木製造作" },
} satisfies Record<string, PhotoSlot>;

export const interiorReasons: Point[] = [
  { title: "素材の質感", note: "手に触れて分かる違いを" },
  { title: "経年美", note: "使うほどに馴染む表情" },
  { title: "掃除・耐久性", note: "日々の暮らしに耐える丈夫さ" },
];

export const interiorStandardItems: PhotoGridItem[] = [
  { label: "床材", photo: interiorPhotos.standardFloor },
  { label: "建具", photo: interiorPhotos.standardDoor },
  { label: "造作家具", photo: interiorPhotos.standardFurniture },
  { label: "壁装仕上げ", photo: interiorPhotos.standardWall },
];

export const interiorCaseItems: PhotoShowcaseItem[] = [
  { photo: interiorPhotos.caseOverview, caption: "リビング" },
  { photo: interiorPhotos.caseDetail, caption: "床材のディテール" },
  { photo: interiorPhotos.caseFurniture, caption: "造作家具" },
];

export const interiorCombinations: PhotoGridItem[] = [
  { label: "無垢床 × 白い壁", photo: interiorPhotos.comboA },
  { label: "モルタル調 × ブラック建具", photo: interiorPhotos.comboB },
  { label: "タイル × 木製造作", photo: interiorPhotos.comboC },
];
