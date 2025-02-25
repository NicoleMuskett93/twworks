<? get_header();

// $job_time_filter = isset($_GET['full_or_part_time']) ? $_GET['full_or_part_time'] : '';
$search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

$vol_banner_image = get_field('vol_banner_image', 'option');
$vol_title = get_field('vol_title', 'option');
$vol_description = get_field('vol_description', 'option');
$vol_description_hidden = get_field('vol_description_hidden', 'option');

?>

<div class="<?php echo get_post_type(); ?> volunteering-page lg:mt-[50px]" data-page-id="<?php echo get_the_ID(); ?>" id="page-wrapper">

    <div class="hidden lg:flex justify-center items-center h-[350px] md:mt-10" style="background-image:url('<?php echo $vol_banner_image['url']; ?>'); background-position: center">

    </div>
    <div class="hidden lg:flex flex-col lg:flex-row ">
        <div class="w-full lg:w-1/3"></div>


        <div class=" w-full lg:w-2/3 ">
            <div class="flex flex-col bg-lighterpurple gap-[15px] pb-0 p-8 ml-3 mr-8 lg:h-[220px] -mt-[175px]  lg:-mt-[220px] " id="main-content">
                <h2 class="text-2xl font-bold text-black"><?php echo $vol_title; ?></h2>
                <div class="flex flex-col gap-5 text-black text-base"><?php echo $vol_description; ?></div>
                <?php if ($vol_description_hidden): ?>
                    <div class="flex justify-end openinfo">
                        <a href="#" id="morelink" class="text-darkergreen text-base underline pb-5">More</a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($vol_description_hidden): ?>

                <div class="hidden bg-lighterpurple flex flex-col gap-5 p-8 pt-5 ml-3 mr-8 " id="infosection">
                    <div>
                        <div class="flex flex-col gap-5 text-black text-base"><?php echo $vol_description_hidden; ?></div>
                    </div>
                    <div class="flex justify-end closeinfo">
                        <a href="#" id="lesslink" class="text-darkergreen text-base underline">Less</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="strip block md:hidden px-5 py-4">
        <p class="text-white text-2xl text-center font-bold">Find a Volunteering position in Tunbridge Wells</p>
    </div>
    <div class="flex justify-center md:justify-end p-5 md:px-8 w-full">
        <div id="adblock" class="flex flex-col md:flex-row md:flex-wrap md:justify-evenly gap-3 md:gap-0 border border-darkergreen p-4 relative lg:w-2/3 w-full ">
            <div id="adclose" class="absolute right-[10px] top-[10px]">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#7837a0" />
                </svg>
            </div>

            <div class="flex flex-row gap-1 md:gap-3 items-center">
                <p class="text-base text-darkgrey w-[185px] md:w-auto">Project funded and run by</p>
                <img src="https://tunbridgewells.works/wp-content/uploads/2024/11/64149e2ffabbf94baa7c1e2dfd266598.png" alt="Logo" class="w-[100px] h-[50px] object-contain">
            </div>
            <div class="flex flex-row gap-1 md:gap-3 items-center">
                <p class="text-base text-darkgrey w-[185px] md:w-auto">with support from</p>
                <img src="https://tunbridgewells.works/wp-content/uploads/2024/11/709ef9c02c49236fbd7835c1d26acd9f-e1730461422645.png" alt="Logo" class="w-[100px] h-[50px] object-contain">
            </div>
            <div class="flex flex-row gap-1 md:gap-3 items-center">
                <p class="text-base text-darkgrey w-[185px] md:w-auto">and support from</p>
                <img src="https://tunbridgewells.works/wp-content/uploads/2025/02/Creative_Tunbridge_Wells.png" alt="Logo" class="w-[100px] h-[50px] object-contain">
            </div>


        </div>
    </div>


    <?php
    // Load the filter form
    get_template_part('template-parts/content', 'filterform');
    ?>

</div>

</div>

<div class="bg-white flex flex-col gap-5 w-full lg:w-2/3 lg:p-8 mt-0">

    <div class="flex flex-row justify-between">
        <h2 class="text-2xl font-semibold">Latest Jobs</h2>

        <?php
        // Define your query arguments
        $args = array(
            'post_type' => 'jobs', // Custom post type slug
            'posts_per_page' => 10, // Number of posts per page
            'post_status' => 'publish', // Only show published posts
            's' => isset($search_query) ? $search_query : '', // Optional search query
            //exclude posts with volunteering tag
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_tag',
                    'field' => 'slug',
                    'terms' => 'volunteering',
                    'operator' => 'IN'
                )
            )

        );

        // Perform the query
        $query = new WP_Query($args);

        // Assign post counts
        $posts_displayed = $query->post_count;
        $total_posts = $query->found_posts;
        ?>

        <!-- Now we display the post count AFTER the query has run
         only display the post count if there are posts to display
        -->


        <p id="posts-count-block" class="text-base text-black">
            Showing <span id="posts-count"><?php echo $posts_displayed; ?> </span> of <?php echo $total_posts; ?> vacancies
        </p>


    </div>

    <div class="lg:hidden">
        <form id="mobile-job-filter-form" class="">
            <div class="">
                <select class="w-full border-grey border rounded-sm p-3 text-base select-custom" id="when_published_mobile" name="when_published" placeholder="Lastest">
                    <option value="" class="text-grey" selected>Sort by date added</option>
                    <option value="today">Today</option>
                    <option value="this-week">This Week</option>
                    <option value="this-month">This Month</option>
                </select>
            </div>
        </form>
    </div>

    <div id="job-listing-container" class="jobs-content flex flex-col gap-5 ">

        <?php
        // Check if there are posts


        if ($query->have_posts()) :
            $max_pages = $query->max_num_pages;
            while ($query->have_posts()) :
                $query->the_post();
                get_template_part('template-parts/content', get_post_type());
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
    <div class="lg:w-1/3"></div>
    <div class="lg:w-2/3">

        <!-- Load More Jobs Button -->
        <div class="p-8 pt-0">
            <?php if ($max_pages > 1) : ?>
                <div class="">
                    <button id="load-more-jobs" class="mt-4 border-2 border-darkergreen text-darkergreen px-[45px] py-2 rounded-full" data-page="1" data-max-pages="<?php echo $max_pages; ?>">Show more jobs</button>
                    <div id="loading" style="display:none;">Loading...</div>
                </div>
            <?php endif; ?>
        </div>
        <!-- <div class="flex flex-col gap-3 m-5 lg:m-8 lg:mt-0 p-5 lg:p-8 bg-lighterpurple">
            <h2 class="text-black font-bold text-2xl">Need advice or support?</h2>
            <p>Below is a list of recruitment companies who can provide further advice and support:</p>
            <div class="flex flex-col gap-1">
                <a href="https://www.bluepelican.com/" target="_blank" class="text-darkergreen">Blue Pelican Recruitment</a>
                <a href="https://www.dsr-global.com" target="_blank" class="text-darkergreen">DSR Global</a>
                <a href="https://www.gerrardwhite.com" target="_blank" class="text-darkergreen">Gerrard White Recruitment</a>
                <a href="https://www.hobsonprior.com" target="_blank" class="text-darkergreen">Hobson Prior International Recruitment</a>
                <a href="https://www.interquestgroup.com" target="_blank" class="text-darkergreen">Interquest Group Recruitment</a>
                <a href="https://www.office-angels.com" target="_blank" class="text-darkergreen">Office Angels Recruitment</a>
            </div>
        </div> -->
    </div>
</div>
</div>

<div class="p-5 lg:hidden">
    <img src="https://tunbridgewells.works/wp-content/uploads/2024/10/ad.png" alt="Ad" class="pt-[10px] pb-[10px]">
    <div class="flex flex-row gap-[10px]">
        <a href="https://apps.apple.com/gb/app/rtw-lovelocal/id6695746434">
            <img src="https://tunbridgewells.works/wp-content/uploads/2024/10/App-Store.svg" alt="app-store">
        </a>
        <a href="https://play.google.com/store/apps/details?id=com.loqiva.tunbridgewells">
            <img src="https://tunbridgewells.works/wp-content/uploads/2024/10/Google-Play.svg" alt="google-play">
        </a>
    </div>
</div>

</div>

<?php get_footer(); ?>