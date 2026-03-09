# テーマ開発: SCSS 自動ビルドとブラウザ自動リロード

- **作成日**: 2025年3月9日
- **目的**: SCSS を編集すると自動で CSS にビルドされ、ブラウザが自動でリロード（または CSS インジェクト）されるようにする

---

## 前提

- Docker で WordPress が起動しており、**http://localhost:8082** で表示できること
- プロジェクトルートで `npm install` 済みであること

---

## 手順

### 1. 開発用コマンドを起動

プロジェクトルートで:

```bash
npm run dev
```

これで次の 2 つが同時に動きます。

- **sass:watch** … テーマの SCSS を監視し、変更を保存すると `style.css` に自動ビルド
- **browser-sync** … http://localhost:8082 をプロキシし、`style.css` の変更を検知してブラウザに反映（CSS インジェクト or リロード）

### 2. ブラウザで開く URL

起動後、ターミナルに表示される **Browsersync の URL**（例: http://localhost:3000）をブラウザで開いてください。

- この URL が WordPress（8082）をプロキシしています
- **この Browsersync の URL で見ているときだけ**、CSS の変更が自動で反映されます
- http://localhost:8082 を直接開いている場合は自動リロードされません

### 3. 作業の流れ

1. `npm run dev` を実行したままにする
2. ブラウザで Browsersync の URL（例: localhost:3000）を開く
3. テーマの `scss/` 内のファイルを編集して保存
4. 数秒以内に CSS がビルドされ、ブラウザに自動反映される

---

## その他の npm スクリプト

| コマンド | 説明 |
|----------|------|
| `npm run sass:build` | SCSS を 1 回だけビルド（watch なし） |
| `npm run sass:watch` | SCSS の監視のみ（Browsersync なし） |
| `npm run browser-sync` | Browsersync のみ（sass:watch なし） |
| `npm run dev` | sass:watch と browser-sync を同時に実行（推奨） |

---

## 注意

- 初回は `npm run dev` 実行後にブラウザが自動で開く場合があります。開かない場合はターミナルに表示された URL を手動で開いてください。
- WordPress のポートが 8082 でない場合は、`package.json` の `browser-sync` スクリプト内の `--proxy http://localhost:8082` を実際の URL に合わせて変更してください。
