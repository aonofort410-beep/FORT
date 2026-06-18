# 画像の入れ方ガイド（写真の差し込み一覧）

このサイトの写真は、すべて **この `images/` フォルダの中のファイル名** を読み込んでいます。
（WordPressテーマで使う場合は `fort-theme/assets/images/` に同じ名前で入れてください）

## いちばん簡単な手順（3ステップ）

1. 下の表の **ファイル名とまったく同じ名前** で写真を用意する（半角英数字・拡張子 `.jpg` / `.png`）
2. その写真を `images/` フォルダに入れる（同名なら上書き＝差し替え）
3. 完了。ページを開くと自動で表示されます

> 💡 まだ写真を入れていない場所は、自動で「FORT」の仮画像（または別の写真）が表示されます。
> 1枚ずつ、置けたところから順番に差し替えてOKです。

### コツ
- ファイル名は **半角英数字** で、表と**完全一致**させてください（全角・スペース・日本語・大文字小文字の違いはNG）
- 形式は **JPG** 推奨（ロゴだけ透過 `.png`）。容量は1枚 **300〜600KB** くらいに圧縮すると軽くて速いです
- サイズの目安：**横長＝幅2000px前後／正方形＝800px前後／縦長＝幅1000px前後**（多少違っても自動で調整されます）
- 縦横比（例 2000×1200＝5:3）を合わせると、トリミングのズレが少なくきれいに収まります

---

## ① 共通・トップページでよく使う写真
| ファイル名 | 表示される場所 | 推奨サイズ／形式 |
|---|---|---|
| `hero.jpg` | トップ最上部ヒーローの背景（動画が無いとき用の静止画） | 2000×1200・JPG |
| `hero.mp4` | トップ最上部ヒーローの背景動画（任意。あれば動画が優先） | 横長・10〜15秒・5MB以内目安 |
| `logo-white.png` | ヒーロー中央のFORTロゴ（白・透過）※VIデータから作成済み | 幅1100px・透過PNG |
| `logo-dark.png` | 明るい背景用のFORTロゴ（濃いグレー・透過）※作成済み | 幅1100px・透過PNG |
| `logo-lockup-white.png` | ヘッダー／フッターのロゴ（白・横組み）※作成済み | 幅800px・透過PNG |
| `logo-lockup-dark.png` | スクロール時ヘッダーのロゴ（濃色・横組み）※作成済み | 幅800px・透過PNG |
| `niche.jpg` | FORT PHILOSOPHY（思い）欄の写真 | 1000×1200・縦長JPG |
| `exterior.jpg` | 各ページ上部の背景・外観として多用 | 2000×1200・JPG |
| `ldk.jpg` | LDK・内観として多用 | 2000×1200・JPG |
| `kitchen-view.jpg` | キッチン・内観として多用 | 2000×1200・JPG |
| `ogp.jpg` | SNSでシェアされた時のサムネイル | 1200×630・JPG |

> ※ 施工事例（WORKS）のカードは、上の `hero / exterior / ldk / kitchen-view` を使い回しています。
> 事例ごとに別写真にしたい場合は教えてください（`works-01.jpg`…のように分けられます）。

## ② モデルハウス（トップ「体感する」欄・見学会ページ）
| ファイル名 | 表示される場所 | 推奨サイズ |
|---|---|---|
| `model-tamano.jpg` | 岡山玉野モデルハウス | 1600×1000（16:10） |
| `model-shimokamo.jpg` | 福山下加茂モデルハウス | 1600×1000（16:10） |

## ③ ラインナップ（商品）
| ファイル名 | 表示される場所 | 推奨サイズ |
|---|---|---|
| `lineup-style.jpg` | FORT STYLE の商品イメージ | 1200×800 |
| `lineup-design.jpg` | FORT DESIGN の商品イメージ | 1200×800 |

> FORT PRO の図面・外観パース（`pro/plan-a.jpg`〜`plan-f.jpg`、`pro/persp-a.jpg`〜`persp-f.jpg`）は
> いただいたPDFから作成済みです。差し替えたい場合は同名で `images/pro/` に上書きしてください。

## ④ お客様・引渡し（FORT FAMILY）
| ファイル名 | 表示される場所 | 推奨サイズ |
|---|---|---|
| `family-01.jpg` / `family-02.jpg` / `family-03.jpg` | お客様の声 3枚 | 1200×900 |

## ⑤ スタッフ写真（すべて正方形・800×800 推奨）
**トップページのスタッフ欄（3枚・部門イメージ）**
| ファイル名 | 部門 |
|---|---|
| `staff-sales.jpg` | 営業 |
| `staff-design.jpg` | 設計 |
| `staff-engineering.jpg` | 工務 |

**スタッフ紹介ページ（個人写真）**
| ファイル名 | 氏名 |
|---|---|
| `staff-aono.jpg` | 青野 弘輝 |
| `staff-kawasaki.jpg` | 川崎 力 |
| `staff-nakao.jpg` | 中尾 実樹 |
| `staff-sakamoto.jpg` | 坂本 薫 |
| `staff-yamashita.jpg` | 山下 唯 |
| `staff-kobayashi.jpg` | 古林 真希 |
| `staff-matsukawa.jpg` | 松川 琳斗 |
| `staff-murakami.jpg` | 村上 芽生 |
| `staff-nagataki.jpg` | 長瀧 渉 |
| `staff-matsuzaki.jpg` | 松崎 真紀 |
| `staff-ishida.jpg` | 石田 一成 |
| `staff-hikasa.jpg` | 日笠 泰成 |
| `staff-nakamura-ryoko.jpg` | 中村 涼子 |

## ⑥ 会社・スタジオ（STUDIOページ・会社概要）
| ファイル名 | 表示される場所 | 推奨サイズ |
|---|---|---|
| `studio-okayama.jpg` | 岡山スタジオの外観・内観 | 1200×800 |
| `studio-fukuyama.jpg` | 福山スタジオの外観・内観 | 1200×800 |
| `map-okayama.jpg` | 岡山スタジオの地図 | 16:9（例 1200×675） |
| `map-fukuyama.jpg` | 福山スタジオの地図 | 16:9（例 1200×675） |

> 地図は画像でなく、Googleマップの「埋め込みコード(iframe)」に差し替えると
> 実際に動かせる地図になります（ご希望ならこちらで対応します）。

---

## 写真をどこから入れる？（方法）

- **このまま私（Claude）に送る**：チャットに写真を**ファイル添付**して「これを〇〇に入れて」と伝えてください。こちらで `images/` に正しい名前で配置します。
  （※チャット本文に貼り付けた画像はファイルとして届かないことがあります。クリップ📎の「ファイル添付」でお願いします）
- **GitHubのWeb画面から**：`images/` フォルダを開き「Add file → Upload files」で、上の表の名前にした写真をアップロードするだけです。

迷ったら、まず `hero.jpg`（トップ最上部）と `model-tamano.jpg` / `model-shimokamo.jpg`（モデルハウス）から差し替えると、見た目の変化が分かりやすいです。

---

## ファイル名だけ早見表（コピー用）

```
hero.jpg
hero.mp4
logo-white.png
logo-dark.png
logo-lockup-white.png
logo-lockup-dark.png
niche.jpg
exterior.jpg
ldk.jpg
kitchen-view.jpg
ogp.jpg
model-tamano.jpg
model-shimokamo.jpg
lineup-style.jpg
lineup-design.jpg
family-01.jpg
family-02.jpg
family-03.jpg
staff-sales.jpg
staff-design.jpg
staff-engineering.jpg
staff-aono.jpg
staff-kawasaki.jpg
staff-nakao.jpg
staff-sakamoto.jpg
staff-yamashita.jpg
staff-kobayashi.jpg
staff-matsukawa.jpg
staff-murakami.jpg
staff-nagataki.jpg
staff-matsuzaki.jpg
staff-ishida.jpg
staff-hikasa.jpg
staff-nakamura-ryoko.jpg
studio-okayama.jpg
studio-fukuyama.jpg
map-okayama.jpg
map-fukuyama.jpg
pro/plan-a.jpg 〜 pro/plan-f.jpg
pro/persp-a.jpg 〜 pro/persp-f.jpg
```
