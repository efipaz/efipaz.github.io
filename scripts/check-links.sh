#!/bin/bash
# Check for broken internal links in HTML files

echo "=== Broken Links Check ==="
echo "Scanning for broken internal links..."
echo ""

BROKEN_LINKS=0
BASE_DIR="/home/user/efipaz"

# Find all HTML files
HTML_FILES=$(find "$BASE_DIR" -name "*.html" -o -name "*.htm" | grep -v node_modules | grep -v ".git")

for file in $HTML_FILES; do
    FILE_DIR=$(dirname "$file")

    # Extract href and src attributes
    LINKS=$(grep -oE '(href|src)="[^"#]*"' "$file" 2>/dev/null | sed 's/.*="\([^"]*\)"/\1/' | grep -v "^http" | grep -v "^mailto" | grep -v "^javascript" | grep -v "^#" | grep -v "^$")

    for link in $LINKS; do
        # Skip external links and anchors
        if [[ "$link" == http* ]] || [[ "$link" == "//" ]] || [[ "$link" == "#"* ]]; then
            continue
        fi

        # Resolve relative path
        if [[ "$link" == /* ]]; then
            TARGET="$BASE_DIR$link"
        elif [[ "$link" == ../* ]]; then
            TARGET=$(cd "$FILE_DIR" && realpath -m "$link" 2>/dev/null)
        else
            TARGET="$FILE_DIR/$link"
        fi

        # Remove query strings and anchors for file check
        TARGET_CLEAN=$(echo "$TARGET" | sed 's/[?#].*//')

        # Check if file exists
        if [ ! -e "$TARGET_CLEAN" ]; then
            echo "BROKEN: $file"
            echo "  -> $link (target: $TARGET_CLEAN)"
            BROKEN_LINKS=$((BROKEN_LINKS + 1))
        fi
    done
done

echo ""
echo "=== Summary ==="
if [ $BROKEN_LINKS -eq 0 ]; then
    echo "No broken links found!"
else
    echo "Found $BROKEN_LINKS broken links."
fi

exit $BROKEN_LINKS
