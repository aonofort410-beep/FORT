export type Category = {
  label: string;
  href: string;
};

/** Category nav on TOP. "性能" has no page yet — link is ready for when it does. */
export const categories: Category[] = [
  { label: "性能", href: "/performance" },
  { label: "外装", href: "/exterior" },
  { label: "内装", href: "/interior" },
  { label: "収納", href: "/storage" },
  { label: "キッチン", href: "/kitchen" },
  { label: "洗面", href: "/washroom" },
  { label: "浴室", href: "/bath" },
  { label: "トイレ", href: "/toilet" },
  { label: "照明", href: "/lighting" },
  { label: "保証", href: "/warranty" },
];
