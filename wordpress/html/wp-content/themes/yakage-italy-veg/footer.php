<?php
/**
 * フッターテンプレート
 * 左: ロゴ・プロジェクト名 / 中央: リンク・著作権 / 右: ページトップへスクロールボタン
 *
 * @package Yakage_Italy_Veg
 */
?>
<footer class="l-footer">
	<div class="l-container">
		<div class="l-footer__inner">
			<div class="l-footer__brand">
				<div class="l-footer__seal" aria-hidden="true">
					<!-- 円形ロゴ・シール（画像は後で差し替え可） -->
					<span class="l-footer__seal-inner">YAKAGE</span>
				</div>
				<div class="l-footer__project-name">
					<p class="l-footer__project-line">岡山県矢掛町</p>
					<p class="l-footer__project-line">イタリア野菜プロジェクト</p>
				</div>
			</div>
			<div class="l-footer__center">
				<nav class="l-footer__nav" aria-label="フッターナビゲーション">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">TOP</a>
					<span class="l-footer__separator" aria-hidden="true">|</span>
					<a href="#">サイトポリシー</a>
					<span class="l-footer__separator" aria-hidden="true">|</span>
					<a href="#">プライバシーポリシー</a>
				</nav>
				<p class="l-footer__copyright"><?php echo esc_html( date( 'Y' ) ); ?> (c) yakage.</p>
			</div>
			<div class="l-footer__right">
				<button type="button" class="l-footer__scroll-top c-scroll-top" aria-label="ページの先頭へ">
					<span class="c-scroll-top__icon" aria-hidden="true">^</span>
				</button>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
