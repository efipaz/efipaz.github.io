# דוח ביקורת עמודים פנימיים - efipaz.com
**תאריך:** ינואר 2026

---

## סיכום מנהלים

**בעיה קריטית:** מהעמודים הראשיים המודרניים יש קישורים רבים לעמודים פנימיים עם עיצוב ישן וגרוע.
המשתמש שמגיע מדף הבית המודרני ולוחץ על לינק - מגיע לעמוד שנראה כמו משנות ה-2000.

### סטטיסטיקה

| סוג | מספר קבצים |
|-----|------------|
| עמודים מודרניים (HTML5 + style.css) | ~35 |
| **עמודים ישנים הדורשים חידוש** | **~65** |
| קבצים פגומים/בעיות קידוד | 3 |

---

## 🔴 עדיפות קריטית - עמודים מקושרים מהעמודים הראשיים

אלה העמודים שמשתמש **יראה בוודאות** כשגולש באתר:

### 1. teachers/krishnamurti/km_index.html
**מקושר מ:** `spiritual.html` (כפתור "לתכנים")

**בעיות:**
- HTML 4.01 Transitional
- **בעיית קידוד חמורה** - עברית מופיעה כג'יבריש: `÷øéùðîåøèé` במקום `קרישנמורטי`
- תגיות deprecated: `<big>`, `<font>`, `bgcolor`, `background`
- CSS inline בכל אלמנט
- Layout מבוסס טבלאות
- מקשר לעמודי `.htm` ישנים (1.htm, 2.htm, 3.htm, 4.htm)

---

### 2. teachers/demello/demello.html
**מקושר מ:** `spiritual.html` (כפתור "לתכנים")

**בעיות:**
- HTML 4.0 Transitional
- נוצר ע"י CoffeeCup HTML Editor 2006
- תגיות deprecated: `<font>`, `bgcolor`, `background`
- Absolute positioning בכל מקום
- קוד כפול בקובץ
- מקשר לקבצים בעייתיים: `ShortWisdomStories.htm` (306KB!)

---

### 3. teachers/watts/index.html
**מקושר מ:** `spiritual.html` (כפתור "לתכנים")

**בעיות קריטיות:**
- **קובץ פגום!** - קידוד UTF-16 עם null bytes
- נוצר ע"י Microsoft Word
- לא ניתן לקריאה בדפדפן רגיל
- דורש שחזור/כתיבה מחדש מלאה

---

### 4. living/About.html
**מקושר מ:** `living.html` (קישור "אודות הקורס")

**בעיות:**
- HTML 4.0 Transitional
- נוצר ע"י Web Page Maker V2
- CSS classes ישנים (.ws6, .ws7, etc.)
- JavaScript ישן (language="JavaScript1.4")
- רוחב קבוע 310px

---

### 5. living/Workshop.html
**מקושר מ:** `living.html` (קישור "סדנאות")

**בעיות:** זהות ל-living/About.html

---

### 6. business/index.html
**מקושר מ:** `archive.html`, `business.html`

**בעיות:**
- HTML 4.0 Transitional
- Web Page Maker V2
- רוחב קבוע 802px
- לא רספונסיבי כלל

---

### 7. business/About.html, services.html, contact.html, projects.html, customers.html
**מקושרים מ:** `archive.html`, `business.html`

**בעיות:** זהות ל-business/index.html

---

### 8. personal/ethics/index.html ושאר קבצי ethics/
**מקושרים מ:** `archive.html`

**בעיות:**
- HTML 4.0 Transitional
- Web Page Maker V2
- עיצוב ישן

---

### 9. personal/drawings/huxley.htm
**מקושר מ:** `personal.html` (שורה 66)

**בעיות:**
- קובץ .htm (לא .html)
- נוצר ע"י Adobe PageMill 3.0
- תגיות deprecated: `<font>`, `<basefont>`, `<center>`
- Layout מבוסס טבלאות
- bgcolor ו-link/vlink/alink attributes

---

### 10. personal/drawings/Danielle/Danielle_index.html
**מקושר מ:** `personal.html`

**בעיות:** Web Page Maker V2, עיצוב ישן

---

### 11. personal/evyatar/Evyatar_index.html
**מקושר מ:** `personal.html`

**בעיות:** Web Page Maker V2, עיצוב ישן

---

## 🟠 עדיפות גבוהה - תיקיות שלמות לחידוש

### תיקיית business/ (9 קבצים)
```
business/
├── index.html      ❌ ישן
├── About.html      ❌ ישן
├── Evyatar.html    ❌ ישן
├── contact.html    ❌ ישן
├── contact1.html   ❌ ישן
├── customers.html  ❌ ישן
├── links.html      ❌ ישן
├── projects.html   ❌ ישן
└── services.html   ❌ ישן
```

### תיקיית living/ (~25 קבצים)
```
living/
├── index.html              ❌ ישן
├── About.html              ❌ ישן
├── About_just Efi.html     ❌ ישן
├── Workshop.html           ❌ ישן
├── Personal_Training.html  ❌ ישן
├── contact.html            ❌ ישן
├── links.html              ❌ ישן
├── Affluenza/              ❌ כל התיקייה
│   ├── Affluenza.html
│   ├── Aff_inherit.html
│   ├── Aff_makers.html
│   ├── Aff_sudden.html
│   ├── Aff_sympthoms.html
│   └── Children.html
└── Process/                ❌ כל התיקייה
    ├── Process.html
    ├── 1 Innocence.html
    ├── 2 Pain & Suffering.html
    ├── 3 Knowledge.html
    ├── 4 Lib.html
    ├── 5 Goals.html
    ├── 6 Management.html
    └── 7 Worlds.html
```

### תיקיית personal/ (~14 קבצים)
```
personal/
├── drawings/
│   ├── Danielle/
│   │   └── Danielle_index.html  ❌ ישן
│   ├── huxley.htm               ❌ ישן + פורמט .htm
│   ├── rampole.htm              ❌ ישן + פורמט .htm
│   ├── watts-pic.htm            ❌ ישן + פורמט .htm
│   └── parker.html              ❌ ישן
├── ethics/                      ❌ כל התיקייה ישנה
│   ├── index.html
│   ├── About.html
│   ├── Coach.html
│   ├── Kezad.html
│   ├── Madua.html
│   ├── Org.html
│   ├── hazman.html
│   ├── links.html
│   ├── contact.html
│   └── services.html
└── evyatar/
    ├── Evyatar_index.html       ❌ ישן
    └── Evyatar_index1.html      ❌ ישן
```

### תיקיית teachers/ (קריטי!)
```
teachers/
├── krishnamurti/
│   ├── km_index.html    ❌ ישן + בעיות קידוד
│   ├── 1.htm            ❌ MS Word export
│   ├── 2.htm            ❌ MS Word export
│   ├── 3.htm            ❌ MS Word export
│   └── 4.htm            ❌ MS Word export
├── demello/
│   ├── demello.html         ❌ ישן
│   ├── demelloAboutHeb.html ❌ ישן
│   ├── DeMelloEn1.html      ❌ ישן
│   ├── demello_video.html   ❌ ישן
│   └── ShortWisdomStories.htm ❌ 306KB!
└── watts/
    └── index.html       ❌ פגום - UTF-16
```

---

## 🟢 עמודים מודרניים (תקינים)

### שורש האתר
- ✅ index.html
- ✅ spiritual.html
- ✅ travel.html
- ✅ living.html
- ✅ personal.html
- ✅ archive.html
- ✅ ethics.html
- ✅ business.html

### גרסה אנגלית (en/)
- ✅ en/index.html
- ✅ en/spiritual.html
- ✅ en/travel.html
- ✅ en/personal.html
- ✅ en/living.html

### גלריות תמונות (travel/)
- ✅ travel/india/index.html + כל קבצי הקטגוריות
- ✅ travel/myanmar/index.html + כל קבצי הקטגוריות

---

## רשימת קישורים בעייתיים מעמודים ראשיים

| עמוד מקור | קישור בעייתי | סוג הבעיה |
|-----------|--------------|-----------|
| spiritual.html:61 | teachers/krishnamurti/km_index.html | עיצוב ישן, קידוד |
| spiritual.html:99 | teachers/watts/index.html | קובץ פגום |
| spiritual.html:151 | teachers/demello/demello.html | עיצוב ישן |
| living.html:101 | living/About.html | עיצוב ישן |
| living.html:108 | living/Workshop.html | עיצוב ישן |
| archive.html:58 | business/About.html | עיצוב ישן |
| archive.html:59 | business/contact.html | עיצוב ישן |
| archive.html:70 | business/index.html | עיצוב ישן |
| archive.html:77 | business/services.html | עיצוב ישן |
| archive.html:84 | business/projects.html | עיצוב ישן |
| archive.html:101 | personal/ethics/index.html | עיצוב ישן |
| archive.html:108 | personal/ethics/Coach.html | עיצוב ישן |
| archive.html:115 | personal/ethics/Org.html | עיצוב ישן |
| personal.html:54 | personal/drawings/Danielle/Danielle_index.html | עיצוב ישן |
| personal.html:60 | personal/drawings/parker.html | עיצוב ישן |
| personal.html:66 | personal/drawings/huxley.htm | עיצוב ישן, פורמט .htm |
| personal.html:82 | personal/evyatar/Evyatar_index.html | עיצוב ישן |
| en/living.html:105 | ../living/About.html | עיצוב ישן |
| en/living.html:112 | ../living/Workshop.html | עיצוב ישן |

---

## המלצות לפעולה

### שלב 1 - תיקונים דחופים (קריטי)
1. **תקן או צור מחדש** `teachers/watts/index.html` - הקובץ פגום לחלוטין
2. **תקן קידוד** ב-`teachers/krishnamurti/km_index.html`
3. **חדש** את 3 עמודי המורים הראשיים (km_index, demello, watts/index)

### שלב 2 - חידוש עמודים מקושרים
4. חדש את `living/About.html` ו-`living/Workshop.html`
5. חדש את עמודי business/ הראשיים
6. חדש את personal/ethics/ ו-personal/drawings/

### שלב 3 - ניקוי
7. המר קבצי .htm ל-.html או מחק אם לא נחוצים
8. הסר קבצים כפולים (Copy of index.html, index2.html וכו')
9. עדכן קישורים בעמודים הראשיים לאחר החידוש

### שלב 4 - אופציונלי
10. שקול למזג תוכן מעמודים ישנים לעמודים הראשיים במקום לחדש הכל

---

## הערות טכניות

### תבנית לעמוד מודרני:
```html
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>כותרת | אפי פז</title>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../style.css"> <!-- התאם לפי עומק התיקייה -->
</head>
<body>
  <!-- תוכן עם CSS classes מ-style.css -->
</body>
</html>
```

### כלים קיימים לבדיקה:
- `scripts/check-encoding.sh` - בדיקת קידוד
- `scripts/check-links.sh` - בדיקת קישורים שבורים
- `scripts/validate-all.sh` - כל הבדיקות

---

**נוצר ע"י Claude | ינואר 2026**
