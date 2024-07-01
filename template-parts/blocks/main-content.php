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


?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($className); ?> mx-auto my-10 max-w-screen-2xl">
    <div class="grid md:grid-cols-3 grid-cols-1 align-top gap-5 px-4 py-12">
        <?php if(have_rows('links')) { ?>
            <?php while(have_rows('links')) { the_row();
                $link_image = get_sub_field('link_image');
                $link_heading = get_sub_field('link_title');
                ?>

                <?php if($link_image && $link_heading){ ?>

                    <a href="<?php echo $link_heading['url'];?>" class="">
                        <img src="<?php echo $link_image['url']; ?>" alt="<?php echo $link_image['alt']; ?>" class="h-full w-full object-cover"/>
                        <h3 class="text-xl px-3 py-4 font-bold uppercase text-primary"><?php echo $link_heading['title']; ?></h3>
                    </a>
                <?php }?>
            <?php }
        } ?>
    </div>


    <div class="flex flex-col gap-4 text-center">
        <?php if ($image) { ?>
            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="object-cover h-full"/>
        <?php }; ?>
        <?php if ($title) { ?>
            <h3 class="text-2xl px-3 py-4 font-bold "><?php echo $title; ?></h3>
        <?php } ?>
        <?php if ($content) { ?>
            <div class="max-w-5xl mx-auto"><?php echo $content; ?></div>
        <?php } ?>
    </div>


</section>
