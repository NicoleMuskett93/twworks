<?php

$id = 'testimonials-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

$className = 'testimonials';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}


//style

$text_color = get_field('text_color');

?>

<div id="<?= esc_attr($id); ?>" class="<?= esc_attr($className); ?> bg-primary p-5 text-white">

    <div class="swiper max-w-5xl mx-auto my-20">
        <div class="swiper-wrapper">
            <?php if (have_rows('testimonials')) : ?>
                <?php while (have_rows('testimonials')) : the_row();
                    $position = get_sub_field('position');
                    $company = get_sub_field('company'); ?>


                    <div class="swiper-slide flex flex-col text-center gap-5 md:gap-8 ">
                        <div class="flex flex-row justify-center gap-0 text-base md:text-4xl font-bold">
                            <?php the_sub_field('testimonial'); ?>
                        </div>
                        <div class="flex flex-row gap-1 text-base md:text-2xl justify-center">
                            <p><?php the_sub_field('author'); ?></p>
                            <?php if ($position): ?>
                                <p> , <?php echo $position; ?></p>

                            <?php endif;

                            if ($company): ?>
                                <p> , <?php echo $company; ?></p>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <!-- <div class="swiper-pagination"></div> -->
    </div>
</div>