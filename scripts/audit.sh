#!/bin/bash
# Comprehensive repository audit script

OUTPUT="/home/user/efipaz/AUDIT_REPORT.md"
REPO="/home/user/efipaz"

echo "# Repository Audit Report" > $OUTPUT
echo "" >> $OUTPUT
echo "Generated: $(date)" >> $OUTPUT
echo "" >> $OUTPUT

# Count totals
echo "## Summary" >> $OUTPUT
echo "" >> $OUTPUT
TOTAL_HTML=$(find $REPO -type f \( -name "*.html" -o -name "*.htm" \) | wc -l)
TOTAL_PHP=$(find $REPO -type f -name "*.php" | wc -l)
TOTAL_JPG=$(find $REPO -type f \( -name "*.jpg" -o -name "*.JPG" \) | wc -l)
TOTAL_CSS=$(find $REPO -type f -name "*.css" | wc -l)
TOTAL_JS=$(find $REPO -type f -name "*.js" | wc -l)

echo "| Type | Count |" >> $OUTPUT
echo "|------|-------|" >> $OUTPUT
echo "| HTML/HTM files | $TOTAL_HTML |" >> $OUTPUT
echo "| PHP files | $TOTAL_PHP |" >> $OUTPUT
echo "| JPG images | $TOTAL_JPG |" >> $OUTPUT
echo "| CSS files | $TOTAL_CSS |" >> $OUTPUT
echo "| JS files | $TOTAL_JS |" >> $OUTPUT
echo "" >> $OUTPUT

# Check function
check_file() {
    local file="$1"
    local relpath="${file#$REPO/}"
    local size=$(stat -c%s "$file" 2>/dev/null || echo "?")

    local utf8="NO"
    grep -qi "charset=UTF-8\|charset=\"UTF-8\"" "$file" 2>/dev/null && utf8="YES"

    local gibberish="OK"
    if grep -q "&#65533;\|�" "$file" 2>/dev/null; then
        gibberish="GIBBERISH"
    fi

    local design="OLD"
    if grep -qi "<frameset\|<frame " "$file" 2>/dev/null; then
        design="FRAMESET"
    elif grep -q "style\.css" "$file" 2>/dev/null && grep -q "class=\"header\"" "$file" 2>/dev/null; then
        design="NEW"
    fi

    echo "| $relpath | ${size}B | $utf8 | $gibberish | $design |"
}

# Main pages
echo "## Main Pages (New Design)" >> $OUTPUT
echo "" >> $OUTPUT
echo "| File | Size | UTF-8 | Content | Design |" >> $OUTPUT
echo "|------|------|-------|---------|--------|" >> $OUTPUT
for f in index.html spiritual.html travel.html personal.html living.html archive.html; do
    [ -f "$REPO/$f" ] && check_file "$REPO/$f" >> $OUTPUT
done
for f in en/index.html en/spiritual.html en/travel.html en/personal.html en/living.html en/archive.html; do
    [ -f "$REPO/$f" ] && check_file "$REPO/$f" >> $OUTPUT
done
echo "" >> $OUTPUT

# All directories
echo "## All HTML/HTM Files by Directory" >> $OUTPUT
echo "" >> $OUTPUT

for dir in $(find $REPO -type d ! -path "*/.git/*" ! -path "*/node_modules/*" | sort); do
    html_count=$(find "$dir" -maxdepth 1 -type f \( -name "*.html" -o -name "*.htm" \) 2>/dev/null | wc -l)
    if [ "$html_count" -gt 0 ]; then
        reldir="${dir#$REPO}"
        [ -z "$reldir" ] && reldir="/"
        echo "### $reldir ($html_count files)" >> $OUTPUT
        echo "" >> $OUTPUT
        echo "| File | Size | UTF-8 | Content | Design |" >> $OUTPUT
        echo "|------|------|-------|---------|--------|" >> $OUTPUT
        for f in $(find "$dir" -maxdepth 1 -type f \( -name "*.html" -o -name "*.htm" \) | sort); do
            check_file "$f" >> $OUTPUT
        done
        echo "" >> $OUTPUT
    fi
done

echo "Report complete." >> $OUTPUT
