<?php
/**
 * フロントページ（TOPページ）テンプレート
 *
 * @package Yakage_Italy_Veg
 */

get_header();
?>

<main class="l-main">
	<!-- ヒーローセクション -->
	<section class="p-hero">
		<div class="p-hero__slider">
			<div class="p-hero__slide p-hero__slide--active">
				<div class="p-hero__image">
					<?php if ( get_header_image() ) : ?>
						<img src="<?php echo esc_url( get_header_image() ); ?>" alt="">
					<?php else : ?>
						<div class="p-hero__placeholder">ヒーロー画像（外観 → カスタマイズで設定可）</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="p-hero__indicators" aria-hidden="true">
			<button type="button" class="p-hero__dot p-hero__dot--active" aria-current="true"></button>
			<button type="button" class="p-hero__dot"></button>
			<button type="button" class="p-hero__dot"></button>
		</div>
	</section>

	<!-- Phase C 以降で各セクションを追加 -->
	<div class="l-container">
		<section class="l-section">
			<p class="l-placeholder">NEWS・PICK UP 以降のセクションは Phase C で追加</p>
		</section>
	</div>
</main>

<?php
get_footer();
