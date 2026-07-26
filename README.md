# FORT 社内ポータル

株式会社FORT（岡山・福山の注文住宅／建売の工務店）の社内ポータルサイト。
バラバラのGoogleスプレッドシートで管理している業務（日報・勤怠・席予約など）を、
ひとつのWebアプリにまとめ、全社員が日常的に使う土台をつくる。

設計思想・全体像は `CLAUDE.md` と `docs/` を参照。

---

## 技術スタック

| 項目 | 技術 |
|------|------|
| フレームワーク | Next.js 15（App Router） |
| 言語 | TypeScript |
| DB・認証・ストレージ | Supabase（PostgreSQL / Auth / Storage） |
| 認証方式 | Supabase Auth ＋ Google OAuth（@fort410.jp 限定） |
| スタイリング | Tailwind CSS ＋ shadcn/ui |
| アイコン | lucide-react |
| ホスティング | Vercel |

---

## 開発状況（Phase 0：土台）

Phase 0 は「社員がGoogleでログインでき、空のポータルの枠が表示される」ことがゴール。
現在の実装内容：

- ✅ Next.js 15 + TypeScript + Tailwind + shadcn/ui のプロジェクト基盤
- ✅ FORT ブランドのデザイントークン（色・フォント・角丸・影）を Tailwind に登録
- ✅ Supabase クライアント（server / client / middleware）
- ✅ `employees`・`fiscal_periods` テーブル ＋ RLS（`supabase/migrations/`）
- ✅ Google OAuth ログイン（@fort410.jp のドメイン二重チェック＋招待リスト方式）
- ✅ ログイン後の共通レイアウト（サイドバー＋ヘッダー＋レスポンシブ）
- ✅ ダッシュボード（HOME）の器（サマリー枠は次Phaseで中身を差し込む）
- ✅ 社員マスタ 14名の初期データ（`supabase/seed.sql`）

以降のロードマップは `docs/06_roadmap.md`。

---

## セットアップ

詳細な外部サービス設定は `docs/07_setup.md` を参照。

### 1. 依存をインストール

```bash
npm install
```

### 2. 環境変数を設定

`.env.local.example` を `.env.local` にコピーし、Supabase のキーを設定：

```bash
cp .env.local.example .env.local
# NEXT_PUBLIC_SUPABASE_URL / NEXT_PUBLIC_SUPABASE_ANON_KEY を記入
```

### 3. データベースを用意

Supabase プロジェクトの SQL エディタ（またはローカルの Supabase CLI）で、
以下を順に実行：

1. `supabase/migrations/0000_init.sql`（テーブル・RLS）
2. `supabase/seed.sql`（初期データ）

> ⚠️ `seed.sql` のメールアドレスは仮の値です。ログインは `employees.email` との
> 一致で許可されるため、運用前に実際の @fort410.jp アドレスへ修正してください。

### 4. Google OAuth を設定

`docs/07_setup.md` の手順で、Google Cloud の OAuth クライアントを作成し、
Supabase の Authentication → Providers → Google に設定する。

### 5. 開発サーバー起動

```bash
npm run dev
# → http://localhost:3000
```

---

## フォルダ構成

```
FORT/
├─ CLAUDE.md              … プロジェクト憲法（最初に読む）
├─ docs/                  … 設計書一式
├─ src/
│  ├─ app/
│  │  ├─ (auth)/login/    … ログイン画面
│  │  ├─ auth/            … OAuth コールバック・ログアウト
│  │  └─ (portal)/        … ログイン後のポータル（共通レイアウト＋各画面）
│  ├─ components/         … 共通UI（サイドバー・ヘッダー 等）＋ ui/（shadcn）
│  ├─ lib/                … Supabase クライアント・認証ヘルパー・定数
│  ├─ types/              … DB の型定義
│  └─ middleware.ts       … 認証ガード・セッション更新
├─ supabase/
│  ├─ migrations/         … スキーマ（テーブル・RLS）
│  └─ seed.sql            … 初期データ（社員14名・会計期）
└─ public/                … 静的アセット
```

---

## スクリプト

| コマンド | 内容 |
|----------|------|
| `npm run dev` | 開発サーバー |
| `npm run build` | 本番ビルド |
| `npm run start` | ビルド済みアプリを起動 |
| `npm run lint` | ESLint |
