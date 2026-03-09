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

	<!-- イタリア野菜プロジェクトについて（Phase E）ダミーデータ -->
	<section class="p-project" id="project">
		<div class="l-container">
			<header class="p-project__header">
				<h2 class="p-project__title">矢掛町イタリア野菜プロジェクトについて</h2>
				<span class="p-project__title-line" aria-hidden="true"></span>
			</header>

			<div class="p-project__block">
				<h3 class="p-project__heading">矢掛町って?</h3>
				<div class="p-project__body">
					<div class="p-project__text">
						<p>矢掛町は岡山県の南西部に位置し、人口約〇〇〇〇人のまちです。江戸時代には山陽道の宿場町として栄え、今も町並みが残っています。温暖な気候と豊かな土壌に恵まれ、米や野菜、果物など多様な農産物が生産されています。（ダミーテキスト）</p>
					</div>
					<div class="p-project__image p-project__image--placeholder">
						<span>画像（矢掛町の町並み）</span>
					</div>
				</div>
			</div>

			<div class="p-project__block">
				<h3 class="p-project__heading">SPECIAL movie</h3>
				<div class="p-project__body p-project__body--video">
					<div class="p-project__video-wrap">
						<?php
						$youtube_id = get_theme_mod( 'yakage_project_youtube_id', 'jNQXAC9IVRw' );
						if ( $youtube_id ) :
							?>
							<iframe src="https://www.youtube.com/embed/<?php echo esc_attr( $youtube_id ); ?>?rel=0" title="YouTube 動画" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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
						<p>矢掛町は〇〇〇〇年、東京オリンピック・パラリンピックにおけるイタリアチームのホストタウンに選ばれました。大会延期やコロナ禍のなか、交流の形を模索しながら、地元の野菜や食文化でイタリアを応援してきました。（ダミーテキスト）</p>
					</div>
					<div class="p-project__image p-project__image--placeholder">
						<span>画像（イタリアチーム交流）</span>
					</div>
				</div>
			</div>

			<div class="p-project__block">
				<h3 class="p-project__heading">コロナ禍の中、自慢の野菜でイタリアを応援</h3>
				<div class="p-project__body">
					<div class="p-project__text">
						<p>渡航が難しい時期、矢掛町からは地元で育てた野菜や、それを使ったオリジナル料理のレシピをイタリアに届けました。現地でも「おいしい」「心が温まった」と好評をいただき、野菜を通じたつながりを実感しています。（ダミーテキスト）</p>
					</div>
				</div>
			</div>

			<div class="p-project__block">
				<h3 class="p-project__heading">そうじゃ! イタリア野菜、植えてみよーや</h3>
				<div class="p-project__body">
					<div class="p-project__text">
						<p>そんな経験を経て、〇〇〇〇年に「矢掛町イタリア野菜プロジェクト」がスタート。地元の農家さんとともに、イタリア野菜の栽培や普及に取り組んでいます。太陽の光をたっぷり浴びた、おいしいイタリア野菜をぜひ味わってください。（ダミーテキスト）</p>
					</div>
					<div class="p-project__image p-project__image--placeholder">
						<span>画像（イタリア野菜）</span>
					</div>
				</div>
			</div>
		</div>

		<div class="p-project__hero">
			<div class="p-project__hero-bg p-project__hero-bg--placeholder">
				<span>背景画像（矢掛町の景観）</span>
			</div>
			<div class="p-project__hero-overlay">
				<div class="p-project__hero-logo">
					<span class="p-project__hero-logo-inner">矢掛町<br>おもてなしの町</span>
				</div>
				<p class="p-project__hero-copy">人をつなぐ、イタリア野菜でありたい。</p>
			</div>
		</div>
	</section>

	<!-- イタリア野菜とは（Phase F） -->
	<?php
	$vegetables_data = array(
		array( 'name' => 'ズッキーニ', 'desc' => '色よし、艶よし。種も少なく、身がずっしり詰まっています', 'season' => '5月中旬〜7月中旬' ),
		array( 'name' => 'カーボロネーロ', 'desc' => 'トスカーナの黒キャベツ。加熱で甘みとコクが増します', 'season' => '12月〜3月' ),
		array( 'name' => 'サボイキャベツ', 'desc' => 'ちりめん状の葉が特徴。甘みがあり煮崩れしにくい', 'season' => '11月〜2月' ),
		array( 'name' => 'リーキ', 'desc' => '西洋ネギ。やわらかく甘みがあり、スープやグラタンに', 'season' => '11月〜2月' ),
		array( 'name' => 'チコリ', 'desc' => 'ほろ苦さが特徴。サラダやグリルで', 'season' => '4月〜6月' ),
		array( 'name' => 'プチヴェール', 'desc' => '芽キャベツとケールの交配。小さな緑の蕾がかわいい', 'season' => '12月〜2月' ),
		array( 'name' => 'ルッコラ', 'desc' => 'ゴマのような風味とピリッとした辛み。サラダやパスタに', 'season' => '4月〜6月・10月〜11月' ),
		array( 'name' => 'プラムトマト', 'desc' => '煮込みやソースに最適。甘みと酸味のバランスが良い', 'season' => '6月〜9月' ),
		array( 'name' => 'ナス', 'desc' => '紫の実は加熱でとろり。イタリアでは焼く・揚げるが定番', 'season' => '6月〜9月' ),
	);
	// 読み込み時にランダム配置
	shuffle( $vegetables_data );
	$order_link = get_theme_mod( 'yakage_vegetables_order_url', '#' );
	?>
	<section class="p-vegetables" id="vegetables">
		<div class="l-container">
			<div class="p-vegetables__inner">
				<div class="p-vegetables__content">
					<h2 class="p-vegetables__title">イタリア野菜とは</h2>
					<span class="p-vegetables__title-line" aria-hidden="true"></span>
					<p class="p-vegetables__text">イタリア野菜は、イタリア料理に欠かせない品種で、味わいの濃さや程よい苦味、はっきりとした甘味が特徴です。紫や黄色、縞模様など彩りが豊かで、形も個性的なものが多く、料理に華やかさを添えます。リゾットやパスタ、スープなど素材を生かす調理法と相性が良く、加熱することで旨味が一層引き立ちます。矢掛町では、温暖な気候と高い晴天率、寒暖差のある中山間地の環境、清らかな水に恵まれ、野菜本来の味がより濃く育つのが特徴です。（ダミーテキスト）</p>
					<div class="p-vegetables__cta">
						<a href="<?php echo esc_url( $order_link ); ?>" class="c-btn c-btn--red">ご注文はこちら</a>
					</div>
				</div>
				<div class="p-vegetables__grid" role="list">
					<?php foreach ( $vegetables_data as $veg ) : ?>
						<div class="p-vegetables__card" role="listitem">
							<div class="p-vegetables__card-image p-vegetables__card-image--placeholder">
								<span>画像</span>
							</div>
							<div class="p-vegetables__card-overlay">
								<p class="p-vegetables__card-name"><?php echo esc_html( $veg['name'] ); ?></p>
								<p class="p-vegetables__card-desc"><?php echo esc_html( $veg['desc'] ); ?></p>
								<span class="p-vegetables__card-season"><?php echo esc_html( $veg['season'] ); ?></span>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<!-- 生産者紹介（Phase G）ループスライダー -->
	<?php
	$producers_data = array(
		array( 'catchphrase' => 'チャレンジを楽しむ、レチプレイヤー。', 'name' => '月周次郎', 'supplement' => 'ノア野菜部会長 矢神毎戸営農組合代表理事' ),
		array( 'catchphrase' => 'へこたれない生き方が、へこたれない野菜を生み出す。', 'name' => '江尻健二', 'supplement' => 'チーマ・ディ・ラーパ生産者' ),
		array( 'catchphrase' => '矢掛のブランド野菜「満点リーキ」のマエストロ', 'name' => '中本静満', 'supplement' => 'リーキ生産者' ),
		array( 'catchphrase' => '天空のアスペで、空に届く野菜を。', 'name' => '山田一郎', 'supplement' => '中山間地栽培' ),
		array( 'catchphrase' => '土と向き合い、ひとつひとつ手をかける。', 'name' => '佐藤花子', 'supplement' => 'イタリア野菜生産者' ),
		array( 'catchphrase' => 'おいしいは、笑顔の先にある。', 'name' => '田村誠', 'supplement' => '直売所担当 生産者' ),
	);
	?>
	<section class="p-producers" id="producers">
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
									<div class="p-producers__card-image p-producers__card-image--placeholder">
										<span>画像</span>
									</div>
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
		array( 'name' => '毛利亮シェフ', 'affiliation' => 'リストランテ美郷' ),
		array( 'name' => '西山亮介オーナー兼マネージャー', 'affiliation' => 'ソロノイ' ),
		array( 'name' => 'ジョヴァンニカパンネリ代表取締役', 'affiliation' => 'ディ・マルコ・ジャパン' ),
		array( 'name' => 'ビアージョインコーニト シェフ', 'affiliation' => 'はるぴい農園' ),
		array( 'name' => '清水美絵シェフ', 'affiliation' => 'カンティーナ・アルコ' ),
		array( 'name' => '北村英紀シェフ', 'affiliation' => 'イタリア料理ラ・セッテ' ),
		array( 'name' => '岡田幸司さん', 'affiliation' => 'イタリア食材 PIATTI' ),
		array( 'name' => '陣内秀信名誉教授', 'affiliation' => '法政大学' ),
		array( 'name' => '三浦慶文シェフ', 'affiliation' => 'トラットリア・デッラ・ラソテルナ・マジカ' ),
	);
	?>
	<section class="p-supporters" id="supporters">
		<div class="l-container">
			<header class="p-supporters__header">
				<div class="p-supporters__header-banner">
					<h2 class="p-supporters__title">サポーター紹介</h2>
					<span class="p-supporters__header-divider" aria-hidden="true"></span>
					<p class="p-supporters__catchphrase">いつも矢掛町イタリア野菜を応援してくださり、ありがとうございます</p>
				</div>
			</header>
			<div class="p-supporters__grid" role="list">
				<?php foreach ( $supporters_data as $s ) : ?>
					<div class="p-supporters__card" role="listitem">
						<div class="p-supporters__card-photo p-supporters__card-photo--placeholder">
							<span>写真</span>
						</div>
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
		<p class="p-achievements__tagline">おもてなしの町、矢掛町のイタリア野菜から、今日もご縁が生まれています。</p>
		<div class="p-achievements__inner">
			<div class="l-container">
				<!-- ブロック1: 大阪・関西万博に出展 -->
				<div class="p-achievements__block">
					<h2 class="p-achievements__title">大阪・関西万博に出展</h2>
					<p class="p-achievements__text">矢掛町のイタリア野菜約20種類を、大阪・関西万博のイタリア館で出展しました。町・JA・生産者が一体となった産地づくりとブランド化の取り組みが評価され、「食と暮らしの未来」をテーマにした週間ではイタリア政府との連携のもと、多くの来場者・メディア・SNSの注目を集めました。</p>
					<div class="p-achievements__gallery p-achievements__gallery--6">
						<?php for ( $i = 0; $i < 6; $i++ ) : ?>
							<div class="p-achievements__img p-achievements__img--placeholder"><span>画像</span></div>
						<?php endfor; ?>
					</div>
				</div>
				<!-- ブロック2: 矢掛町テーブル CROSS -->
				<div class="p-achievements__block">
					<h2 class="p-achievements__title">矢掛町テーブル CROSS</h2>
					<p class="p-achievements__text">県内外の方がイタリア料理を通じて「食卓」でつながる体験型イベントです。「育てる」「つくる」（シェフとともに）、「味わう」の3つのステージで、矢掛町のイタリア野菜と人とのご縁を紡いでいます。</p>
					<div class="p-achievements__gallery p-achievements__gallery--6">
						<?php for ( $i = 0; $i < 6; $i++ ) : ?>
							<div class="p-achievements__img p-achievements__img--placeholder"><span>画像</span></div>
						<?php endfor; ?>
					</div>
				</div>
				<!-- ブロック3: イタリア大使館建国記念パーティ -->
				<div class="p-achievements__block">
					<h2 class="p-achievements__title">イタリア大使館建国記念パーティにて旬のイタリア野菜を提供</h2>
					<div class="p-achievements__gallery p-achievements__gallery--3">
						<?php for ( $i = 0; $i < 3; $i++ ) : ?>
							<div class="p-achievements__img p-achievements__img--placeholder"><span>画像</span></div>
						<?php endfor; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- お問い合わせ（Phase J） -->
	<section class="p-contact" id="contact">
		<div class="l-container">
			<header class="p-contact__header">
				<h2 class="p-contact__title">お問い合わせ</h2>
				<span class="p-contact__title-line" aria-hidden="true"></span>
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
