# 画像はめ込み一覧（最新版）

このサイトの写真は、すべて **この `images/` フォルダの中のファイル名** を読み込んでいます。
（WordPressテーマで使う場合は `fort-theme/assets/images/` に同じ名前で入れてください）

## 使い方（3ステップ）
1. 下の表の **ファイル名とまったく同じ名前** で写真を用意する
2. その写真を `images/` フォルダに入れる（同名なら上書き＝差し替え）
3. ページを開くと自動で表示されます

### コツ
- ファイル名は **半角英数字**・表と**完全一致**（全角／日本語／大文字小文字違いはNG）
- 形式は **JPG** 推奨（ロゴだけ透過 **PNG**）。1枚 **300〜600KB** 目安に圧縮
- サイズ目安：横長＝幅2000px／正方形＝800px／縦長＝幅1000px（多少違っても自動調整）
- まだ無い写真は、自動で仮画像や別の写真で代替表示されます。置けたところから順にどうぞ

### 状態の見方
- ✅ … すでに用意済み（差し替えたい場合のみ上書き）
- ▢ … これから用意してください

---

## ① 共通（全ページで使用）
| 状態 | ファイル名 | 使う場所 | 推奨サイズ |
|---|---|---|---|
| ✅ | `logo-white.png` | ヒーロー中央のFORTロゴ（白・透過） | 幅1100px・透過 |
| ✅ | `logo-dark.png` | 明るい背景用ロゴ（濃色・透過） | 幅1100px・透過 |
| ✅ | `logo-lockup-white.png` | ヘッダー／フッターのロゴ（白・横組み） | 幅800px・透過 |
| ✅ | `logo-lockup-dark.png` | スクロール時ヘッダーのロゴ（濃色・横組み） | 幅800px・透過 |
| ▢ | `ogp.jpg` | SNSでシェアされた時のサムネイル | 1200×630 |

## ② トップページ
| 状態 | ファイル名 | 使う場所 | 推奨サイズ |
|---|---|---|---|
| ✅ | `hero.jpg` | ヒーロー背景（動画が無いとき用の静止画） | 2000×1200 |
| ▢ | `hero.mp4` | ヒーロー背景動画（任意。あれば動画が優先） | 横長・10〜15秒・5MB以内 |
| ▢ | `niche.jpg` | FORT PHILOSOPHY（思い）欄の写真 | 1000×1200（縦長） |
| ▢ | `exterior.jpg` | 各ページ上部の背景・外観として多用 | 2000×1200 |
| ▢ | `ldk.jpg` | LDK・内観として多用 | 2000×1200 |
| ▢ | `kitchen-view.jpg` | キッチン・内観として多用 | 2000×1200 |

> ※ 施工事例（WORKS）のスライド／カードは、上の `hero / exterior / ldk / kitchen-view` を使い回しています。
> 事例ごとに別写真にしたい場合は教えてください（`works-01.jpg`… のように分けられます）。

## ③ 見学会・モデルハウス（event.html ／ studio.html）
| 状態 | ファイル名 | 使う場所 | 推奨サイズ |
|---|---|---|---|
| ▢ | `model-tamano.jpg` | 岡山玉野モデルハウス | 1600×1000 |
| ▢ | `model-shimokamo.jpg` | 福山下加茂モデルハウス | 1600×1000 |
| ▢ | `studio-okayama.jpg` | 岡山スタジオの外観・内観 | 1200×800 |
| ▢ | `studio-fukuyama.jpg` | 福山スタジオの外観・内観 | 1200×800 |
| ▢ | `map-okayama.jpg` | 岡山スタジオの地図 | 16:9（例 1200×675） |
| ▢ | `map-fukuyama.jpg` | 福山スタジオの地図 | 16:9（例 1200×675） |

> 地図は画像でなく、Googleマップの「埋め込みコード(iframe)」に差し替えると実際に動かせる地図になります（ご希望ならこちらで対応します）。

## ④ 商品ラインナップ
| 状態 | ファイル名 | 使う場所 | 推奨サイズ |
|---|---|---|---|
| ▢ | `lineup-style.jpg` | FORT STYLE の商品イメージ | 1200×800 |
| ▢ | `lineup-design.jpg` | FORT DESIGN の商品イメージ | 1200×800 |
| ✅ | `pro/plan-a.jpg` 〜 `pro/plan-f.jpg` | FORT PRO 各プランの間取り図 | PDFから作成済み |
| ✅ | `pro/persp-a.jpg` 〜 `pro/persp-f.jpg` | FORT PRO 各プランの外観パース | PDFから作成済み |

> FORT PRO の画像はいただいたPDFから作成済みです。差し替えるときは同名で `images/pro/` に上書きしてください。

## ⑤ FORT DESIGN 特設ページ（fort-design.html）
現在は下記の共通写真（②）を使い回しています：`kitchen-view.jpg` `ldk.jpg` `exterior.jpg` `niche.jpg` `hero.jpg`。
**この特設ページ専用の上質な写真を入れたい場合**は、下の名前で用意してください（こちらでページに割り当てます）。
| 状態 | ファイル名（任意・推奨） | 使う場所 | 推奨サイズ |
|---|---|---|---|
| ▢ | `design-hero.jpg` | ページ最上部の大判ビジュアル | 2400×1400 |
| ▢ | `design-01.jpg`〜`design-06.jpg` | 特徴・ギャラリーの写真 | 1600×1200／正方形 |

## ⑥ お客様の声（family.html ／ FORT FAMILY）
| 状態 | ファイル名 | 使う場所 | 推奨サイズ |
|---|---|---|---|
| ▢ | `family-01.jpg` | お客様の声 1（倉敷市 T様邸） | 1200×900 |
| ▢ | `family-02.jpg` | お客様の声 2（岡山市 K様邸） | 1200×900 |
| ▢ | `family-03.jpg` | お客様の声 3（福山市 M様邸） | 1200×900 |

> 4件目以降（S様・N様・Y様…）は現在 `ldk / kitchen-view / exterior` を流用中。
> 専用写真にしたい場合は `family-04.jpg`… で用意してください（割り当てます）。

## ⑦ スタッフ（部門イメージ・トップ）※正方形 800×800
| 状態 | ファイル名 | 部門 |
|---|---|---|
| ▢ | `staff-sales.jpg` | 営業 |
| ▢ | `staff-design.jpg` | 設計 |
| ▢ | `staff-engineering.jpg` | 工務 |

## ⑧ スタッフ個別ページ（各人 2枚・正方形 800×800 推奨）
1枚目＝一覧＆プロフィール用、2枚目＝プロフィールページのサブ写真（未登録なら1枚目で代替）。
| 状態 | 1枚目 | 2枚目 | 氏名 ／ 部門 |
|---|---|---|---|
| ▢ | `staff-aono.jpg` | `staff-aono-2.jpg` | 青野 弘輝 ／ 営業 |
| ▢ | `staff-kawasaki.jpg` | `staff-kawasaki-2.jpg` | 川崎 力 ／ 営業 |
| ▢ | `staff-nakao.jpg` | `staff-nakao-2.jpg` | 中尾 実樹 ／ 営業 |
| ▢ | `staff-sakamoto.jpg` | `staff-sakamoto-2.jpg` | 坂本 薫 ／ 設計 |
| ▢ | `staff-yamashita.jpg` | `staff-yamashita-2.jpg` | 山下 唯 ／ 設計 |
| ▢ | `staff-kobayashi.jpg` | `staff-kobayashi-2.jpg` | 古林 真希 ／ 設計 |
| ▢ | `staff-matsukawa.jpg` | `staff-matsukawa-2.jpg` | 松川 琳斗 ／ 設計 |
| ▢ | `staff-murakami.jpg` | `staff-murakami-2.jpg` | 村上 芽生 ／ 設計 |
| ▢ | `staff-nagataki.jpg` | `staff-nagataki-2.jpg` | 長瀧 渉 ／ 工務 |
| ▢ | `staff-matsuzaki.jpg` | `staff-matsuzaki-2.jpg` | 松崎 真紀 ／ 工務 |
| ▢ | `staff-ishida.jpg` | `staff-ishida-2.jpg` | 石田 一成 ／ 工務 |
| ▢ | `staff-hikasa.jpg` | `staff-hikasa-2.jpg` | 日笠 泰成 ／ 工務 |
| ▢ | `staff-nakamura-ryoko.jpg` | `staff-nakamura-ryoko-2.jpg` | 中村 涼子 ／ 総務 |

---

## 写真の入れ方（方法）
- **チャットで私（Claude）に送る**：クリップ📎の「**ファイル添付**」で写真を送り、「これを〇〇に入れて」と伝えてください。こちらで `images/` に正しい名前で配置します。
  （※チャット本文に貼り付けた画像はファイルとして届かないことがあります）
- **GitHubのWeb画面から**：`images/` フォルダを開き「Add file → Upload files」で、上の名前にした写真をアップロード。

迷ったら、まず ✅以外で目立つ `hero.jpg`・`model-tamano.jpg`・`model-shimokamo.jpg`・スタッフ写真 から差し替えると変化が分かりやすいです。

---

## ファイル名だけ早見表（コピー用）
```
ogp.jpg
hero.mp4
niche.jpg
exterior.jpg
ldk.jpg
kitchen-view.jpg
model-tamano.jpg
model-shimokamo.jpg
studio-okayama.jpg
studio-fukuyama.jpg
map-okayama.jpg
map-fukuyama.jpg
lineup-style.jpg
lineup-design.jpg
family-01.jpg  family-02.jpg  family-03.jpg
staff-sales.jpg  staff-design.jpg  staff-engineering.jpg
staff-aono.jpg          staff-aono-2.jpg
staff-kawasaki.jpg      staff-kawasaki-2.jpg
staff-nakao.jpg         staff-nakao-2.jpg
staff-sakamoto.jpg      staff-sakamoto-2.jpg
staff-yamashita.jpg     staff-yamashita-2.jpg
staff-kobayashi.jpg     staff-kobayashi-2.jpg
staff-matsukawa.jpg     staff-matsukawa-2.jpg
staff-murakami.jpg      staff-murakami-2.jpg
staff-nagataki.jpg      staff-nagataki-2.jpg
staff-matsuzaki.jpg     staff-matsuzaki-2.jpg
staff-ishida.jpg        staff-ishida-2.jpg
staff-hikasa.jpg        staff-hikasa-2.jpg
staff-nakamura-ryoko.jpg  staff-nakamura-ryoko-2.jpg
（任意）design-hero.jpg / design-01.jpg〜design-06.jpg
（任意）family-04.jpg〜 / works-01.jpg〜
```
