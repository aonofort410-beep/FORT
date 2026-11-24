#!/usr/bin/env python3
"""重複を除いた判定(プレフィックス_u.txt)を、重複分は「#元番号と重複」のCにして全件に展開する。
使い方: python3 expand_dups.py "邸フォルダ名" 出力プレフィックス"""
import json, sys
h, pre = sys.argv[1], sys.argv[2]
dups = json.load(open(pre + '_dups.json'))
n_all = len(json.load(open(f'sheets/{h}/_index.json', encoding='utf-8')))
j = {}
for l in open(pre + '_u.txt', encoding='utf-8'):
    if l.strip():
        no, *r = l.split(maxsplit=5); j[int(no)] = r
miss = [n for n in json.load(open(pre + '_uniq.json')) if n not in j]
if miss: sys.exit(f'判定が無い番号: {miss}')
out = []
for n in range(1, n_all + 1):
    if n in j: out.append(f"{n} {' '.join(j[n][:4])} {j[n][4].strip()}")
    else:
        o = int(dups[str(n)])
        while o not in j: o = int(dups[str(o)])
        r = j[o]; out.append(f"{n} {r[0]} {r[1]} {r[2]} C #{o}と重複")
open(f'judgments/{h}.txt', 'w', encoding='utf-8').write('\n'.join(out) + '\n')
print(len(out), 'lines')
