<?php

$id = 'main-content-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

$className = 'main-content';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}

$image = get_field('image');
$title = get_field('title');
$content = get_field('content');
$links = get_field('links');

?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($className); ?> m-5 md:m-0 md:max-w-7xl md:mx-auto md:px-[50px] md:py-[30px]">

    <?php if ($links) { ?>

        <div class="grid md:grid-cols-3 grid-cols-1 align-top gap-5 py-5 lg:py-12">
            <?php if (have_rows('links')) { ?>
                <?php while (have_rows('links')) {
                    the_row();
                    $link_image = get_sub_field('link_image');
                    $link_heading = get_sub_field('link_title');
                ?>

                    <?php if ($link_image && $link_heading) { ?>

                        <a href="<?php echo $link_heading['url']; ?>" class="">
                            <img src="<?php echo $link_image['url']; ?>" alt="<?php echo $link_image['alt']; ?>" class=" h-full w-full object-cover" />
                            <h3 class="-mt-12 text-[18px] text-center px-3 py-4 font-bold text-white"><?php echo $link_heading['title']; ?></h3>
                        </a>
                    <?php } ?>
            <?php }
            } ?>
        </div>

    <?php } ?>


    <div class="flex flex-col gap-6 ">
        <?php if ($image) { ?>
            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="object-cover h-full md:pb-5" />
        <?php }; ?>
        <?php if ($title) { ?>
            <h3 class="text-2xl md:text-[40px] font-bold lg:max-w-4xl"><?php echo $title; ?></h3>
        <?php } ?>
        <?php if ($content) { ?>
            <div class="flex flex-col gap-5 lg:max-w-4xl text-base"><?php echo $content; ?></div>
        <?php } ?>
    </div>


</section>