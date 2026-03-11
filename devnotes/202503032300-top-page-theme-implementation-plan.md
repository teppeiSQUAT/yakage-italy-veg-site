# TOPページ テーマ実装計画書

- **作成日**: 2025年3月3日
- **最終更新**: 2026年3月2日
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
| **Phase D** | Instagramセクション | **完了** |
| **Phase E** | イタリア野菜プロジェクトについて | **完了** |
| **Phase F** | イタリア野菜とは | **完了** |
| **Phase G** | 生産者紹介 | **完了** |
| **Phase H** | サポーター紹介 | **完了** |
| **Phase I** | 実績紹介 | **完了** |
| **Phase J** | お問い合わせ | **完了** |
| **Phase K** | レスポンシブ・仕上げ | 未着手 |

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
- [x] ヘッダーコンテナ（.l-header__container）の max-width: 90%
- [x] ナビゲーションメニュー（横並び・右寄せ、文字間・メニュー間を調整）
- [x] TOP 時も**最初から白背景**（スクロール前後で統一）。コンテナ・inner に白背景指定
- [x] TOP スクロール時：固定表示に切り替え（header.js で .is-scrolled 付与）
- [x] ナビホバー・現在ページ：赤文字＋ライムグリーン下線（`--color-green-lime`）。.current-menu-item にも同スタイル
- [x] 下層ページ：固定ヘッダー（.l-header--sub）

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
- [x] 右：ページトップへスクロール用ボタン（半円かまぼこ型・下端固定・CSS 三角矢印、シャドウなし）
- [x] レイアウト：3カラム grid（左・中央・右）、スマホ時は縦並び

---

# Phase C: お知らせセクション

**目的**: お知らせ（ニュース）セクションを実装する。ヒーローの次に表示。投稿＋カテゴリ（お知らせ・イベント・レシピ・PICKUP）で管理。

## C-1. お知らせ

- [x] セクション構成・背景（#009145、bg_layveg01.png 上部 contain・opacity 0.2・mix-blend-mode: lighten）
- [x] セクションタイトル「お知らせ」＋左右に赤・白縦二重線（::before/::after、幅11px・高さ1.5em）、文字サイズは他セクションタイトルと統一（clamp）
- [x] PICKUP トラック幅をグリッドと同一にし、前へ・次へボタンはトラック外側に absolute 配置
- [x] PICKUP カード内タイトル（.p-news__pickup-card-body .p-news__card-title）font-size: 26px
- [x] カテゴリ 4 種登録（お知らせ・イベント・レシピ・PICKUP）
- [x] PICKUP: 先頭でスライダー表示（前後矢印・ドット、ループ）、カード内に日付・カテゴリ・タイトル・抜粋・NEW タグ（7日以内）
- [x] それ以外: お知らせ・イベント・レシピを新着順で 6 件グリッド（3列）、サムネイル・日付・カテゴリタグ・タイトル・抜粋・NEW タグ
- [x] 「もっと見る」ボタンでアーカイブ（投稿ページ or お知らせカテゴリ）へ

---

# Phase D: Instagramセクション

**目的**: Instagram フィードを表示するセクションを実装する。Smash Balloon Social Photo Feed プラグインを使用。

## D-1. Instagram

- [x] セクション構成・背景（白＋薄い野菜パターン）
- [x] セクションタイトル「公式 Instagram」＋Instagram ロゴ（SVG）＋赤・緑の破線装飾
- [x] プラグインショートコード `[instagram-feed feed=1]` で埋め込み、4 列グリッド（スマホ 2 列）
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

- [x] セクション構成・背景（白）。コンテンツ:グリッド＝4:6、グリッドは右端いっぱい
- [x] セクションタイトル「イタリア野菜とは」＋c-border-line-bottom（中央寄せ・padding-bottom 1em）
- [x] 左: 説明テキスト・「ご注文はこちら」ボタン中央配置（border-radius: 999px・#fa0000、カスタマイザーで URL 変更可）
- [x] 右: 野菜画像グリッド（9種・読み込み時ランダム順）。オーバーレイ内に .wrap_card（白背景・角丸15px・margin/padding 15px・テキスト中央）。ホバー/タップでオーバーレイ表示（名称・特徴・オススメ時期）
- [x] PC 3行3列 / スマホ 3行2列、vegetables.js でタップ開閉

---

# Phase G: 生産者紹介

**目的**: 生産者（農家）紹介セクションをループスライダーで実装する。

## G-1. 生産者紹介

- [x] セクション構成・背景（オフホワイト）
- [x] セクションタイトル「生産者紹介」＋赤・緑破線
- [x] 1ブロック＝画像（角丸）・キャッチコピー（赤・太字）・名前（〇〇さん）・補足情報
- [x] 6名のダミーデータでループスライダー（矢印・ドット）、PC で 3〜4名表示・スマホで 1名表示
- [x] SCSS: _producers.scss、JS: producers-slider.js（--producers-current で位置制御）

---

# Phase H: サポーター紹介

**目的**: サポーター（協力企業・支援者等）紹介セクションを実装する。

## H-1. サポーター紹介

- [x] セクション構成・背景（オフホワイト＋白ドットパターン）
- [x] ヘッダーバナー（白・赤破線枠）、タイトル「サポーター紹介」＋縦線＋キャッチコピー
- [x] 9名グリッド（3列、スマホ2列）。1ブロック＝円形顔写真（赤枠）＋赤吹き出し（名前・所属）
- [x] SCSS: _supporters.scss

---

# Phase I: 実績紹介

**目的**: 実績・活動報告等のセクションを実装する。

## I-1. 実績紹介

- [x] セクション構成（赤背景＋野菜ラインアート）、キャッチコピー
- [x] 白エリア（p-achievements__inner: max-width: 900px 中央配置）内に3ブロック
- [x] 各ブロック：白背景・角丸・シャドウ、タイトル・説明文・写真コラージュ（6枚／3枚）。ブロック間 margin-bottom: 48px
- [x] SCSS: _achievements.scss

---

# Phase J: お問い合わせ

**目的**: お問い合わせフォームセクションを実装する。

## J-1. お問い合わせ

- [x] セクション構成・背景（白）。タイトル「お問い合わせ」＋c-border-line-bottom（文字幅＋左右6em・padding-bottom 1em・letter-spacing 0.1em）。c-border-line-bottom の線間は transparent
- [x] フォームコンテナ（.p-contact__form-wrap）：背景 #f8f3ed・max-width 900px・角丸・シャドウなし。お名前・所属・メール・TEL・内容、ラベル左・入力右。個人情報同意チェック、「送信」緑ボタン
- [x] 注意文「※担当者より内容確認次第、返信させていただきます。」
- [x] SCSS: _contact.scss。送信処理は Contact Form 7 等で後続対応予定

---

# Phase K: レスポンシブ・仕上げ

**目的**: レスポンシブ対応と全体の仕上げを行う。

## K-1. レスポンシブ対応

- [ ] ブレークポイント定義（PC / タブレット / スマホ）
- [ ] 各セクションのグリッド・レイアウト調整
- [ ] 画像・フォントサイズの最適化
- [ ] タッチ操作対応（スライダー等）

## K-2. 仕上げ

- [ ] スライダー・カルーセルの JS 実装（必要箇所）
- [ ] アクセシビリティ（フォーカス、aria 属性）
- [ ] パフォーマンス（画像最適化、遅延読み込み）
- [ ] クロスブラウザ確認

---

## データ連携・コンテンツ管理（検討事項）

| セクション | 想定データソース |
|-----------|------------------|
| お知らせ | 投稿 or カスタム投稿「お知らせ」 |
| Instagram | 埋め込み or 外部リンク or プラグイン |
| イタリア野菜プロジェクトについて | 固定ページ or カスタムフィールド |
| イタリア野菜とは | 固定ページ or カスタム投稿 |
| 生産者紹介 | カスタム投稿「生産者」 |
| サポーター紹介 | カスタム投稿 or 固定データ |
| 実績紹介 | カスタム投稿「実績」 or 固定ページ |
| お問い合わせ | Contact Form 7 等プラグイン or カスタム |

※ 各 Phase 実装時にデータソースを確定し、必要に応じてカスタム投稿タイプ・ACF 等を導入

---

## ヘッダー実装メモ（技術）

- **ページ判定**: `is_front_page()` で TOP / 下層を判定。body に `home` や `page-template-front-page` 等のクラスを活用
- **スクロール検知**: JS で scroll イベントを監視し、閾値超過で固定ヘッダーにクラス付与（例: `.is-scrolled`）
- **スライドイン**: CSS `transform: translateY()` または `top` でアニメーション。`position: fixed` で画面上部に固定

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
- **2026/03/02**: お問い合わせタイトルを文字幅＋左右6em・padding-bottom 1em・letter-spacing 0.1em に。c-border-line-bottom の #fff を transparent に。イタリア野菜とはタイトルは c-border-line-bottom で中央寄せ・下余白1em、ご注文ボタン中央配置。お知らせ: タイトル左右に赤・白縦二重線（::before/::after）、PICKUP トラック幅＝グリッド・矢印は外側 absolute、カードタイトル 26px。--color-green を #009145 に。Instagram: 関連リンクをバナー画像3枚（bnr_yakage・bnr_youtube・bnr_okoshi）に変更、表示順・gap 24px、タイトル文字サイズ統一。プロジェクト: 本文画像を img_about-01/02/03 に差し替え、見出しに赤・緑ライム縦二重線（::before）、コロナ禍ブロックは .p-project__text--full で幅100%、YouTube デフォルト yhibkOmCXow・start=4、SPECIAL movie を .p-project__block--video で白背景・角丸30px・padding 30px・シャドウ、見出しは左線なし・文字赤・右に赤線（::after）、hero-copy を 2vw・letter-spacing 1px。ヘッダー: .l-header__container に max-width 90%。フッター: 背景 #e5e5e5、シールを logo_gry.png、スクロールトップを半円・CSS 三角。イタリア野菜カード: .wrap_card を追加（白背景・角丸15px・margin/padding 15px・テキスト中央）。

---

## 関連ドキュメント

- devnotes/202503031000-schedule-to-production-test.md（**3/11 本番テストアップ スケジュール・TODO**）
- devnotes/202503021430-dev-env-and-implementation-plan.md（全体実装計画）
- devnotes/202503021800-current-status.md（現状記録）
