#!/usr/bin/env python3
"""
Shared page chrome (header / nav / footer / <head>) for efipaz.com.

Used by build_content.py (generated pages) and apply_chrome.py (hand-written pages),
so every page on the site shares exactly the same navigation and footer.

Navigation follows Efi's own "site structure" document: 4 items.
"""
from __future__ import annotations

import html

SITE_URL = "https://www.efipaz.com"
ROOT = __import__("pathlib").Path(__file__).resolve().parent.parent
_ASSET_HASH: dict[str, str] = {}


def asset_url(depth: int, path: str) -> str:
    """Site-relative asset path with a content hash, so browsers never show a stale CSS/JS after a deploy."""
    if path not in _ASSET_HASH:
        import hashlib
        f = ROOT / path
        _ASSET_HASH[path] = hashlib.md5(f.read_bytes()).hexdigest()[:8] if f.exists() else "0"
    return f"{root_prefix(depth)}{path}?v={_ASSET_HASH[path]}"

NAV = {
    "he": [
        ("index.html", "בית", "home"),
        ("spiritual.html", "תבונה, מודעות והרחבת הדעת", "spiritual"),
        ("travel.html", "מסעות", "travel"),
        ("archive.html", "ארכיון", "archive"),
    ],
    "en": [
        ("index.html", "Home", "home"),
        ("spiritual.html", "Wisdom & Awareness", "spiritual"),
        ("travel.html", "Travel", "travel"),
        ("archive.html", "Archive", "archive"),
    ],
}

FOOTER = {
    "he": [
        ("תבונה, מודעות והרחבת הדעת", [
            ("spiritual.html#books", "ספרים"),
            ("spiritual.html#groups", "קבוצות"),
            ("spiritual.html#teachers", "מורים"),
        ]),
        ("מסעות", [
            ("travel.html#photography", "צילומים"),
            ("travel.html#drawings", "ציורים"),
            ("travel.html#greyhair", "הודו בשיער שיבה"),
        ]),
        ("ארכיון", [
            ("archive.html#living", "לחיות בשלום עם הכסף"),
            ("archive.html#ethics", "אתיקה"),
            ("archive.html#family", "משפחה"),
            ("archive.html#old-site", "האתר הישן"),
        ]),
        ("עוד", [
            ("en/index.html", "English"),
        ]),
    ],
    "en": [
        ("Wisdom & Awareness", [
            ("spiritual.html#books", "Books"),
            ("spiritual.html#groups", "Groups"),
            ("spiritual.html#teachers", "Teachers"),
        ]),
        ("Travel", [
            ("travel.html#photography", "Photography"),
            ("travel.html#drawings", "Drawings"),
            ("travel.html#greyhair", "India with Grey Hair"),
        ]),
        ("Archive", [
            ("archive.html#living", "Living with Money"),
            ("archive.html#ethics", "Ethics"),
            ("archive.html#family", "Family"),
            ("archive.html#old-site", "The old site"),
        ]),
        ("More", [
            ("../index.html", "עברית"),
        ]),
    ],
}

SITE_NAME = {"he": "אפי פז", "en": "Efi Paz"}
MENU_LABEL = {"he": "תפריט", "en": "Menu"}
SKIP_LABEL = {"he": "דלג לתוכן", "en": "Skip to content"}

FONTS_URL = ("https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600"
             "&family=Inter:wght@300;400;500;600&display=swap")


def esc(s) -> str:
    return html.escape("" if s is None else str(s), quote=True)


def root_prefix(depth: int) -> str:
    """Relative path from a page at `depth` folders below the site root to the root."""
    return "../" * depth


def lang_root(lang: str, depth: int) -> str:
    """Prefix to the language root (root for he, en/ for en) from a page at `depth`."""
    if lang == "he":
        return root_prefix(depth)
    # en pages live under en/; depth counts folders below the site root
    return root_prefix(depth) + "en/"


def header_html(lang: str, depth: int, active: str, alt_url: str | None) -> str:
    """Site header. `alt_url` is the equivalent page in the other language (relative)."""
    lr = lang_root(lang, depth)
    items = []
    for href, label, key in NAV[lang]:
        cls = "nav__link nav__link--active" if key == active else "nav__link"
        items.append(f'          <li><a href="{lr}{href}" class="{cls}">{esc(label)}</a></li>')
    nav_items = "\n".join(items)
    if lang == "he":
        he_link = '<a href="#" class="active" aria-current="page">עב</a>'
        en_link = f'<a href="{esc(alt_url)}" lang="en" hreflang="en">EN</a>' if alt_url else ""
    else:
        he_link = f'<a href="{esc(alt_url)}" lang="he" hreflang="he">עב</a>' if alt_url else ""
        en_link = '<a href="#" class="active" aria-current="page">EN</a>'
    return f"""  <header class="header">
    <div class="container header__inner">
      <a href="{lr}index.html" class="header__logo">{esc(SITE_NAME[lang])}</a>
      <nav class="nav" aria-label="{esc(MENU_LABEL[lang])}">
        <ul class="nav__list" id="nav-list">
{nav_items}
        </ul>
        <div class="lang-switch">
          {he_link}
          {en_link}
        </div>
        <button class="nav__toggle" aria-label="{esc(MENU_LABEL[lang])}" aria-expanded="false" aria-controls="nav-list">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </nav>
    </div>
  </header>"""


def footer_html(lang: str, depth: int) -> str:
    lr = lang_root(lang, depth)
    cols = []
    for title, links in FOOTER[lang]:
        lis = "\n".join(
            f'            <li><a href="{(root_prefix(depth) + href[3:]) if href.startswith("../") else lr + href}">{esc(label)}</a></li>'
            for href, label in links
        )
        cols.append(f"""        <div class="footer__section">
          <p class="footer__title">{esc(title)}</p>
          <ul class="footer__links">
{lis}
          </ul>
        </div>""")
    cols_html = "\n".join(cols)
    return f"""  <footer class="footer">
    <div class="container">
      <div class="footer__inner">
{cols_html}
      </div>
      <div class="footer__bottom">
        <p>{esc(SITE_NAME[lang])}</p>
      </div>
    </div>
  </footer>"""


NAV_SCRIPT = """  <script>
    (function () {
      var t = document.querySelector('.nav__toggle');
      var l = document.querySelector('.nav__list');
      if (!t || !l) return;
      t.addEventListener('click', function () {
        var open = l.classList.toggle('is-open');
        t.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
    })();
  </script>"""


def head_html(lang: str, depth: int, title: str, description: str,
              canonical_path: str | None = None, alt_path: str | None = None,
              og_image: str | None = None, extra: str = "", noindex: bool = False) -> str:
    """<head> block. Paths are site-root-relative (no leading slash)."""
    rp = root_prefix(depth)
    full_title = f"{title} | {SITE_NAME[lang]}" if title and title != SITE_NAME[lang] else SITE_NAME[lang]
    lines = [
        '  <meta charset="UTF-8">',
        '  <meta name="viewport" content="width=device-width, initial-scale=1.0">',
        f'  <meta name="description" content="{esc(description)}">',
        f"  <title>{esc(full_title)}</title>",
    ]
    if noindex:
        lines.append('  <meta name="robots" content="noindex, nofollow">')
    if canonical_path:
        can = f"{SITE_URL}/{canonical_path}"
        lines.append(f'  <link rel="canonical" href="{esc(can)}">')
        lines.append(f'  <meta property="og:url" content="{esc(can)}">')
        other = "en" if lang == "he" else "he"
        lines.append(f'  <link rel="alternate" hreflang="{lang}" href="{esc(can)}">')
        if alt_path:
            lines.append(f'  <link rel="alternate" hreflang="{other}" href="{esc(SITE_URL + "/" + alt_path)}">')
    lines += [
        f'  <meta property="og:title" content="{esc(full_title)}">',
        f'  <meta property="og:description" content="{esc(description)}">',
        '  <meta property="og:type" content="website">',
        f'  <meta property="og:site_name" content="{esc(SITE_NAME[lang])}">',
        f'  <meta property="og:locale" content="{"he_IL" if lang == "he" else "en_US"}">',
    ]
    if og_image:
        lines.append(f'  <meta property="og:image" content="{esc(SITE_URL + "/" + og_image)}">')
    lines += [
        '  <link rel="preconnect" href="https://fonts.googleapis.com">',
        '  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>',
        f'  <link href="{FONTS_URL}" rel="stylesheet">',
        f'  <link rel="stylesheet" href="{asset_url(depth, "style.css")}">',
        f'  <link rel="icon" href="{rp}favicon.ico" type="image/x-icon">',
    ]
    if extra:
        lines.append(extra.rstrip("\n"))
    return "\n".join(lines)


def page(lang: str, depth: int, title: str, description: str, active: str, body: str,
         canonical_path: str | None = None, alt_path: str | None = None, alt_url: str | None = None,
         og_image: str | None = None, extra_head: str = "", extra_scripts: str = "",
         noindex: bool = False) -> str:
    """Complete HTML document with the shared chrome."""
    dir_attr = "rtl" if lang == "he" else "ltr"
    doc = f"""<!DOCTYPE html>
<html lang="{lang}" dir="{dir_attr}">
<head>
{head_html(lang, depth, title, description, canonical_path, alt_path, og_image, extra_head, noindex)}
</head>
<body>
  <a class="skip-link" href="#main">{esc(SKIP_LABEL[lang])}</a>
{header_html(lang, depth, active, alt_url)}

  <main id="main">

{body}

  </main>

{footer_html(lang, depth)}

{chr(10).join(x for x in (extra_scripts, NAV_SCRIPT) if x)}
</body>
</html>
"""
    import re as _re
    return _re.sub(r"\n{3,}", "\n\n", doc).rstrip("\n") + "\n"
