<?php 

$job_salary = get_post_meta(get_the_ID(), 'job_salary', true);
$job_supplemental_pay = get_post_meta(get_the_ID(), 'job_supplemental_pay', true);
$job_time = get_post_meta(get_the_ID(), 'job_time', true);
$job_shift = get_post_meta(get_the_ID(), 'job_shift', true);
$job_location = get_post_meta(get_the_ID(), 'job_location', true);
$job_start_date = get_post_meta(get_the_ID(), 'job_start_date', true);

$company_logo = get_field('company_logo', 'user_' . get_the_author_meta('ID'));
$company_name = get_field('company_name', 'user_'. get_the_author_meta('ID'));

?>


<div class="flex flex-row">
    <div class="flex flex-col gap-3 w-1/6">
        <?php if ($company_logo) :
            ?>
        <img class="h-full w-full rounded-md object-cover" src="<?php echo esc_url($company_logo); ?>" alt="<?php echo esc_attr(get_the_author_meta('display_name', get_the_author_meta('ID'))); ?>">
        <?php endif; ?>
        </div>
        <div class="flex flex-col bg-white w-5/6 p-3">
        <div>
            <h2 class="text-xl text-black font-bold"><?php the_title(); ?></h2>
            <p class="text-xl text-black"><?php echo $company_name;?></p>
        </div>
        <div class="flex flex-row gap-1">
            <p class="text-xl text-black">£<?php echo $job_salary; ?></p>
            <p class="text-xl text-black"> - <?php echo $job_shift;?></p>
        </div>
        <div class="flex flex-row justify-between">
            <p class="text-xl text-black"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></p>
            <a href="<?php the_permalink( );?>" class="text-xl text-black border border-black border-1 bg-gray-300 p-2 rounded">See more</a>
        </div>
    </div>
</div>