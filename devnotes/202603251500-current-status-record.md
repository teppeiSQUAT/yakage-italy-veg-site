# 現状記録（2026-03-25）

- **記録日時**: 2026年3月25日（ファイル名タイムスタンプ: 1500）
- **集約先**: devnotes/202503021800-current-status.md（本ファイルは同日スナップショット）

---

## 1. Instagram フィード（実装位置の確認済み）

| 項目 | 内容 |
|------|------|
| **ショートコード** | `[instagram-feed feed=1]`（Smash Balloon Social Photo Feed 想定） |
| **テーマでの出力** | `wordpress/html/wp-content/themes/yakage-italy-veg/front-page.php` **215 行付近** `.p-instagram` 内で `<?php echo do_shortcode( '[instagram-feed feed=1]' ); ?>` |
| **前提** | 本番・検証環境でプラグイン有効化、管理画面で **フィード ID 1** が存在すること |
| **スタイル** | `scss/_instagram.scss`（詳細は devnotes/202603221851-instagram-smash-balloon-feed-style-record.md） |

---

## 2. Phase F（イタリア野菜とは）レイアウト・レスポンシブ（現行）

| 項目 | 内容 |
|------|------|
| **データ** | `front-page.php` の `$vegetables_data` **20 件**。`shuffle` 後に全件出力（PHP）。 |
| **`.p-vegetables__inner`** | **≥1024px**: `3.5fr 6.5fr`（左テキスト／右グリッド）。**768–1023px**: `4fr 6fr`。**≤767px**: 1 列（テキスト→グリッド）。 |
| **`.p-vegetables__content`** | `display: flex`、`align-items: start`、`justify-content: center`。 |
| **`.wrap_content`（sticky 対象）** | **≥768px** のみ `position: sticky`、`top: 100px`、背景色、`box-shadow` なし。**≤767px** は `static`。 |
| **`.p-vegetables__grid`** | **≥1024px**: 4 列。**768–1023px**: 3 列、`grid-auto-rows: minmax(220px, 1fr)`。**≤767px**: 2 列。**≤480px**: 1 列＋**11 枚目以降 `display: none`**（先頭 10 枚）。 |
| **`.p-vegetables__card-overlay`** | `padding: 8px`。 |
| **ソース** | `scss/_vegetables.scss`（`npm run sass:build` で `style.css` 生成） |

---

## 3. 作業時間（参考）

| 区分 | 時間 |
|------|------|
| Phase F のメディアクエリ追加・各種スタイル調整・Instagram 出し分け確認・本記録 | **約 30 分**（セッション目安・未厳密計測） |
