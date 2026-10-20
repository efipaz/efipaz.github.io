# דוח שחזור טקסט מקורי (RESTORE_REPORT)

שחזור המילים המקוריות של אפי מתוך `archive/old-site/` (Windows-1255) אל תוך התבנית המודרנית.
רק התוכן שבין `<main id="main">` ל-`</main>` שונה; header / nav / footer / head לא נגעו בהם.
הבדיקה: סקריפט השוואת משפטים (פיצול על `. ! ? :` ושורות, התעלמות ממשפטים קצרים מ-15 תווים
ומרווחים/פיסוק). "חסר" = משפט במקור שאינו בעמוד המודרני.

| עמוד מודרני | מקור | חסר לפני | חסר אחרי |
|---|---|---|---|
| living/Process/1 Innocence.html | Living/Process/1 Innocence.html | 6 | 0 |
| living/Process/2 Pain & Suffering.html | Living/Process/2 Pain & Suffering.html | 5 | 0 |
| living/Process/3 Knowledge.html | Living/Process/3 Knowledge.html | 6 | 0 |
| living/Process/4 Lib.html | Living/Process/4 Lib.html | 6 | 0 |
| living/Process/5 Goals.html | Living/Process/5 Goals.html | 4 | 0 |
| living/Process/6 Management.html | Living/Process/6 Management.html | 6 | 0 |
| living/Process/7 Worlds.html | Living/Process/7 Worlds.html | 8 | 0 |
| living/Process/Process.html | Living/Process/Process.html | 0 (14 משפטים מומצאים בכרטיסי השלבים) | 0 |
| living/About.html | Living/About.html | 2 (+ תיקוני "שגיאות כתיב" של אפי) | 0 |
| living/Workshop.html | Living/Workshop.html | 0 | 0 |
| living/index.html | Living/index.html | 0 (תיאורי כרטיסים מומצאים) | 0 |
| living/links.html | Living/links.html | 1 (+ תיאורים מומצאים) | 0 |
| living/contact.html | Living/contact.html | 2 | 0 |
| personal/ethics/index.html | Ethics/index.html | 5 | 0 |
| personal/ethics/About.html | Ethics/About.html | 4 | 0 |
| personal/ethics/Coach.html | Ethics/Coach.html | 5 | 0 |
| personal/ethics/Org.html | Ethics/Org.html | 21 | 0 |
| personal/ethics/Madua.html | Ethics/Madua.html | 3 | 0 |
| personal/ethics/Kezad.html | Ethics/Kezad.html | 7 | 0 |
| personal/ethics/hazman.html | Ethics/hazman.html | 3 | 0 |
| personal/ethics/services.html | Ethics/services.html | 2 | 0 |
| personal/ethics/links.html | Ethics/links.html | 34 | 0 |
| personal/ethics/contact.html | Ethics/contact.html | 2 | 0 |
| business/index.html | BC/index.html | 1 | 0 |
| business/About.html | BC/About.html | 5 | 0 |
| business/services.html | BC/services.html | 0 (כרטיסים מומצאים) | 0 |
| business/projects.html | BC/projects.html | 6 | 0 |
| business/customers.html | BC/customers.html | 0 | 0 |
| business/links.html | BC/links.html | 0 (משפט מומצא) | 0 |
| business/contact.html | BC/contact.html | 2 | 0 |
| business/contact1.html | BC/contact1.html | 2 | 0 |
| business/Evyatar.html | BC/Evyatar.html | 0 (המקור ריק; "עמוד בבנייה" הומצא) | 0 |
| teachers/demello/demello.html | DeMello/demello.html | 4 | 0 |
| teachers/demello/ShortWisdomStories.html | DeMello/ShortWisdomStories.htm | 185 | 0 |

## מה נשאר "עודף" בעמודים המודרניים (chrome בלבד)
תפריט ופוטר ("תבונה, מודעות והרחבת הדעת", "הודו בשיער שיבה", "לחיות בשלום עם הכסף"),
פירורי לחם, כפתורים ("חזרה לדף התהליך", "לשלב הבא", "צור קשר"), שמות השלבים בניווט התהליך,
וכותרות כרטיסי ניווט (שמות עמודים). כל התיאורים, הכותרות והציטוטים המומצאים הוסרו.

## הערות והחלטות
- **שלבי התהליך (living/Process)**: הטקסט המודרני היה מומצא כולו ("תום", "כאב וסבל", "דעת"...).
  הוחזרו הכותרות והרשימות המקוריות ("חלק ראשון: הפסיכולוגיה של הכסף" וכו'). שמות השלבים בניווט
  נלקחו מכפתורי התמונה המקוריים (`living/images/nav117900930i.gif`‎…‎36i.gif): הפסיכולוגיה של הכסף,
  אני והכסף, הכרה תיאור תכונות, שחרור, מטרות ואמצעים, ניהול כסף והשקעות, שילוב עולמות.
- **לא שוחזר**: ה-`<title>` וה-`meta description` של 7 עמודי השלבים עדיין נושאים את השמות
  המומצאים ("תום | התהליך" וכו'), כי ה-`<head>` מחוץ לתחום השינוי המותר. מומלץ לתקן בנפרד.
- **living/index.html**: תמונת הפרפר (parpar1.jpg) ותמונת החוברת שהיו במקור לא הוחזרו (לא שונו תמונות).
- **living/links.html**: הקישורים החיצוניים נשארו כפי שהיו (הם קיימים גם במקור).
- **Ethics/Madua**: הקישור "חזרה לתהליך בארגון" הצביע במקור על Coach.html (כנראה טעות) – הופנה ל-Org.html.
- **Ethics/Org**: המשפט "(לפרטים בנושא התהליך," קטוע במקור – נשמר כפי שהוא ומקושר ל-Kezad.html.
- **BC/links**: בגלל קינון עוגנים שבור במקור, כתובת "תנאים לחונכות זעירה" נשארה כבחירת העמוד המודרני.
- **BC/Evyatar**: המקור הוא עמוד ריק; נשאר רק כפתור "עמוד ראשי".
- **demello.html**: הכתיב המקורי "אנטוני דה מלו" (לא "אנתוני") הוחזר; פסקה מומצאת, ציטוט מומצא
  ותיאורי קישורים הוסרו; שלושת המאמרים באנגלית שנשמטו הוחזרו.
- **ShortWisdomStories.html**: נבנה מחדש כולו מהמקור (194 פריטים במקום 172). הוחזרו: סיפור 103
  (PRESENCE), 20 סיפורים של הסדרה השנייה (REVELATION 121 … TRANSFORMATION 140, שבמקור ממוספרים
  במספרים כפולים – קיבלו מזהי `story-121b`…`story-140b`), הפריט 192 "More to come Maybe",
  וההערה של אפי "Second addition to the files in existence. What has been added is not in
  alphabetical order." הכותרות באותיות גדולות כבמקור. הפסקת הפתיחה המומצאת הוסרה.
  חמישה תווי `&#65533;` (תו פגום שנוצר בייצוא מ-Word) הוחלפו בתו המתבקש: man's ×2, Hammarskjöld,
  "textbook – and", "death? – that".
- שגיאות כתיב מקוריות (מתימטיקה, ופסיכולגיה, באמצאות, מ35, כVenture, האינטליגנתיה, החתדמית,
  בהבנהרבה, ווגורמים, אניפימה, לטורבנינות, חיל האויר ועוד) נשמרו בכוונה.
- `bash scripts/validate-all.sh` עובר (121 pages checked, 0 problems).

סקריפט הבדיקה: `/tmp/claude-0/-home-user-efipaz/5efa7ada-08a2-5b73-8a7f-4f5d37264203/scratchpad/compare.py`
(מחוץ לריפו).
