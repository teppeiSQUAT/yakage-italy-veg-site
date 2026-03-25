# Contact Form 7 フォームテンプレート

## 使い方

1. WordPress 管理画面で「お問い合わせ」→「新規追加」
2. フォーム名: `お問い合わせフォーム`
3. 下記の「フォーム」タブの内容を貼り付け
4. 「メール」タブの内容を設定
5. 保存後、生成されたショートコードの `id` を `front-page.php` に反映

---

## フォーム タブ

```html
<div class="p-contact__field">
    <label>お名前</label>
    <div class="p-contact__input-wrap">
        [text* your-name placeholder "山田 太郎"]
    </div>
</div>

<div class="p-contact__field">
    <label>所属</label>
    <div class="p-contact__input-wrap">
        [text your-affiliation placeholder "会社名・団体名など"]
    </div>
</div>

<div class="p-contact__field">
    <label>メールアドレス</label>
    <div class="p-contact__input-wrap">
        [email* your-email placeholder "example@example.com"]
    </div>
</div>

<div class="p-contact__field">
    <label>TEL</label>
    <div class="p-contact__input-wrap">
        [tel your-tel placeholder "090-1234-5678"]
    </div>
</div>

<div class="p-contact__field">
    <label>内容</label>
    <div class="p-contact__input-wrap">
        [textarea* your-message x4 placeholder "お問い合わせ内容をご記入ください"]
    </div>
</div>

<div class="p-contact__consent">
    <span class="p-contact__consent-label">個人情報の取り扱い</span>
    <label class="p-contact__checkbox-wrap">
        [acceptance your-consent] <span class="p-contact__checkbox-text">同意します</span>
    </label>
</div>

<p class="p-contact__submit">
    [submit class:c-btn class:c-btn--green "送信"]
</p>
```

---

## メール タブ

### 送信先
```
admin@example.com
```
※ 実際の受信メールアドレスに変更してください

### 送信元
```
[_site_title] <wordpress@example.com>
```

### 題名
```
[_site_title] お問い合わせ: [your-name]
```

### 追加ヘッダー
```
Reply-To: [your-email]
```

### メッセージ本文
```
お問い合わせを受け付けました。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
■ お名前
[your-name]

■ 所属
[your-affiliation]

■ メールアドレス
[your-email]

■ TEL
[your-tel]

■ 内容
[your-message]

■ 個人情報の取り扱い
同意済み

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
このメールは [_site_title] ([_site_url]) のお問い合わせフォームから送信されました。
```

---

## メール (2) タブ（自動返信メール）

「メール (2) を使用」にチェックを入れて以下を設定

### 送信先
```
[your-email]
```

### 送信元
```
[_site_title] <wordpress@example.com>
```

### 題名
```
【[_site_title]】お問い合わせありがとうございます
```

### メッセージ本文
```
[your-name] 様

この度はお問い合わせいただき、誠にありがとうございます。
以下の内容でお問い合わせを受け付けました。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
■ お名前
[your-name]

■ 所属
[your-affiliation]

■ メールアドレス
[your-email]

■ TEL
[your-tel]

■ 内容
[your-message]
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

担当者より内容確認次第、返信させていただきます。
今しばらくお待ちくださいませ。

--
[_site_title]
[_site_url]
```

---

## メッセージ タブ

必要に応じてカスタマイズしてください。デフォルトのままでも問題ありません。

---

## ショートコードの反映

フォーム保存後に表示されるショートコード例:
```
[contact-form-7 id="abc1234" title="お問い合わせフォーム"]
```

`front-page.php` の以下の部分を実際の ID に更新:
```php
echo do_shortcode( '[contact-form-7 id="abc1234" title="お問い合わせフォーム"]' );
```
