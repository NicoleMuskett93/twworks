<?php 
function twworks_pagination_script() {
	global $wp_query; 
    
    // Get data from PHP to JavaScript
	wp_localize_script( 'twworks', 'twworks_pagination_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode( $wp_query->query_vars ),
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	) );
}
add_action( 'wp_enqueue_scripts', 'twworks_pagination_script' );