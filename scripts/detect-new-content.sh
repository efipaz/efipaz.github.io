#!/bin/bash
# Auto-detect new content and generate index entries
# This script scans watch directories for new files and outputs what needs to be added

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(dirname "$SCRIPT_DIR")"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo "========================================"
echo "   Content Auto-Detection Report"
echo "========================================"
echo ""

# Track if we found anything new
FOUND_NEW=0

# ============================================
# 1. Check for new books (PDFs in books/)
# ============================================
echo -e "${BLUE}=== Checking books/ directory ===${NC}"

BOOKS_DIR="$ROOT_DIR/books"
COVERS_DIR="$BOOKS_DIR/covers"

if [ -d "$BOOKS_DIR" ]; then
    # Find PDFs without corresponding cover images
    for pdf in "$BOOKS_DIR"/*.pdf; do
        [ -f "$pdf" ] || continue

        basename=$(basename "$pdf" .pdf)
        # Check if cover exists (simplified name matching)
        cover_exists=0
        for cover in "$COVERS_DIR"/*.png "$COVERS_DIR"/*.jpg; do
            [ -f "$cover" ] || continue
            cover_exists=1
            break
        done

        # Check if PDF is referenced in spiritual.html
        encoded_name=$(python3 -c "import urllib.parse; print(urllib.parse.quote('$basename.pdf'))" 2>/dev/null || echo "")
        if ! grep -q "$encoded_name" "$ROOT_DIR/spiritual.html" 2>/dev/null; then
            echo -e "${YELLOW}NEW BOOK:${NC} $basename.pdf"
            echo "  -> Needs cover extraction and addition to spiritual.html"
            FOUND_NEW=1
        fi
    done

    # Find DOC files
    for doc in "$BOOKS_DIR"/*.doc "$BOOKS_DIR"/*.docx; do
        [ -f "$doc" ] || continue
        basename=$(basename "$doc")
        encoded_name=$(python3 -c "import urllib.parse; print(urllib.parse.quote('$basename'))" 2>/dev/null || echo "")
        if ! grep -q "$encoded_name" "$ROOT_DIR/spiritual.html" 2>/dev/null; then
            echo -e "${YELLOW}NEW DOCUMENT:${NC} $basename"
            echo "  -> Needs addition to spiritual.html"
            FOUND_NEW=1
        fi
    done
else
    echo "  books/ directory not found"
fi

echo ""

# ============================================
# 2. Check for new travel galleries
# ============================================
echo -e "${BLUE}=== Checking travel/ directories ===${NC}"

TRAVEL_DIR="$ROOT_DIR/travel"

if [ -d "$TRAVEL_DIR" ]; then
    for gallery_dir in "$TRAVEL_DIR"/*/; do
        [ -d "$gallery_dir" ] || continue

        gallery_name=$(basename "$gallery_dir")

        # Skip known galleries that are already in travel.html
        if grep -q "travel/$gallery_name" "$ROOT_DIR/travel.html" 2>/dev/null || \
           grep -q "$(python3 -c "import urllib.parse; print(urllib.parse.quote('$gallery_name'))" 2>/dev/null)" "$ROOT_DIR/travel.html" 2>/dev/null; then
            # Check for index.html in gallery
            if [ ! -f "$gallery_dir/index.html" ]; then
                echo -e "${YELLOW}MISSING INDEX:${NC} travel/$gallery_name/"
                echo "  -> Needs index.html created"
                FOUND_NEW=1
            fi
        else
            # New gallery directory
            image_count=$(find "$gallery_dir" -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.png" \) 2>/dev/null | wc -l)
            if [ "$image_count" -gt 0 ]; then
                echo -e "${YELLOW}NEW GALLERY:${NC} travel/$gallery_name/ ($image_count images)"
                echo "  -> Needs index.html and addition to travel.html"
                FOUND_NEW=1
            fi
        fi
    done
else
    echo "  travel/ directory not found"
fi

echo ""

# ============================================
# 3. Summary and recommendations
# ============================================
echo "========================================"
if [ "$FOUND_NEW" -eq 1 ]; then
    echo -e "${GREEN}New content detected!${NC}"
    echo ""
    echo "To process new content, run:"
    echo "  bash scripts/process-new-books.sh    # For new books"
    echo "  bash scripts/generate-gallery.sh     # For new galleries"
else
    echo -e "${GREEN}All content is indexed.${NC}"
fi
echo "========================================"

exit 0
