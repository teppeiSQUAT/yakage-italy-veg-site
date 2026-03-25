<?php
/**
 * ヘッダーテンプレート
 * TOP: 初回はヒーロー上、スクロールで上からスライドイン固定。下層: 常時表示。
 *
 * @package Yakage_Italy_Veg
 */
$is_front = is_front_page();
$header_class = 'l-header';
if ( $is_front ) {
	$header_class .= ' l-header--top';
} else {
	$header_class .= ' l-header--sub';
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class( $is_front ? 'is-front-page' : '' ); ?>>
<?php wp_body_open(); ?>

<header class="<?php echo esc_attr( $header_class ); ?>" id="site-header">
	<div class="l-container l-header__container">
		<div class="l-header__inner">
			<div class="l-header__logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/logo.png' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="l-header__logo-img l-header__logo-img--main" />
					<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/logo_sub.png' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="l-header__logo-img l-header__logo-img--sub" />
				</a>
			</div>
			<nav class="l-header__nav" aria-label="メインメニュー">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'     => 'yakage_italy_veg_default_menu',
				) );
				?>
			</nav>
			<button type="button" class="l-header__hamburger c-hamburger" aria-label="メニューを開く" aria-expanded="false" aria-controls="drawer-nav">
				<span class="c-hamburger__bar"></span>
				<span class="c-hamburger__bar"></span>
				<span class="c-hamburger__bar"></span>
			</button>
		</div>
	</div>
</header>

<div class="l-drawer-overlay" id="drawer-overlay" aria-hidden="true"></div>
<nav class="l-drawer" id="drawer-nav" aria-label="ドロワーメニュー">
	<button type="button" class="l-drawer__close c-close-btn" aria-label="メニューを閉じる">
		<span class="c-close-btn__bar"></span>
		<span class="c-close-btn__bar"></span>
	</button>
	<?php
	wp_nav_menu( array(
		'theme_location' => 'primary',
		'container'      => false,
		'menu_class'     => 'c-drawer-nav',
		'fallback_cb'    => 'yakage_italy_veg_default_drawer_menu',
	) );
	?>
</nav>
