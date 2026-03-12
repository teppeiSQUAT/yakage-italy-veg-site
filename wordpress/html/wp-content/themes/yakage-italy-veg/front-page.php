<?php
/**
 * フロントページ（TOPページ）テンプレート
 *
 * @package Yakage_Italy_Veg
 */

get_header();
?>

<main class="l-main">
	<!-- ヒーローセクション（8枚をフェードイン・アウトで切り替え） -->
	<?php
	$hero_images = array( 'hero-1.jpg', 'hero-2.jpg', 'hero-3.jpg', 'hero-4.jpg', 'hero-5.jpg', 'hero-6.jpg', 'hero-7.jpg', 'hero-8.jpg' );
	?>
	<section class="p-hero" id="hero-slider">
		<div class="p-hero__slider">
			<?php foreach ( $hero_images as $i => $filename ) : ?>
				<div class="p-hero__slide<?php echo $i === 0 ? ' p-hero__slide--active' : ''; ?>" data-hero-index="<?php echo (int) $i; ?>">
					<div class="p-hero__image">
						<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $filename ) ); ?>" alt="">
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="p-hero__indicators" data-hero-dots aria-hidden="true">
			<?php for ( $i = 0; $i < count( $hero_images ); $i++ ) : ?>
				<button type="button" class="p-hero__dot<?php echo $i === 0 ? ' p-hero__dot--active' : ''; ?>" data-hero-dot-index="<?php echo (int) $i; ?>" aria-label="スライド<?php echo (int) $i + 1; ?>"></button>
			<?php endfor; ?>
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
	foreach ( array( 'news', 'event', 'recipe' ) as $slug ) {
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
			<h2 class="p-news__title">お知らせ</h2>

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
			'image'  => 'bnr_yakage.png',
		),
		array(
			'label' => '矢掛町 × YouTube',
			'url'   => get_theme_mod( 'yakage_instagram_link_center', '#' ),
			'class'  => 'p-instagram__footer-block--youtube',
			'image'  => 'bnr_youtube.png',
		),
		array(
			'label' => '矢掛町地域おこし協力隊',
			'url'   => get_theme_mod( 'yakage_instagram_link_right', '#' ),
			'class'  => 'p-instagram__footer-block--team',
			'image'  => 'bnr_okoshi.png',
		),
	);
	?>
	<section class="p-instagram" id="instagram">
		<div class="l-container">
			<header class="p-instagram__header">
				
				<h2 class="p-instagram__title"><span class="p-instagram__logo" aria-hidden="true">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" role="img" aria-label="Instagram"><defs><linearGradient id="ig-gradient" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#f58529"/><stop offset="50%" style="stop-color:#dd2a7b"/><stop offset="100%" style="stop-color:#8134af"/></linearGradient></defs><path fill="url(#ig-gradient)" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
				</span>公式 Instagram</h2>
				</header>
			<div class="p-instagram__feed">
				<?php echo do_shortcode( '[instagram-feed feed=1]' ); ?>
			</div>
			<div class="p-instagram__cta">
				<a href="<?php echo esc_url( $instagram_url ); ?>" class="p-instagram__follow-btn" target="_blank" rel="noopener noreferrer">follow us</a>
			</div>
			<nav class="p-instagram__footer" aria-label="関連リンク">
				<?php foreach ( $instagram_footer_links as $link ) : ?>
					<a href="<?php echo esc_url( $link['url'] ); ?>" class="p-instagram__footer-block <?php echo esc_attr( $link['class'] ); ?>" target="_blank" rel="noopener noreferrer">
						<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $link['image'] ) ); ?>" alt="<?php echo esc_attr( $link['label'] ); ?>" class="p-instagram__footer-img" width="320" height="80" loading="lazy">
					</a>
				<?php endforeach; ?>
			</nav>
		</div>
	</section>

	<!-- イタリア野菜プロジェクトについて（Phase E）ダミーデータ -->
	<section class="p-project" id="project">
	<div class="gradation_wrap">
		<div class="l-container">
			<header class="p-project__header">
				<h2 class="p-project__title c-border-line-bottom">矢掛町イタリア野菜プロジェクトについて</h2>
				<span class="p-project__title-line" aria-hidden="true"></span>
			</header>

			<div class="p-project__block">
				<h3 class="p-project__heading">矢掛町って?</h3>
				<div class="p-project__body">
					<div class="p-project__text">
						<p>岡山県南西部に位置する人口約1万3千人の小さな町、矢掛町。太陽と清流に恵まれ、野菜や果物が豊かに育つ里山です。江戸時代には旧山陽道の宿場町として栄え、大名行列を迎えてきました。全国でも珍しく本陣と脇本陣がともに現存し、篤姫がお輿入れの際に宿泊した記録も残されています。戦後は空き家となった古民家を一軒ずつ再生し、店舗や宿泊施設として活用。江戸の町並みをよみがえらせ、地域再生の成功例として注目され、重要伝統的建造物群保存地区にも選定されています。</p>
					</div>
					<div class="p-project__image">
						<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/img_about-01.jpg' ) ); ?>" alt="矢掛町の町並み" width="800" height="450" loading="lazy">
					</div>
				</div>
			</div>

			<div class="p-project__block p-project__block--video">
				<h3 class="p-project__heading">SPECIAL movie</h3>
				<div class="p-project__body p-project__body--video">
					<div class="p-project__video-wrap">
						<?php
						$youtube_id = get_theme_mod( 'yakage_project_youtube_id', 'yhibkOmCXow' );
						if ( $youtube_id ) :
							?>
							<iframe src="https://www.youtube.com/embed/<?php echo esc_attr( $youtube_id ); ?>?rel=0&start=0" title="YouTube 動画" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						<?php else : ?>
							<span class="p-project__video-placeholder">YouTube 動画 ID を設定してください</span>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="p-project__block">
				<h3 class="p-project__heading">イタリアチームのホストタウン</h3>
				<div class="p-project__body">
					<div class="p-project__text">
						<p>2018年、矢掛町は分散型宿泊の取り組みが評価され、イタリアのアルベルゴ・ディフーゾ協会から日本初の「アルベルゴ・ディフーゾ・タウン」に認定されました。これを機にイタリアとの交流が深まり、東京2020大会ではイタリア代表のホストタウンにも選定されました。しかし新型コロナウイルスの影響で交流事業は中止に。それでも遠くから応援したいとの思いから、町自慢の野菜でアスリートを支える取り組みが始まりました。</p>
					</div>
					<div class="p-project__image">
						<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/img_about-02.jpg' ) ); ?>" alt="イタリアチーム交流" width="800" height="450" loading="lazy">
					</div>
				</div>
			</div>

			<div class="p-project__block">
				<h3 class="p-project__heading">コロナ禍の中、自慢の野菜でイタリアを応援</h3>
				<div class="p-project__body">
					<div class="p-project__text p-project__text--full">
						<p>矢掛町は「がんばれイタリア！」の思いをトマトやアスパラガス、玉ねぎなど自慢の野菜に託し、所沢で合宿中のイタリア選手団へ届けました。さらに、野菜本来の味わいを生かしたリゾットやスープなどのオリジナルメニューを提供。「実家のマンマの味がする」「野菜の味が濃い」と選手たちからも高い評価をいただき、多くのメダリストも誕生しました。宿場町に息づくおもてなしの心が選手たちを食で支え、生産者にとっても大きな励みとなりました。</p>
					</div>
				</div>
			</div>

			<div class="p-project__block">
				<h3 class="p-project__heading">そうじゃ! イタリア野菜、植えてみよーや</h3>
				<div class="p-project__body">
					<div class="p-project__text">
						<p>この経験を町の一次産業の活性化につなげようと、JA矢掛アグリセンターや生産者、町役場が連携し、2022年に「矢掛町イタリア野菜プロジェクト」を立ち上げました。初挑戦となるイタリア野菜でしたが、温暖な気候や高い晴天率、寒暖差のある中山間地の環境、清流に恵まれ、初年度から順調に生育し出荷が始まっています。</p>
					</div>
					<div class="p-project__image">
						<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/img_about-03.jpg' ) ); ?>" alt="イタリア野菜" width="800" height="450" loading="lazy">
					</div>
				</div>
			</div>
		</div>
</div>
		<div class="p-project__hero">
			<div class="p-project__hero-bg" aria-hidden="true"></div>
			<div class="p-project__hero-overlay">
				<div class="p-project__hero-logo">
					<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/logo_wht.png' ) ); ?>" alt="矢掛町 おもてなしの町" class="p-project__hero-logo-img" width="160" height="160">
				</div>
				<p class="p-project__hero-copy">人をつなぐ、イタリア野菜でありたい。</p>
			</div>
		</div>
	</section>

	<!-- イタリア野菜とは（Phase F） -->
	<?php
	$vegetables_data = array(
		array( 'name' => 'ズッキーニ', 'desc' => '色よし、艶よし。種も少なく、身がずっしり詰まっています', 'season' => '5月中旬〜7月中旬', 'image' => 'img_veg_01.jpg' ),
		array( 'name' => 'カーヴォロ・ネーロ', 'desc' => '凹凸のしっかりついた肉厚の葉が、料理人の期待に応えます。', 'season' => '12月上旬～3月中旬', 'image' => 'img_veg_02.jpg' ),
		array( 'name' => 'サヴォイキャベツ', 'desc' => '煮込むほどに甘くなる。煮込んでも煮崩れない。', 'season' => '12月中旬～1月上旬', 'image' => 'img_veg_03.jpg' ),
		array( 'name' => '満点リーキ', 'desc' => '太さ、巻き、そして甘み。すべてにこだわった自信作。', 'season' => '1月上旬～3月中旬', 'image' => 'img_veg_04.jpg' ),
		array( 'name' => 'フェンネル', 'desc' => '全国のシェフ待望の肉厚フェンネルができました。', 'season' => '6月中旬～7月中旬,11月下旬～3月下旬', 'image' => 'img_veg_05.jpg' ),
		array( 'name' => 'プンタレッラ', 'desc' => '鮮度が命の野菜だから、みんな待ってた国産もの。', 'season' => '12月中旬～2月上旬', 'image' => 'img_veg_06.jpg' ),
		array( 'name' => 'カリーノ・ケール', 'desc' => '苦味が少なく、食べやすいケール', 'season' => '11月中旬～3月下旬', 'image' => 'img_veg_07.jpg' ),
		array( 'name' => 'チーマ・ディ・ラーパ', 'desc' => '煮日本の菜花とは似て非なるこのコシ、味の濃さ。', 'season' => '11月中旬～3月上旬', 'image' => 'img_veg_08.jpg' ),
		array( 'name' => 'ボンジョールノトマト', 'desc' => '加熱すると甘み倍増。型崩れしにくくグリルに最適', 'season' => '7月中旬～9月上旬', 'image' => 'img_veg_09.jpg' ),
	);
	// 読み込み時にランダム配置
	shuffle( $vegetables_data );
	$order_link = get_theme_mod( 'yakage_vegetables_order_url', '#' );
	?>
	<section class="p-vegetables" id="vegetables">
			<div class="p-vegetables__inner">
				<div class="p-vegetables__content">
					<div class="wrap_content">
					<h2 class="p-vegetables__title c-border-line-bottom">イタリア野菜とは</h2>
					<span class="p-vegetables__title-line" aria-hidden="true"></span>
					<p class="p-vegetables__text">イタリア野菜は、イタリア料理に欠かせない品種で、味わいの濃さや程よい苦味、はっきりとした甘味が特徴です。紫や黄色、縞模様など彩りが豊かで、形も個性的なものが多く、料理に華やかさを添えます。リゾットやパスタ、スープなど素材を生かす調理法と相性が良く、加熱することで旨味が一層引き立ちます。矢掛町では、温暖な気候と高い晴天率、寒暖差のある中山間地の環境、清らかな水に恵まれ、野菜本来の味がより濃く育つのが特徴です。（ダミーテキスト）</p>
					<div class="p-vegetables__cta">
						<a href="<?php echo esc_url( $order_link ); ?>" class="c-btn c-btn--red">ご注文はこちら</a>
					</div>
					</div>
				</div>
				<div class="p-vegetables__grid" role="list">
					<?php foreach ( $vegetables_data as $veg ) : ?>
						<div class="p-vegetables__card" role="listitem">
							<?php if ( ! empty( $veg['image'] ) ) : ?>
								<div class="p-vegetables__card-image">
									<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $veg['image'] ) ); ?>" alt="<?php echo esc_attr( $veg['name'] ); ?>" width="400" height="400" loading="lazy">
								</div>
							<?php else : ?>
								<div class="p-vegetables__card-image p-vegetables__card-image--placeholder">
									<span>画像</span>
								</div>
							<?php endif; ?>
							<div class="p-vegetables__card-overlay">
								<div class="wrap_card">
								<p class="p-vegetables__card-name"><?php echo esc_html( $veg['name'] ); ?></p>
								<p class="p-vegetables__card-desc"><?php echo esc_html( $veg['desc'] ); ?></p>
								<span class="p-vegetables__card-season"><?php echo esc_html( $veg['season'] ); ?></span>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
	</section>

	<!-- 生産者紹介（Phase G）ループスライダー -->
	<?php
	$producers_data = array(
		array( 'catchphrase' => '日々のチャレンジを
楽しみ続ける、
マルチプレイヤー', 'name' => '高月 周次郎', 'supplement' => 'イタリア野菜部会長
矢神毎戸営農組合代表理事', 'image' => 'img_frmr_01.jpg' ),
		array( 'catchphrase' => 'へこたれない生き方が、
		へこたれない野菜を生み出す。', 'name' => '江尻健二', 'supplement' => 'チーマ・ディ・ラーパ生産者', 'image' => 'img_frmr_02.jpg' ),
		array( 'catchphrase' => '矢掛のブランド野菜
		「満点リーキ」のマエストロ', 'name' => '三宅幸雄', 'supplement' => 'リーキ生産者', 'image' => 'img_frmr_03.jpg' ),
		array( 'catchphrase' => '“天空のアスパラ畑”の主', 'name' => '中本静満', 'supplement' => 'アスパラ生産者', 'image' => 'img_frmr_04.jpg' ),
		array( 'catchphrase' => '遺伝子工学専攻の
		研究肌トマト職人', 'name' => '出原健吾', 'supplement' => 'トマト生産者', 'image' => 'img_frmr_05.jpg' ),
	);
	?>
	<section class="p-producers c-border-line-top" id="producers">
		<div class="l-container">
			<header class="p-producers__header">
				<span class="p-producers__header-line p-producers__header-line--left" aria-hidden="true"></span>
				<h2 class="p-producers__title">生産者紹介</h2>
				<span class="p-producers__header-line p-producers__header-line--right" aria-hidden="true"></span>
			</header>
			<div class="p-producers__slider">
				<button type="button" class="p-producers__arrow p-producers__arrow--prev" aria-label="前へ"></button>
				<div class="p-producers__viewport">
					<div class="p-producers__track" data-producers-track>
						<?php foreach ( $producers_data as $p ) : ?>
							<div class="p-producers__card">
								<div class="p-producers__card-inner">
									<?php if ( ! empty( $p['image'] ) ) : ?>
										<div class="p-producers__card-image">
											<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $p['image'] ) ); ?>" alt="<?php echo esc_attr( $p['name'] ); ?>" width="400" height="400" loading="lazy">
										</div>
									<?php else : ?>
										<div class="p-producers__card-image p-producers__card-image--placeholder">
											<span>画像</span>
										</div>
									<?php endif; ?>
									<p class="p-producers__card-catch"><?php echo esc_html( $p['catchphrase'] ); ?></p>
									<p class="p-producers__card-name"><?php echo esc_html( $p['name'] ); ?>さん</p>
									<p class="p-producers__card-supplement"><?php echo esc_html( $p['supplement'] ); ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<button type="button" class="p-producers__arrow p-producers__arrow--next" aria-label="次へ"></button>
			</div>
			<div class="p-producers__dots" data-producers-dots aria-hidden="true">
				<?php for ( $i = 0; $i < count( $producers_data ); $i++ ) : ?>
					<button type="button" class="p-producers__dot<?php echo $i === 0 ? ' p-producers__dot--active' : ''; ?>" data-index="<?php echo (int) $i; ?>" aria-label="スライド<?php echo (int) $i + 1; ?>"></button>
				<?php endfor; ?>
			</div>
		</div>
	</section>

	<!-- サポーター紹介（Phase H） -->
	<?php
	$supporters_data = array(
		array( 'name' => '毛利亮シェフ', 'affiliation' => 'リストランテ美郷', 'image' => 'img_spt_01.jpg' ),
		array( 'name' => '三浦慶文シェフ', 'affiliation' => 'トラットリア・デッラ・ラソテルナ・マジカ', 'image' => 'img_spt_02.jpg' ),
		array( 'name' => '陣内秀信名誉教授', 'affiliation' => '法政大学', 'image' => 'img_spt_03.jpg' ),
		array( 'name' => '西山亮介 シェフ', 'affiliation' => 'ソロノイ', 'image' => 'img_spt_04.jpg' ),
		array( 'name' => '清水美絵 シェフ', 'affiliation' => 'カンティーナ・アルコ', 'image' => 'img_spt_05.jpg' ),
		array( 'name' => 'ジョヴァンニカパソネ シェフ', 'affiliation' => 'ディ・マルコ・ジャパソ', 'image' => 'img_spt_06.jpg' ),
		array( 'name' => '岡田幸司 シェフ', 'affiliation' => 'イクリア食材 PIATT', 'image' => 'img_spt_07.jpg' ),
		array( 'name' => 'ビアージョイソコーニト', 'affiliation' => 'はるびぃ農園', 'image' => 'img_spt_08.jpg' ),
		array( 'name' => '北村英紀 シェフ', 'affiliation' => 'イクリア料理ラ・セッテ', 'image' => 'img_spt_09.jpg' ),
		array( 'name' => '片岡幸治 シェフ', 'affiliation' => '岡山プラザホテル', 'image' => 'img_spt_10.jpg' ),
	);
	?>
	<section class="p-supporters" id="supporters">
		<div class="l-container">
			<header class="p-supporters__header">
				<div class="p-supporters__header-banner">
					<span class="p-supporters__header-v p-supporters__header-v--left" aria-hidden="true"></span>
					<h2 class="p-supporters__title">サポーター紹介</h2>
					<span class="p-supporters__header-divider" aria-hidden="true"></span>
					<p class="p-supporters__catchphrase">いつも矢掛町イタリア野菜を応援してくださり、ありがとうございます</p>
					<span class="p-supporters__header-v p-supporters__header-v--right" aria-hidden="true"></span>
				</div>
			</header>
			<div class="p-supporters__grid" role="list">
				<?php foreach ( $supporters_data as $s ) : ?>
					<div class="p-supporters__card" role="listitem">
						<?php if ( ! empty( $s['image'] ) ) : ?>
							<div class="p-supporters__card-photo">
								<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $s['image'] ) ); ?>" alt="<?php echo esc_attr( $s['name'] ); ?>" width="100" height="100" loading="lazy">
							</div>
						<?php else : ?>
							<div class="p-supporters__card-photo p-supporters__card-photo--placeholder">
								<span>写真</span>
							</div>
						<?php endif; ?>
						<div class="p-supporters__card-info">
							<p class="p-supporters__card-name"><?php echo esc_html( $s['name'] ); ?></p>
							<p class="p-supporters__card-affiliation"><?php echo esc_html( $s['affiliation'] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- 実績紹介（Phase I） -->
	<section class="p-achievements" id="achievements">
		<p class="p-achievements__tagline">おもてなしの町、矢掛町のイタリア野菜から、<br>今日もご縁が生まれています。</p>
		<div class="p-achievements__inner">
			<div class="l-container">
				<!-- ブロック1: 大阪・関西万博に出展 -->
				<div class="p-achievements__block">
					<h2 class="p-achievements__title">大阪・関西万博に出展</h2>
					<p class="p-achievements__text">矢掛町のイタリア野菜約20種類を、大阪・関西万博のイタリア館で出展しました。町・JA・生産者が一体となった産地づくりとブランド化の取り組みが評価され、「食と暮らしの未来」をテーマにした週間ではイタリア政府との連携のもと、多くの来場者・メディア・SNSの注目を集めました。</p>
					<div class="p-achievements__gallery p-achievements__gallery--1">
						<div class="p-achievements__img">
							<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/img_archive_03.jpg' ) ); ?>" alt="大阪・関西万博出展" width="800" height="600" loading="lazy">
						</div>
					</div>
				</div>
				<!-- ブロック2: 矢掛町テーブル CROSS -->
				<div class="p-achievements__block">
					<h2 class="p-achievements__title">矢掛町テーブル CROSS</h2>
					<p class="p-achievements__text">県内外の方がイタリア料理を通じて「食卓」でつながる体験型イベントです。「育てる」「つくる」（シェフとともに）、「味わう」の3つのステージで、矢掛町のイタリア野菜と人とのご縁を紡いでいます。</p>
					<div class="p-achievements__gallery p-achievements__gallery--1">
						<div class="p-achievements__img">
							<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/img_archive_02.jpg' ) ); ?>" alt="矢掛町テーブル CROSS" width="800" height="600" loading="lazy">
						</div>
					</div>
				</div>
				<!-- ブロック3: イタリア大使館建国記念パーティ -->
				<div class="p-achievements__block">
					<h2 class="p-achievements__title">イタリア大使館建国記念パーティにて旬のイタリア野菜を提供</h2>
					<div class="p-achievements__gallery p-achievements__gallery--1">
						<div class="p-achievements__img">
							<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/img_archive_01.jpg' ) ); ?>" alt="イタリア大使館建国記念パーティ" width="800" height="600" loading="lazy">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- お問い合わせ（Phase J） -->
	<section class="p-contact" id="contact">
		<div class="l-container">
			<header class="p-contact__header">
				<h2 class="p-contact__title c-border-line-bottom">お問い合わせ</h2>
				
			</header>
			<div class="p-contact__form-wrap">
				<form class="p-contact__form" action="" method="post" novalidate>
					<?php wp_nonce_field( 'yakage_contact', 'yakage_contact_nonce' ); ?>
					<div class="p-contact__field">
						<label for="contact-name">お名前</label>
						<div class="p-contact__input-wrap">
							<input type="text" id="contact-name" name="contact_name" required placeholder="山田 太郎" />
						</div>
					</div>
					<div class="p-contact__field">
						<label for="contact-affiliation">所属</label>
						<div class="p-contact__input-wrap">
							<input type="text" id="contact-affiliation" name="contact_affiliation" placeholder="会社名・団体名など" />
						</div>
					</div>
					<div class="p-contact__field">
						<label for="contact-email">メールアドレス</label>
						<div class="p-contact__input-wrap">
							<input type="email" id="contact-email" name="contact_email" required placeholder="example@example.com" />
						</div>
					</div>
					<div class="p-contact__field">
						<label for="contact-tel">TEL</label>
						<div class="p-contact__input-wrap">
							<input type="tel" id="contact-tel" name="contact_tel" placeholder="090-1234-5678" />
						</div>
					</div>
					<div class="p-contact__field">
						<label for="contact-body">内容</label>
						<div class="p-contact__input-wrap">
							<textarea id="contact-body" name="contact_body" rows="6" required placeholder="お問い合わせ内容をご記入ください"></textarea>
						</div>
					</div>
					<div class="p-contact__consent">
						<span class="p-contact__consent-label">個人情報の取り扱い</span>
						<label class="p-contact__checkbox-wrap">
							<input type="checkbox" name="contact_consent" required value="1" />
							<span class="p-contact__checkbox-text">同意します</span>
						</label>
					</div>
					<p class="p-contact__submit">
						<button type="submit" class="c-btn c-btn--green">送信</button>
					</p>
				</form>
			</div>
			<span class="p-contact__note-line" aria-hidden="true"></span>
			<p class="p-contact__note">※担当者より内容確認次第、返信させていただきます。</p>
		</div>
	</section>
</main>

<?php
get_footer();
