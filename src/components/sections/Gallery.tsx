import { Container } from "@/components/ui/Container";
import { Photo } from "@/components/ui/Photo";
import { photos } from "@/content/photos";

const items = [
  { photo: photos.galleryExterior, caption: "外観" },
  { photo: photos.galleryLiving, caption: "リビング" },
  { photo: photos.galleryKitchen, caption: "キッチン" },
  { photo: photos.galleryDetail, caption: "素材のディテール" },
];

export function Gallery() {
  return (
    <section className="py-24 sm:py-32">
      <Container>
        <h2 className="font-serif text-2xl text-std-ink sm:text-3xl">
          施工写真
        </h2>
      </Container>

      <div className="mt-14 flex flex-col gap-16 sm:mt-16 sm:gap-24">
        {items.map((item) => (
          <figure key={item.caption}>
            <div className="relative aspect-[16/10] w-full overflow-hidden">
              <Photo {...item.photo} sizes="100vw" />
            </div>
            <figcaption className="mt-4 text-xs tracking-[0.14em] text-std-ink-soft">
              <Container>{item.caption}</Container>
            </figcaption>
          </figure>
        ))}
      </div>
    </section>
  );
}
