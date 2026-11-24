#!/usr/bin/env python3
"""見た目がほぼ同じサムネイルを検出し、重複分の番号→元番号の対応と、重複を除いた番号リストを出す。
使い方: python3 dedup.py "邸フォルダ名" 出力プレフィックス"""
import json, sys, collections
from PIL import Image
h, out = sys.argv[1], sys.argv[2]
d = json.load(open(f'sheets/{h}/_index.json', encoding='utf-8'))
def ph(p):
    im = Image.open(f"thumbs/{h}/{p['thumb']}").convert('L').resize((16, 12))
    px = list(im.get_flattened_data()) if hasattr(im, 'get_flattened_data') else list(im.getdata())
    m = sum(px) / len(px)
    return [1 if v > m else 0 for v in px]
hs = [ph(x) for x in d]
orig = {}
for i, x in enumerate(d):
    for j in range(i):
        if j in orig: continue
        if sum(a != b for a, b in zip(hs[i], hs[j])) <= 12 and d[j]['縦横'] == x['縦横']:
            orig[i] = j; break
json.dump({str(d[i]['no']): d[j]['no'] for i, j in orig.items()}, open(out + '_dups.json', 'w'))
json.dump([x['no'] for i, x in enumerate(d) if i not in orig], open(out + '_uniq.json', 'w'))
print(len(d), 'dups', len(orig), collections.Counter(x['rel'].rsplit('/', 1)[0] if '/' in x['rel'] else '.' for x in d))
