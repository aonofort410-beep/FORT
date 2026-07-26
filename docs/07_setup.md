# 07 ｜ 環境構築手順

コードだけでは完結しない「外部サービスの設定」をまとめる。
Claude Code が実装を進める際、この手順で必要なキーやURLを人間が用意する。

> ここは**人間の作業が必要な部分**。Claude Code は、必要になったタイミングで
> 「この設定をして、値を `.env.local` に入れてください」と案内すること。

---

## 1. 必要なアカウント

| サービス | 用途 | 費用 |
|----------|------|------|
| GitHub | ソースコードの保管・Vercel連携 | 無料 |
| Supabase | データベース・認証 | 無料枠から。規模が増えたら有料 |
| Google Cloud | Googleログイン（OAuth）の設定 | 無料 |
| Vercel | ポータルの公開（ホスティング） | 無料枠から |

FORTは Google Workspace（@fort410.jp）を使っているので、Google Cloud は
その組織アカウントで設定するのが望ましい。

---

## 2. Supabase の準備

1. supabase.com でプロジェクトを新規作成（リージョンは Tokyo）。
2. プロジェクトの `URL` と `anon key`、`service_role key` を控える。
3. これらを `.env.local` に設定：
   ```
   NEXT_PUBLIC_SUPABASE_URL=...
   NEXT_PUBLIC_SUPABASE_ANON_KEY=...
   SUPABASE_SERVICE_ROLE_KEY=...   # サーバー側だけで使う。絶対に公開しない
   ```
4. テーブルは Claude Code がマイグレーション（`supabase/migrations/`）で作る。

---

## 3. Google OAuth（Googleログイン）の設定

1. Google Cloud Console で、FORTの組織のプロジェクトを用意。
2. 「APIとサービス」→「OAuth 同意画面」を設定。
   - ユーザーの種類：**内部（Internal）** を選べば、@fort410.jp の組織内
     アカウントだけがログインできる（外部を弾く最も確実な方法）。
   - アプリ名を「FORT 社内ポータル」等にすると、ログイン画面の表示が信頼できる形になる。
3. 「認証情報」→「OAuth クライアントID」を作成（種類：ウェブアプリケーション）。
4. 承認済みリダイレクトURIに、Supabase が指定するコールバックURL
   （`https://<プロジェクトID>.supabase.co/auth/v1/callback`）を登録。
5. 発行された `Client ID` と `Client Secret` を、
   Supabase ダッシュボードの Authentication → Providers → Google に設定。

### ドメイン制限は「二重」でかける（重要・セキュリティ）

- Google 同意画面を **Internal** にする（組織アカウント限定）。
- **加えて、アプリ側でもチェックする**：ログイン後にユーザーの
  メールが `@fort410.jp` で終わるかをサーバー側で必ず検証し、
  違えば弾く。`hd` パラメータやメール末尾一致だけに頼らない
  （末尾一致だけの検証は偽装されうる既知の落とし穴）。
- 理想は、事前に総務が登録した `employees` の招待リスト（メール一致）に
  ある人だけを通すこと。これが最も堅い。

---

## 4. Vercel での公開

1. ソースコードを GitHub リポジトリに置く。
2. Vercel で「Import Project」→ そのGitHubリポジトリを選ぶ。
3. 環境変数（Supabaseのキー等）を Vercel の設定に入れる。
4. デプロイすると `https://xxxx.vercel.app` で公開される。
5. 独自ドメイン（例 `portal.fort410.jp`）を割り当てることも可能。
   - その場合、Google OAuth のリダイレクトURIやSupabaseの許可URLに
     本番URLを追加すること。

---

## 5. ローカルで開発する（Claude Codeが動く環境）

開発する人のPCに必要：

- **Node.js 18以上**
- **Git**
- **Claude Code**

手順の概略（Claude Code が案内する）：

```bash
# 依存をインストール
npm install

# 環境変数ファイルを用意（.env.local に上記キーを設定）

# 開発サーバー起動
npm run dev
# → http://localhost:3000 で確認
```

---

## 6. 進め方の全体像

1. 人間：Supabase・Google Cloud・Vercel のアカウントを用意し、キーを取得。
2. 人間：`.env.local` にキーを設定。
3. Claude Code：`06_roadmap.md` の Phase 0 から実装。
4. 各Phaseごとに、ローカルで動作確認 → GitHubにpush → Vercelで自動公開。
5. 動くものを社員に触ってもらい、フィードバックで育てる。

> 最初の難所は「アカウント準備とキー設定」だけ。そこを越えれば、
> あとは Claude Code が Phase を追って実装を進められる。
> 迷ったら、この設計書一式（docs/）に立ち返る。
