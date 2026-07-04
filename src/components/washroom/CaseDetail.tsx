import { Container } from "@/components/ui/Container";
import { Photo } from "@/components/ui/Photo";
import { PhotoGrid } from "@/components/ui/PhotoGrid";
import { washroomPhotos, washroomCaseItems } from "@/content/washroom";

export function CaseDetail() {
  return (
    <section className="py-24 sm:py-32">
      <Container>
        <h2 className="font-serif text-2xl text-std-ink sm:text-3xl">
          施工事例
        </h2>
      </Container>

      <div className="relative mt-10 aspect-[16/10] w-full overflow-hidden sm:aspect-[21/9]">
        <Photo {...washroomPhotos.caseOverview} sizes="100vw" />
      </div>

      <Container className="mt-14">
        <p className="text-xs tracking-[0.14em] text-std-ink-soft">採用したもの</p>
        <div className="mt-6">
          <PhotoGrid
            items={washroomCaseItems}
            aspectClassName="aspect-square"
            columnsClassName="grid-cols-2 sm:grid-cols-3"
          />
        </div>
      </Container>
    </section>
  );
}
