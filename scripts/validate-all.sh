#!/usr/bin/env bash
# Run every check before a commit. Exit 1 on any problem.
set -u
cd "$(dirname "$0")/.."
status=0
echo "== build_content.py --dry-run --no-network"
python3 scripts/build_content.py --dry-run --no-network >/dev/null || status=1
echo "== apply_chrome.py --check"
python3 scripts/apply_chrome.py --check || status=1
echo "== check_site.py"
python3 scripts/check_site.py || status=1
if [ "$status" -eq 0 ]; then echo "ALL CHECKS PASSED"; else echo "CHECKS FAILED"; fi
exit $status
