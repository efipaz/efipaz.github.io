#!/bin/bash
# cleanup-dead-code.sh - מנקה קוד מת מהפרויקט
# Efi Paz - efipaz.com
#
# שימוש: bash scripts/cleanup-dead-code.sh [--dry-run]
#
# הסקריפט מזהה ומוחק:
# - קבצי PHP שאינם בשימוש
# - ספריות EXIF ישנות
# - קבצי CSS ישנים בתיקיות travel
# - קבצי Flash (SWF)
#
# תוכן בעל ערך (קורסים, ציטוטים) נשמר!

set -e

DRY_RUN=false
if [[ "$1" == "--dry-run" ]]; then
    DRY_RUN=true
    echo "=== מצב DRY RUN - לא מוחק באמת ==="
fi

echo "=== סריקת קוד מת ==="
echo ""

# קבצי PHP בתיקיות travel
PHP_FILES=$(find travel -name "*.php" 2>/dev/null | wc -l)
if [[ $PHP_FILES -gt 0 ]]; then
    echo "נמצאו $PHP_FILES קבצי PHP בתיקיות travel:"
    find travel -name "*.php" 2>/dev/null | head -10
    if [[ "$DRY_RUN" == "false" ]]; then
        find travel -name "*.php" -delete
        echo "✓ נמחקו"
    fi
fi

# ספריות EXIF
EXIF_DIRS=$(find travel -type d -name "EXIF" 2>/dev/null | wc -l)
if [[ $EXIF_DIRS -gt 0 ]]; then
    echo ""
    echo "נמצאו $EXIF_DIRS תיקיות EXIF:"
    find travel -type d -name "EXIF" 2>/dev/null
    if [[ "$DRY_RUN" == "false" ]]; then
        find travel -type d -name "EXIF" -exec rm -rf {} + 2>/dev/null || true
        echo "✓ נמחקו"
    fi
fi

# קבצי CSS ישנים בתיקיות travel
OLD_CSS=$(find travel -name "index.css" 2>/dev/null | wc -l)
if [[ $OLD_CSS -gt 0 ]]; then
    echo ""
    echo "נמצאו $OLD_CSS קבצי CSS ישנים:"
    find travel -name "index.css" 2>/dev/null
    if [[ "$DRY_RUN" == "false" ]]; then
        find travel -name "index.css" -delete
        echo "✓ נמחקו"
    fi
fi

# קבצי Flash
SWF_FILES=$(find . -name "*.swf" 2>/dev/null | wc -l)
if [[ $SWF_FILES -gt 0 ]]; then
    echo ""
    echo "נמצאו $SWF_FILES קבצי Flash:"
    find . -name "*.swf" 2>/dev/null
    if [[ "$DRY_RUN" == "false" ]]; then
        find . -name "*.swf" -delete
        echo "✓ נמחקו"
    fi
fi

# תיקיות gEditorHTML (עורך גלריה ישן)
GEDITOR=$(find . -type d -name "gEditorHTML" 2>/dev/null | wc -l)
if [[ $GEDITOR -gt 0 ]]; then
    echo ""
    echo "נמצאו $GEDITOR תיקיות gEditorHTML:"
    find . -type d -name "gEditorHTML" 2>/dev/null
    if [[ "$DRY_RUN" == "false" ]]; then
        find . -type d -name "gEditorHTML" -exec rm -rf {} + 2>/dev/null || true
        echo "✓ נמחקו"
    fi
fi

# קבצים טכניים בארכיון (לא התוכן!)
ARCHIVE_TECH=""
if [[ -d "archive/misc/wordpress-he" ]]; then
    ARCHIVE_TECH="$ARCHIVE_TECH archive/misc/wordpress-he"
fi
if [[ -d "archive/misc/webalizer" ]]; then
    ARCHIVE_TECH="$ARCHIVE_TECH archive/misc/webalizer"
fi
if [[ -d "archive/misc/elegant" ]]; then
    ARCHIVE_TECH="$ARCHIVE_TECH archive/misc/elegant"
fi
if [[ -d "archive/legacy" ]]; then
    ARCHIVE_TECH="$ARCHIVE_TECH archive/legacy"
fi

if [[ -n "$ARCHIVE_TECH" ]]; then
    echo ""
    echo "נמצאו קבצים טכניים בארכיון:"
    echo "$ARCHIVE_TECH"
    if [[ "$DRY_RUN" == "false" ]]; then
        for dir in $ARCHIVE_TECH; do
            rm -rf "$dir"
        done
        echo "✓ נמחקו"
    fi
fi

echo ""
echo "=== סיום ==="

if [[ "$DRY_RUN" == "true" ]]; then
    echo "זה היה dry run - הרץ בלי --dry-run כדי למחוק באמת"
else
    echo "הניקוי הושלם!"
fi
