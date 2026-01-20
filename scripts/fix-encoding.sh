#!/bin/bash
# Fix encoding issues in old HTML files

REPO="/home/user/efipaz"
FIXED=0
FAILED=0

echo "Fixing encoding issues in HTML files..."

# Find all HTML files that might have encoding issues
for file in $(find "$REPO" -type f \( -name "*.html" -o -name "*.htm" \) ! -path "*/.git/*" ! -path "*/scripts/*"); do
    # Check if file exists and is readable
    [ ! -f "$file" ] && continue

    # Detect encoding
    encoding=$(file -bi "$file" | grep -oP 'charset=\K[^;]+' 2>/dev/null)

    # Check if file has windows-1255 or iso-8859 charset declaration
    if grep -qi "charset=windows-1255\|charset=iso-8859" "$file" 2>/dev/null; then
        echo "Converting: $file"

        # Try to convert from windows-1255
        if iconv -f windows-1255 -t utf-8 "$file" > "${file}.tmp" 2>/dev/null; then
            # Update charset declaration
            sed -i 's/charset=windows-1255/charset=UTF-8/gi' "${file}.tmp"
            sed -i 's/charset=iso-8859-[0-9]*/charset=UTF-8/gi' "${file}.tmp"
            mv "${file}.tmp" "$file"
            FIXED=$((FIXED + 1))
            echo "  -> Fixed!"
        else
            rm -f "${file}.tmp"
            FAILED=$((FAILED + 1))
            echo "  -> Failed to convert"
        fi
    # Also check files without charset that might need UTF-8 declaration
    elif ! grep -qi "charset=UTF-8\|charset=\"UTF-8\"" "$file" 2>/dev/null; then
        # Add UTF-8 charset if missing and file contains Hebrew
        if file "$file" | grep -qi "ISO-8859\|Non-ISO extended-ASCII"; then
            echo "Adding UTF-8 to: $file"
            if iconv -f windows-1255 -t utf-8 "$file" > "${file}.tmp" 2>/dev/null; then
                # Add meta charset if head exists
                if grep -qi "<head" "${file}.tmp"; then
                    sed -i 's/<head>/<head>\n<meta charset="UTF-8">/i' "${file}.tmp"
                    sed -i 's/<head [^>]*>/<head>\n<meta charset="UTF-8">/i' "${file}.tmp"
                fi
                mv "${file}.tmp" "$file"
                FIXED=$((FIXED + 1))
            else
                rm -f "${file}.tmp"
            fi
        fi
    fi
done

echo ""
echo "Done! Fixed: $FIXED files, Failed: $FAILED files"
