<?php
/**
 * メインのテンプレートファイル（フォールバック）
 *
 * @package Yakage_Italy_Veg
 */

get_header();
?>

<main class="l-main">
	<div class="l-container">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
		else :
			?>
			<p><?php esc_html_e( 'コンテンツがありません。', 'yakage-italy-veg' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
