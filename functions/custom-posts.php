<?php

/*
* Adding custom post types
*/
  
function twworks_create_custom_post_type() {

    // Jobs
	$labels = array(
		'name'                => _x( 'Jobs', 'Post Type General Name' ),
		'singular_name'       => _x( 'Jobs', 'Post Type Singular Name' ),
		'menu_name'           => __( 'Jobs' ),
		'parent_item_colon'   => __( 'Parent Post' ),
		'all_items'           => __( 'All Posts' ),
		'view_item'           => __( 'View Post' ),
		'add_new_item'        => __( 'Add New Post' ),
		'add_new'             => __( 'Add New' ),
		'edit_item'           => __( 'Edit Post' ),
		'update_item'         => __( 'Update Post' ),
		'search_items'        => __( 'Search Post' ),
		'not_found'           => __( 'Not Found' ),
		'not_found_in_trash'  => __( 'Not found in Trash' ),
	);
	  
	$args = array(
		'label'               => __( 'jobs' ),
		'description'         => __( 'Jobs' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 8,
		'menu_icon'           => 'dashicons-list-view',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest' => true,

		'taxonomies' => array( 'jobs-category' )
	);

	register_taxonomy(
		'jobs-category', 'jobs', array(
		'hierarchical' => true,
		'label' => 'Jobs Category',
		'show_admin_column' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
	) );
	  
	register_post_type( 'jobs', $args );

	
	
}

add_action( 'init', 'twworks_create_custom_post_type', 0 );