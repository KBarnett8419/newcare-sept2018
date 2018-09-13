<?php

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['briefcase_action'] ) && $_POST['briefcase_action'] == "briefcase" ) {

if(!empty($_POST['cat']) && !empty($_POST['message']) && !empty($_FILES['upload_attachment']['name']) && $_FILES['upload_attachment']["size"] != 0) {

global $post;

if ( $_FILES ) {
	$files = $_FILES['upload_attachment'];

			$file = array(
				'name'     => $files['name'],
				'type'     => $files['type'],
				'tmp_name' => $files['tmp_name'],
				'error'    => $files['error'],
				'size'     => $files['size']
			);
			$_FILES = array("upload_attachment" => $file);
			foreach ($_FILES as $file => $array) {
				$newupload = insert_attachment($file,$post->ID);
			}

} 

$file_url = wp_get_attachment_url( $newupload );
$filetype = wp_check_filetype( $file_url );

$title     = basename( get_attached_file( $newupload ) );
$file_type = $filetype['ext'];
$cat = $_POST['cat'];
$content = $_POST['message'];
$post_type = 'briefcase';
$attachid = $newupload;


//the array of arguements to be inserted with wp_insert_post
$new_post = array(
'post_title'    => $title,
'post_content'  => $content,
'post_category' => $cat,
'post_status'   => 'publish',          
'post_type'     => $post_type 
);

//insert the the post into database by passing $new_post to wp_insert_post
//store our post ID in a variable $pid
$pid = wp_insert_post($new_post);

wp_set_post_terms( $pid, $_POST['cat'], 'briefcase-type', false );

//we now use $pid (post id) to help add out post meta data
add_post_meta($pid, 'upatt_cmb_filetype', $file_type, true);
add_post_meta($pid, 'upatt_cmb_attachfile', $attachid, true);


header("Location: http://newcarenj.org/add-upload/?results=success");
die();

} else {
	header("Location: http://newcarenj.org/add-upload/?results=fail");
	die();
}

}