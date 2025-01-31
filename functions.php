<?php

/**
 * Theme setup.
 */
function tw_works_setup()
{
    add_theme_support('title-tag');

    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'tailpress'),
            'login' => __('Login Menu', 'tailpress'),
            'secondary' => __('Secondary Menu', 'tailpress'),
            'mobile' => __('Mobile Menu', 'tailpress'),
            'footer_secondary' => __('Footer Secondary Menu', 'tailpress'),
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

    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');

    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');

    add_theme_support('editor-styles');
    add_editor_style('css/editor-style.css');
}

add_action('after_setup_theme', 'tw_works_setup');

/**
 * Enqueue theme assets.
 */
function tw_works_enqueue_scripts()
{
    $theme = wp_get_theme();

    wp_enqueue_style('tailpress', tw_works_asset('css/app.css'), array(), $theme->get('Version'));
    wp_enqueue_script('tailpress', tw_works_asset('js/app.js'), array('jquery'), $theme->get('Version'));
    wp_enqueue_style('login-css', site_url('/wp-admin/css/login.min.css'), array(), $theme->get('Version'));

    // use cdn npm not working
    //   if (is_page('jobs')) {
    //     wp_enqueue_style('nouislider-css', 'https://cdn.jsdelivr.net/npm/nouislider@14.7.0/distribute/nouislider.css');
    //     wp_enqueue_script('nouislider', 'https://cdn.jsdelivr.net/npm/nouislider@14.7.0/distribute/nouislider.js', array(), null, true);
    //   }
}

add_action('wp_enqueue_scripts', 'tw_works_enqueue_scripts');

function enqueue_swiper_files()
{
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
function tw_works_asset($path)
{
    if (wp_get_environment_type() === 'production') {
        return get_stylesheet_directory_uri() . '/' . $path;
    }

    return add_query_arg('time', time(),  get_stylesheet_directory_uri() . '/' . $path);
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
function tw_works_nav_menu_add_li_class($classes, $item, $args, $depth)
{
    if (isset($args->li_class)) {
        $classes[] = $args->li_class;
    }

    if (isset($args->{"li_class_$depth"})) {
        $classes[] = $args->{"li_class_$depth"};
    }

    return $classes;
}

add_filter('nav_menu_css_class', 'tw_works_nav_menu_add_li_class', 10, 4);

/**
 * Adds option 'submenu_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The current item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tw_works_nav_menu_add_submenu_class($classes, $args, $depth)
{
    if (isset($args->submenu_class)) {
        $classes[] = $args->submenu_class;
    }

    if (isset($args->{"submenu_class_$depth"})) {
        $classes[] = $args->{"submenu_class_$depth"};
    }

    return $classes;
}

add_filter('nav_menu_submenu_css_class', 'tw_works_nav_menu_add_submenu_class', 10, 3);


function twworks_add_fonts()
{

    // Enqueue Niveau Grotesk font from Typekit
    wp_enqueue_style('wpb-typekit-fonts', "https://use.typekit.net/swa3col.css", false);
}

add_action('wp_enqueue_scripts', 'twworks_add_fonts');

// Font awesome 

function enqueue_font_awesome()
{
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
require_once(get_stylesheet_directory() . '/functions/custom-posts.php');

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
    'rich_editing' => true,

));

/**
 * Register Archive Status
 */

function wpdocs_custom_post_status()
{
    register_post_status('archive', array(
        'label'                     => _x('Archive', 'post'),
        'public'                    => true,
        'internal'                  => true,
        'exclude_from_search'       => true,
        'show_in_admin_all_list'    => false,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Archive <span class="count">(%s)</span>', 'Archive <span class="count">(%s)</span>'),
    ));
}
add_action('init', 'wpdocs_custom_post_status');

/**
 * Add custom option page - only admin can access
 */

if (function_exists('acf_add_options_page')) {

    $option_page = acf_add_options_page(array(
        'page_title'    => 'Jobs Banner',
        'menu_title'    => 'Jobs Banner',
        'menu_slug'     => 'jobs-banner-settings',
        'capability'    => 'administrator',
        'redirect'      => false
    ));
}

//format salary
function format_salary($job_salary)
{
    return number_format($job_salary);
}

//login redirect

// Redirect based on user role
add_filter('login_redirect', function ($redirect_to, $request, $user) {
    // Ensure we have a valid user
    if (isset($user->roles) && is_array($user->roles)) {
        // Check if the user has the 'employer' role
        if (in_array('employer', $user->roles)) {
            // Redirect to my-jobs
            return home_url('/my-jobs/');
        } elseif (in_array('administrator', $user->roles)) {
            return home_url('/jobs/');
        } else {
            // Redirect non-employers to the homepage or another URL
            return home_url('/access-denied/');
        }
    }
    // Default redirect for failed login or other cases
    return home_url();
}, 10, 3);

function restrict_admin_from_my_jobs()
{
    // Define the pages that need restrictions
    $restricted_pages = ['my-jobs', 'add-jobs', 'edit-jobs', 'profile'];

    // If the current page is one of the restricted pages
    if (is_page($restricted_pages)) {
        // If the user is logged in, check their role
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            // If the logged-in user is an administrator, redirect them
            if (in_array('administrator', (array) $current_user->roles)) {
                wp_redirect(home_url('/jobs/'));
                exit;
            }
        }
    }
}

add_action('template_redirect', 'restrict_admin_from_my_jobs');





function change_menu_name($items, $args)
{
    // Check if the menu is the one at the 'login' location
    if ($args->theme_location == 'login') {
        // Check if the user is logged in
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            $display_name = $current_user->user_firstname . ' ' . $current_user->user_lastname;

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

function logout_link($items, $args)
{
    // Check if the menu is the one at the 'login' location
    if ($args->theme_location == 'login') {
        // Check if the user is logged in and has the 'employer' role
        $custom_link = 'https://tunbridgewells.works/my-jobs/';
        if (is_user_logged_in() && in_array('employer', (array) wp_get_current_user()->roles)) {
            // Find the submenu within the existing menu items and append the logout link
            $logout_link = '<li><a href="' . esc_url(wp_logout_url($custom_link)) . '">Log Out</a></li>';
            $items = str_replace('</ul>', $logout_link . '</ul>', $items);
        }
    }
    return $items;
}

add_filter('wp_nav_menu_items', 'logout_link', 10, 2);

//remove admin bar for employer

// Add Employer Role
add_role('employer', 'Employer', array(
    'read' => true,
    'create_posts' => true,
    'edit_posts' => true,
    'delete_posts' => true,
    'edit_others_posts' => false,
    'publish_posts' => true,
    'manage_categories' => false,
    'delete_others_posts' => false,
    'rich_editing' => true,
));

// Remove Admin Bar for Employer Role
function remove_admin_bar_for_employer()
{
    // Check if the user is logged in
    if (is_user_logged_in()) {
        // Get the current user's data
        $current_user = wp_get_current_user();

        // Check if the user has the 'employer' role
        if (in_array('employer', (array) $current_user->roles)) {
            // Remove the admin bar
            return false; // Returning false hides the admin bar
        }
        return true;
    }
    return false;
}

// Hook into 'show_admin_bar' filter
add_filter('show_admin_bar', 'remove_admin_bar_for_employer');






function add_body_classes_based_on_user_role($classes)
{
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $role = $current_user->roles[0];
        $classes[] = 'role-' . $role;
    }
    return $classes;
}
add_filter('body_class', 'add_body_classes_based_on_user_role');

// Add custom class to body

function add_custom_body_class($classes)
{
    if (is_page('my-jobs') || is_page('add-jobs') || is_page('edit-jobs') || is_page('profile')) {
        $classes[] = 'single-jobs';
    }
    return $classes;
}

add_filter('body_class', 'add_custom_body_class');


//Connecting data php and js

function localize_app_script()
{

    // Get the current user information
    $current_user = wp_get_current_user();

    // Localize the script with current user information
    wp_localize_script('app', 'currentUser', array(
        'displayName' => $current_user->display_name,
        'roles' => $current_user->roles
    ));
}
add_action('wp_enqueue_scripts', 'localize_app_script');


add_action('init', function () {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['custom_job_form_nonce']) && wp_verify_nonce($_POST['custom_job_form_nonce'], 'custom_job_form_action')) {

        // Sanitize and validate input data
        $volunteering = isset($_POST['volunteering']) && $_POST['volunteering'] === 'volunteering' ? true : false;
        $job_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0; // For updating post
        $job_title = sanitize_text_field($_POST['job_title']);
        $job_salary = sanitize_text_field($_POST['job_salary']);
        $job_description = wp_kses_post($_POST['job_description']); // Allow HTML tags
        $job_description_summary = sanitize_text_field($_POST['job_description_summary']);
        $job_supplemental_pay = sanitize_text_field($_POST['job_supplemental_pay']);
        $job_time = sanitize_text_field($_POST['job_time']);
        $job_shift = sanitize_text_field($_POST['job_shift']);
        $job_location = sanitize_text_field($_POST['job_location']);
        $job_start_date = sanitize_text_field($_POST['job_start_date']);
        $job_downloads_one = ($_FILES['job_downloads_one']);
        $job_downloads_two = ($_FILES['job_downloads_two']);
        $file_name_one = sanitize_file_name($job_downloads_one['name']);
        $file_name_two = sanitize_file_name($job_downloads_two['name']);
        $job_application_link = sanitize_text_field($_POST['job_application_link']);
        $job_publish_date_str = strtotime(sanitize_text_field($_POST['job_publish_date']));
        $job_publish_date = sanitize_text_field($_POST['job_publish_date']);
        $job_expiry_date = sanitize_text_field($_POST['job_expiry_date']);
        $job_status = isset($_POST['job_status']) ? sanitize_text_field($_POST['job_status']) : 'publish'; // Default to 'publish'
        $job_company_name = sanitize_text_field($_POST['job_company_name']);
        $job_workplace_benefits = isset($_POST['job_workplace_benefits']) ? $_POST['job_workplace_benefits'] : array();
        $job_sector = sanitize_text_field($_POST['job_sector']);
        $job_role = sanitize_text_field($_POST['job_role']);



        // Determine post status and post date
        $post_date = current_time('mysql');

        if ($job_status === 'future') {
            $post_date = date('Y-m-d H:i:s', strtotime($job_publish_date . ' 00:00:00'));
        }
        // if post status is then changed again to publish update status


        // Upload file

        if ($job_downloads_one) {
            if (!empty($file_name_one)) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');
                $upload_one = wp_handle_upload($job_downloads_one, array('test_form' => false));
                $attachments_one = array(
                    'post_title' => $file_name,
                    'post_content' => '',
                    'post_status' => 'inherit',
                    'post_mime_type' => $upload_one['type'],
                    'guid' => $upload_one['url']
                );
                $attachment_id_one = wp_insert_attachment($attachments_one, $upload_one['file']);
                $attachment_data_one = wp_generate_attachment_metadata($attachment_id_one, $upload_one['file']);
                wp_update_attachment_metadata($attachment_id_one, $attachment_data_one);

                $file_url_one = wp_get_attachment_url($attachment_id_one);
            } else {
                $file_url_one = get_post_meta($job_id, 'job_downloads_one', true);
            }
        }




        if ($job_downloads_two) {
            if (!empty($file_name_two)) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');
                $upload_two = wp_handle_upload($job_downloads_two, array('test_form' => false));
                $attachments_two = array(
                    'post_title' => $file_name_two,
                    'post_content' => '',
                    'post_status' => 'inherit',
                    'post_mime_type' => $upload_two['type'],
                    'guid' => $upload_two['url']
                );
                $attachment_id_two = wp_insert_attachment($attachments_two, $upload_two['file']);
                $attachment_data_two = wp_generate_attachment_metadata($attachment_id_two, $upload_two['file']);
                wp_update_attachment_metadata($attachment_id_two, $attachment_data_two);

                $file_url_two = wp_get_attachment_url($attachment_id_two);
            } else {
                $file_url_two = get_post_meta($job_id, 'job_downloads_two', true);
            }
        }

        // Validate the application link
        if (!filter_var($job_application_link, FILTER_VALIDATE_URL)) {
            // If not a valid URL, handle the error (e.g., set an error message, redirect, etc.)
            wp_redirect(add_query_arg('status', 'invalid_url', home_url('/my-jobs/')));
            exit;
        }

        // Prepare post data
        $post_data = array(
            'post_title'    => $job_title,
            'post_content'  => $job_description,
            'post_status'   => $job_status,
            'post_type'     => 'jobs',
            'post_date'     => $post_date,

        );


        if ($job_id > 0) {
            // Update existing job
            $post_data['ID'] = $job_id;
            $current_job_status = get_post_status($post_data['ID']);

            //going from schueduled to published
            if ($job_status === 'publish' && $current_job_status === 'future') {
                $post_data['post_date_gmt'] = current_time('mysql', 1);
            }

            //going from published to schueduled

            if ($job_status === 'future' && $current_job_status === 'publish') {
                $post_data['post_date_gmt'] = date('Y-m-d H:i:s', strtotime($job_publish_date . ' 00:00:00'));
            }
            $result = wp_update_post($post_data);
        } else {
            // Create new job
            $job_id = wp_insert_post($post_data);
        }

        if (!empty($job_company_name)) {
            // Check if the term exists by name in the 'company' taxonomy
            $company_term = get_term_by('name', $job_company_name, 'company');

            if ($company_term) {
                // Get the term ID and name
                $company_term_id = $company_term->term_id;
                $company_term_name = $company_term->name;

                // Assign the term to the post (must use term ID)
                wp_set_post_terms($job_id, [$company_term_id], 'company');

                // Optionally, store the term name in a custom field (post meta)
                update_post_meta($job_id, '_job_company_name', $company_term_name);
            } else {
                // Optionally handle the case when the term is not found
                error_log('Company term "' . $job_company_name . '" not found.');
            }
        }

        //if volunteering checkbox selected in form put post under tag 'volunteering'

        // Handle "Volunteering Position?" checkbox
        if ($volunteering) {
            // Get the "volunteering" tag by its slug
            $volunteering_tag = get_term_by('slug', 'volunteering', 'post_tag');

            if ($volunteering_tag) {
                $volunteering_term_id = $volunteering_tag->term_id;
                $volunteering_term_name = $volunteering_tag->name;

                // Ensure the tag is assigned to the post
                wp_set_post_terms($job_id, [$volunteering_term_id], 'post_tag', true); // Append if it exists

                // Optionally, store the term name in a custom field (post meta)
                update_post_meta($job_id, '_job_volunteering', $volunteering_term_name);
            } else {
                // Optionally handle the case when the term is not found
                error_log('Volunteering tag not found.');
            }
        }



        if ($job_id) {
            update_post_meta($job_id, 'volunteering', $volunteering);
            update_post_meta($job_id, 'job_salary', $job_salary);
            update_post_meta($job_id, 'job_supplemental_pay', $job_supplemental_pay);
            update_post_meta($job_id, 'job_time', $job_time);
            update_post_meta($job_id, 'job_shift', $job_shift);
            update_post_meta($job_id, 'job_location', $job_location);
            update_post_meta($job_id, 'job_start_date', $job_start_date);
            update_post_meta($job_id, 'job_downloads_one', $file_url_one);
            update_post_meta($job_id, 'job_downloads_two', $file_url_two);
            update_post_meta($job_id, 'job_application_link', $job_application_link);
            update_post_meta($job_id, 'job_publish_date', $job_publish_date_str);
            update_post_meta($job_id, 'job_expiry_date', $job_expiry_date);
            update_post_meta($job_id, 'job_description', $job_description);
            update_post_meta($job_id, 'job_description_summary', $job_description_summary);
            update_post_meta($job_id, 'job_company_name', $job_company_name);
            update_post_meta($job_id, 'job_workplace_benefits', $job_workplace_benefits);
            update_post_meta($job_id, 'job_sector', $job_sector);
            update_post_meta($job_id, 'job_role', $job_role);



            wp_redirect(add_query_arg('status', 'success', home_url('/my-jobs/')));
            exit;
        } else {
            wp_redirect(add_query_arg('status', 'error', home_url('/my-jobs/')));
            exit;
        }
    }
});

function filter_jobs_ajax_handler()
{
    if (isset($_POST['action']) && $_POST['action'] == 'filter_jobs') {
        global $post;
        // Retrieve filter parameters
        $full_or_part_time = isset($_POST['full_or_part_time']) ? sanitize_text_field($_POST['full_or_part_time']) : '';
        $location = isset($_POST['location']) ? sanitize_text_field($_POST['location']) : '';
        // $min_salary = isset($_POST['min_salary']) ? floatval($_POST['min_salary']) : '';
        // $max_salary = isset($_POST['max_salary']) ? floatval($_POST['max_salary']) : '';
        $salary = isset($_POST['salary']) ? sanitize_text_field($_POST['salary']) : '';
        $published = isset($_POST['published']) ? sanitize_text_field($_POST['published']) : '';
        $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
        $searchQuery = isset($_POST['search_query']) ? sanitize_text_field($_POST['search_query']) : '';
        $sector = isset($_POST['sector']) ? sanitize_text_field($_POST['sector']) : '';
        $shift_type = isset($_POST['shift_type']) ? sanitize_text_field($_POST['shift_type']) : '';
        $sort_order = isset($_POST['sort_order']) ? sanitize_text_field($_POST['sort_order']) : 'newest_first';
        $page_id = isset($_POST['page_id']) ? intval($_POST['page_id']) : 0;


        // Set up $args for WP_Query
        $args = array(
            'post_type' => 'jobs',
            'posts_per_page' => 10,
            'post_status' => 'publish',
            'paged' => $paged,
            'meta_query' => array('relation' => 'AND'),
            's' => $searchQuery,
            'relevanssi' => true,
            'orderby' => 'date',  // Sort by post date
            'order' => ($sort_order === 'newest_first') ? 'DESC' : 'ASC',

        );
        //above is exluding posts from volunteering section but still including them in jobs
        if ($page_id === 504) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'post_tag',
                    'field' => 'slug',
                    'terms' => 'volunteering',
                    'operator' => 'NOT IN'
                )
            );
        } elseif ($page_id === 519) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'post_tag',
                    'field' => 'slug',
                    'terms' => 'volunteering',
                    'operator' => 'IN'
                )
            );
        }


        if ($full_or_part_time) {
            $args['meta_query'][] = array(
                'key' => 'job_time',
                'value' => $full_or_part_time,
                'compare' => '='
            );
        }

        if ($location) {
            $args['meta_query'][] = array(
                'key' => 'job_location',
                'value' => $location,
                'compare' => '='
            );
        }

        $salary_ranges = array(
            'hundred' => array(100000, PHP_INT_MAX),
            'eighty' => array(80000, 100000),
            'sixty' => array(60000, 80000),
            'forty' => array(40000, 60000),
            'twenty' => array(20000, 40000),
            'zero' => array(1, 20000),
            'unspecified' => 0
        );

        if ($salary && isset($salary_ranges[$salary])) {
            $args['meta_query'][] = array(
                'key' => 'job_salary',
                'value' => $salary_ranges[$salary],
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            );
        }

        if ($sector) {
            $args['meta_query'][] = array(
                'key' => 'job_sector',
                'value' => $sector,
                'compare' => '='
            );
        }

        if ($shift_type) {
            $args['meta_query'][] = array(
                'key' => 'job_shift',
                'value' => $shift_type,
                'compare' => '='
            );
        }


        // if ($min_salary || $max_salary) {
        //     $args['meta_query'][] = array(
        //         'key' => 'job_salary',
        //         'value' => array($min_salary, $max_salary),
        //         'compare' => 'BETWEEN',
        //         'type' => 'NUMERIC'
        //     );
        // }

        if ($published) {
            switch ($published) {
                case 'today':
                    $args['date_query'] = array(
                        array(
                            'after' => date('Y-m-d', strtotime('1 day ago'))
                        )
                    );
                    break;
                case 'this-week':
                    $args['date_query'] = array(
                        array(
                            'after' => date('Y-m-d', strtotime('1 week ago'))
                        )
                    );
                    break;
                case 'this-month':
                    $args['date_query'] = array(
                        array(
                            'after' => date('Y-m-d', strtotime('1 month ago'))
                        )
                    );
                    break;
            }
        }




        // Perform WP_Query
        $posts = new WP_Query($args);

        if ($posts->have_posts()) {
            ob_start();
            while ($posts->have_posts()) {
                $posts->the_post();
                get_template_part('template-parts/content', 'jobs');
            }
            $response = ob_get_clean();
            wp_reset_postdata();

            wp_send_json_success([
                'posts' => $response,
                'max_pages' => $posts->max_num_pages,
                'current_page' => $paged,
                'total_posts' => $posts->found_posts,
                'posts_returned' => $posts->post_count
            ]);
        } else {
            wp_send_json_error(['message' => 'No jobs found.']);
        }

        wp_die();
    }
}
add_action('wp_ajax_filter_jobs', 'filter_jobs_ajax_handler');
add_action('wp_ajax_nopriv_filter_jobs', 'filter_jobs_ajax_handler');





// Handle searching jobs
function search_jobs_ajax_handler()
{
    if (isset($_POST['action']) && $_POST['action'] == 'search_jobs') {
        $search_query = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
        $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
        $search_type = isset($_POST['search_type']) ? sanitize_text_field($_POST['search_type']) : 'all';
        $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : 'publish';


        $args = array(
            'post_type' => 'jobs',
            'posts_per_page' => 10,
            'paged' => $paged,
            's' => $search_query,
            'post_status' => $status,
            'relevanssi' => true


        );

        // Adjust the query based on search type
        if ($search_type === 'my' && is_user_logged_in()) {
            $current_user_id = get_current_user_id();
            $args['author'] = $current_user_id;
        }

        $posts = new WP_Query($args);

        if ($posts->have_posts()) {
            ob_start();
            while ($posts->have_posts()) {
                $posts->the_post();
                get_template_part('template-parts/content', 'jobs');
            }
            $response = ob_get_clean();
            wp_reset_postdata();

            wp_send_json_success([
                'posts' => $response,
                'max_pages' => $posts->max_num_pages,
                'current_page' => $paged,
                'total_posts' => $posts->found_posts,
                'posts_returned' => $posts->post_count
            ]);
        } else {
            wp_send_json_error(['message' => 'No jobs found.']);
        }

        wp_die();
    }
}
add_action('wp_ajax_search_jobs', 'search_jobs_ajax_handler');
add_action('wp_ajax_nopriv_search_jobs', 'search_jobs_ajax_handler');

// Handle AJAX request for loading more posts
function load_more_jobs_ajax_handler()
{
    if (isset($_POST['action']) && $_POST['action'] == 'load_more_jobs') {
        $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $search_query = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
        $full_or_part_time = isset($_POST['full_or_part_time']) ? sanitize_text_field($_POST['full_or_part_time']) : '';
        $location = isset($_POST['location']) ? sanitize_text_field($_POST['location']) : '';
        $salary = isset($_POST['salary']) ? intval($_POST['salary']) : '';
        $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : 'publish';
        $sector = isset($_POST['sector']) ? sanitize_text_field($_POST['sector']) : '';
        $shift_type = isset($_POST['shift_type']) ? sanitize_text_field($_POST['shift_type']) : '';
        // $min_salary = isset($_POST['min_salary']) ? floatval($_POST['min_salary']) : '';
        // $max_salary = isset($_POST['max_salary']) ? floatval($_POST['max_salary']) : '';

        $args = array(
            'post_type' => 'jobs',
            'paged' => $paged,
            'posts_per_page' => 10,
            'post_status' => 'publish',
            'meta_query' => array('relation' => 'AND'),
            'status' => $status,
            's' => $search_query,
            'relevanssi' => true

        );

        if ($full_or_part_time) {
            $args['meta_query'][] = array(
                'key' => 'job_time',
                'value' => $full_or_part_time,
                'compare' => '='
            );
        }

        if ($location) {
            $args['meta_query'][] = array(
                'key' => 'job_location',
                'value' => $location,
                'compare' => '='
            );
        }

        if ($sector) {
            $args['meta_query'][] = array(
                'key' => 'job_sector',
                'value' => $sector,
                'compare' => '='
            );
        }

        if ($shift_type) {
            $args['meta_query'][] = array(
                'key' => 'job_shift',
                'value' => $shift_type,
                'compare' => '='
            );
        }



        $salary_ranges = array(
            'hundred' => array(100000, PHP_INT_MAX),
            'eighty' => array(80000, 100000),
            'sixty' => array(60000, 80000),
            'forty' => array(40000, 60000),
            'twenty' => array(20000, 40000),
            'zero' => array(1, 20000),
            'unspecified' => 0
        );

        if ($salary && isset($salary_ranges[$salary])) {
            $args['meta_query'][] = array(
                'key' => 'job_salary',
                'value' => $salary_ranges[$salary],
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            );
        }


        // if ($min_salary || $max_salary) {
        //     $args['meta_query'][] = array(
        //         'key' => 'job_salary',
        //         'value' => array($min_salary, $max_salary),
        //         'compare' => 'BETWEEN',
        //         'type' => 'NUMERIC'
        //     );
        // }

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            ob_start();
            while ($query->have_posts()) {
                $query->the_post();
                get_template_part('template-parts/content', 'jobs');
            }
            $response = ob_get_clean();

            wp_send_json_success([
                'posts' => $response,
                'max_pages' => $query->max_num_pages,
                'current_page' => $paged,
                'total_posts' => $query->found_posts,
                'posts_returned' => $query->post_count
            ]);
        } else {
            wp_send_json_error(['message' => 'No more jobs found']);
        }

        wp_reset_postdata();
        wp_die();
    }
}
add_action('wp_ajax_load_more_jobs', 'load_more_jobs_ajax_handler');
add_action('wp_ajax_nopriv_load_more_jobs', 'load_more_jobs_ajax_handler');

// Handle AJAX request for categorising jobs

function categorise_jobs_ajax_handler()
{
    if (isset($_POST['action']) && $_POST['action'] == 'categorise_jobs') {
        $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
        $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : 'publish';
        //get custom post type category 'company' 
        $user_id = get_current_user_id();

        // Retrieve the term ID from the ACF field
        $company_term_id = get_field('company_name', 'user_' . $user_id);

        if ($company_term_id) {
            // Fetch the term object using the term ID
            $company_term = get_term($company_term_id);

            // Get the term name or set a fallback
            $company_name = $company_term ? $company_term->name : 'Unknown Company';
        } else {
            $company_name = 'Unknown Company'; // Fallback for missing term ID
        }





        $args = array(
            'post_type' => 'jobs',
            'posts_per_page' => 10,
            'paged' => $paged,
            'orderby' => 'date',
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'company',
                    'field' => 'name',
                    'terms' => $company_name

                )
            ),

        );

        if (!empty($status)) {
            $args['post_status'] = $status;
        } else {
            $args['post_status'] = array('publish', 'draft', 'archive', 'future');
        }

        // Debugging: Log the status value
        error_log('Status: ' . $status);

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            ob_start();
            while ($query->have_posts()) {
                $query->the_post();
                get_template_part('template-parts/content', 'myjobs');
            }
            $response = ob_get_clean();
            wp_reset_postdata();

            wp_send_json_success([
                'posts' => $response,
                'max_pages' => $query->max_num_pages,
                'current_page' => $paged,
                'total_posts' => $query->found_posts,
                'posts_returned' => $query->post_count,
            ]);
        } else {
            wp_send_json_error(['message' => 'No jobs found.']);
        }

        wp_die();
    }
}

add_action('wp_ajax_categorise_jobs', 'categorise_jobs_ajax_handler');


add_action('init', function () {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['custom_profile_nonce']) && wp_verify_nonce($_POST['custom_profile_nonce'], 'custom_profile_action')) {

        // Check if the user is logged in
        if (!is_user_logged_in()) {
            wp_send_json_error(array('message' => 'User not logged in'));
        }

        $user_id = get_current_user_id();
        parse_str($_POST['data'], $data);

        $firstname = sanitize_text_field($data['firstname']);
        $lastname = sanitize_text_field($data['lastname']);
        $email = sanitize_email($data['email']);

        $userdata = array(
            'ID'           => $user_id,
            'user_email'   => $email,
            'first_name'   => $firstname,
            'last_name'    => $lastname
        );

        $user_id = wp_update_user($userdata);

        if (is_wp_error($user_id)) {
            wp_send_json_error(array('message' => $user_id->get_error_message()));
        } else {
            wp_send_json_success();
        }
    }
});


function handle_profile_update()
{
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'User not logged in'));
    }

    $user_id = get_current_user_id();
    parse_str($_POST['data'], $data);

    $firstname = sanitize_text_field($data['firstname']);
    $lastname = sanitize_text_field($data['lastname']);
    $email = sanitize_email($data['email']);

    $userdata = array(
        'ID'           => $user_id,
        'user_email'   => $email,
        'first_name'   => $firstname,
        'last_name'    => $lastname
    );

    $user_id = wp_update_user($userdata);

    if (is_wp_error($user_id)) {
        wp_send_json_error(array('message' => $user_id->get_error_message()));
    } else {
        wp_send_json_success(array(
            'first_name' => $firstname,
            'last_name' => $lastname,
            'email' => $email
        ));
    }
}
add_action('wp_ajax_update_profile', 'handle_profile_update');


function archive_expired_jobs()
{
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

function before_login($content)
{

    $content = get_custom_logo();
    return $content;
}

add_filter('login_form_top', 'before_login');

function after_login($aftercontent)
{
    $aftercontent = ' <a href="' . esc_url(wp_lostpassword_url()) . '" class="text-base text-darkergreen">Forgotten your password?</a>';
    return $aftercontent;
}

add_filter('login_form_bottom', 'after_login');





// relevanssi functions

// add_filter('relevanssi_content_to_index', 'custom_relevanssi_index_content', 20, 2);

// function custom_relevanssi_index_content($content, $post)
// {
//     if ($post->post_type === 'jobs') {
//         // Add post fields to the content
//         $content .= ' ' . $post->post_title;
//         $content .= ' ' . $post->post_content;
//         $content .= ' ' . $post->post_excerpt;
//         $content .= ' ' . $post->post_date;
//         $content .= ' ' . $post->post_modified;

//         // Fetch and add author name instead of just ID
//         $author_name = get_the_author_meta($post->post_author, 'job_company_name', true);
//         $content .= ' ' . $author_name;

//         $content .= ' ' . $post->post_status;
//         $content .= ' ' . $post->post_type;
//         $content .= ' ' . $post->post_parent;
//         $content .= ' ' . $post->post_name;
//         $content .= ' ' . $post->post_password;
//         $content .= ' ' . $post->post_mime_type;

//         // Add custom fields to the content
//         $custom_fields = get_post_custom($post->ID);
//         foreach ($custom_fields as $key => $values) {
//             foreach ($values as $value) {
//                 $content .= ' ' . wp_strip_all_tags($value);
//             }
//         }
//     }

//     return $content;
// }
