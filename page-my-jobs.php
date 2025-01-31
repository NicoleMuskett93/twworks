<?php get_header();
$search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

$banner_image = get_field('banner_image', 'option');

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


if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    if (in_array('employer', $current_user->roles) || in_array('administrator', $current_user->roles)) {

        // Fetch counts for each status
        $published_query = new WP_Query(array(
            'post_type' => 'jobs',
            'posts_per_page' => 10,
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'company',
                    'field' => 'name',
                    'terms' => $company_name

                )
            ),


        ));
        $published_count = $published_query->found_posts;
        wp_reset_postdata();

        $draft_query = new WP_Query(array(
            'post_type' => 'jobs',
            'posts_per_page' => 10,
            'post_status' => 'draft',
            'tax_query' => array(
                array(
                    'taxonomy' => 'company',
                    'field' => 'name',
                    'terms' => $company_name

                )
            ),

        ));
        $draft_count = $draft_query->found_posts;
        wp_reset_postdata();

        $archive_query = new WP_Query(array(
            'post_type' => 'jobs',
            'posts_per_page' => 10,
            'post_status' => 'archive',
            'tax_query' => array(
                array(
                    'taxonomy' => 'company',
                    'field' => 'name',
                    'terms' => $company_name

                )
            ),

        ));
        $archive_count = $archive_query->found_posts;

        $scheduled_query = new WP_Query(array(
            'post_type' => 'jobs',
            'posts_per_page' => 10,
            'post_status' => 'future',
            'tax_query' => array(
                array(
                    'taxonomy' => 'company',
                    'field' => 'name',
                    'terms' => $company_name

                )
            ),
        ));
        $scheduled_count = $scheduled_query->found_posts;
        wp_reset_postdata();

?>
        <div class="mt-[50px]">
            <!-- <div class="flex items-center h-48" style="background-image:url('<?php echo $banner_image['url']; ?>'); background-position: center">
                <div class="flex flex-col gap-3 mx-5">
                    <h1 class="text-white text-5xl font-semibold">Your jobs: <?php echo esc_html($company_name); ?></h1>
                    <?php
                    echo get_search_form();
                    ?>
                </div>
            </div> -->

            <div class="flex flex-col lg:flex-row">
                <div class="w-full lg:w-1/3 flex flex-col gap-6 justify-start px-5 lg:px-8 lg:my-8 border-r-2 border-lightgreen">

                    <div class="flex flex-row gap-3 text-black font-bold text-base">
                        <p><span class="first-name"><?php echo $current_user->user_firstname; ?></span> <span class="last-name"><?php echo $current_user->user_lastname; ?></span></p> |
                        <p><?php echo esc_html($company_name); ?></p>
                    </div>



                    <div class="flex flex-row lg:flex-col gap-3">
                        <div class="flex flex-row lg:flex-col gap-3">
                            <a href="<?php echo esc_url(home_url('/my-jobs/')); ?>" class="text-base text-black underline">My vacancies</a>
                            <a href="<?php echo esc_url(home_url('/add-jobs/')); ?>" class="text-base text-darkergreen">Add new vacancy</a>
                        </div>



                        <div class="flex flex-row lg:flex-col gap-3">
                            <a href="<?php echo esc_url(home_url('/profile/')); ?>" class="text-base text-darkergreen">Profile</a>
                            <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="text-base text-darkergreen">Logout</a>
                        </div>
                    </div>
                </div>



                <div class="bg-white flex flex-col gap-5 w-full lg:w-2/3 p-5 lg:p-8">
                    <h2 class="text-2xl font-bold">Your vacancies</h2>
                    <div class="flex flex-row gap-4 text-[13px] text-darkergreen options">
                        <p id="published-tab" class="title cursor-pointer" data-status="publish">Published (<?php echo esc_html($published_count); ?>)</p>
                        <p id="scheduled-tab" class="title cursor-pointer" data-status="future">Scheduled (<?php echo esc_html($scheduled_count); ?>)</p>
                        <p id="draft-tab" class="title cursor-pointer" data-status="draft">Draft (<?php echo esc_html($draft_count); ?>)</p>
                        <p id="archive-tab" class="title cursor-pointer" data-status="archive">Archive (<?php echo esc_html($archive_count); ?>)</p>

                    </div>
                    <div id="my-job-listing-container" class="posts-content flex flex-col gap-5">
                        <?php
                        // Define query arguments
                        $args = array(
                            'post_type' => 'jobs', // Custom post type slug
                            'posts_per_page' => 10, // Display all posts
                            'post_status' => array('publish', 'draft', 'archive', 'future'), // Include all statuses
                            's' => $search_query, // Search query
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'company',
                                    'field' => 'name',
                                    'terms' => $company_name

                                )
                            ),
                            'meta_key' => 'job_publish_date'

                        );

                        // Perform the query
                        $query = new WP_Query($args);

                        if ($query->have_posts()) :
                            $max_pages = $query->max_num_pages;
                            while ($query->have_posts()) :
                                $query->the_post();
                                $status = get_post_status();

                                $job_salary = get_post_meta(get_the_ID(), 'job_salary', true);
                                $job_supplemental_pay = get_post_meta(get_the_ID(), 'job_supplemental_pay', true);
                                $job_time = get_post_meta(get_the_ID(), 'job_time', true);
                                $job_shift = get_post_meta(get_the_ID(), 'job_shift', true);
                                $job_location = get_post_meta(get_the_ID(), 'job_location', true);
                                $job_start_date = get_post_meta(get_the_ID(), 'job_start_date', true);
                                $job_publish_date = get_post_meta(get_the_ID(), 'job_publish_date', true);
                                $job_description_summary = get_post_meta(get_the_ID(), 'job_description_summary', true);


                                $company_logo = get_field('company_logo', 'user_' . get_the_author_meta('ID'));


                                $publish_timestamp = get_the_time('U + 1');
                                $time_diff = human_time_diff($publish_timestamp);
                        ?>

                                <div class="my-job-post flex flex-col gap-[10px]" data-status="<?php echo esc_attr($status); ?>">
                                    <div class=" lg:bg-lightergreen flex flex-row gap-5 lg:p-[15px]">
                                        <div class="flex flex-col gap-3 w-1/3 lg:w-[113px]">
                                            <?php if ($company_logo) : ?>
                                                <img class="w-[90px] h-[90px] lg:w-[113px] lg:h-[113px] rounded-md object-contain bg-white" src="<?php echo esc_url($company_logo); ?>" alt="<?php echo esc_attr(get_the_author_meta('display_name', get_the_author_meta('ID'))); ?>">
                                            <?php endif; ?>
                                        </div>



                                        <div class="flex flex-col w-2/3 lg:w-5/6 gap-3">
                                            <div class="flex flex-col lg:flex-row justify-between">
                                                <div>
                                                    <h2 class="text-base lg:text-lg text-black lg:text-darkergreen font-bold"><?php the_title(); ?></h2>

                                                    <div class="flex flex-col lg:flex-row lg:gap-5 text-black lg:font-bold text-base ">
                                                        <p class=" text-black"><?php echo esc_html($company_name); ?></p>
                                                        <?php if ($job_salary == 0): ?>

                                                        <?php else: ?>
                                                            <p class="unspecified">
                                                                £<?php echo format_salary($job_salary) ?>
                                                            </p>
                                                        <?php endif; ?>

                                                        <p class=" text-black"> <?php echo esc_html($job_time); ?></p>

                                                    </div>
                                                </div>
                                                <!-- <div class="flex flex-row justify-between"> -->
                                                <?php
                                                /*
                                                if ($job_publish_date) {
                                                    // Check if the publish date is numeric (timestamp)
                                                    if (is_numeric($job_publish_date)) {
                                                        // Format the timestamp to 'j F Y'
                                                        $date = date('j F Y', $job_publish_date);
                                                    } else {
                                                        // Convert the date string to a timestamp and then format it to 'j F Y'
                                                        $date = date('j F Y', strtotime($job_publish_date));
                                                    }
                                                    // Output the formatted date
                                                    echo '<p class="text-xl text-black">' . esc_html($date) . '</p>';
                                                }
                                                */
                                                ?>
                                                <!-- </div> -->

                                                <div class="hidden lg:flex lg:flex-col items-end w-1/6 gap-5">
                                                    <?php
                                                    if ($status === 'future') { // Or whatever status you use for scheduled jobs
                                                        if ($time_diff > 0) {
                                                            // If still scheduled
                                                            $scheduled_date = date('j F Y', $job_publish_date);
                                                            echo "<p class='text-[12px] text-black text-end'>Scheduled for {$scheduled_date}</p>";
                                                        }
                                                    } else if ($status === 'publish') {
                                                        // If the job is published
                                                        echo "<p class='text-[12px] text-black'>Added {$time_diff} ago</p>";
                                                    } ?>
                                                    <a href="<?php echo esc_url(home_url('/edit-jobs/?post_id=' . get_the_ID())); ?>" class="w-fit cursor-pointer text-sm font-bold text-darkergreen underline">Edit</a>
                                                </div>
                                            </div>
                                            <hr class="hidden lg:block">
                                            <div class="hidden lg:flex lg:flex-row">
                                                <?php echo $job_description_summary; ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="flex flex-col lg:hidden gap-[18px]">
                                        <p class="text-[12px] text-black">Added <?php echo $time_diff . ' ago'; ?></p>
                                        <?php echo $job_description_summary; ?>
                                        <a href="<?php echo esc_url(home_url('/edit-jobs/?post_id=' . get_the_ID())); ?>" class="lg:hidden w-fit cursor-pointer text-sm text-center border-darkergreen border-2 rounded-full text-darkergreen px-10 py-1 ">Edit</a>
                                    </div>
                                </div>

                        <?php
                            endwhile;
                            wp_reset_postdata(); // Restore original post data
                        else :
                            echo 'No jobs to display';
                        endif;
                        ?>
                    </div>

                </div>


            </div>
            <div class="flex flex-row">
                <div class="w-1/3">

                </div>
                <div class="w-2/3 m-8 mt-0">
                    <!-- Load More Jobs Button -->
                    <?php if ($max_pages > 1) : ?>
                        <div class="">
                            <button id="load-more-my-jobs" class="mt-4 bg-white border-darkergreen border-2 text-darkergreen hover:bg-darkergreen hover:text-white px-10 py-2 rounded-full" data-page="1" data-max-pages="<?php echo $max_pages; ?>">Load More Jobs</button>
                            <div id="loading" style="display:none;">Loading...</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php
    } else {
        echo '<p>You do not have permission to view this content.</p>';
    }
} else {
    $args = array(
        'echo' => true,
        'form_id' => 'loginform',
        'label_username' => 'Username',
        'placeholder_username' => 'Username',
        'placeholder_password' => 'Password',
        'label_password' => 'Password',
        'label_remember' => 'Remember Me',
        'label_log_in' => 'Log In',
        'id_username' => 'user_login',
        'id_password' => 'user_pass',
        'id_remember' => 'rememberme',
        'id_submit' => 'wp-submit',
        'remember' => true,
        'value_username' => '',
        'value_remember' => false
    );
    //loginform top to add image
    ?> <div class="custom-login">
        <?php echo wp_login_form($args);
        // $login_form_top = apply_filters( 'login_form_top', '', $args );
        // $login_form_top .= sprintf('<img src="https://tunbridgewells.works/wp-content/uploads/2024/06/xlogo.png.pagespeed.ic_.vin3YSmmMj.png" alt="logo">');
        // echo $login_form_top;

        //moved to functions.php

        ?>

    </div>
<?php }
?>

<?php get_footer(); ?>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.title');
        const jobPosts = document.querySelectorAll('.job-post');

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                const status = this.getAttribute('data-status');
                
                // Remove 'active' class from all tabs
                tabs.forEach(tab => {
                    tab.classList.remove('active');
                });

                // Add 'active' class to the clicked tab
                this.classList.add('active');


                jobPosts.forEach(post => {
                    if (post.getAttribute('data-status') === status || status === '') {
                        post.style.display = 'flex'; // Show the post
                    } else {
                        post.style.display = 'none'; // Hide the post
                    }
                });
            });
        });
    });
</script> -->