import { CtaSection } from "@/components/ui/CtaSection";

export function Cta() {
  return (
    <CtaSection
      heading={
        <>
          あなたの理想に、
          <br className="sm:hidden" />
          最適なFORTを。
        </>
      }
      supporting="標準仕様の考え方が伝わったら、次は暮らしの理想をお聞かせください。"
      buttonLabel="家づくりの相談をする"
      href="/contact"
    />
  );
}
