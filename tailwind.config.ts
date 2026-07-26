import type { Config } from "tailwindcss";

/**
 * FORT ブランドのデザイントークン。
 * 色の実値は src/app/globals.css の CSS 変数で定義し、ここでは参照する。
 * （docs/03_design_system.md を参照）
 */
const config: Config = {
  darkMode: ["class"],
  content: [
    "./src/pages/**/*.{ts,tsx}",
    "./src/components/**/*.{ts,tsx}",
    "./src/app/**/*.{ts,tsx}",
  ],
  theme: {
    container: {
      center: true,
      padding: "1.5rem",
      screens: { "2xl": "1400px" },
    },
    extend: {
      colors: {
        // ── FORT ベーストークン ──
        bg: "var(--bg)",
        card: "var(--card)",
        ink: "var(--ink)",
        sub: "var(--sub)",
        line: "var(--line)",
        dark: "var(--dark)",
        // ── アクセント ──
        bronze: "var(--bronze)",
        olive: "var(--olive)",
        // ── 部署カラー ──
        "dept-exec": "#9A8060",
        "dept-sales": "#6F7565",
        "dept-design": "#7C7A8A",
        "dept-works": "#8A7560",
        "dept-admin": "#6B7A7C",

        // ── shadcn/ui 互換トークン（FORT の値へ寄せる）──
        border: "var(--line)",
        input: "var(--line)",
        ring: "var(--bronze)",
        background: "var(--bg)",
        foreground: "var(--ink)",
        primary: {
          DEFAULT: "var(--bronze)",
          foreground: "#FFFFFF",
        },
        secondary: {
          DEFAULT: "var(--olive)",
          foreground: "#FFFFFF",
        },
        muted: {
          DEFAULT: "#ECEBE6",
          foreground: "var(--sub)",
        },
        accent: {
          DEFAULT: "#EAEEE7",
          foreground: "var(--ink)",
        },
        destructive: {
          DEFAULT: "#A85A52",
          foreground: "#FFFFFF",
        },
        popover: {
          DEFAULT: "var(--card)",
          foreground: "var(--ink)",
        },
      },
      borderRadius: {
        // 角丸は控えめ（6〜8px）
        lg: "8px",
        md: "6px",
        sm: "4px",
      },
      boxShadow: {
        // 影は極薄
        card: "0 1px 2px rgba(0,0,0,.04)",
        "card-hover": "0 4px 12px rgba(0,0,0,.06)",
      },
      fontFamily: {
        sans: ["var(--font-noto-sans-jp)", "var(--font-inter)", "sans-serif"],
        heading: ["var(--font-inter)", "var(--font-noto-sans-jp)", "sans-serif"],
      },
      letterSpacing: {
        label: "0.1em",
      },
      keyframes: {
        "accordion-down": {
          from: { height: "0" },
          to: { height: "var(--radix-accordion-content-height)" },
        },
        "accordion-up": {
          from: { height: "var(--radix-accordion-content-height)" },
          to: { height: "0" },
        },
      },
      animation: {
        "accordion-down": "accordion-down 0.2s ease-out",
        "accordion-up": "accordion-up 0.2s ease-out",
      },
    },
  },
  plugins: [require("tailwindcss-animate")],
};

export default config;
