<?php
/**
 * Yakage Italy Veg Theme Functions
 *
 * @package Yakage_Italy_Veg
 * @since 0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * テーマサポート
 */
function yakage_italy_veg_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
	) );
}
add_action( 'after_setup_theme', 'yakage_italy_veg_setup' );

/**
 * お知らせ用カテゴリー（お知らせ・イベント・レシピ・PICKUP）を登録
 * 初回のみ作成
 */
function yakage_italy_veg_register_news_categories() {
	if ( get_option( 'yakage_italy_veg_news_categories_created' ) ) {
		return;
	}
	$categories = array(
		array( 'name' => 'お知らせ', 'slug' => 'news' ),
		array( 'name' => 'イベント', 'slug' => 'event' ),
		array( 'name' => 'レシピ', 'slug' => 'recipe' ),
		array( 'name' => 'PICKUP', 'slug' => 'pickup' ),
	);
	foreach ( $categories as $cat ) {
		if ( ! term_exists( $cat['slug'], 'category' ) ) {
			wp_insert_term( $cat['name'], 'category', array( 'slug' => $cat['slug'] ) );
		}
	}
	update_option( 'yakage_italy_veg_news_categories_created', true );
}
add_action( 'init', 'yakage_italy_veg_register_news_categories' );

/**
 * アーカイブタイトルのプレフィックスを削除（「カテゴリー:」等）
 */
function yakage_italy_veg_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author();
	} elseif ( is_year() ) {
		$title = get_the_date( 'Y年' );
	} elseif ( is_month() ) {
		$title = get_the_date( 'Y年n月' );
	} elseif ( is_day() ) {
		$title = get_the_date( 'Y年n月j日' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'yakage_italy_veg_archive_title' );

/**
 * スクリプト・スタイルの読み込み
 */
function yakage_italy_veg_scripts() {
	// Google Fonts: Zen Maru Gothic
	wp_enqueue_style(
		'google-font-zen-maru-gothic',
		'https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic:wght@400;500;700&display=swap',
		array(),
		null
	);
	$theme_version = '0.1.0';
	$style_path    = get_stylesheet_directory() . '/style.css';
	if ( file_exists( $style_path ) ) {
		// 開発時: 毎回別 URL にしてキャッシュを避け、リロードで確実に最新 CSS を読む
		$theme_version = defined( 'WP_DEBUG' ) && WP_DEBUG ? (string) time() : (string) filemtime( $style_path );
	}
	wp_enqueue_style(
		'yakage-italy-veg-style',
		get_stylesheet_uri(),
		array( 'google-font-zen-maru-gothic' ),
		$theme_version
	);
	wp_enqueue_script(
		'yakage-italy-veg-header',
		get_theme_file_uri( 'assets/js/header.js' ),
		array(),
		'0.1.0',
		true
	);
	wp_enqueue_script(
		'yakage-italy-veg-hero-slider',
		get_theme_file_uri( 'assets/js/hero-slider.js' ),
		array(),
		'0.1.0',
		true
	);
	wp_enqueue_script(
		'yakage-italy-veg-news-slider',
		get_theme_file_uri( 'assets/js/news-slider.js' ),
		array(),
		'0.1.0',
		true
	);
	wp_enqueue_script(
		'yakage-italy-veg-vegetables',
		get_theme_file_uri( 'assets/js/vegetables.js' ),
		array(),
		'0.1.0',
		true
	);
	wp_enqueue_script(
		'yakage-italy-veg-producers-slider',
		get_theme_file_uri( 'assets/js/producers-slider.js' ),
		array(),
		'0.1.0',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'yakage_italy_veg_scripts' );

/**
 * メニュー登録
 */
function yakage_italy_veg_menus() {
	register_nav_menus( array(
		'primary' => __( 'メインメニュー', 'yakage-italy-veg' ),
	) );
}
add_action( 'init', 'yakage_italy_veg_menus' );

/**
 * メニュー未設定時のデフォルト表示
 */
function yakage_italy_veg_default_menu() {
	echo '<ul class="c-nav-list">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">TOP</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/' ) . '#project' ) . '">プロジェクトについて</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/' ) . '#vegetables' ) . '">イタリア野菜とは</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/' ) . '#producers' ) . '">生産者紹介</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/' ) . '#supporters' ) . '">サポーター紹介</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/' ) . '#contact' ) . '">お問い合わせ</a></li>';
	echo '</ul>';
}

/**
 * すべての投稿記事一覧 URL（もっと見る用）
 * 固定ページ「NEWS」（スラッグ: news）の URL を返す
 */
function yakage_italy_veg_get_news_archive_url() {
	$news_page = get_page_by_path( 'news' );
	if ( $news_page ) {
		return get_permalink( $news_page );
	}
	return home_url( '/news/' );
}

/**
 * カスタマイザー: Instagram セクション用 URL
 */
function yakage_italy_veg_customize_register_instagram( $wp_customize ) {
	$wp_customize->add_section( 'yakage_instagram', array(
		'title'    => __( 'Instagram セクション', 'yakage-italy-veg' ),
		'priority' => 120,
	) );
	$wp_customize->add_setting( 'yakage_instagram_url', array(
		'default'           => 'https://www.instagram.com/',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'yakage_instagram_url', array(
		'label'   => __( '公式 Instagram URL（follow us ボタン先）', 'yakage-italy-veg' ),
		'section' => 'yakage_instagram',
		'type'    => 'url',
	) );
	$wp_customize->add_setting( 'yakage_instagram_link_left', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'yakage_instagram_link_left', array(
		'label'   => __( '左下ブロック URL（岡山県 矢掛町）', 'yakage-italy-veg' ),
		'section' => 'yakage_instagram',
		'type'    => 'url',
	) );
	$wp_customize->add_setting( 'yakage_instagram_link_center', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'yakage_instagram_link_center', array(
		'label'   => __( '中央ブロック URL（矢掛町 × YouTube）', 'yakage-italy-veg' ),
		'section' => 'yakage_instagram',
		'type'    => 'url',
	) );
	$wp_customize->add_setting( 'yakage_instagram_link_right', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'yakage_instagram_link_right', array(
		'label'   => __( '右下ブロック URL（矢掛町地域おこし協力隊）', 'yakage-italy-veg' ),
		'section' => 'yakage_instagram',
		'type'    => 'url',
	) );
}
add_action( 'customize_register', 'yakage_italy_veg_customize_register_instagram' );

/**
 * カスタマイザー: イタリア野菜プロジェクトについて（Phase E）YouTube 動画 ID
 */
function yakage_italy_veg_customize_register_project( $wp_customize ) {
	$wp_customize->add_section( 'yakage_project', array(
		'title'    => __( 'イタリア野菜プロジェクトについて', 'yakage-italy-veg' ),
		'priority' => 125,
	) );
	$wp_customize->add_setting( 'yakage_project_youtube_id', array(
		'default'           => 'jNQXAC9IVRw',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'yakage_project_youtube_id', array(
		'label'       => __( 'YouTube 動画 ID（SPECIAL movie 埋め込み）', 'yakage-italy-veg' ),
		'description' => __( '例: 動画 URL が https://www.youtube.com/watch?v=XXXXXXXX の場合、XXXXXXXX のみ入力', 'yakage-italy-veg' ),
		'section'     => 'yakage_project',
		'type'        => 'text',
	) );
}
add_action( 'customize_register', 'yakage_italy_veg_customize_register_project' );

/**
 * カスタマイザー: イタリア野菜とは（Phase F）
 */
function yakage_italy_veg_customize_register_vegetables( $wp_customize ) {
	$wp_customize->add_section( 'yakage_vegetables', array(
		'title'    => __( 'イタリア野菜とは', 'yakage-italy-veg' ),
		'priority' => 127,
	) );
	$wp_customize->add_setting( 'yakage_vegetables_order_url', array(
		'default'           => 'https://forms.gle/1hs63P1vK5d8qavN8',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'yakage_vegetables_order_url', array(
		'label'   => __( 'ご注文はこちら ボタン URL', 'yakage-italy-veg' ),
		'section' => 'yakage_vegetables',
		'type'    => 'url',
	) );
}
add_action( 'customize_register', 'yakage_italy_veg_customize_register_vegetables' );

/**
 * ドロワー用メニュー未設定時の表示
 */
function yakage_italy_veg_default_drawer_menu() {
	echo '<ul class="c-drawer-nav">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">TOP</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/' ) . '#project' ) . '">プロジェクトについて</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/' ) . '#vegetables' ) . '">イタリア野菜とは</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/' ) . '#producers' ) . '">生産者紹介</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/' ) . '#supporters' ) . '">サポーター紹介</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/' ) . '#contact' ) . '">お問い合わせ</a></li>';
	echo '</ul>';
}

/**
 * Contact Form 7: 自動 <p> タグ挿入を無効化
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );
