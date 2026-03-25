# TOPページ テーマ実装計画書

- **作成日**: 2025年3月3日
- **最終更新**: 2026年3月25日（Phase F レイアウト・レスポンシブの現状反映、Instagram 実装位置の明記、K-1 整合）
- **対象**: 矢掛町イタリア野菜プロジェクト 公式サイト TOPページ
- **目的**: 新規 WordPress テーマを作成し、デザインを再現する
- **進め方**: フェーズごとに切り、コンテンツブロック単位で実装
- **スケジュール**: 2025年3月11日（火）本番サーバーへテストアップ予定 → devnotes/202503031000-schedule-to-production-test.md

---

## 前提・方針

- **テーマ名**: yakage-italy-veg（仮）
- **テーマ配置**: `wordpress/html/wp-content/themes/yakage-italy-veg/` に配置。.gitignore を調整し、当該テーマディレクトリのみ Git 管理（WP コア・他テーマ・plugins・uploads は除外）
- **デザイン参照**: assets/sample_TOP-dbe22a30-a328-4641-8422-cb6a3b1a3e31.png、フッターは sample_TOP_10 等の仕上がりイメージ
- **フォント**: Google Fonts「Zen Maru Gothic」を全体で使用（functions.php で読み込み、CSS 変数で指定）
- **カラーパレット**: 緑（背景・アクセント）、赤（ボタン・強調）、白/オフホワイト（背景）。フッターはライトグレー背景・ダークグレー文字

---

## 全体フェーズ一覧

**TOPページ セクション順**: ヒーロー → お知らせ → Instagram → イタリア野菜プロジェクトについて → イタリア野菜とは → 生産者紹介 → サポーター紹介 → 実績紹介 → お問い合わせ → フッター

| フェーズ | 内容 | 状態 |
|---------|------|------|
| **Phase A** | テーマ基盤・共通レイアウト | **完了** |
| **Phase B** | ヘッダー・ヒーロー・フッター | **完了** |
| **Phase C** | お知らせセクション | **完了** |
| **Phase D** | Instagramセクション | **完了**（`front-page.php` で `do_shortcode( '[instagram-feed feed=1]' )` を出力。Smash Balloon 出力は `_instagram.scss` でグリッド・アスペクト・重複 UI 非表示を調整。詳細: devnotes/202603221851-instagram-smash-balloon-feed-style-record.md） |
| **Phase E** | イタリア野菜プロジェクトについて | **完了** |
| **Phase F** | イタリア野菜とは | **完了**（2026/03/25 時点: 20 件 shuffle・3 段階ブレークのグリッド・左列 sticky は `.wrap_content` のみ。詳細: devnotes/202603251500-current-status-record.md） |
| **Phase G** | 生産者紹介 | **完了** |
| **Phase H** | サポーター紹介 | **完了** |
| **Phase I** | 実績紹介 | **完了** |
| **Phase J** | お問い合わせ | **完了** |
| **Phase K** | レスポンシブ・仕上げ | **進行中**（主要ブレークポイントはコードに反映済み。残: 全体微調整・A11y・性能・本番確認／納品マニュアル初稿・PDF 済） |
| **Phase L** | 下層ページ・アーカイブ（page/home/archive/single） | **完了** → devnotes/202603121148-sub-page-archive-implementation-plan.md |

---

# Phase A: テーマ基盤・共通レイアウト

**目的**: テーマの骨格を作成し、共通スタイルを定義する。

## A-1. テーマディレクトリ・環境整備

- [x] テーマ配置（`wordpress/html/wp-content/themes/yakage-italy-veg/`）
  - [x] ディレクトリ作成（Docker 起動後、wp-content/themes/ は自動作成済みのため yakage-italy-veg のみ作成）
  - [x] .gitignore により当該テーマのみ Git 管理されることを確認
- [x] 基本テーマファイルの作成
  - [x] `style.css`（テーマ情報・基本スタイル）
  - [x] `functions.php`（テーマサポート、スクリプト・スタイル読み込み）
  - [x] `index.php`（フォールバック）
  - [x] `front-page.php`（TOPページテンプレート）
  - [x] `header.php`（共通ヘッダー枠）
  - [x] `footer.php`（共通フッター枠）
- [ ] WordPress 管理画面でテーマを有効化できることを確認（要：設定 > 表示設定 > 固定ページをホームに設定）

## A-2. 共通スタイル・変数定義

- [x] CSS 変数（カラー・フォント・スペーシング）の定義
  - [x] 緑（--color-green: #009145）、赤（--color-red: #f70801）、白、オフホワイト、ダークグレー、ライムグリーン（--color-green-lime）
  - [x] フォントファミリー、フォントサイズ
  - [x] セクション余白、コンテナ幅
- [x] リセット・ベーススタイル（body, a, img 等）
- [x] 共通コンテナ・セクションクラス
- [x] ボタンコンポーネント（赤・緑・白）

---

# Phase B: ヘッダー・ヒーロー・フッター

**目的**: 全ページ共通のヘッダー・ヒーロー・フッターを実装する。

## B-1. ヘッダー

### ヘッダー仕様（使い分け）

| パターン | 対象 | 仕様 |
|---------|------|------|
| **TOP 初回表示** | フロントページ読み込み時 | ヒーロー上に配置。初期状態のヘッダー |
| **TOP スクロール時** | フロントページでスクロール後 | 上からスライドインして固定表示（fixed） |
| **下層ページ** | 野菜紹介、イベント等 | 常に固定表示（または通常表示）のヘッダー |

### PC 表示

- [x] ロゴ（`assets/images/logo.png` を絶対配置で表示、PC: height 200px / max-width 300px、スマホ: 72px / 160px）
- [x] ロゴ切り替え：TOP 初回は logo.png、800px スクロール後・下層ページは logo_sub.png（header.php で両 img を配置、CSS で表示切り替え）
- [x] ヘッダーコンテナ（.l-header__container）の max-width: 96%
- [x] ナビゲーションメニュー（横並び・右寄せ、gap: 15px、letter-spacing: 0.01em）
- [x] メニューリンク：TOP・プロジェクトについて（#project）・イタリア野菜とは（#vegetables）・生産者紹介（#producers）・サポーター紹介（#supporters）・お問い合わせ（#contact）。スムーズスクロール＋scroll-padding-top でオフセット調整
- [x] TOP 時も**最初から白背景**（スクロール前後で統一）。コンテナ・inner に白背景指定
- [x] TOP スクロール時：800px で固定表示に切り替え（header.js で .is-scrolled 付与）。上から下へスライドイン（headerSlideIn 0.8s）、800px 未満で上へスライドアウト（headerSlideOut 0.8s、is-sliding-out 経由）
- [x] ナビホバー・現在ページ：赤文字＋ライムグリーン下線（`--color-green-lime`）。.current-menu-item にも同スタイル
- [x] 下層ページ：固定ヘッダー（.l-header--sub）、logo_sub.png を使用

### スマホ表示（Phase H で詳細）

- [x] ハンバーガーメニューに切り替え（767px 以下）
- [x] タップでドロワー表示（サイドからスライドイン）

## B-2. ヒーローセクション

- [x] ヒーロー画像スライダー（`assets/images/hero-1.jpg`～`hero-8.jpg` の8枚、100vw×90vh / min-height: 80vh、object-fit: cover）
- [x] クロスフェード切り替え（opacity 0.6s）、表示中は約5秒でゆっくり拡大（scale 1→1.08）、5秒ごとに自動送り、ドットで選択、ホバーで一時停止（hero-slider.js、_hero.scss）
- [ ] 画像上オーバーレイ（赤バナー・テキスト、必要に応じて後続で追加）
- [x] スライダーインジケーター（3ドット、1つ緑でアクティブ）
- [ ] スライダー機能（複数画像切り替え、必要に応じて JS で後続追加）

## B-3. フッター（仕上がりイメージ準拠）

- [x] フッター背景（#e5e5e5）
- [x] 左：シールに `logo_gry.png` を表示（角丸・枠線なし）
- [x] 中央：ナビ（TOP｜サイトポリシー｜プライバシーポリシー）、著作権「YYYY (c) yakage.」
- [x] 右：ページトップへスクロール用ボタン（半円かまぼこ型・下端固定・CSS 三角矢印、シャドウなし）。700px スクロールでフェードイン表示（.is-visible）
- [x] レイアウト：3カラム grid（左・中央・右）、スマホ時は縦並び

---

# Phase C: お知らせセクション

**目的**: お知らせ（ニュース）セクションを実装する。ヒーローの次に表示。投稿＋カテゴリ（お知らせ・イベント・レシピ・PICKUP）で管理。

## C-1. お知らせ

- [x] セクション構成・背景（#009145、bg_layveg01.png 上部 contain・opacity 0.2・mix-blend-mode: lighten）
- [x] セクションタイトル「お知らせ」＋左右に赤・白縦二重線（::before/::after、幅11px・高さ1.5em）、文字サイズは他セクションタイトルと統一（clamp）
- [x] PICKUP トラック幅をグリッドと同一にし、前へ・次へボタンはトラック外側に absolute 配置
- [x] PICKUP カード内タイトル（.p-news__pickup-card-body .p-news__card-title）font-size: 26px
- [x] カテゴリ 4 種登録（お知らせ slug: news・イベント・レシピ・PICKUP）
- [x] PICKUP: 先頭でスライダー表示（前後矢印・ドット）。**1枚ずつ表示**（p-news__pickup-viewport でクリップ）。**自動再生**（5秒間隔）・**ループ**・ホバー時一時停止。**常に右→左スライド**（先頭スライドを末尾にクローン、transitionend でリセット）。カード画像 aspect-ratio: 4/3。カード内に日付・カテゴリ・タイトル・抜粋・NEW タグ（7日以内）
- [x] PICKUP ラベル「PICKUP」テキスト: 上部を V 字に欠く装飾（`clip-path`、_news.scss）
- [x] それ以外: お知らせ・イベント・レシピを新着順で 6 件グリッド（3列）、サムネイル・日付・カテゴリタグ・タイトル・抜粋・NEW タグ
- [x] 「もっと見る」ボタンで固定ページ「NEWS」（スラッグ: news）へ。`yakage_italy_veg_get_news_archive_url()` で URL 取得

---

# Phase D: Instagramセクション

**目的**: Instagram フィードを表示するセクションを実装する。Smash Balloon Social Photo Feed プラグインを使用。

## D-1. Instagram

- [x] セクション構成・背景（白＋薄い野菜パターン）
- [x] セクションタイトル「公式 Instagram」＋Instagram ロゴ（SVG）＋赤・緑の破線装飾
- [x] プラグインショートコード `[instagram-feed feed=1]` で埋め込み（**`front-page.php` の Instagram セクション内**で `do_shortcode()` 呼び出し）。4 列グリッド（スマホ 2 列、テーマ `_instagram.scss` で上書き）
- [x] 「follow us」赤ボタン（カスタマイザーで URL 変更可）
- [x] 下部関連リンク：バナー画像 3 枚（bnr_yakage.png・bnr_youtube.png・bnr_okoshi.png）、表示順は左から「岡山県 矢掛町」「YouTube」「矢掛町地域おこし協力隊」、gap 24px。カスタマイザーで各 URL 変更可

---

# Phase E: イタリア野菜プロジェクトについて

**目的**: プロジェクト紹介セクションを実装する。

## E-1. イタリア野菜プロジェクトについて

- [x] セクション構成・背景（グラデーション #efe3d7→#edf6fc を .gradation_wrap に、bg_layveg01.png 透過。下部ヒーローは bg_layveg03.jpg・logo_wht.png）
- [x] セクションタイトル「矢掛町イタリア野菜プロジェクトについて」＋c-border-line-bottom（文字幅＋左右6em・下余白1em）
- [x] 見出し（.p-project__heading）左に赤・緑ライム縦二重線（::before）。SPECIAL movie 見出しのみ左線なし・文字赤・右に赤線（::after）を右端まで
- [x] 説明ブロック：画像は img_about-01.jpg（矢掛町の町並み）・img_about-02.jpg（イタリアチーム交流）・img_about-03.jpg（イタリア野菜）。「コロナ禍の中…」ブロックは .p-project__text--full で幅100％（grid-column: 1 / -1）
- [x] SPECIAL movie ブロック（.p-project__block--video）：白背景・角丸30px・padding 30px・ドロップシャドウ。YouTube 埋め込みはデフォルト yhibkOmCXow・start=4（カスタマイザーで ID 変更可）
- [x] 下部ヒーロー風エリア（.p-project__hero）：bg_layveg03.jpg・ロゴは logo_wht.png。hero-copy は font-size: 2vw・letter-spacing: 1px

---

# Phase F: イタリア野菜とは

**目的**: イタリア野菜の説明・紹介セクションを実装する。

## F-1. イタリア野菜とは

- [x] セクション構成・背景（白）。**`.p-vegetables__inner`**: **≥1024px** `grid-template-columns: 3.5fr 6.5fr`、**768–1023px** `4fr 6fr`（タブレット）、**≤767px** 1 列（上: テキスト → 下: グリッド）。グリッド列は右端いっぱい
- [x] 見出し（H2）「**イタリア野菜の魅力**」＋c-border-line-bottom（中央寄せ・padding-bottom 1em）。セクション ID は `#vegetables`（ナビ表記は「イタリア野菜とは」）
- [x] 左列 **`.p-vegetables__content`**: `display: flex`、`align-items: start`、`justify-content: center`。内側 **`.wrap_content`** のみ **≥768px** で `position: sticky; top: 100px`（ヘッダー下）。`box-shadow` なし。説明テキスト・「ご注文はこちら」ボタン（border-radius: 999px・#fa0000、デフォルト Google Forms、カスタマイザーで URL 変更可）
- [x] 右列: 野菜画像グリッド。**`$vegetables_data` は制作資料準拠 20 件**（`img_veg_01.png`〜`img_veg_20.png`）。**ページ読み込みごとに `shuffle` し 20 件すべて出力**。`image` キーで紐づけ、画像ありは `<img>`、なしはプレースホルダー。オーバーレイ `.p-vegetables__card-overlay` の **padding: 8px**。内側 .wrap_card（白背景・角丸15px・margin/padding 15px・テキスト中央）。PC は hover、**≤767px** は vegetables.js でタップ開閉
- [x] **グリッド列数（`_vegetables.scss`）**: **≥1024px** 4 列（5 行×4 列で 20 枚）／**768–1023px** 3 列（`grid-auto-rows: minmax(220px, 1fr)`）／**≤767px** 2 列／**≤480px** 1 列かつ **11 枚目以降 `display: none`**（先頭 10 枚のみ表示）

---

# Phase G: 生産者紹介

**目的**: 生産者（農家）紹介セクションをループスライダーで実装する。

## G-1. 生産者紹介

- [x] セクション構成・背景（白・c-border-line-top）
- [x] セクションタイトル「生産者紹介」＋赤・緑破線
- [x] 1ブロック＝画像（角丸）・キャッチコピー（赤・太字・改行は white-space: pre-line）・名前（〇〇さん）・補足情報
- [x] `$producers_data` に `image` キーで assets/images の画像を紐づけ。画像ありなら `<img>`、なしならプレースホルダー表示
- [x] ループスライダー（矢印・ドット）、枚数は JS で動的（cards.length）。**PC（1024px以上）3枚・タブレット（768–1023px）2枚・スマホ（767px以下）1枚**（`_producers.scss` のトラック幅 400% / 600% / 1200%）
- [x] SCSS: _producers.scss、JS: producers-slider.js（--producers-current で位置制御、LOGICAL_COUNT 動的）

---

# Phase H: サポーター紹介

**目的**: サポーター（協力企業・支援者等）紹介セクションを実装する。

## H-1. サポーター紹介

- [x] セクション構成・背景（白＋赤ドットパターン）
- [x] ヘッダーバナー：リボン型、左右に横V（span + c-scroll-top::before の border+transform 方式）、タイトル赤・縦線赤・キャッチコピー
- [x] 9名グリッド（3列、スマホ2列）。1ブロック＝円形顔写真（赤枠・左半分がバナー外にはみ出し）＋赤バナー（右端に横Vカット、円形写真と重なる）
- [x] `$supporters_data` に `image` キーで assets/images の画像を紐づけ。画像ありなら `<img>`、なしならプレースホルダー表示
- [x] SCSS: _supporters.scss

---

# Phase I: 実績紹介

**目的**: 実績・活動報告等のセクションを実装する。

## I-1. 実績紹介

- [x] セクション構成（赤背景＋野菜ラインアート）、キャッチコピー
- [x] 白エリア（p-achievements__inner: max-width: 900px 中央配置）内に3ブロック
- [x] 各ブロック：白背景・角丸・シャドウ、タイトル・説明文・写真（1枚ずつ img_archive_01/02/03.jpg）。ブロック間 margin-bottom: 48px
- [x] SCSS: _achievements.scss

---

# Phase J: お問い合わせ

**目的**: お問い合わせフォームセクションを実装する。

## J-1. お問い合わせ

- [x] セクション構成・背景（白）。タイトル「お問い合わせ」＋c-border-line-bottom（文字幅＋左右6em・padding-bottom 1em・letter-spacing 0.1em）。c-border-line-bottom の線間は transparent
- [x] フォームコンテナ（.p-contact__form-wrap）：背景 #f8f3ed・max-width 900px・角丸・シャドウなし。お名前・所属・メール・TEL・内容、ラベル左・入力右。個人情報同意チェック、「送信」緑ボタン
- [x] 注意文「※担当者より内容確認次第、返信させていただきます。」
- [x] SCSS: _contact.scss。送信処理は Contact Form 7 等で後続対応予定
- [x] **Contact Form 7 対応**: front-page.php をショートコード呼び出しに変更。functions.php に `wpcf7_autop_or_not` フィルター追加。_contact.scss に CF7 用スタイル追加。devnotes/contact-form-7-template.md にフォームテンプレート・メール設定を作成
- [x] **CF7 スピナー（送信ボタン中央寄せ）**: 待機中は `.wpcf7-spinner` を `display: none`（レイアウトから除外）。送信中のみ `form.wpcf7-form.submitting .wpcf7-spinner` で `inline-block` 表示（_contact.scss）。画面確認済み

---

# Phase K: レスポンシブ・仕上げ

**目的**: レスポンシブ対応と全体の仕上げを行う。

## K-1. レスポンシブ対応

- [x] **ブレークポイント（実装ベースの整理）**: テーマ SCSS で **767px 以下＝スマホ**、**768px 以上＝タブレット帯（sticky 等）**、**1024px 以上＝PC（例: 生産者3列・野菜グリッド4列）**、**480px 以下＝野菜グリッド1列＋10枚表示** 等を使用。**Phase F（野菜）** は **768–1023px で 3 列**の中間帯あり（`_vegetables.scss` 先頭コメント参照）。一覧表のドキュメント化は任意
- [x] **ヘッダー（スマホ）**: ハンバーガーメニューの色を赤に変更、間隔・幅を調整（gap: 7px, width: 30px, height: 3px）。ドロワーに閉じるボタン（×）を追加。スマホ表示時（767px以下）に TOP ページでもサブロゴ（logo_sub.png）を表示。ロゴエリア幅 50%・top: 4px
- [x] **ヒーロー（スマホ）**: 高さを 60vh に変更。ヒーロー下にスマホ用ロゴセクション（.p-hero-logo）を追加（赤背景 #e60013 + logo.png センター配置）。PC では非表示
- [x] **プロジェクト（スマホ）**: .p-project__block--video を padding: 15px, border-radius: 20px に。.p-project__hero-copy を font-size: 4vw に
- [x] **イタリア野菜とは（Phase F）**: `$vegetables_data` **20 件**、`shuffle` 後に **全件出力**。グリッド: **≥1024px** 4 列／**768–1023px** 3 列／**≤767px** 2 列／**≤480px** 1 列で先頭 10 枚のみ。`.p-vegetables__inner` の列比（3.5/6.5・タブレット 4/6）、`.wrap_content` のみ sticky、`.p-vegetables__content` は `align-items: start`、オーバーレイ padding 8px（_vegetables.scss・`front-page.php`）
- [x] **お問い合わせ（スマホ）**: .p-contact__field label を flex: 0 0 0 に調整（CF7 対応含む）
- [x] **お問い合わせ（CF7 スピナー）**: 送信ボタンエリアの中央寄せと両立（待機中はスピナー非表示、送信中のみ表示）
- [x] **お知らせ PICKUP ラベル**: `.p-news__pickup-label` に上部 V 字欠け（`clip-path`、_news.scss）
- [x] **生産者スライダー**: 表示枚数 **PC 3 / タブレット 2 / スマホ 1**（_producers.scss）。キャッチコピーはスマホで `white-space: normal`（改行畳み）
- [ ] 各セクションのグリッド・レイアウト調整（残り）
- [ ] 画像・フォントサイズの最適化
- [ ] タッチ操作対応（スライダー等）

## K-2. 仕上げ

- [ ] スライダー・カルーセルの JS 実装（必要箇所）
- [ ] アクセシビリティ（フォーカス、aria 属性）
- [ ] パフォーマンス（画像最適化、遅延読み込み）
- [ ] クロスブラウザ確認

## K-3. 納品・クライアント向けドキュメント

- [x] **WordPress 簡易操作マニュアル（初稿）**: `devnotes/202603221932-client-wordpress-manual-draft-v1.md`、ダミーキャプチャ SVG、`npm run manual:pdf`（Pandoc + Chrome）で PDF 生成。詳細: `devnotes/202603221956-current-status-record.md`
- [ ] **納品時**: 実スクリーンショット差し替え・URL・連絡先の追記、クライアントレビュー

---

## 次のフェーズ（いま着手する単位）

テーマの **Phase A〜L（ブロック実装・下層）は完了**しています。**いまの「次」は Phase K の未チェックを潰して仕上げる段階**です。並行して **本番テストアップ**（`devnotes/202503031000-schedule-to-production-test.md`）に向けた確認がゴールです。

| 順序 | 内容 | メモ |
|------|------|------|
| **1（Phase K 残り）** | 各セクションのグリッド・レイアウトの最終調整 | 実機・複数幅で見た目確認 |
| **2（Phase K 残り）** | 画像・フォントサイズの最適化 | 重量・可読性 |
| **3（Phase K 残り）** | タッチ操作（スライダー等） | 必要なら JS 調整 |
| **4（Phase K-2）** | アクセシビリティ（フォーカス、`aria`） | フォーム・スライダー・ナビ |
| **5（Phase K-2）** | パフォーマンス（遅延読み込み・画像圧縮） | Core Web Vitals 目安 |
| **6（Phase K-2）** | クロスブラウザ確認 | Safari / Chrome / Edge 等 |
| **7（納品）** | マニュアルの実キャプチャ差し替え・PDF 再出力 | K-3 |
| **8（本番）** | サーバーアップロード・動作確認 | スケジュールドキュメント参照 |

**Phase K 完了後**に新しい「Phase M」を切るより、**本番リリースチェックリスト**として上記 1〜8 を進める想定で問題ありません。

---

## データ連携・コンテンツ管理（検討事項）

| セクション | 想定データソース |
|-----------|------------------|
| お知らせ | 投稿 or カスタム投稿「お知らせ」 |
| Instagram | 埋め込み or 外部リンク or プラグイン |
| イタリア野菜プロジェクトについて | 固定ページ or カスタムフィールド |
| イタリア野菜とは | front-page.php の $vegetables_data（image キーで assets/images 紐づけ） or カスタム投稿 |
| 生産者紹介 | front-page.php の $producers_data（image キーで assets/images 紐づけ） or カスタム投稿「生産者」 |
| サポーター紹介 | front-page.php の $supporters_data（image キーで assets/images 紐づけ） or カスタム投稿 |
| 実績紹介 | カスタム投稿「実績」 or 固定ページ |
| お問い合わせ | Contact Form 7 等プラグイン or カスタム |

※ 各 Phase 実装時にデータソースを確定し、必要に応じてカスタム投稿タイプ・ACF 等を導入

---

## ヘッダー実装メモ（技術）

- **ページ判定**: `is_front_page()` で TOP / 下層を判定。body に `home` や `page-template-front-page` 等のクラスを活用
- **スクロール検知**: JS で scroll イベントを監視し、閾値 800px 超過で固定ヘッダーに `.is-scrolled` 付与。800px 未満で `.is-sliding-out` を付与しスライドアウト、animationend でクラス削除
- **スライドイン/アウト**: キーフレーム headerSlideIn（-100%→0）、headerSlideOut（0→-100%）。0.8s ease。`position: fixed` で画面上部に固定
- **スムーズスクロール**: html に `scroll-behavior: smooth`、`scroll-padding-top: 80px`（PC）/ 60px（スマホ）でアンカーリンク時のオフセット

---

## 進捗管理・更新履歴

- **2025/03/03**: 初版作成。TOPページデザインに基づき Phase A〜H の TODO を定義。
- **2025/03/03**: Phase A 完了。テーマ yakage-italy-veg 作成（style.css, functions.php, index.php, front-page.php, header.php, footer.php）。CSS 変数・共通スタイル・ボタン・ヘッダー/フッター基盤を実装。
- **2025/03/03**: Phase B 完了。ヘッダー（TOP 初回/スクロール時/下層の使い分け）、ヒーローセクション、フッター。スマホ用ハンバーガー・ドロワー。assets/js/header.js でスクロール検知・ドロワー開閉。SCSS: _hero.scss 追加。
- **2025/03/05**: フッターを仕上がりイメージに合わせて更新。左（シール＋プロジェクト名）、中央（TOP｜サイトポリシー｜プライバシーポリシー、著作権）、右（ページトップへスクロールボタン）。配色・3カラムレイアウト・スクロールトップ機能を実装。フォントは Zen Maru Gothic を採用済み。
- **2025/03/05**: セクション順を変更。お知らせ → Instagram → イタリア野菜プロジェクトについて → イタリア野菜とは → 生産者紹介 → サポーター紹介 → 実績紹介 → お問い合わせ。Phase C〜K に合わせて TODO・フェーズを再整理。
- **2025/03/06**: Phase C 完了。お知らせセクションを投稿で管理。カテゴリ 4 種（お知らせ・イベント・レシピ・PICKUP）。PICKUP をスライダー、他を 3 列グリッド。NEW タグ（7日以内）、もっと見るでアーカイブへ。SCSS: _news.scss、JS: news-slider.js。
- **2025/03/06**: Phase C を仕上がりイメージに合わせてレイアウト・スタイル調整。PICKUP は赤枠・深緑丸矢印・赤ドット・ラベルかぶせ。グリッドは緑枠・カテゴリピル（白文字）・NEW はメタ行のみ。もっと見るは緑角丸ボタン・枠線・シャドウ。日付｜カテゴリ表示を共通化。
- **2025/03/07**: Phase D 完了。Instagram セクションを実装イメージに合わせて実装。Smash Balloon プラグイン（ショートコード feed=1）、公式 Instagram ヘッダー・破線・4 列グリッド・follow us ボタン・3 ブロックリンク。カスタマイザーで Instagram URL と 3 ブロックの URL を設定可能。SCSS: _instagram.scss。プラグイン用 DB テーブル（wp_sbi_feeds 等）は db/sbi_tables_create.sql で作成。
- **2025/03/02**: Phase G 完了。生産者紹介をループスライダーで実装。6名ダミー（画像・キャッチコピー・名前・補足）、PC 4枚/タブレット 3枚/スマホ 1枚表示、赤丸矢印・ドット、SCSS: _producers.scss、JS: producers-slider.js。
- **2025/03/09**: Phase H・I・J 完了。サポーター紹介（9名グリッド・円形写真＋赤吹き出し）、実績紹介（3ブロック・白エリア max-width:900px）、お問い合わせ（完成イメージに合わせたフォーム・同意チェック・送信ボタン）。ヘッダー：ロゴを logo.png に差し替え・絶対配置・最初から白背景、ナビの文字間・ホバー時赤文字＋ライムグリーン下線（--color-green-lime を変数化）。開発環境：Browsersync＋concurrently で npm run dev、WP_DEBUG 時はスタイルバージョンに time() でリロード時確実に最新 CSS。テーマ画像用 assets/images/ 作成。
- **2025/03/10**: ヒーローを8枚スライダーに変更（hero-1～8.jpg、クロスフェード・約5秒で拡大アニメ・自動送り・ドット・ホバーで一時停止）。ヘッダーロゴ画像サイズを PC で height: 200px / max-width: 300px に変更。
- **2025/03/11**: セクション背景を変数化（--section-*）、--color-red を #f70801 に変更。お知らせ: 背景 #009145＋bg_layveg01.png contain・opacity 0.2。Instagram: 白＋bg_layveg02.png cover・0.15。プロジェクト: グラデーション＋線画を gradation_wrap に集約、ヒーローに bg_layveg03.jpg・logo_wht.png、hero-copy 3vw。イタリア野菜とは: パディングを content に、グリッド右端いっぱい・4:6・wrap_content・カード非正方形・ご注文ボタン 999px/#fa0000。生産者: 白背景・l-container 幅いっぱい・カードシャドウ削除・gap 広め・上部ボーダーを .c-border-line-top で共通化（CSS のみ）。サポーター: ドットパターン（#f70801、22px 40px）。実績: bg_layveg01.png 透過・top・contain。
- **2026/03/02**: お問い合わせタイトルを文字幅＋左右6em・padding-bottom 1em・letter-spacing 0.1em に。c-border-line-bottom の #fff を transparent に。イタリア野菜とはタイトルは c-border-line-bottom で中央寄せ・下余白1em、ご注文ボタン中央配置。お知らせ: タイトル左右に赤・白縦二重線（::before/::after）、PICKUP トラック幅＝グリッド・矢印は外側 absolute、カードタイトル 26px。--color-green を #009145 に。Instagram: 関連リンクをバナー画像3枚（bnr_yakage・bnr_youtube・bnr_okoshi）に変更、表示順・gap 24px、タイトル文字サイズ統一。プロジェクト: 本文画像を img_about-01/02/03 に差し替え、見出しに赤・緑ライム縦二重線（::before）、コロナ禍ブロックは .p-project__text--full で幅100%、YouTube デフォルト yhibkOmCXow・start=4、SPECIAL movie を .p-project__block--video で白背景・角丸30px・padding 30px
- **2026/03（生産者紹介）**: 生産者データに `image` キーを追加し画像紐づけ（img_frmr_01〜05.jpg）。キャッチコピー改行は white-space: pre-line。PC 表示枚数を 4→3 に変更（トラック幅 400%）。producers-slider.js の LOGICAL_COUNT を動的（cards.length）にし、5件でもスライダー動作。変数 --font-size-xl / --font-size-2xl を追加。
- **2026/03（イタリア野菜とは）**: `$vegetables_data` に `image` キーを追加。各野菜（9種）に `'image' => ''` を追加。画像ファイル名を指定すると assets/images の画像を表示、空ならプレースホルダー。テンプレートで `!empty($veg['image'])` により img/placeholder を出し分け。
- **2026/03（サポーター紹介）**: ヘッダーバナーをリボン型に変更。clip-path 削除、左右に span で横V（c-scroll-top::before と同様の border+transform）。カードを完成イメージ準拠に変更（円形写真が赤バナー左端に重なる、右端に clip-path で横Vカット、左三角・右矢印を削除）。`$supporters_data` に `image` キーを追加し画像紐づけ。
- **2026/03/12（ヘッダー・メニュー・ナビ等）**: お知らせスラッグ otoshirase→news。メニューを TOP・プロジェクトについて・イタリア野菜とは・生産者紹介・サポーター紹介・お問い合わせに変更（アンカーリンク＋スムーズスクロール）。scroll-padding-top でオフセット。ヘッダー max-width 96%、ナビ gap 15px・letter-spacing 0.01em。スライドイン着火 800px、スライドイン/アウトアニメーション（0.8s）。ロゴ切り替え（logo_sub.png をスライドイン時・下層ページで使用）。ページトップボタン 700px でフェードイン。
- **2026/03/12（下層ページ・アーカイブ）**: page.php・home.php・archive.php・single.php を作成。_page.scss でスタイル定義。get_the_archive_title フィルターでアーカイブタイトルプレフィックス削除。.l-header__logo-img から vertical-align を削除（display: block では無効のため）。
- **2026/03/12（固定ページ・フッター）**: c-border-line-left を _components.scss に追加（p-project__heading::before と同様の赤・ライムグリーン縦二重線）。page.php のタイトルに適用。フッターのサイトポリシー・プライバシーポリシーを /site-policy/・/privacy-policy/ にリンク更新。
- **2026/03/12（PICKUP スライダー）**: 1枚表示（p-news__pickup-viewport 追加）、aspect-ratio 4/3、自動再生（5秒）・ループ・ホバー時一時停止、常に右→左スライド（先頭クローンを末尾に追加、transitionend でリセット）。news-slider.js・front-page.php・_news.scss を更新。
- **2026/03/18（Contact Form 7 対応）**: お問い合わせフォームを Contact Form 7 のショートコード呼び出しに変更。functions.php に `wpcf7_autop_or_not` フィルター追加（自動 `<p>` タグ無効化）。_contact.scss に CF7 用スタイル追加（.wpcf7-form-control, .wpcf7-submit, バリデーションエラー, 送信結果メッセージ等）。devnotes/contact-form-7-template.md を作成（管理画面貼り付け用フォームテンプレート・メール設定）。
- **2026/03/18（レスポンシブ・ヘッダー）**: ハンバーガーメニューの色を赤（var(--color-red)）に変更、間隔・幅を調整（gap: 7px, width: 30px, height: 3px, ボタン 48px）。ドロワーに閉じるボタン（×）を追加（.c-close-btn、2本のバーを 45°/-45° で交差）。スマホ表示時（767px 以下）に TOP ページでもサブロゴ（logo_sub.png）を表示。スマホ時のロゴエリア（.l-header__logo）幅 50%・top: 4px、サブロゴ height: auto。
- **2026/03/18（レスポンシブ・各セクション）**: ヒーロー高さを 60vh に変更、ヒーロー下にスマホ用ロゴセクション追加（.p-hero-logo、赤背景 #e60013 + logo.png センター配置、PC 非表示）。プロジェクト: .p-project__block--video のスマホ時 padding: 15px / border-radius: 20px、.p-project__hero-copy のスマホ時 font-size: 4vw。イタリア野菜とは: 野菜データを 19 種に拡張し、shuffle + array_slice で 12 枚をランダム表示。お問い合わせ: スマホ時 .p-contact__field label を flex: 0 0 0 に調整（CF7 対応含む）。
- **2026/03/22（Phase K・次フェーズの整理）**: K-1 にブレークポイント整理・PICKUP ラベル・生産者スライダー/キャッチ折り返しを完了チェック。K-3「納品・クライアント向けドキュメント」を追加（マニュアル初稿・PDF 済）。**「次のフェーズ」** 節を追加（Phase K 残タスク → 本番テストアップの順序表）。
- **2026/03/22（クライアントマニュアル・納品ドキュメント）**: WordPress 簡易操作マニュアル初稿（`202603221932-client-wordpress-manual-draft-v1.md`）、SVG ダミーキャプチャ10点、**Pandoc + Chrome headless** で PDF 生成（`npm run manual:pdf`）。詳細: devnotes/202603221956-current-status-record.md
- **2026/03/22（お知らせ・生産者 UI）**: PICKUP ラベル（`.p-news__pickup-label`）に上部 V 字欠け（clip-path）。生産者スライダー表示枚数を PC3・タブレット2・スマホ1 に変更。キャッチコピーはスマホで改行畳み（`white-space: normal`）。
- **2026/03/22（ドキュメント・実装計画の反映）**: 現状記録（202503021800-current-status.md）と本計画書に、Instagram フィード（Smash Balloon）テーマ CSS・CF7 スピナー表示制御を追記。集約メモ: devnotes/202603221856-implementation-plan-and-status-update.md
- **2026/03/22（現状スナップショット・手動調整反映）**:
  - **野菜**: `front-page.php` の `$vegetables_data` を **野菜リスト.xlsx**（`Documents/2026_矢掛町イタリア野菜プロジェクト/配置画像/野菜リスト.xlsx`）から反映した **20 件**。画像はテーマ内 `assets/images/img_veg_01.png`〜`img_veg_20.png`（全ファイル配置済み）。芽キャベツ・コーララビの紹介文は Excel 上プレースホルダ（＊）のまま。
  - **イタリア野菜の魅力**: 見出し・本文コピーを手動更新済み。
  - **プロジェクト**: 本文ブロック・SPECIAL movie・ヒーロー下部のキャッチ「人をつなぐ、イタリア野菜でありたい。」、ロゴ alt「矢掛町 おもてなしの町」等を手動調整。`gradation_wrap` / `l-container` / `p-project__hero` の閉じタグ整合を確認・インデント修正。
  - **生産者**: 6 名（`img_frmr_01.jpg`〜`06.jpg`）。6 人目「佐野禎夫」氏（ズッキーニ生産者）を追加。`producers-slider.js` は枚数動的のまま。
  - **サポーター**: 10 名分の氏名・所属・`img_spt_01.jpg`〜`10.jpg` を手動更新。
  - **実績**: 各ブロックの見出し・本文を手動更新（万博・テーブル CROSS・大使館パーティ）。画像は `img_archive_01〜03.jpg`。
  - **お問い合わせ**: Contact Form 7 ショートコード例 `id="18b5500"`（環境ごとに要差し替え）。
  - **お問い合わせ（スピナー）**: `.wpcf7-spinner` は待機中 `display: none`、`.wpcf7-form.submitting` 時のみ表示（_contact.scss）。送信ボタンの中央寄せずれを解消。**確認済み**。
  - **Instagram フィード**: Smash Balloon ショートコード出力をテーマ `_instagram.scss` で調整（`#sbi_images` グリッド、4:5、プラグインヘッダー／`#sbi_load` 非表示等）。**表示確認済み** → devnotes/202603221851-instagram-smash-balloon-feed-style-record.md
  - **レスポンシブ**: 野菜グリッド **max-width: 480px で 1 列** に変更済み。
- **2026/03/25（Phase F・Instagram・実装計画整合）**:
  - **Phase F**: 上記 F-1・K-1 のとおり、**20 件 shuffle 全件表示**、**1024 / 768–1023 / 767 / 480** のグリッド分岐、左列レイアウト・sticky 対象を **`.wrap_content`** に限定、オーバーレイ **padding 8px**。
  - **Instagram**: `[instagram-feed feed=1]` のテーマ側出力箇所を **`front-page.php`（Instagram ブロック内・`do_shortcode`）** と明記。実装位置の確認を記録（devnotes/202603251500-current-status-record.md）。
  - **現状記録**: devnotes/202503021800-current-status.md を同日内容で更新済み。

---

## 関連ドキュメント

- devnotes/202503031000-schedule-to-production-test.md（**3/11 本番テストアップ スケジュール・TODO**）
- devnotes/202503021430-dev-env-and-implementation-plan.md（全体実装計画）
- devnotes/202503021800-current-status.md（現状記録）
- devnotes/202603121148-sub-page-archive-implementation-plan.md（下層ページ・アーカイブページ実装計画）
- devnotes/202603221851-instagram-smash-balloon-feed-style-record.md（Instagram / Smash Balloon フィードのテーマ CSS 記録）
- devnotes/202603221856-implementation-plan-and-status-update.md（実装計画・現状記録の一括更新メモ）
- devnotes/202603221932-client-wordpress-manual-draft-v1.md（クライアント向け WordPress 簡易マニュアル初稿）／同 PDF・`manual-captures-placeholder/`・`npm run manual:pdf`
- devnotes/202603221956-current-status-record.md（2026/03/22 後半の現状メモ）
- devnotes/202603251500-current-status-record.md（2026/03/25: Phase F レスポンシブ・sticky・Instagram 実装位置のスナップショット）
