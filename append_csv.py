#!/usr/bin/env python3
"""判定ファイルと一覧インデックスから 写真分類.csv に追記する（重複パスは飛ばす）。
使い方: python3 append_csv.py エリア "邸フォルダ名"
判定ファイル: judgments/邸フォルダ名.txt  1行1枚「番号 部屋 色味 人物 投稿向き度 ひとこと」
（旧形式 judgments/邸フォルダ名.json にも対応）
"""
import csv, json, os, sys
BASE = os.path.dirname(os.path.abspath(__file__))
CSV = os.path.join(BASE, "写真分類.csv")
COLS = ["エリア", "邸フォルダ名", "ファイル名", "Dropboxパス", "部屋", "縦横", "色味", "人物", "投稿向き度", "ひとこと"]
ROOMS = {"外観","玄関","LDK","キッチン","洗面","浴室","トイレ","寝室","収納","階段","ガレージ","中庭・庭","その他"}
COLORS = {"白","グレー","木目","黒","その他"}


def load_judgments(house):
    txt = os.path.join(BASE, "judgments", house + ".txt")
    if os.path.exists(txt):
        j = {}
        for line in open(txt, encoding="utf-8"):
            if line.strip():
                no, *rest = line.split(maxsplit=5)
                j[no] = rest
        return j
    return json.load(open(os.path.join(BASE, "judgments", house + ".json"), encoding="utf-8"))


area, house = sys.argv[1], sys.argv[2]
index = json.load(open(os.path.join(BASE, "sheets", house, "_index.json"), encoding="utf-8"))
judg = load_judgments(house)
missing = [str(p["no"]) for p in index if str(p["no"]) not in judg]
if missing:
    sys.exit("判定が無い番号: " + ",".join(missing))
for p in index:
    room, color, person, grade, note = judg[str(p["no"])]
    assert room in ROOMS and color in COLORS and person in ("あり","なし") and grade in ("A","B","C"), (p["no"], judg[str(p["no"])])
    assert len(note.strip()) <= 20, (p["no"], note)

done = set()
new_file = not os.path.exists(CSV)
if not new_file:
    with open(CSV, encoding="utf-8-sig", newline="") as f:
        done = {r["Dropboxパス"] for r in csv.DictReader(f)}

added = 0
with open(CSV, "a", encoding="utf-8-sig" if new_file else "utf-8", newline="") as f:
    w = csv.writer(f)
    if new_file:
        w.writerow(COLS)
    for p in index:
        if p["path_display"] in done:
            continue
        room, color, person, grade, note = judg[str(p["no"])]
        w.writerow([area, house, p["name"], p["path_display"], room, p["縦横"], color, person, grade, note.strip()])
        added += 1
print(f"追記 {added}行（既存スキップ {len(index) - added}）")
