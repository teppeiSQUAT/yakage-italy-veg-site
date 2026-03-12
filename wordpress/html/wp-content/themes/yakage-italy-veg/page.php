<?php
/**
 * 固定ページテンプレート
 *
 * @package Yakage_Italy_Veg
 */

get_header();
?>

<main class="l-main">
	<div class="l-container">
		<article class="p-page">
			<header class="p-page__header">
				<h1 class="p-page__title c-border-line-left"><?php the_title(); ?></h1>
			</header>
			<div class="p-page__body">
				<?php
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
				?>
			</div>
		</article>
	</div>
</main>

<?php
get_footer();
