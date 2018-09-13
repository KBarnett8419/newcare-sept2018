<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'upatt_cmb_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$meta_boxes['briefcase_metabox'] = array(
		'id'         => 'briefcase_metabox',
		'title'      => __( 'Briefcase Metabox', 'cmb' ),
		'pages'      => array( 'briefcase', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
		/*	array(
				'name'    => __( 'User Id', 'cmb' ),
				'desc'    => __( 'Please, Input the User Id', 'cmb' ),
				'id'      => $prefix . 'user',
				'type'    => 'text',
			),*/
			array(
				'name'    => __( 'File Type', 'cmb' ),
				'desc'    => __( 'Input the file type', 'cmb' ),
				'id'      => $prefix . 'filetype',
				'type'    => 'text',
				),			
			array(
				'name' => __( 'Attachment Id', 'cmb' ),
				'desc' => __( 'Please, Input the Attachement Id', 'cmb' ),
				'id'   => $prefix . 'attachfile',
				'type' => 'text',
			),
			
		),
	);


	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}
