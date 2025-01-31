<?php

if (is_page('volunteering')) {
    $job_type = 'volunteering_job';
} else {
    $job_type = 'normal_job';
}

$job_salary = get_post_meta(get_the_ID(), 'job_salary', true);
$job_supplemental_pay = get_post_meta(get_the_ID(), 'job_supplemental_pay', true);
$job_time = get_post_meta(get_the_ID(), 'job_time', true);
$job_shift = get_post_meta(get_the_ID(), 'job_shift', true);
$job_location = get_post_meta(get_the_ID(), 'job_location', true);
$job_start_date = get_post_meta(get_the_ID(), 'job_start_date', true);
$job_description_summary = get_post_meta(get_the_ID(), 'job_description_summary', true);

$company_logo = get_field('company_logo', 'user_' . get_the_author_meta('ID'));

$company_term_id = get_field('company_name', 'user_' . get_the_author_meta('ID'));

if ($company_term_id) {
    $company_term = get_term($company_term_id); // Fetch term object
    $company_name = $company_term ? $company_term->name : 'Unknown Company'; // Get the name from the term object
} else {
    $company_name = 'Unknown Company'; // Fallback if term ID is not found
}


$publish_timestamp = get_post_time('U + 1');
$time_diff = human_time_diff($publish_timestamp);

?>


<div class="flex flex-col gap-5" data="<?php echo $job_type; ?>">
    <div class="flex flex-row gap-5 job-post md:bg-lightergreen md:p-[15px]">
        <div class="flex flex-col gap-3 w-[90px] lg:w-[113px]">
            <?php if ($company_logo) :
            ?>
                <img class="w-[90px] h-[90px] lg:w-[113px] lg:h-[113px]  object-contain bg-white" src="<?php echo esc_url($company_logo); ?>" alt="<?php echo esc_attr(get_the_author_meta('display_name', get_the_author_meta('ID'))); ?>">
            <?php endif; ?>
        </div>


        <div class="flex flex-col md:w-5/6 gap-3">
            <div class="flex flex-row justify-between">
                <div>
                    <h2 class="text-base md:text-lg text-darkergreen font-bold"><?php the_title(); ?></h2>

                    <div class="flex flex-col gap-1 md:flex-row md:gap-5 text-sm text-black font-bold">
                        <p class=""><?php echo $company_name; ?></p>


                        <?php if ($job_salary == 0): ?>

                        <?php else: ?>
                            <p class="unspecified">
                                £<?php echo format_salary($job_salary) ?>
                            </p>
                        <?php endif; ?>


                        <p class=""><?php echo $job_time; ?></p>
                    </div>
                </div>

                <div class="hidden md:flex flex-col items-end w-1/6 gap-5">
                    <p class="text-[12px] text-black">Added <?php echo $time_diff . ' ago'; ?></p>
                    <a href="<?php the_permalink(); ?>" class="w-fit text-sm font-bold text-darkergreen underline">See more</a>
                </div>
            </div>
            <hr class="hidden lg:block">
            <div class="hidden lg:flex lg:flex-row">
                <?php echo $job_description_summary; ?>
            </div>

        </div>

    </div>
    <div class="md:hidden flex flex-row justify-between gap-5">
        <p class="text-[12px] text-black">Added <?php echo $time_diff . ' ago'; ?></p>
        <a href="<?php the_permalink(); ?>" class="w-fit text-sm font-bold text-darkergreen underline">See more</a>
    </div>
</div>