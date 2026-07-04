import { Container } from "@/components/ui/Container";
import { Photo } from "@/components/ui/Photo";
import { TextLink } from "@/components/ui/Button";
import { featuredStandards } from "@/content/featured";

export function FeaturedStandard() {
  return (
    <section className="py-24 sm:py-32 lg:py-40">
      <Container>
        <h2 className="max-w-lg font-serif text-2xl text-std-ink sm:text-3xl">
          FORTが大切にしている標準仕様
        </h2>

        <div className="mt-14 grid grid-cols-1 gap-x-10 gap-y-16 sm:grid-cols-3 sm:gap-y-0">
          {featuredStandards.map((item) => (
            <article key={item.href}>
              <div className="relative aspect-[4/3] overflow-hidden">
                <Photo {...item.photo} sizes="(min-width: 640px) 33vw, 100vw" />
              </div>

              <p className="mt-6 text-xs tracking-[0.2em] text-std-ink-soft">
                {item.category}
              </p>
              <h3 className="mt-3 font-serif text-xl text-std-ink">
                {item.title}
              </h3>
              <p className="mt-3 text-base leading-[1.8] text-std-ink">
                {item.lead}
              </p>

              <TextLink href={item.href} className="mt-6">
                詳しく見る
              </TextLink>
            </article>
          ))}
        </div>
      </Container>
    </section>
  );
}
