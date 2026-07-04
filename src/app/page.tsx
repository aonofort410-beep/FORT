import { Hero } from "@/components/sections/Hero";
import { Concept } from "@/components/sections/Concept";
import { CategoryNav } from "@/components/sections/CategoryNav";
import { FeaturedStandard } from "@/components/sections/FeaturedStandard";
import { Gallery } from "@/components/sections/Gallery";
import { Cta } from "@/components/sections/Cta";

export default function Home() {
  return (
    <main>
      <Hero />
      <Concept />
      <CategoryNav />
      <FeaturedStandard />
      <Gallery />
      <Cta />
    </main>
  );
}
