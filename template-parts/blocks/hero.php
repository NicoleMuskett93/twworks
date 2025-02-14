<?php

$id = 'hero-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

$className = 'hero';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}

$background_image = get_field('hero_image');
$heading = get_field('heading');
$sub_heading = get_field('sub_heading');
$text_color = get_field('text_color');
$text_background_color = get_field('text_background_color');

//For future
$heading_size = get_field('heading_size');
$sub_heading_size = get_field('sub_heading_size');
$content_alignment = get_field('content_alignment');


?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($className); ?> hero-height md:mt-[50px]">
    <div class="h-full flex justify-center items-center " style="background-image:url('<?php echo $background_image['url']; ?>'); background-size:cover; background-repeat: no-repeat; background-position: center;">
        <div class="flex flex-col gap-3 text-center bg-<?php echo $text_background_color; ?> w-full py-6 mx-5 lg:w-auto lg:px-14 lg:mx-0 ">
            <?php if ($heading) { ?>
                <h1 class="text-2xl lg:text-[40px] text-<?php echo $text_color; ?> font-extrabold uppercase "><?php echo $heading; ?></h1>
            <?php } ?>

            <?php if ($sub_heading) { ?>
                <h2 class="text-2xl lg:text-[32px] text-<?php echo $text_color; ?> font-bold "><?php echo $sub_heading; ?></h2>
            <?php } ?>
        </div>
    </div>
</section>