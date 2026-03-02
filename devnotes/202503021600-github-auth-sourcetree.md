# GitHub 認証エラー対処（SourceTree で push する場合）

- **作成日**: 2025年3月2日
- **対象エラー**:
  - `Invalid username or token. Password authentication is not supported for Git operations.` / `Authentication failed`
  - **`Permission to ... denied to teppeiSQUAT`** / **`403`**（認証は通るが push が拒否される）

---

## 403 / Permission denied to [ユーザー名] が出る場合

**症状**: `remote: Permission to teppeiSQUAT/yakage-italy-veg-site.git denied to teppeiSQUAT.` や `The requested URL returned error: 403`

**主な原因**:  
**キーチェーンや SourceTree に保存された「古い認証」や「別アカウントの認証」が使われている**ため、GitHub が push を拒否しています。ユーザー名は合っていても、**パスワード欄に古いパスワードや無効なトークンが残っている**と 403 になります。

### 対処手順（HTTPS で PAT を使っている場合）

1. **キーチェーンから GitHub の認証を削除**
   - **キーチェーンアクセス**（Spotlight で「キーチェーン」と検索）を開く
   - 左で **「ログイン」** → **「パスワード」** を選択
   - 検索欄に **`github.com`** と入力
   - 出てきた **github.com** の項目を右クリック → **削除**（複数あれば、該当しそうなものを削除）
2. **SourceTree の認証をやり直す**
   - SourceTree → **設定（Preferences）** → **認証（Authentication）**
   - **GitHub** のアカウントを選び **削除** または **編集**
   - 削除した場合: **追加** で再度 GitHub を追加  
     編集した場合: **パスワード** 欄に **新しく発行した Personal Access Token** を貼り付け（下記「トークン再発行」参照）
   - 保存して閉じる
3. **トークンが有効か確認・必要なら再発行**
   - GitHub → **Settings** → **Developer settings** → **Personal access tokens**
   - 既存のトークンで **repo** にチェックが入っているか確認。期限切れや不明な場合は **Generate new token** で新規作成し、**repo** にチェックを入れて発行
   - 表示された **ghp_xxxx...** をコピーし、SourceTree の認証の「パスワード」欄に貼り付け
4. **再度 push**
   - SourceTree で **プッシュ** を実行。認証を聞かれたら、**ユーザー名**: `teppeiSQUAT`、**パスワード**: 新しいトークン を入力

### それでも 403 になる場合

- **SSH に切り替える**（下記「方法B」）。HTTPS のキャッシュの影響を受けずに push できることがあります。
- リポジトリが **Organization** 配下で **SAML SSO** 有効の場合は、トークン発行後に **Configure SSO** でその Organization を承認する必要があります。

---

## 原因（パスワード認証廃止）

GitHub では **パスワードでの Git 操作（clone / push / pull）は廃止**されています。  
SourceTree で HTTPS のまま使う場合は **Personal Access Token (PAT)**、または **SSH キー** のどちらかで認証する必要があります。

---

## 方法A: Personal Access Token（PAT）で HTTPS のまま使う

### 1. GitHub でトークンを作成

1. GitHub にログイン → 右上のアイコン → **Settings**
2. 左メニュー最下部の **Developer settings**
3. **Personal access tokens** → **Tokens (classic)** または **Fine-grained tokens**
4. **Generate new token** をクリック
5. **Note**: 例）`SourceTree - yakage-italy-veg`（用途が分かる名前）
6. **Expiration**: 90 days または No expiration（運用方針に合わせて）
7. **Scopes**: 少なくとも **repo** にチェック（リポジトリの読み書きに必要）
8. **Generate token** で作成し、**表示されたトークン（ghp_xxxx...）をコピー**（あとで再表示できないため）

### 2. SourceTree で認証情報を設定

1. **SourceTree** を開く
2. メニュー **SourceTree** → **設定（Preferences）** または **Settings**
3. **認証（Authentication）** タブを開く
4. **アカウント** で **GitHub** を選び、**追加** または **編集**
5. **認証方法**: **OAuth** または **Basic**
   - **Basic** の場合:
     - **ユーザー名**: GitHub のユーザー名（例: `teppeiSQUAT`）
     - **パスワード**: 上でコピーした **Personal Access Token** を貼り付け（通常のパスワード欄にトークンを入れる）
6. 保存してから、再度 **プッシュ** を実行

### 3. まだエラーになる場合（macOS キーチェーン）

- 以前 GitHub のパスワードを保存していると、古い認証が使われることがあります。
- **キーチェーンアクセス** を開く → `github.com` で検索 → 該当項目を削除してから、SourceTree で再度 push し、**トークン** を入力して保存し直す。

---

## 方法B: SSH に切り替える（推奨・トークン不要）

HTTPS ではなく **SSH** で接続するようにリモート URL を変更します。

### 1. SSH キーがあるか確認

ターミナルで:

```bash
ls -la ~/.ssh
```

`id_rsa` と `id_rsa.pub`（または `id_ed25519` と `id_ed25519.pub`）があれば既存のキーが使えます。なければ次のステップで作成。

### 2. SSH キーを生成（まだない場合）

```bash
ssh-keygen -t ed25519 -C "your_email@example.com"
```

プロンプトでは Enter 連打でデフォルトの保存場所（`~/.ssh/id_ed25519`）でよいです。パスフレーズを設定しても構いません。

### 3. 公開鍵を GitHub に登録

1. 公開鍵の内容をコピー:
   ```bash
   cat ~/.ssh/id_ed25519.pub
   ```
   または `id_rsa.pub` の内容をコピー
2. GitHub → **Settings** → **SSH and GPG keys** → **New SSH key**
3. **Title**: 例）`Mac - yakage 開発`
4. **Key**: コピーした内容を貼り付け → **Add SSH key**

### 4. リモート URL を HTTPS から SSH に変更

リポジトリのルートで:

```bash
git remote set-url origin git@github.com:teppeiSQUAT/yakage-italy-veg-site.git
git remote -v
```

`origin` が `git@github.com:teppeiSQUAT/yakage-italy-veg-site.git` を指していれば OK です。

### 5. SourceTree での操作

- 上記はターミナルで実行しても、SourceTree から「リモート」を編集しても同じです。
- SourceTree: **リポジトリ** → **リモート**（または Repository Settings）→ **origin** の URL を  
  `git@github.com:teppeiSQUAT/yakage-italy-veg-site.git` に変更して保存。
- その後、**プッシュ** を実行。初回だけ「SSH 鍵を使う」などの許可を聞かれたら許可してください。

---

## まとめ

| 方法 | メリット | 手順 |
|------|----------|------|
| **A: PAT（HTTPS）** | 設定が簡単、GitHub の画面だけで完結 | トークン発行 → SourceTree の認証で「パスワード」にトークンを入力 |
| **B: SSH** | トークンの期限切れを気にしにくい、一般的な運用 | 鍵生成 → GitHub に公開鍵登録 → `origin` を SSH URL に変更 |

**別マシン** でも push する場合は、そのマシンで同様に **PAT を設定** するか **SSH キーを用意して GitHub に登録** し、必要ならそのマシンでも `git remote set-url origin git@github.com:teppeiSQUAT/yakage-italy-veg-site.git` に変更してください。
