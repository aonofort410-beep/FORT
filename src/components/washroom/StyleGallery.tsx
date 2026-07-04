import { Container } from "@/components/ui/Container";
import { PhotoGrid } from "@/components/ui/PhotoGrid";
import { washroomStyles } from "@/content/washroom";

export function StyleGallery() {
  return (
    <section className="py-24 sm:py-32">
      <Container>
        <h2 className="font-serif text-2xl text-std-ink sm:text-3xl">
          スタイルから選ぶ
        </h2>

        <div className="mt-10">
          <PhotoGrid
            items={washroomStyles}
            aspectClassName="aspect-[4/5]"
            columnsClassName="grid-cols-2 sm:grid-cols-3 lg:grid-cols-5"
          />
        </div>
      </Container>
    </section>
  );
}
