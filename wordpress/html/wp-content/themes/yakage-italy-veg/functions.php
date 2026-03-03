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
 * スクリプト・スタイルの読み込み
 */
function yakage_italy_veg_scripts() {
	wp_enqueue_style(
		'yakage-italy-veg-style',
		get_stylesheet_uri(),
		array(),
		'0.1.0'
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
