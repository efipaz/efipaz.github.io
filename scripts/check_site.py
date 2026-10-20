#!/usr/bin/env python3
"""
check_site.py — static checks for efipaz.com. Exit 0 when clean, 1 when something is wrong.

Checks (live pages only; archive/old-site is left alone):
  * every internal href/src/url() resolves to a file (case-sensitive, URL-decoded)
  * every #anchor points at an existing id in the target page
  * every HTML page declares charset=UTF-8 and has lang + dir on <html>
  * no <!img …> pseudo-tags, no trailing junk after </html>
  * no live page links into archive/old-site except archive.html / ethics pages
  * no <img> outside a lightbox points at a file larger than 1 MB
  * manifests are valid JSON; auto:* markers are balanced
  * Hebrew/English page pairs have the same section ids and the same number of cards
  * style.css uses only the palette colours (and documented tints)
  * tracked file names never collide on a case-insensitive file system

Usage: python3 scripts/check_site.py [--quiet]
"""
from __future__ import annotations

import json
import re
import subprocess
import sys
import urllib.parse
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
PROBLEMS: list[str] = []
WARNINGS: list[str] = []

LIVE_GLOBS = ["*.html", "en/*.html", "living/**/*.html", "personal/**/*.html", "business/**/*.html",
              "teachers/**/*.html", "travel/**/*.html"]
OLD_SITE_ALLOWED = {"archive.html", "en/archive.html", "en/ethics.html", "personal/ethics/index.html"}
PALETTE_OK = {"#f7f5f0", "#1a1a1a", "#8b2635", "#efebe4", "#4a4a4a", "#d4cfc5", "#fff", "#ffffff"}
PAIRS = ["index", "spiritual", "travel", "archive"]


def problem(msg: str) -> None:
    PROBLEMS.append(msg)


def warn(msg: str) -> None:
    WARNINGS.append(msg)


def live_pages() -> list[Path]:
    seen = set()
    for g in LIVE_GLOBS:
        for p in ROOT.glob(g):
            if "old-site" in p.parts or p.name.endswith(".bak"):
                continue
            seen.add(p)
    return sorted(seen)


ATTR_RE = re.compile(r"""(?:href|src|poster)\s*=\s*["']([^"']+)["']""", re.I)
URL_RE = re.compile(r"""url\(\s*['"]?([^'")]+)['"]?\s*\)""", re.I)
ID_RE = re.compile(r"""\sid\s*=\s*["']([^"']+)["']""")
IMG_RE = re.compile(r"<img\b[^>]*\bsrc\s*=\s*[\"']([^\"']+)[\"']", re.I)


def check_page(page: Path, ids_cache: dict[Path, set[str]]) -> None:
    rel = page.relative_to(ROOT).as_posix()
    raw = page.read_bytes()
    try:
        text = raw.decode("utf-8")
    except UnicodeDecodeError:
        problem(f"{rel}: not valid UTF-8")
        return
    if "<!--" in text and re.search(r"<!(?!--|DOCTYPE|doctype)", text):
        problem(f"{rel}: broken pseudo-comment tag like <!img …>")
    if not re.search(r"<meta\s+charset\s*=\s*[\"']?utf-8", text, re.I):
        problem(f"{rel}: missing <meta charset=\"UTF-8\">")
    m = re.search(r"<html\b([^>]*)>", text, re.I)
    attrs = m.group(1) if m else ""
    if 'lang="' not in attrs:
        problem(f"{rel}: <html> has no lang attribute")
    if 'dir="' not in attrs:
        problem(f"{rel}: <html> has no dir attribute")
    tail = text.split("</html>")[-1]
    if tail.strip():
        problem(f"{rel}: content after </html>")
    if text.count("</html>") > 1:
        problem(f"{rel}: more than one </html>")
    for key in set(re.findall(r"<!-- auto:([a-z-]+) -->", text)):
        if f"<!-- /auto:{key} -->" not in text:
            problem(f"{rel}: marker auto:{key} is not closed")
    # links
    is_old_site = "old-site" in rel
    for target in ATTR_RE.findall(text) + URL_RE.findall(text):
        t = target.strip()
        if not t or t.startswith(("http:", "https:", "mailto:", "tel:", "data:", "javascript:", "#", "//")):
            if t.startswith("#") and len(t) > 1:
                frag = t[1:]
                if frag not in page_ids(page, ids_cache):
                    problem(f"{rel}: anchor {t} has no matching id on the page")
            continue
        path_part, _, frag = t.partition("#")
        path_part = path_part.split("?")[0]
        if not path_part:
            continue
        path_part = urllib.parse.unquote(path_part)
        if path_part.startswith("/"):
            dest = ROOT / path_part.lstrip("/")
        else:
            dest = (page.parent / path_part)
        try:
            dest = dest.resolve()
            dest.relative_to(ROOT)
        except (ValueError, OSError):
            problem(f"{rel}: link escapes the site root: {t}")
            continue
        if dest.is_dir():
            dest = dest / "index.html"
        if not dest.exists():
            problem(f"{rel}: broken link {t}")
            continue
        if not is_old_site and "old-site" in dest.relative_to(ROOT).parts and rel not in OLD_SITE_ALLOWED:
            problem(f"{rel}: live page links into archive/old-site: {t}")
        if frag and dest.suffix == ".html" and frag not in page_ids(dest, ids_cache):
            problem(f"{rel}: anchor #{frag} not found in {dest.relative_to(ROOT).as_posix()}")
    # heavy images
    for src in IMG_RE.findall(text):
        s = urllib.parse.unquote(src.split("?")[0])
        if s.startswith(("http", "data:")):
            continue
        dest = (ROOT / s.lstrip("/")) if s.startswith("/") else (page.parent / s)
        if dest.exists() and dest.stat().st_size > 1_000_000:
            problem(f"{rel}: <img> loads a {dest.stat().st_size // 1024} KB file: {src}")


def page_ids(page: Path, cache: dict[Path, set[str]]) -> set[str]:
    if page not in cache:
        try:
            cache[page] = set(ID_RE.findall(page.read_text(encoding="utf-8", errors="replace")))
        except OSError:
            cache[page] = set()
    return cache[page]


def check_manifests() -> None:
    for m in ["books/manifest.json", "transcripts/manifest.json", "travel/gallery-manifest.json",
              "teachers/manifest.json", "recordings/manifest.json", "assets/data/content-report.json"]:
        p = ROOT / m
        if not p.exists():
            warn(f"{m}: missing")
            continue
        try:
            json.loads(p.read_text(encoding="utf-8"))
        except Exception as e:  # noqa: BLE001
            problem(f"{m}: invalid JSON ({e})")


def check_pairs() -> None:
    for name in PAIRS:
        he, en = ROOT / f"{name}.html", ROOT / "en" / f"{name}.html"
        if not he.exists() or not en.exists():
            problem(f"language pair missing: {name}.html / en/{name}.html")
            continue
        th, te = he.read_text(encoding="utf-8"), en.read_text(encoding="utf-8")
        sec_he = re.findall(r"<section[^>]*\bid=\"([^\"]+)\"", th)
        sec_en = re.findall(r"<section[^>]*\bid=\"([^\"]+)\"", te)
        if sec_he != sec_en:
            problem(f"{name}: section ids differ he={sec_he} en={sec_en}")
        ch, ce = len(re.findall(r'class="card[ "]', th)), len(re.findall(r'class="card[ "]', te))
        if ch != ce:
            problem(f"{name}: card count differs he={ch} en={ce}")


def check_css() -> None:
    css = (ROOT / "style.css").read_text(encoding="utf-8")
    css = re.sub(r"/\*.*?\*/", "", css, flags=re.S)
    for hexv in set(re.findall(r"#[0-9a-fA-F]{3,6}\b", css)):
        if hexv.lower() not in PALETTE_OK:
            problem(f"style.css: colour outside the palette: {hexv}")
    for rgba in set(re.findall(r"rgba?\(([^)]+)\)", css)):
        nums = [n.strip() for n in rgba.split(",")[:3]]
        if nums not in (["247", "245", "240"], ["26", "26", "26"], ["139", "38", "53"]):
            problem(f"style.css: rgba outside the palette: rgba({rgba})")
    for word in re.findall(r":\s*(white|black|red|blue|green|gray|grey)\b", css):
        problem(f"style.css: named colour {word}")


def check_case_collisions() -> None:
    try:
        out = subprocess.run(["git", "ls-files"], cwd=ROOT, capture_output=True, text=True, check=True).stdout
    except Exception:  # noqa: BLE001
        return
    seen: dict[str, str] = {}
    for line in out.splitlines():
        k = line.lower()
        if k in seen and seen[k] != line:
            problem(f"case-insensitive path collision: {seen[k]} vs {line}")
        seen[k] = line


def check_archive_encoding() -> None:
    """GitHub Pages serves every HTML file as charset=utf-8 (the HTTP header beats <meta charset>), so a
    Windows-1255 or UTF-16 file in the archive shows as gibberish. Every text file must be UTF-8."""
    for p in (ROOT / "archive").rglob("*"):
        if p.suffix.lower() not in (".html", ".htm", ".js", ".css", ".txt"):
            continue
        raw = p.read_bytes()
        rel = p.relative_to(ROOT).as_posix()
        try:
            text = raw.decode("utf-8")
        except UnicodeDecodeError:
            problem(f"{rel}: not UTF-8 (would show as gibberish on GitHub Pages)")
            continue
        m = re.search(r"charset=[\"']?([A-Za-z0-9_-]+)", text, re.I)
        if m and m.group(1).lower() != "utf-8" and any(ord(c) > 127 for c in text):
            problem(f"{rel}: declares charset={m.group(1)} but the file is UTF-8")


def main(argv: list[str]) -> int:
    quiet = "--quiet" in argv
    cache: dict[Path, set[str]] = {}
    pages = live_pages()
    for p in pages:
        check_page(p, cache)
    check_archive_encoding()
    check_manifests()
    check_pairs()
    check_css()
    check_case_collisions()
    for w in WARNINGS:
        print(f"WARN  {w}")
    for p in PROBLEMS:
        print(f"ERROR {p}")
    print(f"\n{len(pages)} pages checked, {len(PROBLEMS)} problem(s), {len(WARNINGS)} warning(s)")
    return 1 if PROBLEMS else 0


if __name__ == "__main__":
    sys.exit(main(sys.argv[1:]))
