import Link from "next/link";
import { Container } from "@/components/ui/Container";
import { categories } from "@/content/categories";

export function CategoryNav() {
  return (
    <section className="py-24 sm:py-32">
      <Container>
        <h2 className="font-serif text-2xl text-std-ink sm:text-3xl">
          標準仕様をカテゴリから見る
        </h2>

        <div className="mt-10 grid grid-cols-2 gap-x-8 border-t border-std-line sm:grid-cols-3 sm:gap-x-10">
          {categories.map((category) => (
            <Link
              key={category.href}
              href={category.href}
              className="group flex items-center justify-between gap-3 border-b border-std-line py-6 text-base text-std-ink transition-colors duration-300 hover:text-std-accent sm:py-7"
            >
              <span>{category.label}</span>
              <span
                aria-hidden
                className="text-std-ink-soft transition-transform duration-300 group-hover:translate-x-1 group-hover:text-std-accent"
              >
                →
              </span>
            </Link>
          ))}
        </div>
      </Container>
    </section>
  );
}
