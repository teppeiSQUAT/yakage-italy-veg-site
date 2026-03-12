<?php
/**
 * 単一投稿テンプレート
 *
 * @package Yakage_Italy_Veg
 */

get_header();
?>

<main class="l-main">
	<div class="l-container">
		<article class="p-single">
			<?php
			while ( have_posts() ) :
				the_post();
				$cats     = get_the_category();
				$cat_slug = $cats ? $cats[0]->slug : '';
				$cat_name = $cats ? $cats[0]->name : '';
				?>
				<header class="p-single__header">
					<div class="p-single__meta">
						<span class="p-single__date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
						<?php if ( $cat_name ) : ?>
							<span class="p-single__meta-sep">|</span>
							<span class="p-single__cat p-news__cat p-news__cat--<?php echo esc_attr( $cat_slug ); ?>"><?php echo esc_html( $cat_name ); ?></span>
						<?php endif; ?>
					</div>
					<h1 class="p-single__title"><?php the_title(); ?></h1>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="p-single__thumbnail">
						<?php the_post_thumbnail( 'large' ); ?>
					</div>
				<?php endif; ?>

				<div class="p-single__body">
					<?php the_content(); ?>
				</div>

				<nav class="p-single__nav" aria-label="投稿ナビゲーション">
					<?php
					the_post_navigation( array(
						'prev_text' => '<span class="p-single__nav-label">前の記事</span> %title',
						'next_text' => '<span class="p-single__nav-label">次の記事</span> %title',
					) );
					?>
				</nav>
				<?php
			endwhile;
			?>
		</article>
	</div>
</main>

<?php
get_footer();
