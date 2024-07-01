<? get_header();?>

<div class="<?php echo get_post_type(); ?>">

<div class="flex justify-center items-center h-48" style="background-image:url('https://garyb173.sg-host.com/wp-content/uploads/2024/06/pantiles-exterior-hero.jpg'); background-position: center">
    <h1 class="text-white text-center text-5xl font-semibold max-w-xl">Find your pefect job in Tunbridge Wells </h1>
</div>
<div class="flex flex-row">
    <div class="bg-blue-100 w-1/3">Filter

    </div>
    <div class="bg-blue-50 w-2/3 p-8">
        <h2 class="text-2xl font-semibold">Latest Jobs</h2>
        <div class="jobs">
            <div class="">
                    <?php
                    // Define your query arguments
                    $args = array(
                        'post_type' => 'jobs', // Custom post type slug
                        'posts_per_page' => -1, // Display all posts
                    );

                    // Perform the query
                    $query = new WP_Query($args);

                    if ($query->have_posts()) :
                        while ($query->have_posts()) :
                            $query->the_post();
                            $job_salary = get_post_meta(get_the_ID(), 'job_salary', true);
                            $job_supplemental_pay = get_post_meta(get_the_ID(), 'job_supplemental_pay', true);
                            $job_time = get_post_meta(get_the_ID(), 'job_time', true);
                            $job_shift = get_post_meta(get_the_ID(), 'job_shift', true);
                            $job_location = get_post_meta(get_the_ID(), 'job_location', true);
                            $job_start_date = get_post_meta(get_the_ID(), 'job_start_date', true);
                        ?>
                        <a href="<?php the_permalink(); ?>" class="cursor-pointer">
                            <div class="flex flex-col gap-3">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img class="h-80 w-full rounded-md object-cover" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                                <div class="flex flex-col">
                                    <div>
                                        <h2 class="text-xl text-black font-bold"><?php the_title(); ?></h2>
                                        <p class="text-xl text-black">Company Name</p>
                                    </div>
                                    <div class="flex flex-row gap-1">
                                        <p class="text-xl text-black">£<?php echo $job_salary; ?></p>
                                        <p class="text-xl text-black"> - <?php echo $job_shift;?></p>
                                    </div>
                                    <div class="flex flex-row justify-between">
                                        <p class="text-xl text-black"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></p>
                                        <a href="<?php the_permalink( );?>" class="text-xl text-black border border-black border-1 bg-gray-300 p-2 rounded">See more</a>
                                    </div>
                                </div>
                            </div>
                        </a>
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
</div>

</div>

<?php get_footer();