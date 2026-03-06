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

	<!-- お知らせセクション（Phase C） -->
	<?php
	$pickup_cat = get_category_by_slug( 'pickup' );
	$pickup_query = null;
	if ( $pickup_cat ) {
		$pickup_query = new WP_Query( array(
			'category_name' => 'pickup',
			'posts_per_page' => 5,
			'orderby' => 'date',
			'order' => 'DESC',
			'post_status' => 'publish',
		) );
	}
	$grid_cat_ids = array();
	foreach ( array( 'otoshirase', 'event', 'recipe' ) as $slug ) {
		$c = get_category_by_slug( $slug );
		if ( $c ) {
			$grid_cat_ids[] = $c->term_id;
		}
	}
	$grid_args = array(
		'posts_per_page' => 6,
		'orderby' => 'date',
		'order' => 'DESC',
		'post_status' => 'publish',
	);
	if ( ! empty( $grid_cat_ids ) ) {
		$grid_args['category__in'] = $grid_cat_ids;
	}
	if ( $pickup_cat ) {
		$grid_args['category__not_in'] = array( $pickup_cat->term_id );
	}
	$grid_query = new WP_Query( $grid_args );
	?>
	<section class="p-news" id="news">
		<div class="l-container">
			<h2 class="p-news__title">| お知らせ |</h2>

			<?php if ( $pickup_query && $pickup_query->have_posts() ) : ?>
			<div class="p-news__pickup">
				<div class="p-news__pickup-label">PICKUP</div>
				<div class="p-news__pickup-slider">
					<button type="button" class="p-news__pickup-arrow p-news__pickup-arrow--prev" aria-label="前へ"></button>
					<div class="p-news__pickup-track">
						<?php
						while ( $pickup_query->have_posts() ) :
							$pickup_query->the_post();
							$is_new = ( time() - get_the_time( 'U' ) ) < ( 7 * 24 * 60 * 60 );
							?>
							<article class="p-news__pickup-slide">
								<a href="<?php the_permalink(); ?>" class="p-news__pickup-card">
									<div class="p-news__pickup-card-image">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'medium_large' ); ?>
										<?php else : ?>
											<span class="p-news__placeholder-img">画像なし</span>
										<?php endif; ?>
										<?php if ( $is_new ) : ?><span class="p-news__new-tag">NEW</span><?php endif; ?>
									</div>
									<div class="p-news__pickup-card-body">
										<div class="p-news__meta">
											<span class="p-news__date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
											<?php
											$cats = get_the_category();
											if ( $cats ) :
												$cat = $cats[0];
												?>
												<span class="p-news__meta-sep">|</span>
												<span class="p-news__cat p-news__cat--<?php echo esc_attr( $cat->slug ); ?>"><?php echo esc_html( $cat->name ); ?></span>
											<?php endif; ?>
										</div>
										<h3 class="p-news__card-title"><?php the_title(); ?></h3>
										<p class="p-news__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
									</div>
								</a>
							</article>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>
					<button type="button" class="p-news__pickup-arrow p-news__pickup-arrow--next" aria-label="次へ"></button>
				</div>
				<?php $pickup_count = $pickup_query->post_count; ?>
				<div class="p-news__pickup-dots" aria-hidden="true" data-slider-dots>
					<?php for ( $i = 0; $i < $pickup_count; $i++ ) : ?>
						<button type="button" class="p-news__pickup-dot<?php echo $i === 0 ? ' p-news__pickup-dot--active' : ''; ?>" data-index="<?php echo (int) $i; ?>" aria-label="スライド<?php echo (int) $i + 1; ?>"></button>
					<?php endfor; ?>
				</div>
			</div>
			<?php endif; ?>

			<div class="p-news__grid">
				<?php
				if ( $grid_query->have_posts() ) :
					while ( $grid_query->have_posts() ) :
						$grid_query->the_post();
						$is_new = ( time() - get_the_time( 'U' ) ) < ( 7 * 24 * 60 * 60 );
						$cats = get_the_category();
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
									<h3 class="p-news__card-title"><?php the_title(); ?></h3>
									<p class="p-news__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
								</div>
							</a>
						</article>
						<?php
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<p class="p-news__empty">お知らせはまだありません。投稿でカテゴリ「お知らせ」「イベント」「レシピ」を付けて公開してください。</p>
				<?php endif; ?>
			</div>

			<div class="p-news__more">
				<a href="<?php echo esc_url( yakage_italy_veg_get_news_archive_url() ); ?>" class="c-btn c-btn--green">もっと見る</a>
			</div>
		</div>
	</section>

	<!-- Phase D 以降で各セクションを追加 -->
	<div class="l-container">
		<section class="l-section">
			<p class="l-placeholder">Instagram 以降のセクションは Phase D で追加</p>
		</section>
	</div>
</main>

<?php
get_footer();
