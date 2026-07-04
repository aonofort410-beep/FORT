import type { PhotoSlot } from "@/components/ui/Photo";
import type { Point } from "@/components/ui/PointList";
import type { PhotoGridItem } from "@/components/ui/PhotoGrid";
import type { PhotoShowcaseItem } from "@/components/ui/PhotoShowcase";

export const bathPhotos = {
  hero: { alt: "浴室の施工写真:全体カット" },
  standardTub: { alt: "標準仕様:浴槽" },
  standardInsulation: { alt: "標準仕様:断熱・保温" },
  standardVentilation: { alt: "標準仕様:換気乾燥暖房" },
  standardFloor: { alt: "標準仕様:床材" },
  caseOverview: { alt: "施工事例:浴室全体" },
  caseDetail: { alt: "施工事例:断熱・保温仕様のディテール" },
  caseVentilation: { alt: "施工事例:換気システム" },
  comboA: { alt: "組み合わせ:グレー系パネル × ウッド調カウンター" },
  comboB: { alt: "組み合わせ:ホワイト × ブラックアクセント" },
  comboC: { alt: "組み合わせ:タイル調 × 上質な照明" },
} satisfies Record<string, PhotoSlot>;

export const bathReasons: Point[] = [
  { title: "断熱・保温", note: "ヒートショックへの配慮" },
  { title: "お手入れのしやすさ", note: "カビや汚れに強く" },
  { title: "くつろぎ", note: "一日の疲れを癒す設え" },
];

export const bathStandardItems: PhotoGridItem[] = [
  { label: "浴槽", photo: bathPhotos.standardTub },
  { label: "断熱・保温", photo: bathPhotos.standardInsulation },
  { label: "換気乾燥暖房", photo: bathPhotos.standardVentilation },
  { label: "床材", photo: bathPhotos.standardFloor },
];

export const bathCaseItems: PhotoShowcaseItem[] = [
  { photo: bathPhotos.caseOverview, caption: "浴室全体" },
  { photo: bathPhotos.caseDetail, caption: "断熱・保温仕様のディテール" },
  { photo: bathPhotos.caseVentilation, caption: "換気システム" },
];

export const bathCombinations: PhotoGridItem[] = [
  { label: "グレー系パネル × ウッド調カウンター", photo: bathPhotos.comboA },
  { label: "ホワイト × ブラックアクセント", photo: bathPhotos.comboB },
  { label: "タイル調 × 上質な照明", photo: bathPhotos.comboC },
];
