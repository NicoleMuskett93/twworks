<?php get_header(); ?>

<?php if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    if (in_array('employer', $current_user->roles)) { 
?>
    <div>
        <div class="flex items-center h-48" style="background-image:url('https://garyb173.sg-host.com/wp-content/uploads/2024/06/pantiles-exterior-hero.jpg'); background-position: center">
            <div class="flex flex-col">
                    <h1 class="text-white text-5xl font-semibold">Your jobs: <?php echo $current_user->user_login;?></h1>
                search
            </div>
        </div>

        <div class="flex flex-row">
            <div class="bg-blue-100 w-1/3 flex flex-col justify-start text-center p-5">
                <a href="<?php echo home_url('/add-jobs/');?>" class="text-xl text-black border border-black border-1 bg-gray-300 rounded">New job vacancy</a>
            </div>
            <div class="bg-blue-50 w-2/3 p-8">
                <div class="flex flex-row gap-4 text-xl">
                    <p id="published-tab" class="cursor-pointer">Published</p>
                    <p id="draft-tab" class="cursor-pointer">Draft</p>
                    <p id="archive-tab" class="cursor-pointer">Archive</p>
                </div>
                <div class="posts-content">
                    <?php
                    // Define your query arguments
                    $args = array(
                        'post_type' => 'jobs', // Custom post type slug
                        'posts_per_page' => -1, // Display all posts
                        'author' => get_current_user_id(), // Only posts by current user
                        'post_status' => array('publish', 'draft', 'archive'), // Include all statuses
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
                        ?>
                        <div class="job-post" data-status="<?php echo $status;?>">
                            <a href="<?php the_permalink(); ?>" class="cursor-pointer">
                                <div class="flex flex-col gap-3">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img class="h-80 w-full rounded-md object-cover" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>">
                                    <?php endif; ?>
                                    <div class="flex flex-col bg-white">
                                        <div>
                                            <h2 class="text-xl text-black font-bold"><?php the_title(); ?></h2>
                                            <p class="text-xl text-black">Company Name</p>
                                        </div>
                                        <div class="flex flex-row gap-1">
                                            <p class="text-xl text-black">£<?php echo $job_salary; ?></p>
                                            <p class="text-xl text-black"> - <?php echo $job_shift;?></p>
                                        </div>
                                        <div class="flex flex-row justify-between">
                                            <p class="text-xl text-black"><?php echo $job_publish_date;?></p>
                                            <a href="" class="text-xl text-black border border-black border-1 bg-gray-300 p-2 rounded">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                        endwhile;
                        wp_reset_postdata(); // Restore original post data
                    else :
                        echo 'No posts found';
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
    ?> <div class="login">
            <?php echo wp_login_form($args); ?>
        </div>
<?php }
?>

<?php get_footer(); ?>



