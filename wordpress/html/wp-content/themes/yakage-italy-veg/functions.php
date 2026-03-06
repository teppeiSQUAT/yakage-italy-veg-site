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
		array( 'name' => 'お知らせ', 'slug' => 'otoshirase' ),
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
	wp_enqueue_style(
		'yakage-italy-veg-style',
		get_stylesheet_uri(),
		array( 'google-font-zen-maru-gothic' ),
		'0.1.0'
	);
	wp_enqueue_script(
		'yakage-italy-veg-header',
		get_theme_file_uri( 'assets/js/header.js' ),
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
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">HOME</a></li>';
	echo '<li><a href="#">野菜紹介</a></li>';
	echo '<li><a href="#">イベント</a></li>';
	echo '<li><a href="#">農家紹介</a></li>';
	echo '<li><a href="#">アクセス</a></li>';
	echo '<li><a href="#">お問い合わせ</a></li>';
	echo '</ul>';
}

/**
 * お知らせアーカイブページ URL（もっと見る用）
 * 投稿ページが設定されていればその URL、なければお知らせカテゴリのアーカイブ
 */
function yakage_italy_veg_get_news_archive_url() {
	$posts_page_id = get_option( 'page_for_posts' );
	if ( $posts_page_id ) {
		return get_permalink( $posts_page_id );
	}
	$cat = get_category_by_slug( 'otoshirase' );
	if ( $cat ) {
		return get_category_link( $cat->term_id );
	}
	return home_url( '/' );
}

/**
 * ドロワー用メニュー未設定時の表示
 */
function yakage_italy_veg_default_drawer_menu() {
	echo '<ul class="c-drawer-nav">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">HOME</a></li>';
	echo '<li><a href="#">野菜紹介</a></li>';
	echo '<li><a href="#">イベント</a></li>';
	echo '<li><a href="#">農家紹介</a></li>';
	echo '<li><a href="#">アクセス</a></li>';
	echo '<li><a href="#">お問い合わせ</a></li>';
	echo '</ul>';
}
