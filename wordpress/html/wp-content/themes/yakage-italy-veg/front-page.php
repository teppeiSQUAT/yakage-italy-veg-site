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

	<!-- Instagram セクション（Phase D） -->
	<?php
	$instagram_url = get_theme_mod( 'yakage_instagram_url', 'https://www.instagram.com/' );
	$instagram_footer_links = array(
		array(
			'label' => '岡山県 矢掛町',
			'url'   => get_theme_mod( 'yakage_instagram_link_left', '#' ),
			'class'  => 'p-instagram__footer-block--town',
		),
		array(
			'label' => '矢掛町 × YouTube',
			'url'   => get_theme_mod( 'yakage_instagram_link_center', '#' ),
			'class'  => 'p-instagram__footer-block--youtube',
		),
		array(
			'label' => '矢掛町地域おこし協力隊',
			'url'   => get_theme_mod( 'yakage_instagram_link_right', '#' ),
			'class'  => 'p-instagram__footer-block--team',
		),
	);
	?>
	<section class="p-instagram" id="instagram">
		<div class="l-container">
			<header class="p-instagram__header">
				<span class="p-instagram__header-line p-instagram__header-line--left" aria-hidden="true"></span>
				<span class="p-instagram__logo" aria-hidden="true">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" role="img" aria-label="Instagram"><defs><linearGradient id="ig-gradient" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#f58529"/><stop offset="50%" style="stop-color:#dd2a7b"/><stop offset="100%" style="stop-color:#8134af"/></linearGradient></defs><path fill="url(#ig-gradient)" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
				</span>
				<h2 class="p-instagram__title">公式 Instagram</h2>
				<span class="p-instagram__header-line p-instagram__header-line--right" aria-hidden="true"></span>
			</header>
			<div class="p-instagram__feed">
				<?php echo do_shortcode( '[instagram-feed feed=1]' ); ?>
			</div>
			<div class="p-instagram__cta">
				<a href="<?php echo esc_url( $instagram_url ); ?>" class="p-instagram__follow-btn" target="_blank" rel="noopener noreferrer">follow us</a>
			</div>
			<nav class="p-instagram__footer" aria-label="関連リンク">
				<?php foreach ( $instagram_footer_links as $link ) : ?>
					<a href="<?php echo esc_url( $link['url'] ); ?>" class="p-instagram__footer-block <?php echo esc_attr( $link['class'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $link['label'] ); ?></a>
				<?php endforeach; ?>
			</nav>
		</div>
	</section>
</main>

<?php
get_footer();
