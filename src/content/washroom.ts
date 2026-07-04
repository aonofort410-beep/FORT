import type { PhotoSlot } from "@/components/ui/Photo";
import type { Point } from "@/components/ui/PointList";

/**
 * Photo slots for the washroom page. Leave `src` unset for a placeholder;
 * set it once real case photography is ready (see src/content/photos.ts).
 */
export const washroomPhotos = {
  hero: { alt: "洗面の施工写真:大きな空間カット" },

  styleHotel: { alt: "スタイル:ホテルライク" },
  styleNatural: { alt: "スタイル:ナチュラル" },
  styleGreige: { alt: "スタイル:グレージュ" },
  styleBlack: { alt: "スタイル:ブラック" },
  styleJapandi: { alt: "スタイル:ジャパンディ" },

  caseOverview: { alt: "施工事例:洗面全体" },
  caseCounter: { alt: "採用品:カウンター" },
  caseBowl: { alt: "採用品:ボウル" },
  caseMirror: { alt: "採用品:ミラー" },
  caseLighting: { alt: "採用品:照明" },
  caseStorage: { alt: "採用品:収納" },
  caseWall: { alt: "採用品:クロス・タイル" },
} satisfies Record<string, PhotoSlot>;

export const washroomStyles = [
  { label: "ホテルライク", photo: washroomPhotos.styleHotel },
  { label: "ナチュラル", photo: washroomPhotos.styleNatural },
  { label: "グレージュ", photo: washroomPhotos.styleGreige },
  { label: "ブラック", photo: washroomPhotos.styleBlack },
  { label: "ジャパンディ", photo: washroomPhotos.styleJapandi },
];

export const washroomCaseItems = [
  { label: "カウンター", photo: washroomPhotos.caseCounter },
  { label: "ボウル", photo: washroomPhotos.caseBowl },
  { label: "ミラー", photo: washroomPhotos.caseMirror },
  { label: "照明", photo: washroomPhotos.caseLighting },
  { label: "収納", photo: washroomPhotos.caseStorage },
  { label: "クロス・タイル", photo: washroomPhotos.caseWall },
];

export const washroomCoordinatePoints: Point[] = [
  { title: "色合わせ", note: "床・壁・建具の色温度を揃える" },
  { title: "素材感", note: "光の当たり方で質感を選ぶ" },
  { title: "掃除のしやすさ", note: "凹凸の少ない形状を選ぶ" },
  { title: "収納量", note: "使う人数と持ち物量から逆算する" },
];
