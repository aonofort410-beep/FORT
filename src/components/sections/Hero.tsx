import { Container } from "@/components/ui/Container";
import { Photo } from "@/components/ui/Photo";
import { photos } from "@/content/photos";

export function Hero() {
  return (
    <section>
      <Container className="pt-28 sm:pt-36">
        <p className="text-xs tracking-[0.32em] text-std-accent">
          FORT DESIGN STANDARD
        </p>
        <h1 className="mt-6 max-w-2xl font-serif text-[clamp(2.1rem,6vw,3.4rem)] leading-[1.5] text-std-ink">
          暮らしを整える標準仕様
        </h1>
      </Container>

      <div className="relative mt-16 aspect-[4/5] w-full overflow-hidden sm:mt-20 sm:aspect-[16/10]">
        <Photo {...photos.heroConstruction} priority sizes="100vw" />
      </div>
    </section>
  );
}
