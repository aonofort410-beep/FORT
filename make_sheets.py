#!/usr/bin/env python3
"""thumbs/邸/ のサムネイルを12枚ずつ 3列×4段 の番号付き一覧画像にする。

使い方: python3 make_sheets.py "邸フォルダ名"
出力:   sheets/邸フォルダ名/sheet_01.jpg ... と _index.json（番号→写真・縦横）
"""
import json
import os
import sys

from PIL import Image, ImageDraw, ImageFont

BASE = os.path.dirname(os.path.abspath(__file__))
COLS, ROWS = 3, 4
CW, CH = 480, 360  # 1マスの大きさ
LABEL_H = 34
FONT_PATHS = ["/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf"]


def font(size):
    for p in FONT_PATHS:
        if os.path.exists(p):
            return ImageFont.truetype(p, size)
    return ImageFont.load_default()


def orientation(w, h):
    r = w / h
    if r > 1.05:
        return "横"
    if r < 0.95:
        return "縦"
    return "正方形"


def main(house):
    tdir = os.path.join(BASE, "thumbs", house)
    sdir = os.path.join(BASE, "sheets", house)
    os.makedirs(sdir, exist_ok=True)
    with open(os.path.join(tdir, "_list.json"), encoding="utf-8") as f:
        photos = [p for p in json.load(f)
                  if os.path.exists(os.path.join(tdir, p["thumb"]))]

    f_big = font(26)
    index = []
    per = COLS * ROWS
    for s in range(0, len(photos), per):
        sheet = Image.new("RGB", (COLS * CW, ROWS * (CH + LABEL_H)), "white")
        d = ImageDraw.Draw(sheet)
        for k, p in enumerate(photos[s:s + per]):
            no = s + k + 1
            im = Image.open(os.path.join(tdir, p["thumb"])).convert("RGB")
            ori = orientation(*im.size)
            index.append({"no": no, **p, "縦横": ori, "w": im.size[0], "h": im.size[1]})
            im.thumbnail((CW - 8, CH - 8))
            x0 = (k % COLS) * CW
            y0 = (k // COLS) * (CH + LABEL_H)
            sheet.paste(im, (x0 + (CW - im.size[0]) // 2, y0 + LABEL_H + (CH - im.size[1]) // 2))
            d.rectangle([x0, y0, x0 + CW - 1, y0 + LABEL_H - 1], fill="black")
            d.text((x0 + 8, y0 + 3), f"#{no}", fill="yellow", font=f_big)
            d.rectangle([x0, y0, x0 + CW - 1, y0 + LABEL_H + CH - 1], outline="gray")
        sheet.save(os.path.join(sdir, f"sheet_{s // per + 1:02d}.jpg"), quality=85)

    with open(os.path.join(sdir, "_index.json"), "w", encoding="utf-8") as f:
        json.dump(index, f, ensure_ascii=False, indent=1)
    print(f"{len(photos)}枚 → {(len(photos) + per - 1) // per}枚の一覧画像: {sdir}")


if __name__ == "__main__":
    main(sys.argv[1])
