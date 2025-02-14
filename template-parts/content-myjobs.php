<?php
$job_salary = get_post_meta(get_the_ID(), 'job_salary', true);
$job_supplemental_pay = get_post_meta(get_the_ID(), 'job_supplemental_pay', true);
$job_time = get_post_meta(get_the_ID(), 'job_time', true);
$job_shift = get_post_meta(get_the_ID(), 'job_shift', true);
$job_location = get_post_meta(get_the_ID(), 'job_location', true);
$job_start_date = get_post_meta(get_the_ID(), 'job_start_date', true);
$job_publish_date = get_post_meta(get_the_ID(), 'job_publish_date', true);
$job_description_summary = get_post_meta(get_the_ID(), 'job_description_summary', true);
$status = get_post_status();
$current_user = wp_get_current_user();

$user_id = get_current_user_id();

// Retrieve the term ID from the ACF field
$company_term_id = get_field('company_name', 'user_' . $user_id);

if ($company_term_id) {
    // Fetch the term object using the term ID
    $company_term = get_term($company_term_id);

    // Get the term name or set a fallback
    $company_name = $company_term ? $company_term->name : 'Unknown Company';
} else {
    $company_name = 'Unknown Company'; // Fallback for missing term ID
}


$company_logo = get_field('company_logo', 'user_' . get_the_author_meta('ID'));
$publish_timestamp = get_the_time('U + 1');
$time_diff = human_time_diff($publish_timestamp);
?>
<div class="job-post bg-lightergreen flex flex-row gap-5 p-[15px]" data-status="<?php echo esc_attr($status); ?>">
    <div class="flex flex-col gap-3 w-[90px] lg:w-[113px]">
        <?php if ($company_logo) : ?>
            <img class="w-[90px] h-[90px] lg:w-[113px] lg:h-[113px]  rounded-md object-contain bg-white" src="<?php echo esc_url($company_logo); ?>" alt="<?php echo esc_attr(get_the_author_meta('display_name', get_the_author_meta('ID'))); ?>">
        <?php endif; ?>
    </div>
    <div class="flex flex-col w-5/6 gap-3">
        <div class="flex flex-row justify-between">
            <div>
                <h2 class="text-lg text-darkergreen font-bold"><?php the_title(); ?></h2>

                <div class="flex flex-row gap-5 text-black font-bold text-sm">
                    <p class=""><?php echo esc_html($company_name); ?></p>
                    <p class="">£<?php echo format_salary($job_salary); ?></p>
                    <p class=""> <?php echo esc_html($job_time); ?></p>
                </div>
            </div>
            <!-- <div class="flex"> -->
            <?php
            /*
            if ($job_publish_date) {
                // Convert to timestamp if not already
                $timestamp = is_numeric($job_publish_date) ? $job_publish_date : strtotime($job_publish_date);

                // Format the date
                $formatted_date = date('j F Y', $timestamp);
                echo '<p class="text-xl text-black">' . esc_html($formatted_date) . '</p>';
            }
                */
            ?>

            <!-- </div> -->


            <div class="flex flex-col items-end w-1/6 gap-5">
                <?php
                if ($status === 'future') { // Or whatever status you use for scheduled jobs
                    if ($time_diff > 0) {
                        // If still scheduled
                        $scheduled_date = date('j F Y', $job_publish_date);
                        echo "<p class='text-[12px] text-black text-end'>Scheduled for {$scheduled_date}</p>";
                    }
                } else if ($status === 'publish') {
                    // If the job is published
                    echo "<p class='text-[12px] text-black'>Added {$time_diff} ago</p>";
                } ?>
                <a href="<?php echo esc_url(home_url('/edit-jobs/?post_id=' . get_the_ID())); ?>" class="cursor-pointer text-sm font-bold text-darkergreen underline">Edit</a>
            </div>
        </div>

        <hr>
        <div class="flex flex-row">
            <?php echo $job_description_summary; ?>
        </div>
    </div>
</div>