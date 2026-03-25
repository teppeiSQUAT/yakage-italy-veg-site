#!/usr/bin/env bash
# クライアント向けマニュアル（Markdown）→ Pandoc で HTML（画像埋め込み）→ Chrome headless で PDF
# 前提: brew install pandoc / Google Chrome インストール済み

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
DEVNOTES="$ROOT/devnotes"
MD="$DEVNOTES/202603221932-client-wordpress-manual-draft-v1.md"
CSS="$DEVNOTES/manual-pdf-export.css"
BUILD="$DEVNOTES/.manual-pdf-build"
HTML_OUT="$BUILD/manual.html"
PDF_OUT="$DEVNOTES/202603221932-client-wordpress-manual-draft-v1.pdf"

CHROME="${CHROME_PATH:-}"
if [[ -z "$CHROME" ]]; then
  for c in \
    "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome" \
    "/Applications/Chromium.app/Contents/MacOS/Chromium" \
    "/Applications/Microsoft Edge.app/Contents/MacOS/Microsoft Edge"
  do
    if [[ -x "$c" ]]; then CHROME="$c"; break; fi
  done
fi

if ! command -v pandoc &>/dev/null; then
  echo "pandoc が見つかりません。例: brew install pandoc" >&2
  exit 1
fi
if [[ -z "$CHROME" || ! -x "$CHROME" ]]; then
  echo "Chrome / Chromium / Edge が見つかりません。CHROME_PATH で実行ファイルを指定してください。" >&2
  exit 1
fi
if [[ ! -f "$MD" ]]; then
  echo "マニュアルが見つかりません: $MD" >&2
  exit 1
fi

mkdir -p "$BUILD"

echo "→ Pandoc: Markdown → HTML（--embed-resources）"
(cd "$DEVNOTES" && pandoc "$(basename "$MD")" \
  -f markdown \
  -t html5 \
  --standalone \
  --embed-resources \
  --resource-path=".:manual-captures-placeholder" \
  --metadata title="WordPress 簡易操作マニュアル（初稿）" \
  -c manual-pdf-export.css \
  -o ".manual-pdf-build/manual.html")

echo "→ Chrome headless: HTML → PDF"
"$CHROME" \
  --headless=new \
  --disable-gpu \
  --no-pdf-header-footer \
  --print-to-pdf="$PDF_OUT" \
  "file://$HTML_OUT"

echo "完了: $PDF_OUT"
ls -lh "$PDF_OUT"
