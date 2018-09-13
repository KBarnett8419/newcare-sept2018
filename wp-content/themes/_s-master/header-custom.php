<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @import url('https://fonts.googleapis.com/css?family=Brawler|Prata|Tinos|Vidaloka');
 * @package _s
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link href="https://fonts.googleapis.com/css?family=Prata|Raleway" rel="stylesheet">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', '_s' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding" style="margin-top: -110px; position: relative; left: 20px">
			<div class="logo">
			<img src='http://newcarenj.org/wp-content/uploads/2017/08/nc-logo-e1503608099114.png' alt='new-care-associates-logo' style="position: relative; top: 100px"/><h1 style="display: none">New Care Associates</h1>
				</div><!--logo-->
			<h2 class="motto" style="display: none">"Together We Achieve."</h2>
		</div><!-- .site-branding -->

			<div class="contact-header">
				<h3>EMPLOYEE PORTAL</h3>
			</div>

		<nav id="portal-navigation" class="portal-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', '_s' ); ?></button>
				<?php wp_nav_menu( array( 'theme_location' => 'portal-menu' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
