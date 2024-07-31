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
            'secondary' => __('Secondary Menu', 'tailpress'),
            'mobile' => __('Mobile Menu', 'tailpress'),
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
	wp_enqueue_script( 'tailpress', tw_works_asset( 'js/app.js' ), array('jquery'), $theme->get( 'Version' ) );
	wp_enqueue_style('login-css', site_url('/wp-admin/css/login.min.css'), array(), $theme->get( 'Version' ));

      // use cdn npm not working
      if (is_page('jobs')) {
        wp_enqueue_style('nouislider-css', 'https://cdn.jsdelivr.net/npm/nouislider@14.7.0/distribute/nouislider.css');
        wp_enqueue_script('nouislider', 'https://cdn.jsdelivr.net/npm/nouislider@14.7.0/distribute/nouislider.js', array(), null, true);
      }
}

add_action( 'wp_enqueue_scripts', 'tw_works_enqueue_scripts' );

function enqueue_swiper_files() {
    // Enqueue Swiper CSS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), null);

    // Enqueue Swiper JavaScript
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), null, true);
}

add_action('wp_enqueue_scripts', 'enqueue_swiper_files');

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
    // Font Awesome Kit CDN
    wp_enqueue_script('font-awesome-kit', 'https://kit.fontawesome.com/faaca7b9a7.js', array(), null, true);
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
        $job_downloads_one = ($_FILES['job_downloads_one']);
        $job_downloads_two = ($_FILES['job_downloads_two']);
        $file_name_one = sanitize_file_name( $job_downloads_one['name'] );
        $file_name_two = sanitize_file_name( $job_downloads_two['name'] );
        $job_application_link = sanitize_text_field($_POST['job_application_link']);
        $job_publish_date = sanitize_text_field($_POST['job_publish_date']);
        $job_expiry_date = sanitize_text_field($_POST['job_expiry_date']);
        $job_status = isset($_POST['job_status']) ? sanitize_text_field($_POST['job_status']) : 'publish'; // Default to 'publish'


        // Determine post status and post date
        $post_date = current_time('mysql');

     
        if ($job_status === 'future') {
            $post_date = date('Y-m-d H:i:s', strtotime($job_publish_date . ' 00:00:00'));
        }

        // Upload file
        
        if($job_downloads_one){
            if(!empty ($file_name_one)){
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');
                $upload_one = wp_handle_upload( $job_downloads_one, array('test_form' => false) );
                $attachments_one = array(
                    'post_title' => $file_name,
                    'post_content' => '',
                    'post_status' => 'inherit',
                    'post_mime_type' => $upload_one['type'],
                    'guid' => $upload_one['url']
                );
                $attachment_id_one = wp_insert_attachment( $attachments_one, $upload_one['file'] );
                $attachment_data_one = wp_generate_attachment_metadata( $attachment_id_one, $upload_one['file'] );
                wp_update_attachment_metadata( $attachment_id_one, $attachment_data_one );

                $file_url_one = wp_get_attachment_url($attachment_id_one);
                
            }

        }

        if($job_downloads_two){
            if(!empty ($file_name_two)){
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');
                $upload_two = wp_handle_upload( $job_downloads_two, array('test_form' => false) );
                $attachments_two = array(
                    'post_title' => $file_name_two,
                    'post_content' => '',
                    'post_status' => 'inherit',
                    'post_mime_type' => $upload_two['type'],
                    'guid' => $upload_two['url']
                );
                $attachment_id_two = wp_insert_attachment( $attachments_two, $upload_two['file'] );
                $attachment_data_two = wp_generate_attachment_metadata( $attachment_id_two, $upload_two['file'] );
                wp_update_attachment_metadata( $attachment_id_two, $attachment_data_two );

                $file_url_two = wp_get_attachment_url($attachment_id_two);
                
            }

        }

        // Prepare post data
        $post_data = array(
            'post_title'   => $job_title,
            'post_content' => $job_description,
            'post_status'  => $job_status,
            'post_author'  => get_current_user_id(),
            'post_type'    => 'jobs',
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
            update_post_meta($job_id, 'job_downloads_one', $file_url_one);
            update_post_meta($job_id, 'job_downloads_two', $file_url_two);
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
        $search_query = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
        $full_or_part_time = isset( $_POST['full_or_part_time'] ) ? sanitize_text_field( $_POST['full_or_part_time'] ) : '';
        $location = isset( $_POST['location'] ) ? sanitize_text_field( $_POST['location'] ) : '';
        $min_salary = isset($_POST['min_salary']) ? floatval($_POST['min_salary']) : '';
        $max_salary = isset($_POST['max_salary']) ? floatval($_POST['max_salary']) : '';

       

        // Set up $args for WP_Query
        $args = array(
            'post_type' => 'jobs',
            'posts_per_page' => 5,
            'post_status' => 'publish',
            'meta_query' => array('relation' => 'AND'), // Ensuring multiple conditions are combined properly
            's' => $search_query,
        );


        if ( $full_or_part_time ) {
            $args['meta_query'][] = array(
                array(
                    'key' => 'job_time', 
                    'value' => $full_or_part_time,
                    'compare' => '='
                )
            );
        }

        if ( $location ) { 
            $args['meta_query'][] = array(
                array(
                    'key' => 'job_location', 
                    'value' => $location,
                    'compare' => '='
                )
            );
        }

        if ($min_salary || $max_salary) {
            // Use slider values as the salary range
            $args['meta_query'][] = array(
                'key' => 'job_salary',
                'value' => array($min_salary, $max_salary),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
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

// Handle searching jobs
function search_jobs_ajax_handler() {
    // Check if this is an AJAX request
    if ( isset( $_POST['action'] ) && $_POST['action'] == 'search_jobs' ) {
        // Retrieve search query from AJAX request
        $search_query = isset( $_POST['s'] ) ? sanitize_text_field( $_POST['s'] ) : '';

        // Set up $args for WP_Query
        $args = array(
            'post_type' => 'jobs',
            'posts_per_page' => -1,
            's' => $search_query,
            'post_status' => 'publish'
        );

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
add_action( 'wp_ajax_search_jobs', 'search_jobs_ajax_handler' );
add_action( 'wp_ajax_nopriv_search_jobs', 'search_jobs_ajax_handler' );

// Handle AJAX request for loading more posts
function load_more_jobs_ajax_handler() {
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $args = array(
        'post_type' => 'jobs',
        'paged' => $paged,
        'posts_per_page' => 5,
        'post_status' => 'publish',
        // Add more arguments here if needed
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $max_pages = $query->max_num_pages;
        $total_posts = $query->found_posts;
        ob_start();

        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', 'jobs'); // Adjust this based on your template structure
        }

        $response = ob_get_clean();

        wp_send_json_success([
            'posts' => $response,
            'max_pages' => $max_pages,
            'current_page' => $paged,
            'total_posts' => $total_posts,
            'posts_returned' => $query->post_count
        ]);
    } else {
        wp_send_json_error(['message' => 'No more jobs found']);
    }

    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_more_jobs', 'load_more_jobs_ajax_handler');
add_action('wp_ajax_nopriv_load_more_jobs', 'load_more_jobs_ajax_handler');





function archive_expired_jobs() {
    $today = date('Y-m-d');

    $args = array(
        'post_type' => 'jobs',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'job_expiry_date',
                'value' => $today,
                'compare' => '<',
                'type' => 'DATE'
            )
        )
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $post_id = get_the_ID();
            // Update the post status to 'archive'
            wp_update_post(array(
                'ID' => $post_id,
                'post_status' => 'archive' 
            ));
        endwhile;
        wp_reset_postdata();
    endif;
}

// Schedule the event if it's not already scheduled
if (!wp_next_scheduled('daily_archive_expired_jobs')) {
    wp_schedule_event(time(), 'hourly', 'daily_archive_expired_jobs');
}

// Hook the function to the cron event
add_action('daily_archive_expired_jobs', 'archive_expired_jobs');