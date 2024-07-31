<?php get_header(); 

$banner_image = get_field('banner_image', 'option');


if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    if (in_array('employer', $current_user->roles) || in_array('administrator', $current_user->roles)) { 

        // Fetch counts for each status
        $published_query = new WP_Query(array(
            'post_type' => 'jobs',
            'posts_per_page' => -1,
            'author' => get_current_user_id(),
            'post_status' => 'publish'
        ));
        $published_count = $published_query->found_posts;
        wp_reset_postdata();

        $draft_query = new WP_Query(array(
            'post_type' => 'jobs',
            'posts_per_page' => -1,
            'author' => get_current_user_id(),
            'post_status' => 'draft'
        ));
        $draft_count = $draft_query->found_posts;
        wp_reset_postdata();

        $archive_query = new WP_Query(array(
            'post_type' => 'jobs',
            'posts_per_page' => -1,
            'author' => get_current_user_id(),
            'post_status' => 'archive'
        ));
        $archive_count = $archive_query->found_posts;

        $scheduled_query = new WP_Query(array(
            'post_type' => 'jobs',
            'posts_per_page' => -1,
            'author' => get_current_user_id(),
            'post_status' => 'future'
        ));
        $scheduled_count = $scheduled_query->found_posts;
        wp_reset_postdata();

    ?>
    <div>
        <div class="flex items-center h-48" style="background-image:url('<?php echo $banner_image['url'];?>'); background-position: center">
            <div class="flex flex-col gap-3 mx-5">
                <h1 class="text-white text-5xl font-semibold">Your jobs: <?php echo esc_html($current_user->company_name); ?></h1>
                <?php 
                echo get_search_form();
                ?>
            </div>
        </div>

        <div class="flex flex-row">
            <div class="bg-blue-100 w-1/3 flex flex-col justify-start text-center p-5">
                <a href="<?php echo esc_url(home_url('/add-jobs/')); ?>" class="text-xl text-black border border-black border-1 bg-gray-300 rounded">New job vacancy</a>
            </div>
            <div class="bg-blue-50 flex flex-col gap-5 w-2/3 p-8">
                <div class="flex flex-row gap-4 text-xl">
                    <p id="published-tab" class="title cursor-pointer" data-status="publish">Published (<?php echo esc_html($published_count); ?>)</p>
                    <p id="draft-tab" class="title cursor-pointer" data-status="draft">Draft (<?php echo esc_html($draft_count); ?>)</p>
                    <p id="archive-tab" class="title cursor-pointer" data-status="archive">Archive (<?php echo esc_html($archive_count); ?>)</p>
                    <p id="scheduled-tab" class="title cursor-pointer" data-status="future">Scheduled (<?php echo esc_html($scheduled_count); ?>)</p>
                </div>
                <div id="job-listing-container" class="posts-content flex flex-col gap-5">
                    <?php
                        // Define query arguments
                        $args = array(
                            'post_type' => 'jobs', // Custom post type slug
                            'posts_per_page' => -1, // Display all posts
                            'author' => get_current_user_id(), // Only posts by current user
                            'post_status' => array('publish', 'draft', 'archive','future'), // Include all statuses
                        );

                        // Perform the query
                        $query = new WP_Query($args);

                        if ($query->have_posts()) :
                            while ($query->have_posts()) :
                                $query->the_post();
                                $status = get_post_status();

                                $job_salary = get_post_meta(get_the_ID(), 'job_salary', true);
                                $job_supplemental_pay = get_post_meta(get_the_ID(), 'job_supplemental_pay', true);
                                $job_time = get_post_meta(get_the_ID(), 'job_time', true);
                                $job_shift = get_post_meta(get_the_ID(), 'job_shift', true);
                                $job_location = get_post_meta(get_the_ID(), 'job_location', true);
                                $job_start_date = get_post_meta(get_the_ID(), 'job_start_date', true);
                                $job_publish_date = get_post_meta(get_the_ID(), 'job_start_date', true);

                                $company_logo = get_field('company_logo', 'user_' . get_the_author_meta('ID'));
                            ?>
                            <div class="job-post flex flex-row" data-status="<?php echo esc_attr($status); ?>">
                                <div class="flex flex-col gap-3 w-1/6">
                                    <?php if ($company_logo) : ?>
                                    <img class="w-full h-full rounded-md object-contain p-3 bg-white" src="<?php echo esc_url($company_logo); ?>" alt="<?php echo esc_attr(get_the_author_meta('display_name', get_the_author_meta('ID'))); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-col bg-white w-5/6 p-3">
                                    <div>
                                        <h2 class="text-xl text-black font-bold"><?php the_title(); ?></h2>
                                        <p class="text-xl text-black"><?php echo esc_html($current_user->company_name); ?></p>
                                    </div>
                                    <div class="flex flex-row gap-1">
                                        <p class="text-xl text-black">£<?php echo esc_html($job_salary); ?></p>
                                        <p class="text-xl text-black"> - <?php echo esc_html($job_shift); ?></p>
                                    </div>
                                    <div class="flex flex-row justify-between">
                                    <?php
                                        if ($job_publish_date) {
                                            // Create a DateTime object from the job publish date
                                            $date = new DateTime($job_publish_date);
                                            // Format the date
                                            $formatted_date = $date->format('j F Y');
                                            echo '<p class="text-xl text-black">' . esc_html($formatted_date) . '</p>';
                                        }
                                    ?>
                                        <a href="<?php echo esc_url(home_url('/edit-jobs/?post_id=' . get_the_ID())); ?>" class="cursor-pointer text-xl text-black border border-black border-1 bg-gray-300 p-2 rounded">Edit</a>
                                    </div>
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
    ?> <div class="login my-5">
            <?php echo wp_login_form($args); ?>
        </div>
<?php }
?>

<?php get_footer(); ?>

<script>
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
</script>
