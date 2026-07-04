import { photos } from "@/content/photos";

export type FeaturedStandard = {
  category: string;
  title: string;
  lead: string;
  description: string;
  href: string;
  photo: (typeof photos)[keyof typeof photos];
};

/** The 3 standard specs highlighted on TOP, one per pillar (performance / interior / warranty). */
export const featuredStandards: FeaturedStandard[] = [
  {
    category: "性能",
    title: "断熱性能",
    lead: "見えない場所こそ、いちばん妥協しない。",
    description:
      "家族が過ごす一年を通じて心地よい温度を保てるよう、断熱性能を標準仕様として定めています。",
    href: "/performance",
    photo: photos.featuredPerformance,
  },
  {
    category: "内装",
    title: "造作建具",
    lead: "触れるたびに、上質を感じる。",
    description:
      "毎日手が触れる場所だからこそ、素材の質感と仕上げにこだわって選んでいます。",
    href: "/interior",
    photo: photos.featuredInterior,
  },
  {
    category: "保証",
    title: "定期点検体制",
    lead: "選んだ基準を、守りつづける約束。",
    description:
      "引き渡した後も、同じ基準で暮らしを支え続けるための点検体制を整えています。",
    href: "/warranty",
    photo: photos.featuredWarranty,
  },
];
