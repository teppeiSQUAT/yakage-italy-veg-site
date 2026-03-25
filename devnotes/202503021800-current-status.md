# プロジェクト現状記録

- **記録日**: 2026年3月25日（最終追記: Phase F 現状・Instagram 実装位置の記録）
- **プロジェクト**: 矢掛町イタリア野菜プロジェクト 公式サイト（yakage-italy-veg-site）
- **スケジュール**: **2025年3月11日（火）本番サーバーへテストアップ予定** → devnotes/202503031000-schedule-to-production-test.md

---
## 1. 全体進捗

| フェーズ | 内容 | 状態 |
|---------|------|------|
| **フェーズ0** | 開発環境・2台運用基盤構築 | **進行中（本マシンほぼ完了）** |
| **テーマ Phase A〜B** | テーマ基盤・ヘッダー・ヒーロー・フッター | **完了** |
| **テーマ Phase C〜J** | お知らせ→Instagram→プロジェクト→イタリア野菜とは→生産者→サポーター→実績→お問い合わせ | **完了** |
| **テーマ Phase K** | レスポンシブ・仕上げ | **進行中**（主要レスポンシブ・納品マニュアル PDF まで反映。残: 全体微調整・A11y・性能・本番確認）→ 実装計画書「次のフェーズ」節参照 |
| **テーマ Phase L** | 下層ページ・アーカイブ（page/home/archive/single） | **完了** |
| **本番テストアップ** | さくらサーバーへアップロード・確認 | **目標 3/11** |
| フェーズ1〜8 | キックオフ 〜 リリース | 未着手／随時 |

### 直近の反映（2026/03/22 TOP・画像・構成）

- **野菜データ**: `front-page.php` の `$vegetables_data` を **野菜リスト.xlsx**（`Documents/2026_矢掛町イタリア野菜プロジェクト/配置画像/`）に合わせ **20 件**。画像 `img_veg_01.png`〜`20.png` をテーマ `assets/images/` に揃え済み。**`shuffle` 後に 20 件すべて出力**（表示列数・枚数はブレークポイントで制御）。芽キャベツ・コーララビの紹介文は Excel プレースホルダのまま。
- **イタリア野菜セクション**: 見出し「イタリア野菜の魅力」、本文はイタリア産野菜の特徴・矢掛の取り組みの長文に手動更新。
- **プロジェクト**: 各ブロック本文・SPECIAL movie・下部ヒーロー「人をつなぐ、イタリア野菜でありたい。」・ロゴ alt 等を手動更新。`gradation_wrap` 閉じタグのインデント整理。
- **生産者**: **6 名**（`img_frmr_01.jpg`〜`06.jpg`、6 人目 佐野禎夫氏）。
- **サポーター**: **10 名**の氏名・所属・`img_spt_01.jpg`〜`10.jpg` を手動更新。
- **実績**: 万博・テーブル CROSS・大使館パーティの見出し・本文を手動更新。
- **お問い合わせ**: CF7 ショートコード `id="18b5500"`（環境依存）。
- **レスポンシブ（Phase F グリッド）**: **≥1024px** 4 列／**768–1023px** 3 列／**≤767px** 2 列／**≤480px** 1 列で先頭 10 枚のみ（`_vegetables.scss`）。内側カラム比・sticky は同ファイル参照。
- **詳細**: devnotes/202503032300-top-page-theme-implementation-plan.md の「2026/03/22（現状スナップショット）」を参照。

### 直近の反映（2026/03/25 Phase F・Instagram）

- **Instagram**: `[instagram-feed feed=1]` の**テーマ上の指定箇所を確認済み** → `front-page.php` **215 行付近** `do_shortcode( '[instagram-feed feed=1]' )`（`.p-instagram` 内）。
- **Phase F**: 左カラム **≥1024** `3.5fr/6.5fr`、**768–1023** `4fr/6fr`、**≤767** 1 列。`.wrap_content` のみ **≥768** で sticky（`box-shadow` なし）。オーバーレイ `padding: 8px`。
- **詳細スナップショット**: devnotes/202603251500-current-status-record.md

### 直近の反映（2026/03/22 Instagram・Smash Balloon フィード）

- **状態**: TOP の Instagram ブロック（`[instagram-feed feed=1]`）について、**テーマ側スタイルでの表示を確認済み**。
- **実装**: `scss/_instagram.scss` で `#sb_instagram` を縦積み、`#sbi_images` のみグリッド（PC 4列・767px 以下 2列）、`.sbi_photo` のインライン高さを上書き、タイルは **4:5**。プラグインの `.sb_instagram_header` と `#sbi_load`（フォローボタン）は非表示（テーマの見出し・`.p-instagram__follow-btn` と重複回避）。
- **詳細**: devnotes/202603221851-instagram-smash-balloon-feed-style-record.md

### 直近の反映（2026/03/22 お問い合わせ・Contact Form 7 スピナー）

- **課題**: `.wpcf7-spinner` が `display: inline-block` のまま DOM に残り、送信ボタンと並んだブロックとして **中央寄せ（`.p-contact__submit` の text-align）が視覚的にずれる**。
- **対応**: `scss/_contact.scss` で待機中は `.wpcf7-spinner` を **`display: none`**。送信中は CF7 が付与する **`form.wpcf7-form.submitting`** のときだけ **`display: inline-block`**＋左マージンでスピナーを表示。**表示確認済み**。
- **ドキュメント**: 実装計画・現状の一括反映は devnotes/202603221856-implementation-plan-and-status-update.md

### 直近の反映（2026/03/22 クライアント向けマニュアル・Pandoc・PDF）

- **マニュアル初稿**: `devnotes/202603221932-client-wordpress-manual-draft-v1.md`（WordPress 初心者向け操作説明・カテゴリー運用・CF7 / Instagram 注意事項等）。
- **ダミーキャプチャ**: `devnotes/manual-captures-placeholder/` に SVG 10 点を配置し本文から参照。
- **PDF**: `devnotes/202603221932-client-wordpress-manual-draft-v1.pdf`。**Pandoc**（`--embed-resources`）→ **Chrome headless**（`--print-to-pdf`）で生成。再生成は `npm run manual:pdf` または `bash scripts/build-client-manual-pdf.sh`。
- **Pandoc**: 本機に Homebrew で導入済み（`pandoc --version` で確認）。
- **詳細**: devnotes/202603221956-current-status-record.md

### 直近の反映（2026/03/22 テーマ UI 微修正）

- **PICKUP ラベル**: `.p-news__pickup-label` を上部三角欠け風に調整（`clip-path`、`_news.scss`）。
- **生産者スライダー**: **1024px以上 3枚 / 768–1023px 2枚 / 767px以下 1枚**（`_producers.scss` のトラック幅）。
- **生産者キャッチコピー**: スマホで改行を畳んで折り返し（`767px` 以下 `white-space: normal`）。

### 直近の反映（2026/03/12 PICKUP スライダー）

- **1枚表示**: `.p-news__pickup-viewport` を追加し、表示を1枚に制限。front-page.php にビューポートラッパーを追加、_news.scss で flex: 1 1 0・min-width: 0・overflow: hidden を指定。
- **aspect-ratio**: `.p-news__pickup-card-image` に `aspect-ratio: 4 / 3` を追加（_news.scss）。スマホ時は 16/10 のまま。
- **自動再生・ループ**: news-slider.js で 5秒間隔の自動再生、ホバー時一時停止、手動操作でタイマーリセットを実装。
- **常に右→左スライド**: 先頭スライドのクローンを末尾に追加。最後→最初のループ時も右から左へスライド。transitionend で位置をリセットし、クローン表示後に即座に先頭へ戻す（見た目は途切れない）。

### 直近の反映（2026/03/12 news.php・もっと見る・ご注文はこちら）

- **news.php**: 固定ページテンプレート「NEWS（投稿一覧）」を作成。固定ページ「NEWS」にこのテンプレートを適用すると、投稿一覧を表示。ページネーション対応。固定ページはダッシュボードから手動で作成し、テンプレートを選択する。
- **もっと見るリンク**: `yakage_italy_veg_get_news_archive_url()` を変更。スラッグ `news` の固定ページを検索し、その URL（例: http://localhost:8082/news）を返す。ページ未作成時は `home_url('/news/')` をフォールバック。
- **ご注文はこちら**: リンク先を Google Forms（https://forms.gle/1hs63P1vK5d8qavN8）に設定。functions.php のカスタマイザー設定デフォルトと front-page.php のフォールバックを更新。

### 直近の反映（2026/03/12 ヘッダー・メニュー・ナビ等）

- **お知らせカテゴリ**: スラッグを `otoshirase` → `news` に変更。functions.php・front-page.php・_news.scss・style.css を更新。管理画面でのカテゴリ編集も必要。
- **メインメニュー（デフォルト）**: リンクを TOP・プロジェクトについて（#project）・イタリア野菜とは（#vegetables）・生産者紹介（#producers）・サポーター紹介（#supporters）・お問い合わせ（#contact）に変更。スムーズスクロール対応。
- **スムーズスクロール**: html に `scroll-behavior: smooth`、`scroll-padding-top: 80px`（PC）/ `60px`（スマホ）を追加。アンカーリンクでコンテンツがヘッダーに重ならないようオフセット。
- **ヘッダー**: `.l-header__container` の max-width を 90% → 96% に変更。
- **ナビスタイル**: `.c-nav-list a` の letter-spacing を 0.02em → 0.01em、`.c-nav-list` の gap を 32px → 15px に変更。
- **ヘッダースライドイン**: 着火閾値を 80px → 800px に変更。スライドイン速度を 0.6s、スライドアウトを 0.8s で上から下／下から上へアニメーション（headerSlideIn / headerSlideOut）。800px 未満で上へスライドアウト。
- **ロゴ切り替え**: スライドイン時・下層ページで `logo_sub.png` を使用。TOP 初回は `logo.png` のまま。header.php で両 img を配置、CSS で表示切り替え。
- **ページトップボタン**: 700px スクロールでフェードイン表示（opacity・visibility・pointer-events）。_footer.scss・header.js を更新。

### 直近の反映（2026/03/12 下層ページ・アーカイブ・CSS 修正）

- **下層ページ・アーカイブページ実装**: page.php（固定ページ）、home.php（投稿一覧）、archive.php（カテゴリ等アーカイブ）、single.php（単一投稿）を作成。scss/_page.scss でスタイル定義。実装計画は devnotes/202603121148-sub-page-archive-implementation-plan.md に記載。
- **アーカイブタイトル**: functions.php で get_the_archive_title フィルターを追加し、「カテゴリー:」等のプレフィックスを削除。
- **CSS 修正**: .l-header__logo-img から vertical-align: top を削除。display: block の要素では vertical-align が無効のため、lint エラー解消。

### 直近の反映（2026/03/12 固定ページ・フッター）

- **c-border-line-left**: _components.scss に追加。p-project__heading::before と同じスタイル（赤・ライムグリーン縦二重線）を ::before で実装。固定ページタイトル（page.php）に適用。
- **フッターリンク**: サイトポリシー → `/site-policy/`、プライバシーポリシー → `/privacy-policy/` に更新。固定ページのスラッグを site-policy / privacy-policy に設定するとリンク先となる。

### 直近の反映（サポーター紹介 追記）

- **サポーター紹介セクション**
  - **ヘッダーバナー**: リボン型。clip-path を削除し、左右に `<span class="p-supporters__header-v">` を配置。c-scroll-top::before と同様の border＋transform で横Vを表現（--left: border-right/bottom 0, rotate 45deg / --right: border-top/left 0, rotate -45deg）。
  - **カード**: 完成イメージ準拠。円形写真（80→100px、赤枠3→4px）が赤バナーの左端に重なる（margin-left: -40px）。赤バナー右端に clip-path で横Vカット。左三角・右矢印（::before/::after）を削除。
  - **カード画像紐づけ**: `$supporters_data` に `image` キーを追加。`!empty($s['image'])` で img/プレースホルダーを出し分け。9名それぞれに `'image' => ''` を追加済み。

- **イタリア野菜とは（カード画像紐づけ）**
  - **データ**: `$vegetables_data` に `image` キーを追加。`image` にファイル名を指定すると `assets/images/` の画像を表示、空ならプレースホルダー表示。9種の野菜それぞれに `'image' => ''` を追加済み。画像ファイルを配置後、ファイル名を指定すれば表示される。
  - **テンプレート**: カード画像部分を `!empty($veg['image'])` で分岐。画像ありなら `<img>`、なしなら従来のプレースホルダー（緑グラデーション＋「画像」）。_vegetables.scss の `.p-vegetables__card-image img` で object-fit: cover 等は既存のため変更なし。

- **生産者紹介セクション**
  - **データ**: `$producers_data` に `image` キーを追加。`image` にファイル名（例: `img_frmr_01.jpg`）を指定すると `assets/images/` の画像を表示、空なら従来のプレースホルダー表示。現在5名・各画像紐づけ済み。
  - **キャッチコピー改行**: `.p-producers__card-catch` に `white-space: pre-line` を追加し、テキスト内の改行を表示。
  - **スライダー表示枚数**: PC（1024px以上）で一度に表示する枚数を 4枚 → **3枚** に変更（`.p-producers__track` の width を 300% → 400%）。
  - **スライダー JS**: `producers-slider.js` で枚数を固定 6 から **動的**（`LOGICAL_COUNT = cards.length`）に変更。5件・6件どちらでも動作。`position === 6` 等のハードコードを `LOGICAL_COUNT` / `LOGICAL_COUNT - 1` に置き換え。
  - **カード画像**: `.p-producers__card-image` 内の `img` に width/height/object-fit を指定（_producers.scss）。
- **変数**: `_variables.scss` に `--font-size-xl: 20px`、`--font-size-2xl: 24px` を追加。`.p-producers__card-catch` で `--font-size-2xl` を利用。

### 直近の反映（3/2 時点・追記）

- **お問い合わせ**: タイトル（.p-contact__title.c-border-line-bottom）を文字幅＋左右6em・padding-bottom 1em・letter-spacing 0.1em に。c-border-line-bottom の背景 #fff を transparent に変更。
- **イタリア野菜とは**: タイトルに c-border-line-bottom 時は text-align: center・padding-bottom 1em。「ご注文はこちら」ボタンを中央配置。.p-vegetables__title の font-size を clamp(18px, 2.5vw, 28px) に変更済み。
- **お知らせ**: タイトル左右に赤・白の縦二重線（::before/::after）。赤3px→隙間5px→白3px、幅11px・高さ1.5em。文字サイズを .p-project__title と同様 clamp(18px, 2.5vw, 22px) に。PICKUP トラック幅をグリッドと揃え、前へ・次へボタンはトラック外側に absolute 配置。.p-news__pickup-card-body .p-news__card-title を font-size: 26px に。
- **変数**: --color-green を #009145 に変更。
- **Instagram**: 関連リンクをバナー画像（bnr_yakage.png・bnr_youtube.png・bnr_okoshi.png）に変更。表示順は左から「岡山県 矢掛町」「YouTube」「矢掛町地域おこし協力隊」。gap 24px。タイトル文字サイズを clamp(18px, 2.5vw, 22px) に統一。
- **イタリア野菜プロジェクト**: 本文3ブロックの画像を img_about-01.jpg（矢掛町の町並み）・img_about-02.jpg（イタリアチーム交流）・img_about-03.jpg（イタリア野菜）に差し替え。.p-project__heading に ::before で赤・緑ライム縦二重線を追加（.p-project__block--video 内は除く）。「コロナ禍の中…」ブロックの .p-project__text に .p-project__text--full を付与し幅100％・grid-column: 1 / -1。YouTube 埋め込みはデフォルト yhibkOmCXow・start=4。SPECIAL movie ブロックは .p-project__block--video に白背景・角丸30px・padding 30px・ドロップシャドウを適用（.p-project__body--video からは削除）。SPECIAL movie 見出しは左擬似要素なし・文字色赤・右側に ::after で赤線を右端まで伸ばす。.p-project__hero-copy は font-size: 2vw・letter-spacing: 1px。
- **ヘッダー**: .l-header__container に max-width: 90% を設定。
- **イタリア野菜とは（カード）**: オーバーレイ内に .wrap_card を追加。白背景・角丸15px・margin/padding 15px・テキスト中央寄せ。.wrap_card 内の .p-vegetables__card-desc は var(--color-text) で白背景上で可読に。

### 直近の反映（3/11 時点）

- **セクション背景の変数化**: _variables.scss に `--section-news-bg`〜`--section-contact-bg` を定義し、各セクションで参照。`--color-red` を **#f70801** に変更。
- **お知らせ**: 背景 #009145、`bg_layveg01.png` を上部・contain・opacity 0.2・mix-blend-mode: lighten。
- **Instagram**: 背景白、`bg_layveg02.png` を上部・cover・opacity 0.15。
- **イタリア野菜プロジェクト**: グラデーション（#efe3d7→#edf6fc）と野菜線画を `.gradation_wrap` 内のみに集約（ヒーロー手前で終了）。`bg_layveg01.png` は contain。下部ヒーローは `bg_layveg03.jpg`・cover・上部基準。ロゴは `logo_wht.png`（240px）、hero-copy は font-size: 3vw、hero の margin-top 削除。
- **イタリア野菜とは**: セクションのパディングを `.p-vegetables__content` に移動。グリッドは l-container 外で右端いっぱい。コンテンツ:グリッド＝4:6。`.wrap_content` で中央配置・max-width 80%。カードは非正方形（grid-auto-rows: minmax(240px,1fr)）。「ご注文はこちら」は border-radius: 999px・background #fa0000。
- **生産者紹介**: 背景白。`.p-producers .l-container` は max-width: none・width: 100%。カードの box-shadow 削除、カード間 gap を 16/20/24px に拡大。上部ボーダーは CSS の repeating-linear-gradient で赤・白／緑・白（高さ 4px、幅 20px、ズレ 20px）を **.c-border-line-top** として _components.scss に共通化。他セクションでも class 追加で利用可。
- **サポーター紹介**: 背景をドットパターンに変更（background-color: #ffffff、radial-gradient で #f70801 2px、background-size: 22px 40px、background-position: 0 0, 11px 22px）。
- **実績紹介**: 背景色はそのまま。`bg_layveg01.png` を透過（mix-blend-mode: lighten・opacity 0.2）で top 基準・contain 配置。従来の SVG パターンは削除。

### 直近の反映（3/10 時点）

- **ヒーローセクション**: テーマ内 `assets/images/hero-1.jpg`～`hero-8.jpg` の8枚をスライダーで表示。表示エリアは 100vw×90vh、min-height: 80vh。画像は object-fit: cover で幅いっぱい。フェードイン・フェードアウトは**クロスフェード**（z-index で表示中を手前、opacity 0.6s で重なりながら切り替え）。表示中は約5秒かけてゆっくり拡大（scale 1→1.08）するアニメーション。5秒ごとに自動送り、ドットクリックで該当スライドへ。ヒーローにマウスを乗せると自動送り一時停止。JS: hero-slider.js、SCSS: _hero.scss。
- **ヘッダーロゴ**: `.l-header__logo-img` を height: 200px、max-width: 300px に変更（スマホ時は従来どおり 72px / 160px）。

### 直近の反映（3/9 時点）

- **ヘッダー**: ロゴを `assets/images/logo.png` に差し替え。絶対配置で白背景の高さに依存せず左下方向にはみ出して表示。TOP 時も**最初から白背景**（スクロール前後で統一）。ナビは文字間・メニュー間を調整（gap: 32px、letter-spacing: 0.02em）。ホバー・現在ページ時は赤文字＋ライムグリーン下線（`--color-green-lime: #9edb09` を変数化）。コンテナに白背景を指定。
- **開発環境**: SCSS 自動ビルド＋ブラウザ自動リロードのため Browsersync と concurrently を導入（`npm run dev` で sass:watch と browser-sync を同時実行）。スタイル確認でリロードしても反映されない問題に対し、WP_DEBUG 時はスタイルバージョンに `time()` を使用するよう functions.php を変更。devnotes/202503091000-theme-dev-watch-and-reload.md に手順を記載。
- **Phase H サポーター紹介**: 9名グリッド、1ブロック＝円形顔写真＋赤吹き出し（名前・所属）。オフホワイト背景・白ドットパターン。SCSS: _supporters.scss。
- **Phase I 実績紹介**: キャッチコピー＋白エリア内に3ブロック（タイトル・文・写真コラージュ）。ブロックは白背景・角丸・シャドウ。p-achievements__inner は max-width: 900px で中央配置。SCSS: _achievements.scss。
- **Phase J お問い合わせ**: 完成イメージに合わせてタイトル＋破線、ラベル左・入力右のフォーム（お名前・所属・メール・TEL・内容）、個人情報同意チェック、「送信」緑ボタン、破線＋注意文。SCSS: _contact.scss。送信処理は今後 Contact Form 7 等で対応予定。
- **テーマ画像格納**: `assets/images/` を作成（.gitkeep 配置）。ロゴは `get_theme_file_uri('assets/images/logo.png')` で読み込み。

---

## 2. フェーズ0 実施状況

### 完了済み

- **0-1 Git・リポジトリ基盤**
  - リモート: GitHub `teppeiSQUAT/yakage-italy-veg-site`
  - ブランチ: `main`, `develop` 作成済み・リモートへ push 済み
  - .gitignore 整備（wp-config.php, db/mysql/, wordpress/html/, .env）
  - ブランチ戦略・運用ルールを devnotes に文書化
- **0-3 Docker 環境**
  - docker-compose.yml（WordPress / MySQL 8.0 / phpMyAdmin）作成済み
  - php/php.ini, .env.example, db/, wordpress/ ディレクトリ構成済み
  - 環境変数は .env で管理（.env は本マシンで作成済み、Git には含めない）
- **0-4 WordPress 開発環境（本マシン）**
  - `docker-compose up -d` 実行済み
  - http://localhost:8080 で WordPress 初期設定（サイト情報入力まで）完了
  - 開発用 URL・phpMyAdmin（localhost:8890）は runbook に記載済み（ポートは docker-compose で 8890 に設定済み）
- **0-5 ファイル管理ルール**
  - wp-config の扱い・2台運用の注意事項を devnotes に記載済み
  - テーマ・プラグインはリポジトリ内ファイルで Git 共有する方針を明記
  - **DB・メディアの主環境**: **本機**に決定

### 未実施・要確認

- **0-2 SourceTree**: 本マシン・別マシンでのインストール・リポジトリ登録（push は成功しているため実質利用中）
- **0-4 別マシン**: 別マシンでの clone → .env → docker-compose → WordPress 初期設定の確認（2台運用時）
- **0-5**: 「DB・メディアの主環境」→ **本機**に決定済み
- **0-6 完了確認**: 本マシンは**フェーズ0 チェックリスト確認済み**（プル→編集→コミット→プッシュ・WordPress 表示）。別マシンは2台運用開始時に確認

---

## 3. リポジトリ・Git 状態（記録時点）

- **ブランチ**: main / develop あり
- **リモート**: origin（main / develop ともに push 済み）
- **未コミット変更**: テーマ（functions.php・header.php・front-page.php・footer.php、header.js、news-slider.js、_header.scss・_footer.scss・_reset.scss・_news.scss・_page.scss・_components.scss 等）、page.php・home.php・archive.php・single.php・news.php、お知らせスラッグ・メニューリンク・スムーズスクロール・ヘッダーアニメーション・ロゴ切り替え・ページトップボタン・下層ページ・アーカイブページ・c-border-line-left・フッターリンク（site-policy/privacy-policy）・vertical-align 修正・もっと見るリンク（/news/）・ご注文はこちら（Google Forms）・PICKUP スライダー（1枚表示・自動再生・ループ・右→左）等の更新。生産者・サポーター・野菜の画像（img_frmr_*.jpg、img_spt_*.jpg、img_veg_*.jpg）が未追跡。必要に応じて `git status` で確認。
- **直近コミット**: （状況に応じて更新）

※ 現状記録の更新（本ファイル追加・計画書の状態更新）をコミットする場合は、develop で作業し「[フェーズ0] 現状記録・計画書更新」等のメッセージでコミット・push を推奨。

---

## 4. 開発環境（本マシン）

| 項目 | 内容 |
|------|------|
| WordPress | http://localhost:8082（初期設定済み・wp-config で URL 固定） |
| 管理画面 | http://localhost:8082/wp-admin |
| phpMyAdmin | http://localhost:8890（.env の MYSQL_USER / MYSQL_PASSWORD） |
| コンテナ | db, wordpress, phpmyadmin（docker-compose） |
| 認証 | GitHub は PAT または SSH で push 可能な状態 |

---

## 5. 参照ドキュメント

| ファイル | 用途 |
|----------|------|
| devnotes/202503021430-dev-env-and-implementation-plan.md | 全体実装計画・フェーズ0〜8 の TODO |
| devnotes/202503031000-schedule-to-production-test.md | **3/11 本番テストアップ スケジュール・フェーズ別TODO** |
| devnotes/202503032300-top-page-theme-implementation-plan.md | TOPページテーマ実装計画（Phase A〜K、コンテンツブロック単位） |
| devnotes/202603121148-sub-page-archive-implementation-plan.md | 下層ページ・アーカイブページ実装計画（Phase L） |
| devnotes/202603221851-instagram-smash-balloon-feed-style-record.md | Instagram（Smash Balloon）テーマ CSS 調整・確認記録 |
| devnotes/202603221856-implementation-plan-and-status-update.md | 実装計画・現状記録の一括更新メモ（2026/03/22） |
| devnotes/202603221932-client-wordpress-manual-draft-v1.md | クライアント向け WordPress 簡易マニュアル（初稿・Markdown） |
| devnotes/202603221932-client-wordpress-manual-draft-v1.pdf | 同上 PDF（キャプチャ埋め込み・Pandoc + Chrome で再生成可） |
| devnotes/202603221956-current-status-record.md | 2026/03/22 後半の現状詳細（マニュアル・Pandoc・UI 微修正） |
| devnotes/202503032300-scss-workflow.md | SCSS 開発環境ワークフロー（コンパイル・watch） |
| devnotes/202503091000-theme-dev-watch-and-reload.md | テーマ開発: SCSS 自動ビルド・Browsersync によるブラウザ自動リロード |
| devnotes/202503021500-phase0-runbook.md | フェーズ0 実施手順（本マシン・別マシン） |
| devnotes/202503021430-git-workflow-and-branches.md | ブランチ戦略・SourceTree 運用ルール。**本機=develop、ノート機=feature/xxx 推奨**の記載あり |
| devnotes/202503021500-wpconfig-and-2machine-notes.md | wp-config・2台運用の注意事項 |
| devnotes/202503021600-github-auth-sourcetree.md | GitHub 認証（403・PAT・SSH）対処 |

---

## 6. 次のアクション

1. **未コミットの計画書更新をコミット**（任意）  
   - develop に切り替え → 計画書・本現状記録を add → commit → push
2. **0-6 の確認**（任意）  
   - 本マシンで「プル → 軽い編集 → コミット → プッシュ」を一度実施
3. **2台運用する場合**  
   - 別マシンで clone → .env 作成 → docker-compose up -d → WordPress 初期設定  
   - DB・メディアの主環境は **本機**（コンテンツ・投稿・メディアは本機で編集し、必要に応じて別マシンへエクスポートで共有）
4. **フェーズ0 完了後**  
   - フェーズ1（キックオフ）に進行
5. **TOPページテーマ実装**  
   - Phase A〜J 完了。次は Phase K（レスポンシブ・仕上げ）。devnotes/202503032300-top-page-theme-implementation-plan.md 参照。
6. **3/11 本番テストアップ**  
   - devnotes/202503031000-schedule-to-production-test.md に従い Phase E〜K と本番準備を実施

---

*このファイルは現状のスナップショットです。進捗に応じて devnotes 内の実装計画書とあわせて更新してください。*
