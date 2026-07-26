# 05 ｜ アーキテクチャ

## 技術構成の全体像

```
[社員のブラウザ / スマホ]
        │
        ▼
[ Next.js アプリ（Vercel上） ]
   ├─ 画面（React / App Router）
   ├─ サーバー処理（Server Components / Route Handlers）
        │
        ▼
[ Supabase ]
   ├─ Auth（Google OAuth で @fort410.jp ログイン）
   ├─ PostgreSQL（データ本体、RLSで保護）
   └─ Storage（資料ファイル等）
```

- フロントもバックエンドも **Next.js 1つ** にまとまる（別途サーバー不要）。
- データと認証は **Supabase** が引き受ける。
- デプロイは **Vercel**。GitHubにpushすると自動でデプロイされる。

---

## フォルダ構成（目安）

```
fort-portal/
├─ CLAUDE.md                  … Claude Code用の中心ドキュメント
├─ docs/                      … 設計書（この一式）
├─ src/
│  ├─ app/                    … 画面（App Router）
│  │  ├─ (auth)/login/        … ログイン画面
│  │  ├─ (portal)/            … ログイン後のポータル
│  │  │  ├─ layout.tsx        … サイドバー＋ヘッダーの共通枠
│  │  │  ├─ page.tsx          … ダッシュボード（HOME）
│  │  │  ├─ reports/          … 日報
│  │  │  ├─ attendance/       … 勤怠
│  │  │  ├─ reservations/     … 予約
│  │  │  ├─ projects/         … 案件
│  │  │  ├─ tasks/            … タスク
│  │  │  ├─ approvals/        … 申請
│  │  │  ├─ staff/            … 社員
│  │  │  ├─ qualifications/   … 資格
│  │  │  ├─ knowledge/        … ナレッジ
│  │  │  └─ settings/         … 設定
│  │  └─ api/                 … 必要なAPIルート
│  ├─ components/             … 共通UI部品（Card, Pill, LoadBar 等）
│  │  └─ ui/                  … shadcn/ui
│  ├─ lib/
│  │  ├─ supabase/            … Supabaseクライアント（server/client）
│  │  ├─ auth.ts              … 認証ヘルパー（現在のユーザー・権限取得）
│  │  └─ utils.ts
│  └─ types/                  … 型定義（DBの型を含む）
├─ supabase/
│  ├─ migrations/             … DBスキーマのSQL（テーブル・RLS）
│  └─ seed.sql                … 初期データ（社員・会場 等）
├─ .env.local                 … 環境変数（キー類、gitに入れない）
├─ package.json
└─ tailwind.config.ts
```

---

## 認証の仕組み

1. 社員がログイン画面で「Googleでログイン」を押す。
2. Supabase Auth 経由でGoogle認証。**@fort410.jp ドメインのみ許可**する
   （それ以外のGoogleアカウントは弾く）。
3. 初回ログイン時、その `auth_user_id` に対応する `employees` レコードを探す。
   - あれば、その社員として入る。
   - なければ、管理者が事前に登録した招待リスト（メール一致）で紐付ける、
     もしくは「未登録」として総務が承認するフローにする。
4. ログイン後は、`employees.permission` の値で見える範囲・操作を制御する。

> ドメイン制限は、Google Cloud の OAuth 設定と、Supabase 側 or アプリ側の
> チェックの二重で担保する。設定手順は `07_setup.md`。

---

## 権限（ロール）と可視範囲

| ロール | 主な範囲 |
|--------|----------|
| `executive`（経営） | 全社の全データ。ダッシュボード・設定・全社員閲覧。 |
| `manager`（管理職） | 自部署＋関連案件を広く。部下の日報・勤怠閲覧、一次承認。 |
| `hr`（総務） | 勤怠・休日・申請・社員マスタの管理。給与関連の下地。 |
| `member`（一般） | 自分の日報・勤怠・タスク。予約・案件は業務範囲で閲覧・編集。 |

---

## RLS（Row Level Security）の方針

Supabaseでは、テーブルごとに「誰がどの行を読めるか／書けるか」を
SQLのポリシーで定義する。原則：

- **自分のデータは自分が読み書きできる**
  （例：`daily_reports` は `employee_id = 自分` なら可）。
- **経営・管理職・総務は、役割に応じて広く読める**。
- **書き込み（承認など）は権限を持つ人だけ**。
- 参照マスタ（`venues`・`projects` 等）は、社員なら読める。編集は権限者のみ。

> RLSは必ず有効化する。アプリ側のチェックだけに頼らない（DBレベルで守る）。
> 具体的なポリシーSQLは、各Phaseのマイグレーションで定義する。

---

## データの初期投入（移行）

- 社員・会場などの**マスタ**は `supabase/seed.sql` に初期データを書いて投入。
- 既存スプレッドシートの**過去データ**（日報など）を移すかは選択制。
  - まずは「今日から新規に貯めていく」でも運用は始められる。
  - 過去分が必要なら、CSVエクスポート→取り込みスクリプトを別途用意（Phase 1の後半 or 随時）。

---

## 通知の仕組み（Phase 3以降）

- まずは**ポータル内通知**（`notifications` テーブル＋ヘッダーのベル)。
- メールやチャット（Slack等）連携は、必要になった段階で追加。
- 「承認待ち」「日報未提出」「資格期限接近」を自動生成する
  （定期実行は Supabase の scheduled function か Vercel Cron で）。
