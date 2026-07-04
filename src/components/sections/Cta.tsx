import { Container } from "@/components/ui/Container";
import { PrimaryButton } from "@/components/ui/Button";

export function Cta() {
  return (
    <section className="bg-std-bg-deep py-24 text-white sm:py-32 lg:py-40">
      <Container className="text-center">
        <h2 className="font-serif text-[clamp(1.6rem,4vw,2.3rem)] leading-[1.6]">
          あなたの理想に、
          <br className="sm:hidden" />
          最適なFORTを。
        </h2>
        <p className="mx-auto mt-6 max-w-md text-sm leading-[1.9] text-white/70">
          標準仕様の考え方が伝わったら、次は暮らしの理想をお聞かせください。
        </p>
        <div className="mt-12">
          <PrimaryButton href="/contact">家づくりの相談をする</PrimaryButton>
        </div>
      </Container>
    </section>
  );
}
