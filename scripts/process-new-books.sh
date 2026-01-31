#!/bin/bash
# Process new books: extract covers and generate HTML entries
# Usage: bash scripts/process-new-books.sh [--dry-run]

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(dirname "$SCRIPT_DIR")"
BOOKS_DIR="$ROOT_DIR/books"
COVERS_DIR="$BOOKS_DIR/covers"

DRY_RUN=0
if [ "$1" = "--dry-run" ]; then
    DRY_RUN=1
    echo "DRY RUN MODE - no changes will be made"
fi

# Ensure covers directory exists
mkdir -p "$COVERS_DIR"

echo "========================================"
echo "   Processing New Books"
echo "========================================"

# Check for pdftoppm
if ! command -v pdftoppm &> /dev/null; then
    echo "ERROR: pdftoppm not found. Install with: apt-get install poppler-utils"
    exit 1
fi

PROCESSED=0

for pdf in "$BOOKS_DIR"/*.pdf; do
    [ -f "$pdf" ] || continue

    filename=$(basename "$pdf")
    basename="${filename%.pdf}"

    # Create a safe cover name (ASCII)
    safe_name=$(echo "$basename" | iconv -f utf-8 -t ascii//TRANSLIT 2>/dev/null | tr ' ' '-' | tr -cd '[:alnum:]-' || echo "book-$RANDOM")

    cover_path="$COVERS_DIR/$safe_name.png"

    # Check if cover already exists
    if [ -f "$cover_path" ]; then
        echo "SKIP: Cover exists for $filename"
        continue
    fi

    echo "PROCESSING: $filename"

    if [ "$DRY_RUN" -eq 0 ]; then
        # Extract first page as cover
        pdftoppm -png -f 1 -l 1 -scale-to 400 "$pdf" "$COVERS_DIR/${safe_name}" 2>/dev/null

        # Rename output (pdftoppm adds page number)
        for f in "$COVERS_DIR/${safe_name}"*.png; do
            [ -f "$f" ] && mv "$f" "$cover_path" && break
        done

        if [ -f "$cover_path" ]; then
            echo "  -> Created cover: $cover_path"
            PROCESSED=$((PROCESSED + 1))
        else
            echo "  -> ERROR: Failed to create cover"
        fi
    else
        echo "  -> Would create cover: $cover_path"
        PROCESSED=$((PROCESSED + 1))
    fi
done

echo ""
echo "========================================"
echo "Processed $PROCESSED new book(s)"

if [ "$PROCESSED" -gt 0 ] && [ "$DRY_RUN" -eq 0 ]; then
    echo ""
    echo "Next steps:"
    echo "1. Add book entries to spiritual.html"
    echo "2. Run: bash scripts/validate-all.sh"
    echo "3. Commit and push changes"
fi
echo "========================================"
