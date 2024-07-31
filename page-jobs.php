<? get_header(); 

// $job_time_filter = isset($_GET['full_or_part_time']) ? $_GET['full_or_part_time'] : '';
$search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

?>

<div class="<?php echo get_post_type(); ?>">

<div class="flex justify-center items-center h-60 mt-10" style="background-image:url('https://garyb173.sg-host.com/wp-content/uploads/2024/06/pantiles-exterior-hero.jpg'); background-position: center">
    <h1 class="text-white text-center text-5xl font-semibold max-w-xl">Find your pefect job in Tunbridge Wells </h1>
</div>
<div class="flex flex-col lg:flex-row">
    <div class="bg-blue-100 w-full lg:w-1/3 flex flex-col items-center p-8 divide-y divide-black">

    <div class="w-full max-w-96">

    <?php echo get_search_form();?>

    
    </div>


    <div class="post-filters w-full max-w-96">
            <form id="job-filter-form" class="flex flex-col gap-4 mt-4" method="get">
                    
                <div class="flex flex-row items-center justify-between">
                    <label class="text-lg font-semibold" for="job_salary">Salary</label>
                    <div id="salary_slider" class="w-1/2"></div>
                    <input type="hidden" id="min_salary" name="min_salary">
                    <input type="hidden" id="max_salary" name="max_salary">
                    <div class="text-lg">
                        <span id="salary_value">£20000 - £50000</span>
                    </div>
                    <!-- <div class="text-lg"><span>£</span><span id="salary_value">20000 - 40000</span></div> -->
                </div>

                    <div class="flex flex-row items-center justify-between">
                        <label class="text-lg font-semibold" for="full_or_part_time">Full / Part time</label>
                        <select class="w-1/2 border  rounded p-2" id="full_or_part_time" name="full_or_part_time" placeholder="Select Time">
                            <option value="">All</option>
                            <option value="full-time">Full-time</option>
                            <option value="part-time">Part-time</option>
                        </select>
                    </div>

                    <div class="flex flex-row items-center justify-between">
                        <label class="text-lg font-semibold" for="location">Location</label>
                        <select class="w-1/2 border rounded p-2" id="location" name="location" placeholder="Select Location">
                        <option value="">All</option>
                            <option value="In person">In person</option>
                            <option value="Hybrid">Hybrid</option>
                            <option value="Remote">Remote</option>
                        </select>
                    </div>


                    <button type="submit" class="mt-4 bg-blue-500 text-white p-2 rounded">Filter Jobs</button>
                </form>
            </div>

    </div>
    <div class="bg-blue-50 flex flex-col gap-5 w-full lg:w-2/3 p-8">
        <h2 class="text-2xl font-semibold">Latest Jobs</h2>
        <div id="job-listing-container" class="jobs-content flex flex-col gap-5">
            
            <?php
                    // Define your query arguments
                    $args = array(
                        'post_type' => 'jobs', // Custom post type slug
                        'posts_per_page' => 5, 
                        'post_status' => 'publish' , // Only show published posts
                        's' => $search_query, // Search query
                    );

                    // Perform the query
                    $query = new WP_Query($args);

                    if ($query->have_posts()) :
                        $max_pages = $query->max_num_pages;
                        while ($query->have_posts()) :
                            $query->the_post();
                           
                        
                       
                            get_template_part( 'template-parts/content', get_post_type() ); 
                    
                        endwhile;
                        wp_reset_postdata(); // Restore original post data
                    else :
                        echo 'No jobs to display';
                    endif;
                    ?>
            </div>
            <!-- Load More Jobs Button -->
             <div class="flex justify-center">
                <button id="load-more-jobs" class="mt-4 bg-blue-500 text-white p-2 rounded" data-page="2" data-max-pages="<?php echo $max_pages;?>">Load More Jobs</button>
                <div id="loading" style="display:none;">Loading...</div>
            </div>
        </div>
    </div>
</div>

</div>

<?php get_footer(); ?>

