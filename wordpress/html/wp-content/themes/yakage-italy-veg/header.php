<?php
/**
 * ヘッダーテンプレート
 *
 * @package Yakage_Italy_Veg
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="l-header">
	<div class="l-container">
		<div class="l-header__inner">
			<div class="l-header__logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">YAKAGE ITALY VEG SITE</a>
			</div>
			<nav class="l-header__nav">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'     => 'yakage_italy_veg_default_menu',
				) );
				?>
			</nav>
		</div>
	</div>
</header>
