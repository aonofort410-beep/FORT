import type { PhotoSlot } from "@/components/ui/Photo";
import type { Point } from "@/components/ui/PointList";
import type { PhotoGridItem } from "@/components/ui/PhotoGrid";
import type { PhotoShowcaseItem } from "@/components/ui/PhotoShowcase";

export const warrantyPhotos = {
  hero: { alt: "保証:引き渡し時の説明シーン" },
  standardStructure: { alt: "標準仕様:構造保証" },
  standardEquipment: { alt: "標準仕様:設備保証" },
  standardInspection: { alt: "標準仕様:定期点検" },
  standardSupport: { alt: "標準仕様:アフター対応" },
  caseOverview: { alt: "施工事例:定期点検の様子" },
  caseDetail: { alt: "施工事例:アフターサービススタッフの対応" },
  comboA: { alt: "組み合わせ:構造保証20年 × 5年ごとの定期点検" },
  comboB: { alt: "組み合わせ:設備保証10年 × 24時間サポート窓口" },
  comboC: { alt: "組み合わせ:引き渡し時説明 × 初年度点検" },
} satisfies Record<string, PhotoSlot>;

export const warrantyReasons: Point[] = [
  { title: "構造の保証", note: "長期にわたる安心" },
  { title: "定期点検", note: "変化を早期に見つける" },
  { title: "アフター対応", note: "困った時にすぐ頼れる" },
];

export const warrantyStandardItems: PhotoGridItem[] = [
  { label: "構造保証", photo: warrantyPhotos.standardStructure },
  { label: "設備保証", photo: warrantyPhotos.standardEquipment },
  { label: "定期点検", photo: warrantyPhotos.standardInspection },
  { label: "アフター対応", photo: warrantyPhotos.standardSupport },
];

export const warrantyCaseItems: PhotoShowcaseItem[] = [
  { photo: warrantyPhotos.caseOverview, caption: "定期点検の様子" },
  { photo: warrantyPhotos.caseDetail, caption: "アフターサービススタッフの対応" },
];

export const warrantyCombinations: PhotoGridItem[] = [
  { label: "構造保証20年 × 5年ごとの定期点検", photo: warrantyPhotos.comboA },
  { label: "設備保証10年 × 24時間サポート窓口", photo: warrantyPhotos.comboB },
  { label: "引き渡し時説明 × 初年度点検", photo: warrantyPhotos.comboC },
];
