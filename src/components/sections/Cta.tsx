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
      buttonLabel="家づくりの相談をする"
      href="/contact"
    />
  );
}
