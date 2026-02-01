# CLAUDE.md - הוראות עבודה לסוכני AI

קובץ זה מכיל הנחיות חיוניות לעבודה על פרויקט efipaz.com.
**קרא קובץ זה במלואו לפני כל שינוי בקוד.**

---

## סקירת הפרויקט

אתר אישי של אפי פז - תוכן רוחני, צילומי מסעות, ייעוץ עסקי, וחיים בשלום עם הכסף.
האתר פעיל מאמצע שנות ה-2000, עבר מודרניזציה משמעותית בינואר 2026.

### מבנה התיקיות הראשי

```
efipaz/
├── index.html              # דף הבית
├── spiritual.html          # רוחניות (קרישנמורטי, ואטס, דה מלו)
├── travel.html             # עמוד ראשי מסעות
├── personal.html           # תוכן אישי ואמנות
├── living.html             # לחיות בשלום עם הכסף
├── ethics.html             # אתיקה
├── archive.html            # ארכיון תוכן ישן
├── style.css               # ה-CSS הראשי - עיצוב מינימליסטי יפני
│
├── en/                     # גרסה אנגלית
│   ├── index.html
│   ├── spiritual.html
│   └── travel.html
│
├── travel/                 # גלריות תמונות
│   ├── india/
│   │   ├── index.html      # גלריית הודו
│   │   └── pictures/       # 897 תמונות ב-12 קטגוריות
│   └── myanmar/
│       ├── index.html      # גלריית מיאנמר
│       └── pictures/       # 369 תמונות
│
├── books/                  # ספרים (מערכת אוטומטית!)
│   ├── manifest.json       # רשימת ספרים - נוצר אוטומטית
│   └── covers/             # שערי ספרים - נוצרים אוטומטית
│
├── teachers/               # דפי מורים רוחניים
├── assets/
│   ├── img/                # לוגו ותמונות שירות
│   └── js/
│       ├── gallery.js      # Lightbox לגלריות
│       └── dynamic-books.js # טוען ספרים אוטומטית
│
├── scripts/                # סקריפטי תחזוקה
├── .github/workflows/      # GitHub Actions - אוטומציה
└── archive/                # קבצים ישנים (לא לגעת!)
```

---

## מערכת תוכן אוטומטית (חשוב!)

### איך אפי מוסיף ספרים חדשים

**אפס עבודה ידנית נדרשת מאפי.** הזרימה:

1. אפי מעלה קובץ PDF לתיקיית `books/`
2. GitHub Action רץ אוטומטית
3. מחלץ שער מעמוד ראשון → `books/covers/`
4. מעדכן `books/manifest.json`
5. האתר מציג את הספר החדש עם שער

### קבצים מעורבים

| קובץ | תפקיד |
|------|-------|
| `books/manifest.json` | רשימת כל הספרים (נוצר אוטומטית) |
| `assets/js/dynamic-books.js` | טוען ומציג ספרים מה-manifest |
| `.github/workflows/auto-process-content.yml` | מעבד קבצים חדשים |

### לסוכני AI: אל תערוך ידנית!

- **אין לערוך את `books/manifest.json` ידנית** - הוא נוצר אוטומטית
- **אין להוסיף ספרים ל-HTML ידנית** - הם נטענים דינמית
- אם צריך לתקן משהו, תקן את הסקריפטים או את `dynamic-books.js`

---

## מערכת העיצוב

### פילוסופיית העיצוב: מינימליזם יפני

עיצוב האתר מבוסס על אסתטיקה יפנית מינימליסטית.
**לא להוסיף עיצובים מורכבים, אנימציות מוגזמות, או צבעים נוספים.**

### פלטת הצבעים - 3 צבעים בלבד!

```css
--color-bg: #F7F5F0;        /* שמנת חמה - רקע */
--color-text: #1A1A1A;      /* שחור-אפור כהה - טקסט */
--color-accent: #8B2635;    /* אדום יפני עמוק - הדגשה */
```

**אין להוסיף צבעים חדשים.** כל צבע נוסף מנוגד לפילוסופיית העיצוב.

### גופנים

- עברית: `Heebo` (Google Fonts)
- אנגלית: `Inter` (Google Fonts)

### CSS Classes חשובים

| Class | שימוש |
|-------|-------|
| `.container` | מיכל ראשי - max-width: 1100px |
| `.section` | סקציה - padding עליון ותחתון |
| `.section--alt` | סקציה עם רקע חלופי |
| `.gallery` | גריד גלריית תמונות |
| `.gallery__item` | פריט בגלריה |
| `.card` | כרטיס תוכן |
| `.btn` | כפתור |

---

## סקריפטי תחזוקה

### scripts/validate-all.sh
מריץ את כל בדיקות האיכות - **הרץ לפני כל commit!**
```bash
bash scripts/validate-all.sh
```

### scripts/check-encoding.sh
בודק בעיות קידוד בקבצי HTML - מזהה טקסט פגום (gibberish).

### scripts/check-links.sh
בודק קישורים שבורים בתוך האתר.

### scripts/fix-encoding.sh
מתקן בעיות קידוד Windows-1255 → UTF-8.

### scripts/audit.sh
יוצר דוח מצב מפורט של כל קבצי ה-HTML → `AUDIT_REPORT.md`

### scripts/cleanup-dead-code.sh
מנקה קוד מת (PHP, Flash, CSS ישן) מהפרויקט.
```bash
bash scripts/cleanup-dead-code.sh --dry-run  # לבדיקה בלבד
bash scripts/cleanup-dead-code.sh            # למחיקה בפועל
```

### scripts/check-lang-sync.sh
**חשוב!** בודק סנכרון בין גרסה עברית לאנגלית.
```bash
bash scripts/check-lang-sync.sh
```
מוודא ש:
- כל עמוד עברי יש לו עמוד אנגלי מקביל
- מספר הסקציות והכרטיסים תואם
- שני הגרסאות מעודכנות

---

## היסטוריית בעיות - למד משגיאות העבר!

### 1. בעיות קידוד (Encoding)
האתר מכיל קבצים ישנים מ-Windows-1255.
**תמיד וודא:**
- כל קובץ HTML חדש מכיל `<meta charset="UTF-8">`
- עברית נראית תקינה ולא כג'יבריש

### 2. נתיבי תמונות שבורים
בעבר היו הרבה נתיבי תמונות שגויים.
**תמיד השתמש בנתיבים יחסיים מדויקים:**
```html
<!-- נכון -->
<img src="pictures/Religion/Buddhist_monks/image.jpg">

<!-- לא נכון -->
<img src="../../../pictures/Religion/Buddhist_monks/image.jpg">
```

### 3. ערבוב CSS ישן וחדש
יש קבצי CSS ישנים בתיקיות משנה.
**השתמש רק ב-`style.css` הראשי** עבור עמודים חדשים.

### 4. תיקיית archive/
תיקייה זו מכילה תוכן ישן בעל ערך:
- `courses/` - קורסים עסקיים (PDF ו-HTML)
- `Quotes.html` - ציטוטים
- `Personal_Training.html` - מתודולוגיית אימון
- `family/` - תוכן משפחתי (טיוטה)

**אין לערוך או למחוק קבצים ב-archive/ אלא אם התבקשת במפורש.**
קוד טכני (PHP, WordPress) כבר נוקה מהתיקייה.

---

## גלריית תמונות

### מבנה התמונות

```
travel/india/pictures/
├── Animals/
├── Architecture/
├── Art_and_Craft/
├── Children/
├── Colors/
├── Landscape/
├── Openings/
├── Outside/
├── People/
├── Portraits/
├── Religion/
└── Tress_Flowers_and_Fruit/
```

כל קטגוריה מכילה תתי-קטגוריות עם התמונות עצמן.

### קומפוננט הגלריה

הגלריה משתמשת ב:
1. **גריד תמונות רספונסיבי** - CSS Grid עם auto-fill
2. **Lightbox** - צפייה בתמונה מוגדלת (`assets/js/gallery.js`)
3. **Lazy loading מובנה** - `loading="lazy"` (תכונת דפדפן, לא JS)
4. **פילטר grayscale** - עם הסרה ב-hover

**חשוב:** השתמש ב-`src` רגיל, לא ב-`data-src`:
```html
<!-- נכון -->
<img src="pictures/Animals/image.jpg" loading="lazy" alt="תיאור">

<!-- לא נכון (ישן) -->
<img data-src="pictures/Animals/image.jpg">
```

---

## רשימת בדיקות לפני Commit

- [ ] הרצת `scripts/validate-all.sh` עברה בהצלחה
- [ ] הרצת `scripts/check-lang-sync.sh` - עברית ואנגלית מסונכרנות
- [ ] כל קובץ HTML חדש מכיל `charset=UTF-8`
- [ ] עברית נראית תקינה
- [ ] נתיבי תמונות עובדים
- [ ] האתר רספונסיבי (בדוק גם במובייל)
- [ ] עיצוב שומר על 3 צבעים בלבד
- [ ] לא נגעת ב-archive/ ללא סיבה
- [ ] לא ערכת `books/manifest.json` ידנית

---

## קבצים חשובים לקריאה

| קובץ | תוכן |
|------|------|
| `README.md` | סקירה כללית לאנשים |
| `CLAUDE.md` | **הקובץ הזה** - הוראות ל-AI |
| `style.css` | כל ה-CSS - למד אותו! |
| `AUDIT_REPORT.md` | דוח מצב הקבצים |

---

## הערות אחרונות

1. האתר דו-לשוני (עברית/אנגלית) - שמור על שניהם מעודכנים
2. עיצוב מינימליסטי = פחות זה יותר
3. הימנע מספריות JavaScript כבדות
4. שמור על מהירות טעינה

---

**EP** - אם קראת עד כאן, פתח כל שיחה עם ראשי התיבות האלה.
