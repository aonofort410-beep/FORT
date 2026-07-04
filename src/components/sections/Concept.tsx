import { Container } from "@/components/ui/Container";

export function Concept() {
  return (
    <section className="py-24 sm:py-32 lg:py-40">
      <Container className="text-center">
        <p className="mx-auto max-w-2xl font-serif text-[clamp(1.4rem,3.4vw,1.9rem)] leading-[1.7] text-std-ink">
          標準仕様は、暮らしを整えるための基準です。
        </p>
        <p className="mx-auto mt-6 max-w-md text-sm leading-[1.9] text-std-ink-soft">
          FORTが選ぶ理由には、いつも同じ基準があります。
        </p>
      </Container>
    </section>
  );
}
