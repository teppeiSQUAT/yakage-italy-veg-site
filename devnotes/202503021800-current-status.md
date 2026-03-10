# プロジェクト現状記録

- **記録日**: 2025年3月9日
- **プロジェクト**: 矢掛町イタリア野菜プロジェクト 公式サイト（yakage-italy-veg-site）
- **スケジュール**: **2025年3月11日（火）本番サーバーへテストアップ予定** → devnotes/202503031000-schedule-to-production-test.md

---
## 1. 全体進捗

| フェーズ | 内容 | 状態 |
|---------|------|------|
| **フェーズ0** | 開発環境・2台運用基盤構築 | **進行中（本マシンほぼ完了）** |
| **テーマ Phase A〜B** | テーマ基盤・ヘッダー・ヒーロー・フッター | **完了** |
| **テーマ Phase C〜J** | お知らせ→Instagram→プロジェクト→イタリア野菜とは→生産者→サポーター→実績→お問い合わせ | **完了** |
| **テーマ Phase K** | レスポンシブ・仕上げ | **3/11 までに実施**（スケジュール参照） |
| **本番テストアップ** | さくらサーバーへアップロード・確認 | **目標 3/11** |
| フェーズ1〜8 | キックオフ 〜 リリース | 未着手／随時 |

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
- **未コミット変更**: テーマ（お知らせ・Instagram セクション・SCSS）、devnotes（現状記録・実装計画等）の更新がある可能性あり。必要に応じて `git status` で確認。
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
