<?php get_header(); ?>

<?php
// Fetch the content of the "News" page by its slug
$page = get_page_by_path('news');
if ($page) {
    echo apply_filters('the_content', $page->post_content);
}
?>

<div id="news" class="grid lg:grid-cols-12 md:grid-cols-8 grid-cols-4 gap-5 p-5 md:max-w-7xl md:mx-auto md:px-[50px]">
    <?php
    // Define your query arguments
    $args = array(
        'post_type' => 'news', // Custom post type slug
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC'
    );

    // Perform the query
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        // $max_pages = $query->max_num_pages;
        while ($query->have_posts()) :
            $query->the_post();
            $news_title = get_the_title();
            $news_image = get_the_post_thumbnail_url();
            $news_date = get_the_date();
            $news_content = wp_trim_words(get_the_content(), 20, '...');
            $news_link = get_the_permalink();
    ?>

            <div class="news-item flex flex-col gap-5 col-span-12 md:col-span-4 lg:col-span-4 cursor-default">
                <div class="news-image">
                    <a href="<?php echo $news_link; ?>">
                        <img src="<?php echo $news_image; ?>" alt="<?php echo $news_title; ?>" class="md:h-56 object-cover">
                    </a>
                </div>

                <div class="news-content flex flex-1 flex-col gap-[10px]">
                    <div>
                        <h3 class="text-xl font-semibold"><?php echo $news_title; ?></h3>
                        <p class="text-sm text-gray-500"><?php echo $news_date; ?></p>
                    </div>
                    <div class="mt-auto">
                        <p><?php echo $news_content; ?></p>
                    </div>
                    <div class="mt-auto">
                        <a href="<?php echo $news_link; ?>" class="text-blue-500">Read More</a>
                    </div>
                </div>
            </div>
    <?php

        endwhile;
        wp_reset_postdata(); // Restore original post data
    else :
        echo 'No news to display';
    endif;
    ?>
</div>
<?php get_footer(); ?>