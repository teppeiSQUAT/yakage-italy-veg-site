<?php
/**
 * 固定ページテンプレート: 投稿一覧（NEWS）
 * 固定ページ「NEWS」にこのテンプレートを適用すると、投稿一覧を表示
 *
 * Template Name: NEWS（投稿一覧）
 *
 * @package Yakage_Italy_Veg
 */

get_header();

$paged = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;
$news_query = new WP_Query( array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => get_option( 'posts_per_page', 10 ),
	'paged'          => $paged,
	'orderby'        => 'date',
	'order'          => 'DESC',
) );

global $wp_query;
$original_query = $wp_query;
$wp_query       = $news_query;

$page_title = get_the_title();
?>

<main class="l-main p-news">
	<div class="l-container">
		<section class="p-archive p-archive--news">
			<header class="p-archive__header">
				<h1 class="p-archive__title"><?php echo esc_html( $page_title ); ?></h1>
			</header>

			<div class="p-archive__grid p-news__grid">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						$is_new   = ( time() - get_the_time( 'U' ) ) < ( 7 * 24 * 60 * 60 );
						$cats     = get_the_category();
						$cat_slug = $cats ? $cats[0]->slug : '';
						$cat_name = $cats ? $cats[0]->name : '';
						?>
						<article class="p-news__grid-item">
							<a href="<?php the_permalink(); ?>" class="p-news__card">
								<div class="p-news__card-image">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'medium' ); ?>
									<?php else : ?>
										<span class="p-news__placeholder-img">画像なし</span>
									<?php endif; ?>
								</div>
								<div class="p-news__card-body">
									<div class="p-news__meta">
										<span class="p-news__date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
										<?php if ( $cat_name ) : ?>
											<span class="p-news__meta-sep">|</span>
											<span class="p-news__cat p-news__cat--<?php echo esc_attr( $cat_slug ); ?>"><?php echo esc_html( $cat_name ); ?></span>
										<?php endif; ?>
										<?php if ( $is_new ) : ?><span class="p-news__new-tag p-news__new-tag--inline">NEW</span><?php endif; ?>
									</div>
									<h2 class="p-news__card-title"><?php the_title(); ?></h2>
									<p class="p-news__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
								</div>
							</a>
						</article>
						<?php
					endwhile;
				else :
					?>
					<p class="p-archive__empty">お知らせはまだありません。</p>
				<?php endif; ?>
			</div>

			<?php
			if ( $news_query->max_num_pages > 1 ) {
				the_posts_pagination( array(
					'mid_size'  => 2,
					'prev_text' => '&laquo; 前へ',
					'next_text' => '次へ &raquo;',
				) );
			}
			?>
		</section>
	</div>
</main>

<?php
$wp_query = $original_query;
wp_reset_postdata();
get_footer();
