<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _s
 */

 get_header();?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found" style="margin: 5%;">
				<header class="page-header">
					<h1 class="page-title" style="margin-top: 20px; font-family: sans-serif;"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', '_s' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content" style="font-family: sans-serif;">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. It might help to try a link from the menu. :)', '_s' ); ?></p>


				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
