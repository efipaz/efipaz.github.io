# CLAUDE.md – הוראות עבודה לסוכני AI

קובץ זה מכיל הנחיות מחייבות לעבודה על פרויקט efipaz.com.
**קרא קובץ זה במלואו לפני כל שינוי בקוד.**

---

## סקירת הפרויקט

אתר אישי של אפי פז (בן 80): תבונה ומודעות (ספרים, קבוצות, מורים), צילומי מסעות, וארכיון
(לחיות בשלום עם הכסף, אתיקה, משפחה, האתר הישן). דו-לשוני: עברית בשורש, אנגלית ב-`en/`.
האתר מתארח ב-GitHub Pages מהריפו `efipaz/efipaz.github.io` (ענף `main`, דומיין www.efipaz.com).

**העיקרון המנחה:** אפי מעלה קבצים דרך ממשק GitHub (או דרך `admin.html`) והאתר מתעדכן לבד.
אפס עריכת HTML ידנית מצד אפי. כל מה שאפי עורך אי פעם הוא קובץ `.txt` פשוט.

### מבנה התיקיות

```
efipaz/
├── index.html spiritual.html travel.html archive.html   # 4 עמודי התפריט (עברית)
├── admin.html              # לוח הבקרה של אפי (noindex, לא בתפריט)
├── viewer.html             # קורא PDF (pdf.js) – viewer.html?file=<נתיב>
├── 404.html  style.css  sitemap.xml  robots.txt  HOWTO.md  content-report.md
├── en/                     # אותם עמודים באנגלית (index, spiritual, travel, archive, viewer) + living/ethics: תיאור באנגלית של האתרים העבריים
├── books/                  # ספרים: PDF/Word → שער + כרטיס אוטומטי. <שם>.txt לכותרת/תיאור
├── transcripts/            # תמלולים (קבוצות) – אותו מנגנון כמו books
├── travel/<תיקייה>/        # כל תיקייה עם תמונות = גלריה. info.txt אופציונלי, cover.jpg אופציונלי
│   ├── india/ myanmar/     # גלריות ידניות (עם קטגוריות) – index.html נכתב ביד, לא נדרס
│   └── thumbs/             # נוצר אוטומטית
├── teachers/<id>/          # הוגה: info.txt + portrait.jpg + קבצים → index.html + index.en.html אוטומטיים. עמוד אחד להוגה: אין עמודי סקירה ידניים לצידו
├── recordings/manifest.json  # רשימת ההקלטות מ-archive.org (אוטומטי)
├── living/ personal/ business/   # עמודי תוכן ישנים שהומרו (טקסט מקורי של אפי)
├── archive/                # ארכיון: courses/, family/, misc/, ו-old-site/ (האתר הישן כפי שהיה, UTF-8, לא נוגעים בתוכן)
├── assets/js/gallery.js viewer.js   assets/data/content-report.json
├── scripts/                # build_content.py, sitechrome.py, apply_chrome.py, check_site.py, validate-all.sh
└── .github/workflows/auto-process-content.yml
```

---

## מערכת התוכן האוטומטית (חשוב!)

`scripts/build_content.py` הוא המנוע. הוא רץ ב-GitHub Actions בכל push ל-`books/ transcripts/ travel/ teachers/`
ולקבצים בשורש, וגם מקומית. הוא:

| מה | איך |
|----|-----|
| ספרים/תמלולים | ממיר doc/docx/odt/rtf/mht ל-PDF (LibreOffice), מפיק שער מעמוד 1, כותב `manifest.json`, ומזריק כרטיסים ל-`spiritual.html` + `en/spiritual.html` בין `<!-- auto:books -->` ו-`<!-- /auto:books -->` |
| גלריות | כל תיקייה ב-`travel/` עם תמונות/וידאו: thumbnails, HEIC→JPG, poster לווידאו, `index.html` + `index.en.html` מתבנית, `gallery-manifest.json`, כרטיסים ב-`travel.html` בין `auto:galleries`. תיקייה עם `cover.*` בלבד = כרטיס "בקרוב" |
| מורים | `teachers/<id>/info.txt` (מפתחות בעברית/אנגלית, ראה דוגמה ב-`teachers/spinoza/info.txt`) → עמוד הוגה he+en עם ביו, ויקיפדיה, PDF דרך ה-viewer, mp3, עמודים ישנים, תמונות; כרטיסים ב-`spiritual.html` בין `auto:teachers` |
| הקלטות | שואל את archive.org (`uploader:efipaz@gmail.com`) → `recordings/manifest.json` → כרטיסים בין `auto:recordings` |
| שורש | PDF/תמונה שהועלו לשורש בטעות מועברים ל-`books/` או ל-`travel/inbox-<תאריך>/` |
| דוח | `content-report.md` (לאפי, עברית) + `assets/data/content-report.json` (ל-`admin.html`) |
| sitemap | `sitemap.xml` נבנה מחדש |

**כללים לסוכני AI:**
- **אין לערוך ידנית** את ה-manifest-ים, את מה שבין סימני `<!-- auto:* -->`, את `travel/*/index.html` של גלריות אוטומטיות,
  את `teachers/*/index*.html`, את `sitemap.xml` ואת `content-report.*`. אם צריך לתקן – מתקנים את `build_content.py`.
- המנוע **סלחני**: קובץ בעייתי לעולם לא מפיל את הריצה, הוא נרשם בדוח. שמור על העיקרון הזה.
- המנוע **אידמפוטנטי**: ריצה שנייה בלי שינוי תוכן לא משנה קבצים. בדוק זאת אחרי כל שינוי בו.
- מטא-דאטה של קבצים = קובץ `.txt` ליד הקובץ באותו שם (ספרים, מורים, גלריות). פורמט `מפתח: ערך`, ראה `parse_info()`.
- אסור להוסיף דרישות נסתרות (כמו `info.txt` חובה). כל דבר שאפי מעלה למקום סביר חייב לעבוד.

---

## עיצוב ו-chrome משותף

- מינימליזם יפני, **3 צבעים בלבד**: `#F7F5F0` רקע, `#1A1A1A` טקסט, `#8B2635` הדגשה (+ הגוונים המתועדים ב-`style.css`).
  `check_site.py` נכשל על כל צבע אחר.
- גופנים: Heebo (עברית), Inter (אנגלית). עמודי `en/` מקבלים `lang="en" dir="ltr"` ו-`style.css` מטפל בשאר.
- **כל העמודים חולקים header/nav/footer מ-`scripts/sitechrome.py`.** תפריט של 4 פריטים לפי "מבנה האתר" של אפי:
  בית · תבונה, מודעות והרחבת הדעת · מסעות · ארכיון. אין להוסיף פריטים.
- שינוי בתפריט/פוטר: עורכים את `sitechrome.py` ומריצים `python3 scripts/apply_chrome.py` (מעדכן את כל העמודים הידניים;
  העמודים האוטומטיים מתעדכנים בריצת `build_content.py`).
- עמוד חדש: `<main id="main">` עוטף את התוכן, קישור דילוג, `<meta charset="UTF-8">`, ללא inline styles, ללא classes שלא קיימים ב-`style.css`.
- תמונות: לעולם לא `<img>` לקובץ מעל 1MB (ה-checker נכשל). משתמשים ב-thumbs.

---

## חי מול ארכיון – לא מערבבים

| חי (נערך, מתוחזק) | ארכיון (לא נוגעים) |
|---|---|
| עמודי השורש, `en/`, `books/`, `transcripts/`, `travel/`, `teachers/`, `living/`, `personal/`, `business/`, `assets/`, `scripts/` | `archive/` כולו, ובמיוחד `archive/old-site/` (האתר הישן כפי שהיה) |

- `archive/old-site/` נגיש מ-`archive.html#old-site`. אין להמיר קידוד, אין "לשפר", אין למחוק.
- קישורים מעמודים חיים אל `archive/old-site/` מותרים רק מ-`archive.html`, `en/ethics.html` ו-`personal/ethics/index.html` (ה-checker אוכף).
- בשורש נשארים redirect stubs לנתיבים הישנים הציבוריים (`/LightOfIndia/`, `/Burma/`, `/Ethics/` וכו').

---

## בדיקות – לפני כל commit

```bash
bash scripts/validate-all.sh      # build dry-run + apply_chrome --check + check_site
python3 scripts/build_content.py   # ריצה אמיתית (צריך poppler, imagemagick, ffmpeg, libreoffice, Pillow)
python3 scripts/build_content.py   # ריצה שנייה: חייבת לדווח "changed files: 0"
```

`check_site.py` בודק: קישורים ועוגנים, charset/lang/dir, תגיות `<!img`, סימני auto מאוזנים, manifests תקינים,
סנכרון he↔en (sections + מספר כרטיסים), פלטת צבעים, תמונות כבדות, התנגשויות רישיות בשמות קבצים.

בדיקה ויזואלית: `python3 -m http.server 8077` + Playwright (Chromium ב-`/opt/pw-browsers/chromium`) – כל עמוד
ב-1280 וב-390, 0 שגיאות קונסול, 0 בקשות 404, צילומי מסך.

---

## רשימת בדיקות לפני Commit

- [ ] `bash scripts/validate-all.sh` ירוק
- [ ] `build_content.py` פעמיים – השנייה בלי שינויים
- [ ] עברית ואנגלית מסונכרנות (אותן sections, אותו מספר כרטיסים)
- [ ] לא נגעת ב-`archive/` ולא ב-manifest-ים/אזורי auto ידנית
- [ ] לא הוספת צבע, גופן, ספרייה חיצונית או פריט תפריט
- [ ] אם שינית `sitechrome.py` – הרצת `apply_chrome.py`

---

## מבנה תוכן – כללים

- **עמוד אחד לכל דבר.** להוגה יש עמוד אחד (נוצר אוטומטית). עמודי משנה (פרק מתורגם, מאמר) הם תוכן, לא "סקירה" נוספת.
  עמוד שמשכפל עמוד אחר נמחק ומשאיר redirect stub. עמוד בלי תוכן (למשל "הסרטון הוסר") נמחק.
- **הארכיון מצביע ישירות על האתרים המקוריים** (`living/index.html`, `personal/ethics/index.html`, `business/index.html`),
  בלי שכבת "סקירה" ביניהם. אין עמודי living/ethics/personal/family בשורש (נותרו redirect stubs).
- מטא-דאטה ב-`info.txt` של הוגה: בנוסף לשדות הרגילים, `קישורים:` (שורה לכל קישור, `תווית | https://…`) ו-`עמודים:` (משפט מעל רשימת עמודי המשנה).
- כותרת של עמוד משנה נלקחת מה-`<h1>` שלו; כותרת של PDF מה-`.txt` שלידו – חייבת להתאים למה שכתוב בקובץ עצמו.

## היסטוריה חשובה (למד משגיאות העבר)

1. **ינואר 2026:** מודרניזציה שכתבה את הטקסטים של אפי במקום להמיר אותם. הטקסט המקורי הוחזר מ-`archive/old-site/`.
   **לעולם לא לשכתב טקסט של אפי. ממירים, לא "משפרים".**
2. **פברואר 2026:** אפי העלה גלריה ללא `info.txt` והיא לא נוצרה; עריכות HTML ידניות שלו שברו את `travel.html`.
   מכאן: אפס דרישות נסתרות, אפס עריכת HTML לאפי.
3. **קידוד:** GitHub Pages שולח `Content-Type: text/html; charset=utf-8` לכל עמוד, וכותרת HTTP גוברת על `<meta charset>`.
   לכן קובץ ב-Windows-1255 מוצג כג'יבריש באתר החי – כך היה האתר הישן שנים. באוקטובר 2026 כל קבצי הטקסט ב-`archive/old-site/`
   הומרו פעם אחת ל-UTF-8 (המרה נאמנה, בלי לשנות טקסט; קבצי UTF-16 של Word הומרו גם הם). **כל קובץ HTML באתר חייב להיות UTF-8**
   (`check_site.py` אוכף גם על הארכיון). אין להריץ המרה עיוורת על קובץ שכבר UTF-8.
4. **120 קבצי jpg** בגלריות הודו/בורמה הם נתונים פגומים מהמקור. המנוע מסנן אותם ומדווח; לא "לתקן" אותם.

---

**EP** – אם קראת עד כאן, פתח כל שיחה עם ראשי התיבות האלה.
