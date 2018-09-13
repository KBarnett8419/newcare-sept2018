<?php
/**
* Template Name: Add Upload Template
*
* @package WordPress
* @subpackage Chorui
* @since Chorui 1.0
*/
get_header('custom'); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
		<div class="nc-content-wrapper">
		<h3 style="margin: 50px 0; ">Add New Upload Documents</h3>
		<?php if ($_GET['results'] == "success"): ?>
		<p style="color: green;">Uploaded Successfully</p>
		<?php elseif ($_GET['results'] == "fail"): ?>
		<p style="color: red;">Failed to Upload </p>
		<?php endif; ?>
		<div class="add_upload_content">
		<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post" enctype="multipart/form-data">
			<div class="brief_input">
			<p for="category">Select Category: </p>
			<?php
			$select_cats = wp_dropdown_categories( array( 'echo' => 0, 'taxonomy' => 'briefcase-type', 'hide_empty' => 0 ) );
			$select_cats = str_replace( "name='cat' id=", "name='cat[]' id=", $select_cats );
			echo $select_cats;?>
			</div>
			<div class="brief_input">
				<p for="upload_file">Upload File: </p>
				<input type="file" name="upload_attachment" />
			</div>
			<div class="brief_input">
				<p for="upload_file">Message: </p>
				<textarea name="message"></textarea>
			</div>
			<input type="hidden" name="briefcase_action" value="briefcase" />
			<div class="button">
			<input type="submit" value="Upload" />
			<input type="button" onclick="location.href='http://newcarenj.org/upload/';" value="Cancel" />
			</div>
		</form>
		</div>
		<a href="http://newcarenj.org/upload" style="color:#990000; font-weight:bold; font-family: Sans Serif">Click here to view all uploads.</a>
		</div>
	</main><!-- #main -->
	</div><!-- #primary -->
<?php get_footer(); ?>
