#!/usr/bin/env python3
"""写真分類.csv の投稿向き度Aの写真を、サムネイル入りの data.json にする（pages/a_select/index.html が読む）。
使い方: python3 build_a_page.py [出力ディレクトリ=pages/a_select]
前提: thumbs/邸/ と sheets/邸/_index.json が作成済み（dbx_thumbs.py fetch → make_sheets.py）。"""
import base64, csv, io, json, os, sys
from PIL import Image
BASE = os.path.dirname(os.path.abspath(__file__))
OUT = sys.argv[1] if len(sys.argv) > 1 else os.path.join(BASE, "pages", "a_select")
ORDER = {"福山エリア": 0, "岡山エリア": 1, "モデルハウス": 2, "スタジオ": 3}
rows = [r for r in csv.DictReader(open(os.path.join(BASE, "写真分類.csv"), encoding="utf-8-sig")) if r["投稿向き度"] == "A"]
rows.sort(key=lambda r: (ORDER.get(r["エリア"], 9), r["邸フォルダ名"], r["Dropboxパス"]))
idx, data = {}, []
for r in rows:
    h = r["邸フォルダ名"]
    if h not in idx:
        idx[h] = {x["path_display"]: x["thumb"] for x in json.load(open(os.path.join(BASE, "sheets", h, "_index.json"), encoding="utf-8"))}
    im = Image.open(os.path.join(BASE, "thumbs", h, idx[h][r["Dropboxパス"]])).convert("RGB")
    im.thumbnail((420, 420)); b = io.BytesIO(); im.save(b, "JPEG", quality=68, optimize=True)
    data.append({"a": r["エリア"], "h": h, "f": r["ファイル名"], "p": r["Dropboxパス"], "r": r["部屋"], "o": r["縦横"],
                 "c": r["色味"], "m": r["人物"], "n": r["ひとこと"], "i": base64.b64encode(b.getvalue()).decode()})
os.makedirs(OUT, exist_ok=True)
json.dump(data, open(os.path.join(OUT, "data.json"), "w", encoding="utf-8"), ensure_ascii=False)
print(len(data), "枚 →", os.path.join(OUT, "data.json"))
