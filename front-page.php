<?php get_header(); 

if (have_posts()) :
    while (have_posts()) : the_post();
        the_content(); // This will render the blocks within the content area
    endwhile;
endif;

get_footer(); ?>