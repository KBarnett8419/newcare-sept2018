<?php 

add_action('init', 'create_post_type');

function create_post_type() {
    $args = array(
        'label' => __('briefcase'),
        'singular_label' => __('Briefcase'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => true,
        'supports' => array('title','editor'),
        'has_archive' => true
    );

    register_post_type('briefcase', $args);
}

register_taxonomy("briefcase-type", array("briefcase"), array("hierarchical" => true, "label" => "Category", "singular_label" => "Category", "rewrite" => true));


add_filter("manage_edit-briefcase_columns", "briefcase_edit_columns");

function briefcase_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "File Name",
        "description" => "Description",
        "type" => "Category",
        "date" => "Date",
    );

    return $columns;
}

add_action("manage_posts_custom_column", "briefcase_custom_columns");

function briefcase_custom_columns($column) {
    global $post;
    switch ($column) {
        case "description":
            the_excerpt();
            break;
        case "type":
            echo get_the_term_list($post->ID, 'briefcase-type', '', ', ', '');
            break;
    }
}