#!/bin/bash
# Check synchronization between Hebrew and English pages
# Ensures both versions have matching structure and content

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(dirname "$SCRIPT_DIR")"

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo "========================================"
echo "   Hebrew-English Sync Check"
echo "========================================"
echo ""

ISSUES=0

# Define page pairs to check
declare -A PAGES=(
  ["index.html"]="en/index.html"
  ["spiritual.html"]="en/spiritual.html"
  ["travel.html"]="en/travel.html"
  ["archive.html"]="en/archive.html"
  ["living.html"]="en/living.html"
)

for heb_page in "${!PAGES[@]}"; do
  eng_page="${PAGES[$heb_page]}"
  heb_path="$ROOT_DIR/$heb_page"
  eng_path="$ROOT_DIR/$eng_page"

  echo -e "${YELLOW}Checking:${NC} $heb_page <-> $eng_page"

  # Check if both files exist
  if [ ! -f "$heb_path" ]; then
    echo -e "  ${RED}MISSING:${NC} Hebrew page $heb_page"
    ((ISSUES++))
    continue
  fi

  if [ ! -f "$eng_path" ]; then
    echo -e "  ${RED}MISSING:${NC} English page $eng_page"
    ((ISSUES++))
    continue
  fi

  # Check for matching sections (by id)
  heb_sections=$(grep -oP 'id="[^"]+"' "$heb_path" 2>/dev/null | sort -u || true)
  eng_sections=$(grep -oP 'id="[^"]+"' "$eng_path" 2>/dev/null | sort -u || true)

  # Compare section IDs
  heb_only=$(comm -23 <(echo "$heb_sections") <(echo "$eng_sections") 2>/dev/null || true)
  eng_only=$(comm -13 <(echo "$heb_sections") <(echo "$eng_sections") 2>/dev/null || true)

  if [ -n "$heb_only" ]; then
    echo -e "  ${YELLOW}Hebrew only sections:${NC}"
    echo "$heb_only" | sed 's/^/    /'
    ((ISSUES++))
  fi

  if [ -n "$eng_only" ]; then
    echo -e "  ${YELLOW}English only sections:${NC}"
    echo "$eng_only" | sed 's/^/    /'
    ((ISSUES++))
  fi

  # Check for matching card counts
  heb_cards=$(grep -c 'class="card' "$heb_path" 2>/dev/null || echo "0")
  eng_cards=$(grep -c 'class="card' "$eng_path" 2>/dev/null || echo "0")

  if [ "$heb_cards" != "$eng_cards" ]; then
    echo -e "  ${YELLOW}Card count mismatch:${NC} Hebrew=$heb_cards, English=$eng_cards"
    ((ISSUES++))
  fi

  # Check for dynamic-books.js in both
  heb_has_dynamic=$(grep -c 'dynamic-books.js' "$heb_path" 2>/dev/null || echo "0")
  eng_has_dynamic=$(grep -c 'dynamic-books.js' "$eng_path" 2>/dev/null || echo "0")

  if [ "$heb_has_dynamic" != "$eng_has_dynamic" ]; then
    echo -e "  ${YELLOW}Dynamic books script mismatch:${NC} Hebrew=$heb_has_dynamic, English=$eng_has_dynamic"
    ((ISSUES++))
  fi

  # Check modification times
  heb_time=$(stat -c %Y "$heb_path" 2>/dev/null || echo "0")
  eng_time=$(stat -c %Y "$eng_path" 2>/dev/null || echo "0")

  time_diff=$((heb_time - eng_time))
  if [ "${time_diff#-}" -gt 86400 ]; then  # More than 1 day difference
    if [ "$heb_time" -gt "$eng_time" ]; then
      echo -e "  ${YELLOW}Hebrew updated more recently${NC} - English may need update"
    else
      echo -e "  ${YELLOW}English updated more recently${NC} - Hebrew may need update"
    fi
  fi

  echo -e "  ${GREEN}OK${NC}"
done

echo ""
echo "========================================"
if [ "$ISSUES" -gt 0 ]; then
  echo -e "${YELLOW}Found $ISSUES potential sync issues${NC}"
  echo "Review the items above and ensure both versions match."
else
  echo -e "${GREEN}All pages appear synchronized!${NC}"
fi
echo "========================================"

exit 0
