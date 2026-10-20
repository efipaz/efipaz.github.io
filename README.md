# efipaz.com

> האתר האישי של **אפי פז** – תבונה, מודעות והרחבת הדעת · מסעות · ארכיון

האתר פועל מאמצע שנות ה-2000, עבר מודרניזציה בינואר 2026 ורפורמה מלאה באוקטובר 2026.
מתארח ב-GitHub Pages (`efipaz/efipaz.github.io`, דומיין www.efipaz.com).

## לאפי

**לוח הבקרה:** https://www.efipaz.com/admin.html – כפתור לכל פעולה, שלושה צעדים, בלי HTML.
המדריך המלא: [HOWTO.md](HOWTO.md).

## מה יש באתר

| מדור | תוכן | קבצים |
|------|------|-------|
| תבונה, מודעות והרחבת הדעת | ספרים (אוטומטי מ-`books/`), קבוצות (הקלטות מ-archive.org, תמלולים מ-`transcripts/`), מורים (אוטומטי מ-`teachers/`) | `spiritual.html`, `en/spiritual.html` |
| מסעות | גלריות (אוטומטי מ-`travel/`), ציורים, הודו בשיער שיבה, בלוג, Flickr | `travel.html`, `en/travel.html` |
| ארכיון | לחיות בשלום עם הכסף, אתיקה, ייעוץ עסקי, משפחה, אודות, האתר הישן | `archive.html`, `living.html`, `ethics.html`, `family.html`, `personal.html` + `en/` |

## איך זה עובד

`scripts/build_content.py` רץ ב-GitHub Actions בכל העלאה והופך קבצים לתוכן:
שערי ספרים, המרת Word ל-PDF, thumbnails, עמודי גלריה ועמודי הוגים (עברית + אנגלית), רשימת הקלטות,
ודוח בעברית (`content-report.md`). ראה [CLAUDE.md](CLAUDE.md) לפרטים.

## פיתוח

```bash
python3 scripts/build_content.py          # בניית תוכן (דורש poppler, imagemagick, ffmpeg, libreoffice, Pillow)
python3 scripts/apply_chrome.py           # header/footer אחיד בכל העמודים הידניים
bash scripts/validate-all.sh              # כל הבדיקות
python3 -m http.server 8077               # צפייה מקומית
```

עיצוב: מינימליזם יפני, שלושה צבעים, Heebo/Inter. אין ספריות JS חיצוניות חוץ מ-pdf.js (ב-`viewer.html`).
