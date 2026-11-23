#!/usr/bin/env python3
"""指定した番号だけを一覧画像にする（重複が多い邸用）。番号表示は元の番号のまま。
使い方: python3 make_subset_sheets.py "邸フォルダ名" 番号JSONファイル 出力ディレクトリ"""
import json, os, sys
from PIL import Image, ImageDraw
sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
from make_sheets import font, COLS, ROWS, CW, CH, LABEL_H
house, nos_file, out = sys.argv[1:4]
base = os.path.dirname(os.path.abspath(__file__))
idx = {x["no"]: x for x in json.load(open(os.path.join(base, "sheets", house, "_index.json"), encoding="utf-8"))}
nos = json.load(open(nos_file))
os.makedirs(out, exist_ok=True)
f = font(26); per = COLS * ROWS
for s in range(0, len(nos), per):
    sheet = Image.new("RGB", (COLS * CW, ROWS * (CH + LABEL_H)), "white"); d = ImageDraw.Draw(sheet)
    for k, no in enumerate(nos[s:s + per]):
        im = Image.open(os.path.join(base, "thumbs", house, idx[no]["thumb"])).convert("RGB"); im.thumbnail((CW - 8, CH - 8))
        x0 = (k % COLS) * CW; y0 = (k // COLS) * (CH + LABEL_H)
        sheet.paste(im, (x0 + (CW - im.size[0]) // 2, y0 + LABEL_H + (CH - im.size[1]) // 2))
        d.rectangle([x0, y0, x0 + CW - 1, y0 + LABEL_H - 1], fill="black"); d.text((x0 + 8, y0 + 3), f"#{no}", fill="yellow", font=f)
    sheet.save(os.path.join(out, f"u_{s // per + 1:02d}.jpg"), quality=85)
print((len(nos) + per - 1) // per, "sheets")
