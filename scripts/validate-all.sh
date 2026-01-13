#!/bin/bash
# Master validation script - runs all checks

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

echo "========================================"
echo "       WEBSITE VALIDATION SUITE        "
echo "========================================"
echo ""

TOTAL_ISSUES=0

# Run encoding check
echo "Running encoding check..."
echo "----------------------------------------"
bash "$SCRIPT_DIR/check-encoding.sh"
TOTAL_ISSUES=$((TOTAL_ISSUES + $?))
echo ""

# Run broken links check
echo "Running broken links check..."
echo "----------------------------------------"
bash "$SCRIPT_DIR/check-links.sh"
TOTAL_ISSUES=$((TOTAL_ISSUES + $?))
echo ""

echo "========================================"
echo "          FINAL SUMMARY                "
echo "========================================"
if [ $TOTAL_ISSUES -eq 0 ]; then
    echo "All checks passed!"
    exit 0
else
    echo "Total issues found: $TOTAL_ISSUES"
    exit 1
fi
