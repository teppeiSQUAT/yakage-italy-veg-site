# DB を他開発環境へ共有する手順

- **作成日**: 2026年3月6日
- **目的**: 現在の開発環境の WordPress DB をエクスポートし、別マシン・別環境でインポートして同じ内容で開発できるようにする

---

## 前提

- 共有元・共有先ともに Docker Compose で開発環境が起動していること
- 共有先では `docker-compose up -d` 済みで、WordPress の初回セットアップ（言語選択など）が完了しているか、これから行う想定

---

## 1. 共有元（現在の環境）で DB をエクスポート

### 方法A: コマンドライン（mysqldump）

プロジェクトルートで実行する。`.env` の `MYSQL_DATABASE` / `MYSQL_USER` / `MYSQL_PASSWORD` がコンテナに渡されている。

```bash
# エクスポート用ディレクトリ（必要なら作成）
mkdir -p db/exports

# ダンプ取得（パスワードは .env の MYSQL_PASSWORD）
docker exec yakage_italy_veg_db mysqldump -u wp_user -p"${MYSQL_PASSWORD:-wp_password}" \
  --single-transaction --default-character-set=utf8mb4 \
  "${MYSQL_DATABASE:-yakage_italy_veg_db}" > db/exports/export_$(date +%Y%m%d_%H%M%S).sql
```

- `.env` を読み込むには、同じシェルで `set -a && source .env && set +a` してから上記を実行するか、パスワードを手で置き換えて実行する。
- または、root で取る方法（パスワードは .env の `MYSQL_ROOT_PASSWORD`）:

```bash
docker exec yakage_italy_veg_db mysqldump -u root -p"${MYSQL_ROOT_PASSWORD:-root_password}" \
  --single-transaction --default-character-set=utf8mb4 \
  "${MYSQL_DATABASE:-yakage_italy_veg_db}" > db/exports/export_$(date +%Y%m%d_%H%M%S).sql
```

### 方法B: phpMyAdmin でエクスポート

1. ブラウザで **http://localhost:8890** を開く
2. `.env` の `MYSQL_USER` / `MYSQL_PASSWORD` でログイン
3. 左のデータベース一覧で `yakage_italy_veg_db`（または `.env` の `MYSQL_DATABASE`）を選択
4. タブ「エクスポート」→ 方式「詳細」→ 対象テーブルは「すべて」のまま → 「実行」で SQL ファイルをダウンロード

---

## 2. エクスポートファイルの受け渡し

- 上記で作成した `.sql` ファイルを、USB・クラウドストレージ・社内共有など、任意の方法で**共有先の開発マシン**にコピーする。
- `db/exports/` は Git に含めず、手動で共有する運用を推奨（ダンプに環境依存のパスやユーザーが含まれるため）。必要なら `.gitignore` に `db/exports/*.sql` を追加する。

---

## 3. 共有先（他環境）で DB をインポート

共有先マシンで、プロジェクトを clone 済み・`docker-compose up -d` 済みであること。

### 既に WordPress を初期設定済みの場合（DB が既にある）

既存の DB を上書きする場合:

```bash
# コンテナ名は同じ想定（yakage_italy_veg_db）
docker exec -i yakage_italy_veg_db mysql -u wp_user -p"${MYSQL_PASSWORD:-wp_password}" \
  "${MYSQL_DATABASE:-yakage_italy_veg_db}" < /path/to/export_YYYYMMDD_HHMMSS.sql
```

- `/path/to/export_...` は、共有先マシンに置いたダンプファイルのパスに置き換える。
- 例: ダンプをプロジェクトの `db/exports/` に置いた場合  
  `db/exports/export_20260306_155000.sql`

### 共有先でまだ WordPress を初期設定していない場合

1. 先に **http://localhost:8080** を開き、WordPress の「言語選択」→「続ける」→ データベース接続（通常はそのまま「送信」）→「インストール実行」まで進め、サイト情報を入力してインストールを完了する。
2. その後、上記の `docker exec -i ... mysql ... < ダンプ.sql` で同じ DB 名にインポートし直す（既存の初期データが共有元の内容で上書きされる）。

---

## 4. インポート後の確認

- ブラウザで **http://localhost:8080** を開き、トップや固定ページ・投稿が共有元と同様に表示されるか確認する。
- 管理画面（**http://localhost:8080/wp-admin**）にログインできるか、および「設定」→「一般」の「WordPress アドレス」「サイトアドレス」が **http://localhost:8080** のままか確認する。  
  共有元・共有先ともに `localhost:8080` なら、通常はそのままで問題ない。

---

## 5. （任意）メディア（アップロードファイル）を揃える場合

DB だけでは、画像・添付ファイルの実体は共有されない。同じメディアで揃えたい場合:

- **共有元**: `wordpress/html/wp-content/uploads` を zip などにまとめる。
- **共有先**: その zip を `wordpress/html/wp-content/` に展開し、`uploads` フォルダを上書きまたはマージする。

※ `wordpress/html` は Git 管理外のため、メディアの共有も手動または別ツールで行う。

---

## クイック参照（コピー用）

| 項目 | 値（既定） |
|------|------------|
| DB コンテナ名 | `yakage_italy_veg_db` |
| データベース名 | `.env` の `MYSQL_DATABASE`（既定: `yakage_italy_veg_db`） |
| DB ユーザー | `.env` の `MYSQL_USER`（既定: `wp_user`） |
| パスワード | `.env` の `MYSQL_PASSWORD` / `MYSQL_ROOT_PASSWORD` |

---

## 関連ドキュメント

- **devnotes/202503021500-phase0-runbook.md** … 開発環境の初回構築
- **devnotes/202503021500-wpconfig-and-2machine-notes.md** … 2台運用・DB/メディアの主環境の考え方
