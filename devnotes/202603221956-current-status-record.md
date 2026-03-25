# 現状記録（2026-03-22 後半）

- **記録日時**: 2026-03-22（ファイル名タイムスタンプ: 1956）
- **集約先**: devnotes/202503021800-current-status.md（本ファイルは詳細メモ）

---

## 1. クライアント向け WordPress 簡易マニュアル

| 項目 | 内容 |
|------|------|
| **Markdown 初稿** | `devnotes/202603221932-client-wordpress-manual-draft-v1.md`（ログイン〜お知らせ・CF7・Instagram・付録。サイト実装に合わせたカテゴリー説明・PICKUP とグリッドの排他仕様を記載） |
| **ダミーキャプチャ** | `devnotes/manual-captures-placeholder/*.svg`（10点）＋ `README.md` |
| **PDF 成果物** | `devnotes/202603221932-client-wordpress-manual-draft-v1.pdf`（キャプチャ埋め込み済み） |
| **書き出し手順** | **Pandoc** で MD→HTML（`--embed-resources`）、**Google Chrome headless** で PDF。`npm run manual:pdf` または `bash scripts/build-client-manual-pdf.sh` |
| **スタイル** | `devnotes/manual-pdf-export.css`（本文用・`@page` A4 等） |
| **中間生成** | `devnotes/.manual-pdf-build/`（`.gitignore` で除外） |

---

## 2. 開発環境（Pandoc）

- **Homebrew** で `pandoc` 導入済み（本機確認時 v3.9 系）。PDF 直出力用 LaTeX（BasicTeX 等）は**未導入**（HTML 経由で PDF 生成）。

---

## 3. リポジトリ・npm

| 変更 | 内容 |
|------|------|
| `package.json` | `manual:pdf` → `bash scripts/build-client-manual-pdf.sh`。`marked` / `puppeteer-core` を削除（Pandoc 方式へ統一） |
| `scripts/` | `build-client-manual-pdf.sh` 追加。`export-manual-pdf.mjs` は削除済み |
| `.gitignore` | `devnotes/.manual-pdf-build/` を追加 |

※ `package-lock.json` と `node_modules` の整合は、必要に応じて `npm install` で更新。

---

## 4. テーマ（UI）関連の直近反映（同日〜直近）

| 箇所 | 内容 |
|------|------|
| **お知らせ PICKUP ラベル** | `.p-news__pickup-label` に上部 V 字欠け（`clip-path`）。`_news.scss` |
| **生産者スライダー** | 表示枚数: **PC 3 / タブレット（768–1023px）2 / スマホ 1**。トラック幅 400% / 600% / 1200%。`_producers.scss` |
| **生産者キャッチコピー** | スマホ（767px 以下）で `white-space: normal`（改行を折りたたみ）。`_producers.scss` |

（Instagram フィード・CF7 スピナー等、それ以前の記録は `202503021800-current-status.md` の各「直近の反映」を参照。）

---

## 5. 作業時間（参考）

| 区分 | 時間 |
|------|------|
| マニュアル初稿・ダミー画像・Pandoc/PDF パイプライン・ドキュメント | 約 90 分（複数セッション合算の目安） |
| 本記録の作成 | 約 10 分 |
