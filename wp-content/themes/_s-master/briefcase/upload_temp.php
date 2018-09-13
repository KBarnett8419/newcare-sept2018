<?php
/**
* Template Name: Upload Template
*
* @package WordPress
* @subpackage Chorui
* @since Chorui 1.0
*/
get_header('custom');

$user_id= get_current_user_id();
$roles = get_current_user_role();

$delete_post =$_GET['delete_post'];
$attachid =$_GET['attachid'];

if ( !empty($delete_post) && !empty($attachid) ) {
	wp_delete_post($delete_post);
	wp_delete_attachment($attachid);

	header("Location: http://newcarenj.org/upload/");
	die();	
}

?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
		<div class="nc-content-wrapper" id="upload-table-wrapper" style="margin: 5%;">
		<h3 style="text-align: center; margin: 50px 0; ">Upload your Parent Signatures here</h3>
		<div class="addbutton" style="margin-bottom: 50px; text-align: center;">
			<a href="http://newcarenj.org/add-upload/" style="color: #000;" ><input id="upload-doc" name="submit" type="button" value="Upload Document"></a>
		</div>
		<?php if ($roles != "Subscriber" ): ?>
		<div class="user_filter" style="margin-bottom: 30px;">
		<form method="get" action="http://newcarenj.org/upload/">
			<label style="font-family: sans-serif; font-size: 1.1em; font-weight: bold;">Username:</label>
			<?php wp_dropdown_users(array('name' => 'user_id', 'selected' => 0,
				'show_option_all' => 'All', 'role__not_in' => 'Administrator' )); ?>
			<input type="submit" id="ufbtn" value="Search" />
		</form>
		</div>
		<?php endif; ?>

		<p class="table-message" style="font-family: sans-serif; color: #990000;">Mobile/Tablet: Scroll to the right to view entire table.</p>

		<div class="upload_content" style="overflow-x: auto;">
					<table style="border-collapse: collapse; width: 100%;">
				<tr>
					<th>Date</th>
					<th class="name">Name</th>
					<th>Staff Name</th>
					<th>Category</th>
					<th class="message">Message</th>
					<th>Download</th>
					<th>Delete</th>
				</tr>

<?php

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1; // setup pagination

if ($roles == "Subscriber" ) {
$args = array(
    'author' =>  $user_id,
    'posts_per_page' => '10',
    'paged' => $paged,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'briefcase',
    'post_status' => 'publish'
);
} elseif (!empty($_GET['user_id'])) {
$args = array(
    'author' =>  $_GET['user_id'],
    'posts_per_page' => '10',
    'paged' => $paged,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'briefcase',
    'post_status' => 'publish'
);
} else {
$args = array(
    'posts_per_page' => '10',
    'paged' => $paged,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'briefcase',
    'post_status' => 'publish'
);
}


$recent_posts = new WP_Query( $args );

while( $recent_posts->have_posts() ): $recent_posts->the_post();
	global $post;
	$attachid = get_post_meta($post->ID, 'upatt_cmb_attachfile', true);
	$attachment_url = wp_get_attachment_url($attachid);
	$filetype = get_post_meta($post->ID, 'upatt_cmb_filetype', true);
	$bcat= wp_get_post_terms( $post->ID, 'briefcase-type' );
?>

					<tr>
					<td> <?php echo get_the_date( 'd-m-Y' ); ?></td>
					<td> <?php echo the_title(); ?> </td>
					<td> <?php echo get_author_name(); /*echo $filetype;*/ ?> </td>
					<td> <?php foreach ($bcat as $cat) { echo $cat->name; } ?> </td>
					<td> <?php echo the_content(); ?></td>
					<td>
						<a style="color: #000;" href="<?php echo $attachment_url;?>" download>Download</a>
					</td>
					<td>
						<a style="color: #000;" href="?delete_post=<?php echo $post->ID; ?>&attachid=<?php echo $attachid; ?>">Delete</a>
					</td>
				</tr>

<?php 
endwhile; 

echo '</table>';

$total = $recent_posts->max_num_pages;



// only bother with the rest if we have more than 1 page!
if ( $total > 1 )  {
     // get the current page
     if ( !$current_page = get_query_var('paged') )
          $current_page = 1;
     // structure of "format" depends on whether we're using pretty permalinks
     if( $_GET['user_id'] != "" ) {
	     $format = '&paged=%#%';
     } else {
	     $format = 'page/%#%/';
     }
     echo paginate_links(array(
          'base'     => get_pagenum_link(1) . '%_%',
          'format'   => $format,
          'current'  => $current_page,
          'total'    => $total,
          'mid_size' => 4,
          'type'     => 'list'
     ));
}

wp_reset_postdata();
?>

			
		</div>
		</div>
	</main><!-- #main -->
	</div><!-- #primary -->
		<?php get_footer(); ?>
