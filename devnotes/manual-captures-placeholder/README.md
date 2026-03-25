# マニュアル用ダミーキャプチャ（プレースホルダー）

`202603221932-client-wordpress-manual-draft-v1.md` から相対パスで参照している **SVG プレースホルダー** です。

## 納品時の作業

1. 本番（またはステージング）の管理画面で該当画面の **スクリーンショット（PNG 推奨）** を取得する  
2. 同じファイル名（`01-login.png` など）で保存するか、マニュアル内の画像パスを差し替える  
3. 不要になったら本フォルダの SVG は削除してよい  

## ファイル対応表

| ファイル | 差し替え先の想定画面 |
|----------|----------------------|
| `01-login.svg` | ログイン画面 |
| `02-dashboard.svg` | ダッシュボード全体 |
| `03-post-list.svg` | 投稿一覧 |
| `04-post-editor.svg` | 投稿の新規追加・編集 |
| `05-featured-image.svg` | アイキャッチ画像パネル |
| `06-categories.svg` | カテゴリー |
| `07-publish-panel.svg` | 公開パネル |
| `08-media-library.svg` | メディア新規追加 |
| `09-contact-form7.svg` | Contact Form 7 |
| `10-customizer-instagram.svg` | カスタマイザー（Instagram） |

Markdown から PNG に差し替える場合は、画像参照を `![](manual-captures-placeholder/01-login.png)` のように変更してください。

## PDF の書き出し（Pandoc + Chrome）

プロジェクトルートで:

```bash
npm run manual:pdf
```

または:

```bash
bash scripts/build-client-manual-pdf.sh
```

- **Pandoc** で `devnotes/202603221932-client-wordpress-manual-draft-v1.md` を HTML に変換（`--embed-resources` で SVG キャプチャを data URI 埋め込み）
- **Google Chrome（headless）** で `devnotes/202603221932-client-wordpress-manual-draft-v1.pdf` を生成
- 中間 HTML は `devnotes/.manual-pdf-build/`（`.gitignore` 対象）

別ブラウザを使う場合は環境変数 `CHROME_PATH` に実行ファイルのフルパスを指定。
