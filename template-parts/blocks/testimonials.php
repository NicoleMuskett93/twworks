<?php

$id = 'testimonials-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

$className = 'testimonials-';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}

//style

$text_color = get_field('text_color');

?>

<div id="<?= esc_attr($id); ?>" class="<?= esc_attr($className); ?>">
 
    <div class="swiper max-w-5xl mx-auto my-20">
        <div class="swiper-wrapper">
                <?php if (have_rows('testimonials')) : ?>
                    <?php while (have_rows('testimonials')) : the_row(); ?>
                        <div class="swiper-slide flex flex-col text-center gap-8 ">
                            <?php the_sub_field('testimonial'); ?>
                            <div class="flex flex-row gap-1 text-xl font-semibold justify-center">
                                <p><?php the_sub_field('author'); ?></p>,
                                <p> <?php the_sub_field('position'); ?></p>,
                                <p class="text-brightPink"><?php the_sub_field('company'); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

