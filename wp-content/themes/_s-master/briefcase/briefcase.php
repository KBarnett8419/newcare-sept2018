<?php 

// Load briefcase custom post type
require_once( get_template_directory() . '/briefcase/briefcase_cpt.php');

// Load Custom Meta Box
require_once( get_template_directory() . '/briefcase/cmb/metabox.php');

/* Add CSS Style */

function briefcase_css () {
wp_enqueue_style ('custom', get_template_directory_uri().'/briefcase/briefcase.css', array(),  time() );
}

add_action ('wp_enqueue_scripts', 'briefcase_css');

/* Add Upload Documents */

    function wpse_load_custom_upload_doc(){
    if( isset($_POST['briefcase_action']) == 'briefcase' ) {
        require('add_upload_post.php');
        die();
    }
}
add_action('init','wpse_load_custom_upload_doc');


/* Get Current User Role */
function get_current_user_role() {
	global $wp_roles;
	$current_user = wp_get_current_user();
	$roles = $current_user->roles;
	$role = array_shift($roles);
	return isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role] ) : false;
}

/* This function attaches the image to the post in the database, add it to functions.php */
function insert_attachment($file_handler,$post_id,$setthumb='false') {
  // check to make sure its a successful upload
  if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
  require_once(ABSPATH . "wp-admin" . '/includes/media.php');
  $attach_id = media_handle_upload( $file_handler, $post_id );
  if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
  return $attach_id;
}

?>