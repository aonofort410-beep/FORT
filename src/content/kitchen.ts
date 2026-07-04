import type { PhotoSlot } from "@/components/ui/Photo";
import type { Point } from "@/components/ui/PointList";
import type { PhotoGridItem } from "@/components/ui/PhotoGrid";
import type { PhotoShowcaseItem } from "@/components/ui/PhotoShowcase";

export const kitchenPhotos = {
  hero: { alt: "キッチンの施工写真:全体カット" },
  standardBody: { alt: "標準仕様:キッチン本体" },
  standardCounter: { alt: "標準仕様:天板" },
  standardStorage: { alt: "標準仕様:収納" },
  standardFaucet: { alt: "標準仕様:水栓" },
  standardHood: { alt: "標準仕様:レンジフード" },
  caseOverview: { alt: "施工事例:キッチン全体" },
  caseDetail: { alt: "施工事例:天板・水栓のディテール" },
  caseStorage: { alt: "施工事例:収納内部" },
  comboA: { alt: "組み合わせ:ステンレス天板 × ブラック取っ手" },
  comboB: { alt: "組み合わせ:人造大理石 × ウッド収納" },
  comboC: { alt: "組み合わせ:タイル壁 × 真鍮水栓" },
} satisfies Record<string, PhotoSlot>;

export const kitchenReasons: Point[] = [
  { title: "家事動線", note: "無理のない配置と高さ" },
  { title: "耐久性", note: "水・熱に強い素材選び" },
  { title: "デザイン性", note: "LDK全体との調和" },
];

export const kitchenStandardItems: PhotoGridItem[] = [
  { label: "キッチン本体", photo: kitchenPhotos.standardBody },
  { label: "天板", photo: kitchenPhotos.standardCounter },
  { label: "収納", photo: kitchenPhotos.standardStorage },
  { label: "水栓", photo: kitchenPhotos.standardFaucet },
  { label: "レンジフード", photo: kitchenPhotos.standardHood },
];

export const kitchenCaseItems: PhotoShowcaseItem[] = [
  { photo: kitchenPhotos.caseOverview, caption: "キッチン全体" },
  { photo: kitchenPhotos.caseDetail, caption: "天板・水栓のディテール" },
  { photo: kitchenPhotos.caseStorage, caption: "収納内部" },
];

export const kitchenCombinations: PhotoGridItem[] = [
  { label: "ステンレス天板 × ブラック取っ手", photo: kitchenPhotos.comboA },
  { label: "人造大理石 × ウッド収納", photo: kitchenPhotos.comboB },
  { label: "タイル壁 × 真鍮水栓", photo: kitchenPhotos.comboC },
];
