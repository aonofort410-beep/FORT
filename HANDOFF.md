# FORT Instagram自動化 引継ぎメモ

作成日: 2026-11-24
引継ぎ元: Claude（Claude Code のクラウドセッション）
対象アカウント: Instagram `fort_family.jp`（Metricool 経由）

---

## 1. 目的

Dropbox の `/【完成写真】` にある施工事例・モデルハウス・スタジオの写真を分類し、Instagram「fort_family.jp」に**週3回（火・木・土）20:00**で投稿する運用を、できるだけ自動化する。

流れは次の5段階。

1. Dropbox から写真一覧とサムネイルを取得する（元写真はダウンロードしない）
2. サムネイルを12枚ずつの一覧画像にまとめ、1枚ずつ分類する
3. 分類結果を `写真分類.csv` に蓄積する
4. 投稿向き度Aの写真を一覧ページで確認し、投稿計画（1投稿＝1邸のカルーセル）を作る
5. Metricool に**下書き**として入れ、担当者が確認してから予約を確定する

---

## 2. 現在の状況（2026-11-24 時点）

| 項目 | 状況 |
|---|---|
| 写真の分類 | **完了**。10,001枚（福山35邸・岡山76邸・モデルハウス28・スタジオ5） |
| 投稿向き度A | 491枚（福山154・岡山224・モデルハウス89・スタジオ24） |
| A写真の一覧ページ | 作成済み（Claude の非公開ページ。ChatGPT からは開けない） |
| 投稿計画 | 11/26〜12/24 の13投稿を作成済み（下の表） |
| Metricool | Instagram・Facebook の接続済み。**投稿はまだ1件も登録していない** |
| Dropbox の鍵 | 前回の鍵は無効化済み。**新しい鍵（sharing.write 付き）をユーザーが作成中** |

**急ぎ: 初回投稿は 11/26（木）20:00。** それまでに Metricool へ下書きを入れる必要がある。

### 投稿計画（Instagramのみ・下書きで登録する方針）

| 日付 | 曜日 | テーマ | 内容 |
|---|---|---|---|
| 11/26 | 木 | 施工事例 | 府中市｜ルーバー天井の平屋 |
| 11/28 | 土 | 施工事例 | 岡山市中区｜ホテルライクな白の家 |
| 12/01 | 火 | モデルハウス | 岡山モデルハウス｜夕景の中庭 |
| 12/03 | 木 | 施工事例 | 福山市千田町｜モノトーンの吹抜け |
| 12/05 | 土 | 施工事例 | 赤磐市｜森を切り取る平屋 |
| 12/08 | 火 | モデルハウス | 玉野番田F2モデル｜海を望む家 |
| 12/10 | 木 | 施工事例 | 福山市野上町｜木目の平屋 |
| 12/12 | 土 | 施工事例 | 岡山市南区｜石目の壁と吹抜け |
| 12/15 | 火 | モデルハウス | 田益モデル｜ヘリンボーンの床 |
| 12/17 | 木 | 施工事例 | 福山市幕山台｜光あふれる階段のLDK |
| 12/19 | 土 | 施工事例 | 岡山市北区｜愛車と暮らすガレージハウス |
| 12/22 | 火 | 季節 | 下岩成モデル｜クリスマスの装い |
| 12/24 | 木 | 季節 | 岡山モデル｜クリスマスイブ（写真2枚のみ） |

写真の順番・Dropboxパス・キャプション全文は `投稿計画.csv`（ユーザーが保持）にある。

---

## 3. 守るルール（ユーザーとの約束）

- **Dropbox は読み取りのみ。** 例外は「投稿に使う写真の共有リンク作成」だけ（ユーザーが許可済み）。移動・削除・上書き・アップロードはしない。
- **トークンやシークレットは画面・ファイル・ログに出さない。** チャットに貼らせない。
- 次の文字を**フォルダ名に含む邸は丸ごと対象外**:
  `掲載NG` / `SNS等掲載NG` / `SNS掲載禁止` / `広告使用は不可` / `内観NG`
  `〇見学会用RAW素材` も対象外。
- 「人物NG」「施主様（人物）NG」「顔出しNG」の邸は、**人物ありの写真をCSVに載せない**（`append_csv.py --skip-person`）。
- 「※外観SNSはNG」の邸は、**外観写真をCSVに載せない**（`--skip-room 外観`）。
- 投稿にはお客様の家族写真を使わない（掲載同意の確認前）。キャプションにお客様の名前を書かず、市町村名までにする。
- Metricool への登録は**下書き**。勝手に公開状態にしない。

---

## 4. 実装済みの機能（ファイル一覧）

| ファイル | 役割 |
|---|---|
| `dbx_thumbs.py` | Dropbox から写真一覧（`list_folder` recursive）とサムネイル（`get_thumbnail_v2`, jpeg, w640h480, bestfit）を取得し `thumbs/邸/` に保存。取得済みは飛ばすので途中再開できる。パスで失敗したらチームルート（`Dropbox-API-Path-Root`）で再試行。リフレッシュトークンから短期トークンをメモリ上で発行し、期限切れ時は自動更新。`houses` で邸フォルダ一覧（除外語の判定付き） |
| `make_sheets.py` | `thumbs/邸/` を12枚ずつ番号付きの一覧画像（3列×4段）にして `sheets/邸/sheet_NN.jpg` と `_index.json`（番号→写真・縦横）を作る。縦横はサムネイルの縦横比で自動判定 |
| `dedup.py` | ほぼ同じ写真（連写・別フォルダの重複）を簡易ハッシュで検出 |
| `make_subset_sheets.py` | 重複を除いた写真だけで一覧画像を作る |
| `expand_dups.py` | 重複を除いて付けた判定を全件に展開（重複分は「C #元番号と重複」） |
| `append_csv.py` | 判定ファイル `judgments/邸.txt` を `写真分類.csv` に追記。同じDropboxパスは二重に入れない。値の検証付き |
| `build_a_page.py` | CSV の A 写真からサムネイル入り `data.json` を作る（`pages/a_select/index.html` が読む） |
| `build_plan.py` | `posts.json` から各投稿のカルーセル写真（人物なしのA/B、表紙は縦長優先のA、1部屋最大2枚・計10枚）を選び、`plan.json` と `投稿計画.csv` を作る |
| `pages/a_select/index.html` | A写真の一覧ページ（区分・部屋・縦横・人物で絞り込み、Dropboxパスのコピー） |
| `pages/post_plan/index.html` | 投稿計画ページ（日付・キャプション・カルーセル写真） |
| `pages/post_plan/posts.example.json` | 投稿計画の入力形式の例 |

### 写真分類.csv の列

`エリア, 邸フォルダ名, ファイル名, Dropboxパス, 部屋, 縦横, 色味, 人物, 投稿向き度, ひとこと`

- エリア: 福山エリア / 岡山エリア / モデルハウス / スタジオ
- 部屋: 外観／玄関／LDK／キッチン／洗面／浴室／トイレ／寝室／収納／階段／ガレージ／中庭・庭／その他
- 縦横: 縦／横／正方形（自動判定）
- 色味: 白／グレー／木目／黒／その他
- 人物: あり／なし
- 投稿向き度: A（表紙にしたい）／B（使える）／C（ブレ・ほぼ同じカットで不要）
- ひとこと: 20字以内

### 判定ファイルの形式（`judgments/邸フォルダ名.txt`）

1行1枚、半角スペース区切り。番号は `sheets/邸/_index.json` の `no`。

```
番号 部屋 色味 人物 投稿向き度 ひとこと
1 LDK 木目 なし A 吹抜けと階段のLDK
```

**重要: 部屋・色味・人物・投稿向き度・ひとことの判定はコードでは自動化していない。** Claude が一覧画像を目で見て判定ファイルを書いた。引き継ぐ場合は、画像を読めるAIに一覧画像を見せて同じ形式で書かせるか、画像分類APIを組み込む必要がある。

---

## 5. 起動方法

### 準備

```bash
python3 -m pip install -r requirements.txt
cp .env.example .env   # DROPBOX_APP_KEY / DROPBOX_APP_SECRET / DROPBOX_REFRESH_TOKEN を記入
```

### Dropbox のリフレッシュトークンの取り方

1. App Console で「FORT-photo-ledger」の権限に `files.metadata.read` `files.content.read`（共有リンクを作るなら `sharing.write` も）を付けて送信する。
2. ブラウザで次のURLを開き、許可してコードを得る。
   `https://www.dropbox.com/oauth2/authorize?client_id=<APP_KEY>&response_type=code&token_access_type=offline`
3. コードをトークンに交換する（Windows は PowerShell で `Invoke-RestMethod`）。
   ```bash
   curl https://api.dropboxapi.com/oauth2/token -d code=<CODE> -d grant_type=authorization_code -u <APP_KEY>:<APP_SECRET>
   ```
   返ってきた `refresh_token` を `.env` に書く。

### 新しい邸を追加するとき

```bash
# 邸フォルダの一覧（OK/NG 判定付き）
python3 dbx_thumbs.py houses "/【完成写真】/福山エリア"

# サムネイル取得 → 一覧画像
python3 dbx_thumbs.py fetch "/【完成写真】/福山エリア/<邸フォルダ名>"
python3 make_sheets.py "<邸フォルダ名>"

# （重複が多い邸）重複を除いた一覧画像
python3 dedup.py "<邸フォルダ名>" work/x
python3 make_subset_sheets.py "<邸フォルダ名>" work/x_uniq.json work/x
#  → work/x_u.txt に重複以外の判定を書いてから
python3 expand_dups.py "<邸フォルダ名>" work/x

# 判定を書いて CSV に追記（judgments/<邸フォルダ名>.txt）
python3 append_csv.py 福山エリア "<邸フォルダ名>"
python3 append_csv.py 岡山エリア "<邸フォルダ名>" --skip-person      # 人物NG・顔出しNG邸
python3 append_csv.py 岡山エリア "<邸フォルダ名>" --skip-room 外観   # 外観SNS NG邸
```

### 一覧ページ・投稿計画を作り直す

```bash
python3 build_a_page.py                         # → pages/a_select/data.json
python3 build_plan.py pages/post_plan/posts.json  # → pages/post_plan/plan.json と 投稿計画.csv
```

ページは `fetch()` で JSON を読むので、ファイルを直接開かずに簡易サーバーで見る。

```bash
cd pages/a_select && python3 -m http.server 8000   # http://localhost:8000
```

---

## 6. 連携サービス

| サービス | 内容 | 設定 |
|---|---|---|
| Dropbox API | アプリ「FORT-photo-ledger」。一覧・サムネイル取得（読み取り）、共有リンク作成（予定） | `.env` の `DROPBOX_*`。外向き通信先は `api.dropboxapi.com` と `content.dropboxapi.com` |
| Metricool | ブランド blogId `8220265`、userId `6473008`、タイムゾーン Asia/Tokyo。Instagram `fort_family.jp` と Facebook ページ「フォートファミリー」を接続済み（今回は Instagram のみ使う） | Claude では Metricool の MCP コネクタ経由で操作していた。コードからは Metricool API（`METRICOOL_USER_TOKEN`）が必要。プランで API が使えるか要確認 |
| Claude のページ | A写真一覧・投稿計画のページ（非公開） | ChatGPT からは開けない。`pages/` の HTML と生成スクリプトで同じものを作れる |

---

## 7. 未完成の部分（次にやること）

1. **【最優先・11/26 締切】Metricool に下書きを入れる**
   - 新しい Dropbox の鍵（`sharing.write` 付き）を受け取る。
   - `投稿計画.csv` の写真について、Dropbox の共有リンクを作る（`sharing/create_shared_link_with_settings`。既にあれば `sharing/list_shared_links` で取得）。**未実装。**
   - 共有リンクを Metricool の `media` に渡す（Metricool は Dropbox の共有リンクを自動で取り込む）。Instagram は写真が必須。
   - `draft: true`、`providers: instagram`、`instagramData.type: POST`、20:00 Asia/Tokyo で登録する。
   - **まず11/26の1件だけ登録してユーザーに確認してもらい、OK が出たら残り12件を入れる**（ユーザーと合意済みの進め方）。
2. **投稿が公開されたら共有リンクを無効にする**（お客様の家の写真なので）。ユーザーの了承を取ってから。
3. **投稿の最適時刻**: 接続直後で Metricool に実績がない。数週間後に Metricool の「最適な投稿時間」で見直す。
4. **使った写真の管理**: 同じ写真を二度投稿しないよう、CSV に「投稿日」列を足すか、一覧ページにチェック機能を付ける。
5. **未分類のフォルダ**: `/【完成写真】` の `f FORT-pro` `■建売 SUUMO用` `他` `動画広告用素材` `インタビュー動画`。
6. **家族写真の扱い**: 同意が確認できた邸だけ人物ありの写真を使えるよう、邸ごとの同意リストを作る。
7. **12/24 の投稿**: 写真が2枚しかないので、2枚カルーセルか1枚投稿かを決める。

---

## 8. ZIP に入れていないもの（必要ならユーザーから受け取る）

- `.env` と鍵ファイル（`dropbox_refresh.txt` など）: 秘密情報のため除外。`.env.example` を参照。
- `写真分類.csv` `投稿計画.csv`: お客様の氏名・地名を含むため除外。ユーザーがダウンロード済み。
- `judgments/` `thumbs/` `sheets/`、`pages/*/data.json` `plan.json` `posts.json`: お客様のデータ。CSV と Dropbox から作り直せる（判定は CSV に入っている）。

## 9. 注意点・つまずいたところ

- Dropbox の短期トークン（`sl.` で始まる）は数時間で切れる。必ずリフレッシュトークンを使う。
- macOS が作る `._` で始まるファイルはサムネイル取得で `unsupported_image` になる。写真ではないので無視してよい。
- 同じ写真が別フォルダや別名で重複している邸がある（岡山エリアの一部の邸や岡山スタジオなど）。`dedup.py` で検出。
- 岡山スタジオのフォルダには、モデルハウスの写真も混ざっている（エリアは「スタジオ」として分類済み）。
- Windows の PowerShell に複数行のコマンドをまとめて貼ると、`Read-Host` に後続の行が流れ込む。1行ずつ実行させる。
- Dropbox App Console でシークレットを作り直すときは、「新しいアプリキーとシークレットのペアを追加」→ 古い組を「削除」の順（2026-11-24 に実施済み）。
