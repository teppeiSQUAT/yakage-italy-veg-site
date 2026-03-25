# Instagram セクション（Smash Balloon）フィード表示・スタイル調整の記録

- **記録日時**: 2026-03-22 18:51（ファイル名タイムスタンプ基準）
- **状態**: **画面表示の確認済み**（テーマ側デザインで意図どおり再現できていることを確認）

---

## 背景・課題

- TOP `front-page.php` の `.p-instagram` 内で `[instagram-feed feed=1]`（Smash Balloon Instagram Feed）を出力。
- プラグイン既定のマークアップ（`#sb_instagram` / `#sbi_images` / `.sbi_photo` のインライン `height` 等）により、**グリッド崩れ・画像の極小表示・テーマ見出し／フォローボタンとの二重表示**が発生していた。

---

## 対応内容（テーマ SCSS）

**対象ファイル**: `wordpress/html/wp-content/themes/yakage-italy-veg/scss/_instagram.scss`  
**ビルド**: `npm run sass:build` → `style.css`

| 項目 | 内容 |
|------|------|
| `#sb_instagram` | `flex` 縦積み、`padding-bottom` 打ち消し |
| `.sb_instagram_header` | 非表示（テーマの「公式 Instagram」見出しと重複するため） |
| `#sbi_images` | ここだけ `grid`、PC 4列 `minmax(0,1fr)`、`gap: 12px` |
| `.sbi_photo_wrap` | `aspect-ratio: 4 / 5`（フィードの `data-imageaspectratio="4:5"` に合わせる） |
| `a.sbi_photo` | `position: absolute` + `inset: 0` でプラグインのインライン高さを上書き |
| `#sbi_load` | 非表示（テーマの `.p-instagram__follow-btn` のみ利用） |
| 767px 以下 | `.p-instagram__feed #sbi_images` を **2列**（`!important` で上書き） |

---

## テンプレート参照

- `front-page.php` … `do_shortcode( '[instagram-feed feed=1]' )` を `.p-instagram__feed` 内に配置。

---

## 今後のメモ

- スマホを **1列** にしたい場合は、同メディアクエリの `grid-template-columns` を `repeat(1, …)` に変更するか、プラグイン管理画面の列数設定と揃える。
- プラグインの「ヘッダー表示」等をオフにできる場合は、CSS 非表示に加えて管理側で無効化するとマークアップも簡潔になる。

---

## 作業時間（参考）

| 区分 | 時間 |
|------|------|
| SCSS 調整・コンパイル（実装セッション） | （別セッションで実施） |
| 表示確認・本記録の作成 | 約 10 分 |
