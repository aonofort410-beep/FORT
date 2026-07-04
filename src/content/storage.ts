import type { PhotoSlot } from "@/components/ui/Photo";
import type { Point } from "@/components/ui/PointList";
import type { PhotoGridItem } from "@/components/ui/PhotoGrid";
import type { PhotoShowcaseItem } from "@/components/ui/PhotoShowcase";

export const storagePhotos = {
  hero: { alt: "収納の施工写真:空間全体" },
  standardCloset: { alt: "標準仕様:クローゼット" },
  standardShoes: { alt: "標準仕様:シューズクローク" },
  standardPantry: { alt: "標準仕様:パントリー" },
  standardShelf: { alt: "標準仕様:可変棚" },
  caseOverview: { alt: "施工事例:収納全体" },
  caseDetail: { alt: "施工事例:収納内部の使い方" },
  comboA: { alt: "組み合わせ:土間収納 × 可動棚" },
  comboB: { alt: "組み合わせ:パントリー × オープン棚" },
  comboC: { alt: "組み合わせ:ウォークインクローゼット × 可変レール" },
} satisfies Record<string, PhotoSlot>;

export const storageReasons: Point[] = [
  { title: "動線設計", note: "使う場所の近くに配置" },
  { title: "可変性", note: "暮らしの変化に対応できる" },
  { title: "適正量", note: "多すぎず、少なすぎず" },
];

export const storageStandardItems: PhotoGridItem[] = [
  { label: "クローゼット", photo: storagePhotos.standardCloset },
  { label: "シューズクローク", photo: storagePhotos.standardShoes },
  { label: "パントリー", photo: storagePhotos.standardPantry },
  { label: "可変棚", photo: storagePhotos.standardShelf },
];

export const storageCaseItems: PhotoShowcaseItem[] = [
  { photo: storagePhotos.caseOverview, caption: "収納全体" },
  { photo: storagePhotos.caseDetail, caption: "収納内部の使い方" },
];

export const storageCombinations: PhotoGridItem[] = [
  { label: "土間収納 × 可動棚", photo: storagePhotos.comboA },
  { label: "パントリー × オープン棚", photo: storagePhotos.comboB },
  { label: "ウォークインクローゼット × 可変レール", photo: storagePhotos.comboC },
];
