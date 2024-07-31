<?php get_header(); ?>

<?php
// Fetch the content of the "News" page by its slug
$page = get_page_by_path('news');
if ($page) {
    echo apply_filters('the_content', $page->post_content);
}
?>

<div id="news" class="grid grid-cols-3 gap-5 max-w-screen-lg m-auto mt-10">
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

                    <div class="news-item flex flex-col gap-5">
                        <div class="news-image">
                            <img src="<?php echo $news_image; ?>" alt="<?php echo $news_title; ?>" class="h-56 object-cover">
                        </div>
                            
                        <div class="news-content">
                            <h3 class="text-xl font-semibold"><?php echo $news_title; ?></h3>
                            <p class="text-sm text-gray-500"><?php echo $news_date; ?></p>
                            <p><?php echo $news_content; ?></p>
                            <a href="<?php echo $news_link; ?>" class="text-blue-500">Read More</a>
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