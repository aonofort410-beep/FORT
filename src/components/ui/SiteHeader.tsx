import Link from "next/link";
import { Container } from "@/components/ui/Container";

/** The only persistent navigation on the site: a quiet wordmark back to TOP. */
export function SiteHeader() {
  return (
    <header className="py-6">
      <Container>
        <Link href="/" className="text-sm tracking-[0.3em] text-std-ink">
          FORT
        </Link>
      </Container>
    </header>
  );
}
