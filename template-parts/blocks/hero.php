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

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($className); ?> hero-height">
    <div class="h-full flex justify-center items-center "style="background-image:url('<?php echo $background_image['url']; ?>'); background-size:cover; background-repeat: no-repeat; background-position: center;">
        <div class="flex flex-col gap-4 text-center">
            <?php if ($heading) { ?>
                <h1 class="text-6xl px-3 py-4 text-<?php echo $text_color; ?> bg-<?php echo $text_background_color;?> font-extrabold uppercase "><?php echo $heading; ?></h1>
            <?php } ?>

            <?php if ($sub_heading) { ?>
                <h2 class="text-3xl text-<?php echo $text_color; ?> px-3 py-4 bg-<?php echo $text_background_color;?> font-light "><?php echo $sub_heading; ?></h2>
            <?php } ?>
        </div>
    </div>
</section>
