import { PageHero } from "@/components/ui/PageHero";
import { photos } from "@/content/photos";

export function Hero() {
  return (
    <PageHero
      eyebrow="FORT DESIGN STANDARD"
      heading="暮らしを整える標準仕様"
      photo={photos.heroConstruction}
    />
  );
}
