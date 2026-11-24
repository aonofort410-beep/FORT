#!/usr/bin/env python3
"""Dropboxの邸フォルダから写真サムネイルを取得する（読み取り専用）。

使い方:
  python3 dbx_thumbs.py --token-file TOKEN.txt fetch "/【完成写真】/福山エリア/邸フォルダ"
  python3 dbx_thumbs.py --token-file TOKEN.txt houses "/【完成写真】/福山エリア"

- トークンは表示・保存しない
- 使うAPIは users/get_current_account, files/list_folder(/continue), files/get_thumbnail_v2 のみ
- 再実行すると取得済みのサムネイルは飛ばす（一覧も thumbs/邸/_list.json にキャッシュ）
"""
import argparse
import json
import os
import sys
import time

import requests

API = "https://api.dropboxapi.com/2/"
CONTENT = "https://content.dropboxapi.com/2/"
EXTS = (".jpg", ".jpeg", ".png", ".heic")
NG_WORDS = ("掲載NG", "SNS等掲載NG", "SNS掲載禁止", "広告使用は不可", "内観NG")
SKIP_DIRS = ("〇見学会用RAW素材",)
BASE = os.path.dirname(os.path.abspath(__file__))


class Dbx:
    def __init__(self, token_file=None):
        """token_file は アクセストークン1行 か、app_key=/app_secret=/refresh_token= の3行（.env 形式も可）。
        省略時は環境変数 DROPBOX_APP_KEY / DROPBOX_APP_SECRET / DROPBOX_REFRESH_TOKEN を使う。
        リフレッシュトークンの場合は短期トークンをメモリ上でだけ発行して使う。"""
        if token_file:
            with open(token_file, encoding="utf-8-sig") as f:
                text = f.read().strip()
        else:
            text = "\n".join(f"{k}={os.environ.get('DROPBOX_' + k.upper(), '')}"
                             for k in ("app_key", "app_secret", "refresh_token"))
            if not os.environ.get("DROPBOX_REFRESH_TOKEN"):
                sys.exit("DROPBOX_REFRESH_TOKEN が未設定です。.env を用意するか --token-file を指定してください。")
        text = "\n".join(l.replace("DROPBOX_APP_KEY", "app_key").replace("DROPBOX_APP_SECRET", "app_secret")
                         .replace("DROPBOX_REFRESH_TOKEN", "refresh_token") for l in text.splitlines()
                         if l.strip() and not l.lstrip().startswith("#"))
        self.s = requests.Session()
        self.path_root = None  # None=個人ルート / dict=チームルート
        self._refresh = None
        kv = dict(l.split("=", 1) for l in text.splitlines() if "=" in l)
        if "refresh_token" in kv:
            self._refresh = {k: kv[k].strip() for k in ("app_key", "app_secret", "refresh_token")}
            self._renew()
        else:
            self._token = text

    def _renew(self):
        r = self.s.post(API.replace("/2/", "/oauth2/token"),
                        data={"grant_type": "refresh_token",
                              "refresh_token": self._refresh["refresh_token"]},
                        auth=(self._refresh["app_key"], self._refresh["app_secret"]), timeout=60)
        if r.status_code != 200:
            sys.exit("トークン更新に失敗: " + r.text[:120])
        self._token = r.json()["access_token"]

    def _headers(self, extra=None, use_root=False):
        h = {"Authorization": "Bearer " + self._token}
        if use_root and self.path_root:
            h["Dropbox-API-Path-Root"] = json.dumps(self.path_root)
        if extra:
            h.update(extra)
        return h

    def _request(self, url, use_root, hdr, data=None):
        for attempt in range(6):
            try:
                r = self.s.post(url, headers=self._headers(hdr, use_root), data=data, timeout=60)
            except requests.RequestException as e:
                wait = 2 ** attempt
                print(f"  通信エラー({type(e).__name__})、{wait}秒後に再試行", file=sys.stderr)
                time.sleep(wait)
                continue
            if r.status_code == 429 or r.status_code >= 500:
                wait = int(r.headers.get("Retry-After", 2 ** attempt))
                print(f"  HTTP {r.status_code}、{wait}秒待機", file=sys.stderr)
                time.sleep(wait)
                continue
            return r
        raise RuntimeError("再試行回数を超えました: " + url)

    def call(self, url, body=None, arg=None, content=False):
        """path系エラー時はチームルート指定で再試行する。"""
        def go(use_root):
            if content:
                hdr = {"Dropbox-API-Arg": json.dumps(arg, ensure_ascii=True)}
                return self._request(url, use_root, hdr)
            hdr = {"Content-Type": "application/json"}
            return self._request(url, use_root, hdr,
                                 data=json.dumps(body, ensure_ascii=True))

        r = go(self.path_root is not None)
        if r.status_code == 409 and self.path_root is None and "path" in r.text:
            self.enable_team_root()
            if self.path_root:
                print("  個人ルートでパスが見つからないため、チームルートで再試行", file=sys.stderr)
                r = go(True)
        if r.status_code == 401 and self._refresh and "expired" in r.text:
            self._renew()
            r = go(self.path_root is not None)
        if r.status_code == 401:
            # トークン切れ等は続けても全部失敗するので止める（再実行で続きから）
            sys.exit("認証エラー(401): " + r.text[:120] + "\n新しいトークンで再実行してください。")
        return r

    def enable_team_root(self):
        r = self._request(API + "users/get_current_account", False,
                          {"Content-Type": "application/json"}, data="null")
        r.raise_for_status()
        info = r.json().get("root_info", {})
        root_ns = info.get("root_namespace_id")
        if root_ns and root_ns != info.get("home_namespace_id"):
            self.path_root = {".tag": "root", "root": root_ns}

    def list_folder(self, path, recursive=True):
        r = self.call(API + "files/list_folder",
                      {"path": path, "recursive": recursive, "include_media_info": False})
        if r.status_code != 200:
            raise RuntimeError(f"list_folder失敗 {r.status_code}: {r.text[:300]}")
        d = r.json()
        entries = d["entries"]
        while d.get("has_more"):
            r = self.call(API + "files/list_folder/continue", {"cursor": d["cursor"]})
            if r.status_code != 200:
                raise RuntimeError(f"list_folder/continue失敗 {r.status_code}: {r.text[:300]}")
            d = r.json()
            entries += d["entries"]
        return entries

    def thumbnail(self, path_lower):
        arg = {"resource": {".tag": "path", "path": path_lower},
               "format": "jpeg", "size": "w640h480", "mode": "bestfit"}
        return self.call(CONTENT + "files/get_thumbnail_v2", arg=arg, content=True)


def is_target_photo(rel_path):
    parts = rel_path.split("/")
    if any(any(s in p for s in SKIP_DIRS) for p in parts[:-1]):
        return False
    if any(any(w in p for w in NG_WORDS) for p in parts[:-1]):
        return False
    return parts[-1].lower().endswith(EXTS)


def safe_name(rel_path):
    stem = rel_path.replace("/", "__")
    return os.path.splitext(stem)[0] + ".jpg"


def fetch(dbx, house_path):
    house_path = house_path.rstrip("/")
    house = house_path.split("/")[-1]
    if any(w in house for w in NG_WORDS):
        print(f"対象外（掲載NG）: {house}")
        return
    outdir = os.path.join(BASE, "thumbs", house)
    os.makedirs(outdir, exist_ok=True)
    list_file = os.path.join(outdir, "_list.json")

    if os.path.exists(list_file):
        with open(list_file, encoding="utf-8") as f:
            photos = json.load(f)
        print(f"一覧キャッシュを使用: {len(photos)}枚")
    else:
        entries = dbx.list_folder(house_path)
        photos = []
        for e in entries:
            if e.get(".tag") != "file":
                continue
            rel = e["path_display"][len(house_path) + 1:]
            if not is_target_photo(rel):
                continue
            photos.append({"name": e["name"], "rel": rel,
                           "path_display": e["path_display"],
                           "path_lower": e["path_lower"],
                           "thumb": safe_name(rel)})
        photos.sort(key=lambda p: p["rel"])
        with open(list_file, "w", encoding="utf-8") as f:
            json.dump(photos, f, ensure_ascii=False, indent=1)
        print(f"一覧取得: {len(photos)}枚")

    done = fail = 0
    for i, p in enumerate(photos, 1):
        dst = os.path.join(outdir, p["thumb"])
        if os.path.exists(dst):
            done += 1
            continue
        r = dbx.thumbnail(p["path_lower"])
        if r.status_code != 200:
            fail += 1
            print(f"  失敗 {p['rel']}: {r.status_code} {r.text[:200]}", file=sys.stderr)
            continue
        tmp = dst + ".part"
        with open(tmp, "wb") as f:
            f.write(r.content)
        os.replace(tmp, dst)  # 完了したものだけ残す（再開用）
        done += 1
        if i % 20 == 0:
            print(f"  {i}/{len(photos)}")
    print(f"完了: {done}/{len(photos)}枚、失敗 {fail}")


def houses(dbx, area_path):
    entries = dbx.list_folder(area_path, recursive=False)
    for e in sorted(entries, key=lambda e: e["name"]):
        if e.get(".tag") != "folder":
            continue
        ng = any(w in e["name"] for w in NG_WORDS) or any(s in e["name"] for s in SKIP_DIRS)
        print(("NG\t" if ng else "OK\t") + e["path_display"])


def load_dotenv(path):
    """依存ライブラリなしで .env を読み、未設定の環境変数だけ埋める。"""
    if not os.path.exists(path):
        return
    for line in open(path, encoding="utf-8-sig"):
        line = line.strip()
        if line and not line.startswith("#") and "=" in line:
            k, v = line.split("=", 1)
            os.environ.setdefault(k.strip(), v.strip().strip('"').strip("'"))


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--token-file", help="鍵ファイル。省略時は .env / 環境変数を使う")
    ap.add_argument("cmd", choices=["fetch", "houses"])
    ap.add_argument("path")
    a = ap.parse_args()
    load_dotenv(os.path.join(BASE, ".env"))
    dbx = Dbx(a.token_file)
    (fetch if a.cmd == "fetch" else houses)(dbx, a.path)


if __name__ == "__main__":
    main()
