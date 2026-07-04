import type { Metadata } from "next";
import { SiteHeader } from "@/components/ui/SiteHeader";
import "./globals.css";

export const metadata: Metadata = {
  title: "FORT DESIGN STANDARD | 暮らしを整える標準仕様",
  description:
    "FORTが標準仕様として選んでいるものと、その理由を伝えるブランドガイドです。",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="ja" className="h-full antialiased">
      <body className="min-h-full bg-std-bg font-sans text-std-ink">
        <SiteHeader />
        {children}
      </body>
    </html>
  );
}
