import { photos } from "@/content/photos";

export type FeaturedStandard = {
  category: string;
  title: string;
  lead: string;
  href: string;
  photo: (typeof photos)[keyof typeof photos];
};

/** The 3 standard specs highlighted on TOP, one per pillar (performance / interior / warranty). */
export const featuredStandards: FeaturedStandard[] = [
  {
    category: "性能",
    title: "断熱性能",
    lead: "見えない場所こそ、いちばん妥協しない。",
    href: "/performance",
    photo: photos.featuredPerformance,
  },
  {
    category: "内装",
    title: "造作建具",
    lead: "触れるたびに、上質を感じる。",
    href: "/interior",
    photo: photos.featuredInterior,
  },
  {
    category: "保証",
    title: "定期点検体制",
    lead: "選んだ基準を、守りつづける約束。",
    href: "/warranty",
    photo: photos.featuredWarranty,
  },
];
