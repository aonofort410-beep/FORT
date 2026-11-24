#!/usr/bin/env python3
"""投稿計画（posts.json）から、各投稿のカルーセル写真を選び plan.json と 投稿計画.csv を作る。
使い方: python3 build_plan.py pages/post_plan/posts.json
posts.json: [{"date","dow","h"(邸フォルダ名),"label","theme","caption"}, ...]  例は pages/post_plan/posts.example.json
選び方: 人物なしのA/Bから、表紙=縦長優先のA、以降は部屋の優先順で1部屋最大2枚・計10枚まで。"""
import base64, csv, io, json, os, sys
from PIL import Image
BASE = os.path.dirname(os.path.abspath(__file__))
POST_TIME = os.environ.get("POST_TIME", "20:00")
PRI = {"外観": 0, "LDK": 1, "キッチン": 2, "玄関": 3, "ガレージ": 3, "中庭・庭": 4, "階段": 5, "洗面": 6,
       "その他": 7, "トイレ": 8, "寝室": 9, "浴室": 10, "収納": 11}
src = sys.argv[1]
posts = json.load(open(src, encoding="utf-8"))
rows = list(csv.DictReader(open(os.path.join(BASE, "写真分類.csv"), encoding="utf-8-sig")))
for p in posts:
    rs = [r for r in rows if r["邸フォルダ名"] == p["h"] and r["人物"] == "なし" and r["投稿向き度"] in ("A", "B")]
    idx = {x["path_display"]: x for x in json.load(open(os.path.join(BASE, "sheets", p["h"], "_index.json"), encoding="utf-8"))}
    A = [r for r in rs if r["投稿向き度"] == "A"]; B = [r for r in rs if r["投稿向き度"] == "B"]
    cover = sorted(A, key=lambda r: (r["縦横"] != "縦", PRI[r["部屋"]]))[0] if A else B[0]
    pick, cnt = [cover], {cover["部屋"]: 1}
    for r in sorted(A, key=lambda r: PRI[r["部屋"]]) + sorted(B, key=lambda r: PRI[r["部屋"]]):
        if len(pick) >= 10: break
        if r in pick or cnt.get(r["部屋"], 0) >= 2: continue
        pick.append(r); cnt[r["部屋"]] = cnt.get(r["部屋"], 0) + 1
    p["photos"] = []
    for r in pick:
        im = Image.open(os.path.join(BASE, "thumbs", p["h"], idx[r["Dropboxパス"]]["thumb"])).convert("RGB")
        im.thumbnail((360, 360)); b = io.BytesIO(); im.save(b, "JPEG", quality=70)
        p["photos"].append({"f": r["ファイル名"], "p": r["Dropboxパス"], "r": r["部屋"], "o": r["縦横"], "g": r["投稿向き度"],
                            "n": r["ひとこと"], "i": base64.b64encode(b.getvalue()).decode()})
out_dir = os.path.dirname(os.path.abspath(src))
json.dump(posts, open(os.path.join(out_dir, "plan.json"), "w", encoding="utf-8"), ensure_ascii=False)
with open(os.path.join(BASE, "投稿計画.csv"), "w", encoding="utf-8-sig", newline="") as f:
    w = csv.writer(f); w.writerow(["投稿日", "曜日", "時刻", "テーマ", "タイトル", "枚順", "部屋", "Dropboxパス", "キャプション"])
    for p in posts:
        for k, x in enumerate(p["photos"], 1):
            w.writerow([p["date"], p["dow"], POST_TIME, p["theme"], p["label"], k, x["r"], x["p"], p["caption"] if k == 1 else ""])
print(len(posts), "投稿 →", os.path.join(out_dir, "plan.json"), "/ 投稿計画.csv")
