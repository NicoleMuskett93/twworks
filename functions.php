<?php

/**
 * Theme setup.
 */
function tw_works_setup() {
	add_theme_support( 'title-tag' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'tailpress' ),
            'login' => __('Login Menu', 'tailpress'),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

    add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'editor-styles' );
	add_editor_style( 'css/editor-style.css' );
}

add_action( 'after_setup_theme', 'tw_works_setup' );

/**
 * Enqueue theme assets.
 */
function tw_works_enqueue_scripts() {
	$theme = wp_get_theme();

	wp_enqueue_style( 'tailpress', tw_works_asset( 'css/app.css' ), array(), $theme->get( 'Version' ) );
	wp_enqueue_script( 'tailpress', tw_works_asset( 'js/app.js' ), array(), $theme->get( 'Version' ) );
    wp_enqueue_script('pagination', tw_works_asset('js/pagination.js'), array('jquery'), $theme ->get('Version'),true);
	wp_enqueue_style('login-css', site_url('/wp-admin/css/login.min.css'), array(), $theme->get( 'Version' ));

}

add_action( 'wp_enqueue_scripts', 'tw_works_enqueue_scripts' );

/**
 * Get asset path.
 *
 * @param string  $path Path to asset.
 *
 * @return string
 */
function tw_works_asset( $path ) {
	if ( wp_get_environment_type() === 'production' ) {
		return get_stylesheet_directory_uri() . '/' . $path;
	}

	return add_query_arg( 'time', time(),  get_stylesheet_directory_uri() . '/' . $path );
}

/**
 * Adds option 'li_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The current item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tw_works_nav_menu_add_li_class( $classes, $item, $args, $depth ) {
	if ( isset( $args->li_class ) ) {
		$classes[] = $args->li_class;
	}

	if ( isset( $args->{"li_class_$depth"} ) ) {
		$classes[] = $args->{"li_class_$depth"};
	}

	return $classes;
}

add_filter( 'nav_menu_css_class', 'tw_works_nav_menu_add_li_class', 10, 4 );

/**
 * Adds option 'submenu_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The current item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tw_works_nav_menu_add_submenu_class( $classes, $args, $depth ) {
	if ( isset( $args->submenu_class ) ) {
		$classes[] = $args->submenu_class;
	}

	if ( isset( $args->{"submenu_class_$depth"} ) ) {
		$classes[] = $args->{"submenu_class_$depth"};
	}

	return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'tw_works_nav_menu_add_submenu_class', 10, 3 );


function twworks_add_fonts() {

	// Enqueue Niveau Grotesk font from Typekit
	wp_enqueue_style('wpb-typekit-fonts', "https://use.typekit.net/swa3col.css", false );

}

add_action('wp_enqueue_scripts', 'twworks_add_fonts');

// Font awesome 

function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://kit.fontawesome.com/faaca7b9a7.js');
}

add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

/**
 * Register custom ACF blocks
 */
require_once(get_stylesheet_directory() . '/functions/register-block.php');


/**
 * Register custom posts
 */
require_once( get_stylesheet_directory() . '/functions/custom-posts.php' );

/**
 * Adding a new user role of employer
 */

add_role('employer', 'Employer', array(
	'read' => true,
	'create_posts' => true,
	'edit_posts' => true,
	'delete_posts' => true,
	'edit_others_posts' => false,
	'publish_posts' => true,
	'manage_categories' => false,
	'delete_others_posts' => false,

));

/**
 * Register Archive Status
 */

 function wpdocs_custom_post_status(){
	register_post_status( 'archive', array(
		'label'                     => _x( 'Archive', 'post' ),
		'public'                    => true,
        'internal'                  => true,
		'exclude_from_search'       => true,
		'show_in_admin_all_list'    => false,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Archive <span class="count">(%s)</span>', 'Archive <span class="count">(%s)</span>' ),
	) );
}
add_action( 'init', 'wpdocs_custom_post_status' );



//login redirect

// Redirect based on user role
add_filter('login_redirect', function($redirect_to, $request, $user) {
    // Ensure we have a valid user
    if (isset($user->roles) && is_array($user->roles)) {
        // Check if the user has the 'employer' role
        if (in_array('employer', $user->roles)) {
            // Redirect to the desired URL for employers
            return home_url('/my-jobs/');
        } 
        elseif(in_array('administrator', $user->roles)) {
            return home_url('/jobs/');
        }
        else {
            // Redirect non-employers to the homepage or another URL
            return home_url('/access-denied/');
        }
    }
    // Default redirect for failed login or other cases
    return home_url();
}, 10, 3);

function redirect_admin_from_my_jobs() {
    if (is_page('my-jobs') && is_user_logged_in()) { 
        $current_user = wp_get_current_user();
        if (in_array('administrator', $current_user->roles)) {
            wp_redirect(home_url('/jobs/')); // Replace '/jobs/' with the actual path to your Jobs page
            exit;
        }
    }
}
add_action('template_redirect', 'redirect_admin_from_my_jobs');

function change_menu_name($items, $args) {
    // Check if the menu is the one at the 'login' location
    if ($args->theme_location == 'login') {
        // Check if the user is logged in
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            $display_name = $current_user->display_name;

            // Check if the current user has the 'employer' role
            if (in_array('employer', (array) $current_user->roles)) {
                // Retrieve the menu items for 'login'
                $menu_items = wp_get_nav_menu_items($args->menu);
                $sub_menu = '';

                // Generate submenu items
                foreach ($menu_items as $menu_item) {
                    // Assume submenu items are identified by a parent_id and you only need to retrieve them
                    if ($menu_item->menu_item_parent) {
                        $sub_menu .= '<li><a href="' . esc_url($menu_item->url) . '">' . esc_html($menu_item->title) . '</a></li>';
                    }
                }

                // Append the submenu items to the display name link
                $items = '<li><a href="#">' . esc_html($display_name) . '</a><ul class="sub-menu">' . $sub_menu . '</ul></li>';
            } else {
                // For other roles, just display the name
                $items = '<li>' . esc_html($display_name) . '</li>';
            }
        }
    }
    return $items;
}

add_filter('wp_nav_menu_items', 'change_menu_name', 10, 2);


function add_body_classes_based_on_user_role($classes) {
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $role = $current_user->roles[0];
        $classes[] = 'role-' . $role;
    }
    return $classes;
}
add_filter('body_class', 'add_body_classes_based_on_user_role');


//Connecting data php and js

function localize_app_script() {
    // Enqueue the app.js script
    wp_enqueue_script('app', get_template_directory_uri() . '/js/app.js', array(), null, true);

    // Get the current user information
    $current_user = wp_get_current_user();

    // Localize the script with current user information
    wp_localize_script('app', 'currentUser', array(
        'displayName' => $current_user->display_name,
        'roles' => $current_user->roles
    ));
}
add_action('wp_enqueue_scripts', 'localize_app_script');




add_action('init', function() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['custom_job_form_nonce']) && wp_verify_nonce($_POST['custom_job_form_nonce'], 'custom_job_form_action')) {
        
        // Sanitize and validate input data
        $job_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0; // For updating post
        $job_title = sanitize_text_field($_POST['job_title']);
        $job_salary = sanitize_text_field($_POST['job_salary']);
        $job_description = sanitize_textarea_field($_POST['job_description']);
        $job_supplemental_pay = sanitize_text_field($_POST['job_supplemental_pay']);
        $job_time = sanitize_text_field($_POST['job_time']);
        $job_shift = sanitize_text_field($_POST['job_shift']);
        $job_location = sanitize_text_field($_POST['job_location']);
        $job_start_date = sanitize_text_field($_POST['job_start_date']);
        $job_downloads = sanitize_text_field($_POST['job_downloads']);
        $job_application_link = sanitize_text_field($_POST['job_application_link']);
        $job_publish_date = sanitize_text_field($_POST['job_publish_date']);
        $job_expiry_date = sanitize_text_field($_POST['job_expiry_date']);
        $job_status = sanitize_text_field($_POST['job_status']);

        

        // Common post data
        $post_data = array(
            'post_title'   => $job_title,
            'post_content' => $job_description,
            'post_status'  => $job_status,
            'post_author'  => get_current_user_id(),
            'post_type'    => 'jobs', // Assuming 'jobs' is your custom post type
            'post_date'    => $post_date,
        );

        if ($job_id > 0) {
            // Update existing job
            $post_data['ID'] = $job_id;
            wp_update_post($post_data);
        } else {
            // Create new job
            $job_id = wp_insert_post($post_data);
        }

        if ($job_id) {
            update_post_meta($job_id, 'job_salary', $job_salary);
            update_post_meta($job_id, 'job_supplemental_pay', $job_supplemental_pay);
            update_post_meta($job_id, 'job_time', $job_time);
            update_post_meta($job_id, 'job_shift', $job_shift);
            update_post_meta($job_id, 'job_location', $job_location);
            update_post_meta($job_id, 'job_start_date', $job_start_date);
            update_post_meta($job_id, 'job_downloads', $job_downloads);
            update_post_meta($job_id, 'job_application_link', $job_application_link);
            update_post_meta($job_id, 'job_publish_date', $job_publish_date);
            update_post_meta($job_id, 'job_expiry_date', $job_expiry_date);

            wp_redirect(add_query_arg('status', 'success', home_url('/my-jobs/')));
            exit;
        } else {
            wp_redirect(add_query_arg('status', 'error', home_url('/my-jobs/')));
            exit;
        }
    }
});

function filter_jobs_ajax_handler() {
    // Check if this is an AJAX request
    if ( isset( $_POST['action'] ) && $_POST['action'] == 'filter_jobs' ) {
        
        // Retrieve filter parameters from AJAX request
        $full_or_part_time = isset( $_POST['full_or_part_time'] ) ? sanitize_text_field( $_POST['full_or_part_time'] ) : '';

        // Set up $args for WP_Query
        $args = array(
            'post_type' => 'jobs',
            'posts_per_page' => -1,
        );

        // Add custom fields to $args if they are set
        if ( $full_or_part_time ) {
            $args['meta_query'] = array(
                array(
                    'key' => 'job_time', // Replace with your actual meta field key
                    'value' => $full_or_part_time,
                    'compare' => '='
                )
            );
        }

        // Perform WP_Query
        $posts = new WP_Query( $args );

        // Check if there are posts
        if ( $posts->have_posts() ) {
            while ( $posts->have_posts() ) {
                $posts->the_post();
                // Output your post content as needed
                get_template_part( 'template-parts/content', 'jobs' );
            }
            wp_reset_postdata(); // Reset post data
        } else {
            echo 'No jobs found.';
        }

        // Always die() after outputting the data in AJAX
        wp_die();
    }
}
add_action( 'wp_ajax_filter_jobs', 'filter_jobs_ajax_handler' );
add_action( 'wp_ajax_nopriv_filter_jobs', 'filter_jobs_ajax_handler' );
