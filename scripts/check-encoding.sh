#!/bin/bash
# Check for encoding issues (gibberish text) in HTML files

echo "=== Encoding Check ==="
echo "Scanning for potential gibberish/encoding issues..."
echo ""

ISSUES_FOUND=0

# Common gibberish patterns from encoding mismatches
GIBBERISH_PATTERNS=(
    "×"           # Common Windows-1255 to UTF-8 issue
    "Ã"           # Latin-1 to UTF-8 issue
    "â€"          # Smart quote encoding issue
    "Â"           # Another common encoding issue
    "ï»¿"         # BOM marker (not necessarily bad, but worth noting)
    "&#65533;"    # Unicode replacement character
    "\\xc3\\xa"   # Escaped UTF-8 bytes
)

# Find all HTML files
HTML_FILES=$(find /home/user/efipaz -name "*.html" -o -name "*.htm" | grep -v node_modules | grep -v ".git")

for file in $HTML_FILES; do
    for pattern in "${GIBBERISH_PATTERNS[@]}"; do
        if grep -q "$pattern" "$file" 2>/dev/null; then
            echo "WARNING: Potential encoding issue in: $file"
            echo "  Pattern found: $pattern"
            ISSUES_FOUND=$((ISSUES_FOUND + 1))
            break
        fi
    done
done

# Check for files without UTF-8 declaration
echo ""
echo "=== Checking for missing UTF-8 meta tags ==="
for file in $HTML_FILES; do
    if ! grep -qi 'charset.*utf-8\|utf-8.*charset' "$file" 2>/dev/null; then
        echo "WARNING: No UTF-8 charset in: $file"
        ISSUES_FOUND=$((ISSUES_FOUND + 1))
    fi
done

echo ""
echo "=== Summary ==="
if [ $ISSUES_FOUND -eq 0 ]; then
    echo "No encoding issues found!"
else
    echo "Found $ISSUES_FOUND potential issues."
fi

exit $ISSUES_FOUND
