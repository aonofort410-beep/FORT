import { PhotoGridSection } from "@/components/ui/PhotoGridSection";
import { washroomStyles } from "@/content/washroom";

export function StyleGallery() {
  return (
    <PhotoGridSection
      heading="スタイルから選ぶ"
      items={washroomStyles}
      aspectClassName="aspect-[4/5]"
      columnsClassName="grid-cols-2 sm:grid-cols-3 lg:grid-cols-5"
    />
  );
}
