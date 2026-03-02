# プロジェクト現状記録

- **記録日**: 2025年3月2日
- **プロジェクト**: 矢掛町イタリア野菜プロジェクト 公式サイト（yakage-italy-veg-site）


テストプッシュ
---

## 1. 全体進捗

| フェーズ | 内容 | 状態 |
|---------|------|------|
| **フェーズ0** | 開発環境・2台運用基盤構築 | **進行中（本マシンほぼ完了）** |
| フェーズ1 | キックオフ | 未着手 |
| フェーズ2〜8 | 構成・WF 〜 リリース | 未着手 |

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
  - 開発用 URL・phpMyAdmin（localhost:8888）は runbook に記載済み
- **0-5 ファイル管理ルール**
  - wp-config の扱い・2台運用の注意事項を devnotes に記載済み
  - テーマ・プラグインはリポジトリ内ファイルで Git 共有する方針を明記
  - **DB・メディアの主環境**: **本機**に決定

### 未実施・要確認

- **0-2 SourceTree**: 本マシン・別マシンでのインストール・リポジトリ登録（push は成功しているため実質利用中）
- **0-4 別マシン**: 別マシンでの clone → .env → docker-compose → WordPress 初期設定の確認（2台運用時）
- **0-5**: 「DB・メディアの主環境」→ **本機**に決定済み
- **0-6 完了確認**: プル→編集→コミット→プッシュの一連動作の明示的な確認、別マシンでの同様の確認

---

## 3. リポジトリ・Git 状態（記録時点）

- **ブランチ**: main（現在）, develop あり
- **リモート**: origin（main / develop ともに push 済み）
- **未コミット変更**: `devnotes/202503021430-dev-env-and-implementation-plan.md` の修正（フェーズ0 チェックリスト更新分）
- **直近コミット**: first push（main/develop を push した状態）

※ 現状記録の更新（本ファイル追加・計画書の状態更新）をコミットする場合は、develop で作業し「[フェーズ0] 現状記録・計画書更新」等のメッセージでコミット・push を推奨。

---

## 4. 開発環境（本マシン）

| 項目 | 内容 |
|------|------|
| WordPress | http://localhost:8080（初期設定済み） |
| 管理画面 | http://localhost:8080/wp-admin |
| phpMyAdmin | http://localhost:8888（.env の MYSQL_USER / MYSQL_PASSWORD） |
| コンテナ | db, wordpress, phpmyadmin（docker-compose） |
| 認証 | GitHub は PAT または SSH で push 可能な状態 |

---

## 5. 参照ドキュメント

| ファイル | 用途 |
|----------|------|
| devnotes/202503021430-dev-env-and-implementation-plan.md | 全体実装計画・フェーズ0〜8 の TODO |
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

---

*このファイルは現状のスナップショットです。進捗に応じて devnotes 内の実装計画書とあわせて更新してください。*
