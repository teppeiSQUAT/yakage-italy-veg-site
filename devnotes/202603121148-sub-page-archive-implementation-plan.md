# 下層ページ・アーカイブページ 実装計画書

- **作成日**: 2026年3月12日
- **最終更新**: 2026年3月12日（PICKUP スライダー仕様は TOP 実装計画 Phase C に集約）
- **対象**: 矢掛町イタリア野菜プロジェクト 公式サイト
- **目的**: 固定ページ（下層ページ）とアーカイブページのテンプレートを実装する

---

## 1. 対象ページ一覧

### 下層ページ（固定ページ）

| ページ | 想定スラッグ | 内容 | 備考 |
|--------|-------------|------|------|
| プロジェクトについて | project | イタリア野菜プロジェクトの紹介 | TOP の #project セクションと同等または詳細 |
| イタリア野菜とは | vegetables | イタリア野菜の説明・紹介 | TOP の #vegetables セクションと同等 |
| 生産者紹介 | producers | 生産者一覧・紹介 | TOP の #producers セクションと同等 |
| サポーター紹介 | supporters | サポーター一覧・紹介 | TOP の #supporters セクションと同等 |
| お問い合わせ | contact | お問い合わせフォーム | TOP の #contact セクションと同等 |

※ メニューから固定ページへリンクする場合、各ページを WordPress で作成し、スラッグを上記に設定する。

### アーカイブページ

| 種別 | テンプレート | 用途 |
|------|-------------|------|
| 投稿一覧（固定ページ） | news.php | 固定ページ「NEWS」にテンプレート「NEWS（投稿一覧）」を適用した場合の一覧。ダッシュボードで手動作成。URL 例: /news/ |
| 投稿一覧（表示設定） | home.php | 設定 > 表示設定で「投稿ページ」を指定した場合の一覧 |
| カテゴリアーカイブ | archive.php / category.php | お知らせ（news）・イベント・レシピ・PICKUP のカテゴリ別一覧 |
| 単一投稿 | single.php | 個別投稿の詳細表示 |

---

## 2. 実装フェーズ

### Phase L-1: 共通レイアウト・スタイル

- [x] 下層ページ用の共通レイアウト（ヘッダー・フッターは既存、メインコンテンツエリア）
- [x] `.l-main` の padding-top（固定ヘッダー高さ分）は既存の `body:not(.is-front-page) .l-main { padding-top: 60px }` で対応済み
- [x] 下層ページ用 SCSS（`_page.scss`）の作成・style.scss に追加

### Phase L-2: 固定ページ（page.php）

- [x] `page.php` を作成
- [x] ヘッダー（l-header--sub）・フッターは get_header() / get_footer() で共通
- [x] メイン: ページタイトル + the_content()
- [x] シンプルなレイアウト（l-container 内、p-page クラス）

### Phase L-3: 投稿一覧（home.php）

- [x] `home.php` を作成
- [x] お知らせアーカイブとして、カード形式で投稿一覧を表示（p-news__grid 流用）
- [x] ページネーション対応（the_posts_pagination）
- [x] 既存の p-news スタイルを流用

### Phase L-3b: 投稿一覧（news.php 固定ページテンプレート）

- [x] `news.php` を作成（Template Name: NEWS（投稿一覧））
- [x] 固定ページに適用すると投稿一覧を表示。カスタム WP_Query で投稿取得、ページネーション対応
- [x] 固定ページ「NEWS」はダッシュボードから手動作成し、テンプレートを選択
- [x] 「もっと見る」リンク: `yakage_italy_veg_get_news_archive_url()` でスラッグ `news` の固定ページ URL を返す（例: /news/）

### Phase L-4: アーカイブ（archive.php）

- [x] `archive.php` を作成
- [x] カテゴリ・タグ・日付等のアーカイブタイトル表示（functions.php で get_the_archive_title のプレフィックス削除）
- [x] 投稿一覧（home.php と同様のカード形式）
- [x] ページネーション対応
- [ ] カテゴリ別の場合は `category.php` で上書き可能（任意・必要に応じて）

### Phase L-5: 単一投稿（single.php）

- [x] `single.php` を作成
- [x] 投稿タイトル・日付・カテゴリ・本文・サムネイル
- [x] 前後の投稿リンク（the_post_navigation）

---

## 3. テンプレート階層（WordPress）

```
front-page.php  → フロントページ（固定）
home.php        → 投稿一覧（投稿ページを設定した場合）
news.php        → 固定ページテンプレート「NEWS（投稿一覧）」→ 投稿一覧表示
page.php        → 固定ページ
single.php      → 単一投稿
archive.php     → アーカイブ（カテゴリ・タグ・日付等）
index.php       → フォールバック（既存）
```

---

## 4. デザイン方針

- **ヘッダー**: 下層ページは `l-header--sub`（logo_sub.png、固定表示）で統一済み
- **コンテンツ幅**: `l-container`（max-width: 1100px）を使用
- **セクション余白**: `--section-padding-y`（60px）を活用
- **タイトル**: 他セクションと同様のスタイル（c-border-line-bottom 等）を適用
- **お知らせカード**: 既存の `.p-news__card` スタイルを流用

---

## 5. 参照

- devnotes/202503032300-top-page-theme-implementation-plan.md（TOPページ実装計画）
- devnotes/202503021800-current-status.md（現状記録）

---

## 6. 実装履歴

- **2026/03/12**: Phase L-1〜L-5 を実装。page.php・home.php・archive.php・single.php を作成。scss/_page.scss で p-page・p-archive・p-single のスタイルを定義。functions.php に get_the_archive_title フィルターを追加。
- **2026/03/12**: 固定ページタイトルに c-border-line-left を適用（_components.scss で p-project__heading::before と同様の赤・ライムグリーン縦二重線）。フッターのサイトポリシー・プライバシーポリシーを /site-policy/・/privacy-policy/ にリンク更新。
- **2026/03/12**: news.php 固定ページテンプレートを作成。固定ページ「NEWS」に適用すると投稿一覧を表示。yakage_italy_veg_get_news_archive_url() を変更し、「もっと見る」リンクを /news/ へ。ご注文はこちらリンクを Google Forms（https://forms.gle/1hs63P1vK5d8qavN8）に設定。PICKUP スライダー（1枚表示・自動再生・ループ・右→左）の詳細は devnotes/202503032300-top-page-theme-implementation-plan.md の Phase C を参照。
