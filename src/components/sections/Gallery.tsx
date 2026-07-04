import { PhotoShowcase } from "@/components/ui/PhotoShowcase";
import { photos } from "@/content/photos";

const items = [
  { photo: photos.galleryExterior, caption: "外観" },
  { photo: photos.galleryLiving, caption: "リビング" },
  { photo: photos.galleryKitchen, caption: "キッチン" },
  { photo: photos.galleryDetail, caption: "素材のディテール" },
];

export function Gallery() {
  return <PhotoShowcase heading="施工写真" items={items} />;
}
