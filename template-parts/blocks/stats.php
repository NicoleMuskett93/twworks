<?php

$id = 'stats-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'stats';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

?>

<section id="<?= esc_attr($id); ?>" class="<?= esc_attr($className); ?> pt-[50px] pb-[35px] md:pt-0 md:max-w-7xl md:mx-auto md:px-[50px]">
  <div class="grid grid-cols-12 gap-[30px] px-5 md:py-[30px] md:px-0">
    <?php if (have_rows('stats')):
      $count = 0; // To keep track of the item count
    ?>
      <?php while (have_rows('stats')): the_row();
        $count++; // Increment item count on each iteration
        $icon = get_sub_field('icon');
        $content = get_sub_field('content');
        $span = get_sub_field('column_span');
        $background_colour = get_sub_field('background_colour');
        $text_colour = get_sub_field('text_colour');

        // Adding a class to the last two items
        $additional_classes = ($count == 7 || $count == 8) ? 'centered-item' : '';
      ?>
        <div class="item col-span-12 md:col-span-6 lg:col-span-4 <?php echo $background_colour; ?> <?php echo $additional_classes; ?> border-primary rounded-[5px] border-2 flex flex-col gap-7 items-center py-[30px] px-10">
          <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>" class="w-28" />
          <div class="<?php echo $text_colour; ?> text-2xl font-bold text-center"><?php echo $content; ?></div>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</section>