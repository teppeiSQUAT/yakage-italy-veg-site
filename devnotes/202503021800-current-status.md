# プロジェクト現状記録

- **記録日**: 2025年3月7日
- **プロジェクト**: 矢掛町イタリア野菜プロジェクト 公式サイト（yakage-italy-veg-site）
- **スケジュール**: **2025年3月11日（火）本番サーバーへテストアップ予定** → devnotes/202503031000-schedule-to-production-test.md

---
## 1. 全体進捗

| フェーズ | 内容 | 状態 |
|---------|------|------|
| **フェーズ0** | 開発環境・2台運用基盤構築 | **進行中（本マシンほぼ完了）** |
| **テーマ Phase A〜B** | テーマ基盤・ヘッダー・ヒーロー・フッター | **完了** |
| **テーマ Phase C** | お知らせセクション | **完了** |
| **テーマ Phase D** | Instagram セクション | **完了** |
| **テーマ Phase E〜K** | プロジェクトについて→イタリア野菜とは→生産者→サポーター→実績→お問い合わせ・レスポンシブ | **3/11 までに実施**（スケジュール参照） |
| **本番テストアップ** | さくらサーバーへアップロード・確認 | **目標 3/11** |
| フェーズ1〜8 | キックオフ 〜 リリース | 未着手／随時 |

### 直近の反映（3/7 時点）

- **Phase D Instagram セクション**: 実装イメージに合わせてレイアウトを実装。Smash Balloon Social Photo Feed プラグインのショートコード `[instagram-feed feed=1]` を TOP に埋め込み。ヘッダーは「公式 Instagram」＋Instagram ロゴ（SVG）＋赤・緑の破線装飾。フィードは 4 列グリッド（スマホ時 2 列）。赤「follow us」ボタン、下部 3 ブロック（岡山県矢掛町／矢掛町×YouTube／矢掛町地域おこし協力隊）はカスタマイザーで URL 変更可能。SCSS: _instagram.scss。DB 不足テーブル（wp_sbi_feeds 等）は db/sbi_tables_create.sql で作成済み。
- **Phase C お知らせセクション**: 仕上がりイメージに合わせてレイアウト・スタイルを調整済み。PICKUP は赤枠・深緑丸の矢印・赤ドット（アクティブ）、ラベルがカード上端に重なる配置。グリッドは明るい緑枠・カテゴリはピル型（イベント=赤・お知らせ=青・レシピ=緑）、NEW はメタ行（日付｜カテゴリの横）のみ表示。「もっと見る」は緑角丸ボタン・枠線・シャドウ。日付とカテゴリの区切り「|」を共通で表示。
- **フォント**: Google Fonts「Zen Maru Gothic」を全体のフォントとして採用済み。
- **フッター**: 仕上がりイメージに合わせて実装済み。左（円形シール＋岡山県矢掛町・イタリア野菜プロジェクト）、中央（TOP｜サイトポリシー｜プライバシーポリシー、著作権「YYYY (c) yakage.」）、右（ページトップへスクロール用円形白ボタン）。配色はライトグレー背景・ダークグレー文字。header.js でスクロールトップ動作を実装。

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
| WordPress | http://localhost:8081（初期設定済み・wp-config で URL 固定） |
| 管理画面 | http://localhost:8081/wp-admin |
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
   - Phase A〜D 完了。次は Phase E（イタリア野菜プロジェクトについて）から実施。devnotes/202503032300-top-page-theme-implementation-plan.md 参照。
6. **3/11 本番テストアップ**  
   - devnotes/202503031000-schedule-to-production-test.md に従い Phase E〜K と本番準備を実施

---

*このファイルは現状のスナップショットです。進捗に応じて devnotes 内の実装計画書とあわせて更新してください。*
