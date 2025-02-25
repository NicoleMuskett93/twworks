<?php get_header();

$author_id = get_post_field('post_author', get_the_ID());
$company_term_id = get_field('company_name', 'user_' . get_the_author_meta('ID'));

if ($company_term_id) {
    $company_term = get_term($company_term_id); // Fetch term object
    $company_name = $company_term ? $company_term->name : 'Unknown Company'; // Get the name from the term object
} else {
    $company_name = 'Unknown Company'; // Fallback if term ID is not found
}

if (has_term('volunteering', 'post_tag', get_the_ID())) {
    $pageurl = home_url('/volunteering');
} else {
    $pageurl = home_url('/jobs');
}



// $company_name = get_the_author_meta('company_name', $author_id);
$job_downloads_one = get_post_meta(get_the_ID(), 'job_downloads_one', true);
$job_downloads_two = get_post_meta(get_the_ID(), 'job_downloads_two', true);
$job_salary = get_post_meta(get_the_ID(), 'job_salary', true);


$publish_timestamp = get_the_time('U + 1');
$time_diff = human_time_diff($publish_timestamp);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="lg:mt-[50px]">
        <!-- <div class="flex justify-center items-center h-48" style="background-image:url('https://tunbridgewells.works/wp-content/uploads/2024/06/pantiles-exterior-hero.jpg'); background-position: center">
            <h1 class="text-white text-center text-5xl font-semibold max-w-xl">Find your perfect job in Tunbridge Wells</h1>
        </div> -->
        <div class="flex flex-col lg:flex-row">
            <div class="hidden lg:w-1/3 lg:flex flex-col items-start px-8 my-8 border-r-[1px] border-darkergreen">
                <a href="<?php echo esc_url($pageurl); ?>" class="w-fit but text-center text-base text-darkergreen border-darkergreen border-2 hover:bg-darkergreen hover:text-white px-10 p-2 rounded-full">
                    Back to <?php echo has_term('volunteering', 'post_tag') ? 'Volunteering' : 'Jobs'; ?>
                </a>
                <div class="">
                    <img src="https://tunbridgewells.works/wp-content/uploads/2024/10/ad.png" alt="Ad" class="pt-[50px] pb-[10px]">
                    <div class="flex flex-row gap-[10px]">
                        <a href="https://apps.apple.com/gb/app/rtw-lovelocal/id6695746434">
                            <img src="https://tunbridgewells.works/wp-content/uploads/2024/10/App-Store.svg" alt="app-store">
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.loqiva.tunbridgewells">
                            <img src="https://tunbridgewells.works/wp-content/uploads/2024/10/Google-Play.svg" alt="google-play">
                        </a>
                    </div>
                </div>
            </div>
            <div class="lg:w-2/3 p-5 lg:p-8 flex flex-col gap-10 lg:gap-[50px]">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-row gap-5 justify-between">
                        <div class="flex flex-col gap-5 w-full">
                            <div>
                                <h2 class="text-2xl text-black font-bold"><?php the_title(); ?></h2>
                                <p class="text-2xl text-black font-bold" id="job_company_name"><?php echo $company_name; ?></p>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex flex-row items-center">
                                  
                                       
                                    <?php if($job_salary): ?>
                                        <p class="text-lg font-bold unspecified">
                                            £<?php echo format_salary($job_salary); ?> &nbsp;
                                        </p>
                                    <?php else: ?>
                                        <p class="text-lg font-bold unspecified">
                                            Unspecified &nbsp;
                                        </p>
                                    <?php endif; ?>

                                    <p class="text-lg font-bold"> <?php echo  $job_shift = get_post_meta(get_the_ID(), 'job_time', true); ?></p>
                                </div>
                                <div>
                                    <p class="text-[12px] text-black"><?php echo 'Added ' . $time_diff . ' ago'; ?></p>
                                </div>

                            </div>

                            <a href="<?php echo $job_application_link = get_post_meta(get_the_ID(), 'job_application_link', true); ?>" class="w-fit text-base but text-darkergreen text-center border-darkergreen hover:bg-darkergreen hover:text-white border-2 px-10 py-2 rounded-full">Apply</a>
                        </div>
                        <div class="flex flex-row-reverse w-[30%]">
                            <div class="lg:w-36 lg:h-36 lg:p-2">
                                <?php
                                // Retrieve the company logo for the author
                                $company_logo_id = get_user_meta($author_id, 'company_logo', true);
                                echo wp_get_attachment_image($company_logo_id, 'full');
                                ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex flex-col gap-5">
                    <h2 class="text-2xl font-bold">Job details</h2>
                    <div class="flex flex-col gap-1">
                        
                        <?php if ($job_salary) : ?>
                            <p class="text-base text-black flex flex-row gap-1"><strong class="min-w-[180px]">Pay:</strong>£<?php echo format_salary(get_post_meta(get_the_ID(), 'job_salary', true)); ?></p>
                            
                            <?php else : ?>
                            <p class="text-base text-black flex flex-row gap-1 unspecified"><strong class="min-w-[180px]">Pay:</strong>Unspecified</p>
                        <?php endif; ?>
                       

                        <p class="text-base text-black flex flex-row gap-1"><strong class="min-w-[180px]">Contract type:</strong> <?php echo $job_time = get_post_meta(get_the_ID(), 'job_time', true); ?></p>
                        <p class="text-base text-black flex flex-row gap-1"><strong class="min-w-[180px]">Shift and schedule:</strong> <?php echo  $job_shift = get_post_meta(get_the_ID(), 'job_shift', true); ?></p>
                        <p class="text-base text-black flex flex-row gap-1 unspecified"><strong class="min-w-[180px]">Supplemental pay types:</strong> <?php echo $job_supplemental_pay = get_post_meta(get_the_ID(), 'job_supplemental_pay', true); ?></p>

                        <p class="text-base text-black flex flex-row gap-1">
                            <strong class="min-w-[180px]">Workplace Benefits:</strong>
                            <?php
                            $job_workplace_benefits = get_post_meta(get_the_ID(), 'job_workplace_benefits', true);

                            if (is_array($job_workplace_benefits)) {
                                // Convert the array to a comma-separated string
                                echo implode(', ', $job_workplace_benefits);
                            }
                            ?>
                        </p>


                        <p class="text-base text-black flex flex-row gap-1"><strong class="min-w-[180px]">Sector:</strong> <?php echo $job_sector = get_post_meta(get_the_ID(), 'job_sector', true); ?></p>
                        <p class="text-base text-black flex flex-row gap-1"><strong class="min-w-[180px]">Job Role:</strong>
                         <?php $job_role = get_post_meta(get_the_ID(), 'job_role', true); 
                         if (is_array($job_role)) {
                                // Convert the array to a comma-separated string
                                echo implode(', ', $job_role);
                            } ?>
                    
                    </p>
                        <p class="text-base text-black flex flex-row gap-1"><strong class="min-w-[180px]">Workplace:</strong> <?php echo $job_location = get_post_meta(get_the_ID(), 'job_location', true); ?></p>
                        <?php $job_start_date = get_post_meta(get_the_ID(), 'job_start_date', true);
                        if ($job_start_date) {
                            // Create a DateTime object from the job start date
                            $date = new DateTime($job_start_date);
                            // Format the date
                            $formatted_date = $date->format('j F Y');
                            echo '<p class="text-base text-black flex flex-row gap-1"><strong class="min-w-[180px]">Expected start date:</strong> ' . $formatted_date . '</p>';
                        } ?>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <h2 class="text-2xl font-bold">Full job description</h2>
                    <div class="flex flex-col gap-5 text-base">
                        <?php the_content(); ?>
                    </div>
                </div>

                <div class="flex flex-row justify-between lg:justify-start gap-1">
                    <h2 class="text-base font-bold min-w-[180px]">Vacancy Expiry Date:</h2>
                    <?php $job_end_date = get_post_meta(get_the_ID(), 'job_expiry_date', true);
                    if ($job_end_date) {
                        // Create a DateTime object from the job start date
                        $date = new DateTime($job_end_date);
                        // Format the date
                        $formatted_expiry_date = $date->format('j F Y');
                        echo '<p class="text-base text-black"> ' . $formatted_expiry_date . '</p>';
                    } ?>

                </div>

                <div class="flex flex-col gap-3">

                    <a href="<?php echo $job_application_link = get_post_meta(get_the_ID(), 'job_application_link', true); ?>" class="w-fit text-base text-center but text-darkergreen border-darkergreen hover:bg-darkergreen hover:text-white border-2 px-10 py-2 rounded-full">Apply</a>
                    <?php if ($job_downloads_one) { ?>
                        <a href="<?php echo $job_downloads_one; ?>" target="_blank" class="text-base text-darkergreen but hover:underline hover:text-darkergreen w-fit">About employer</a>
                    <?php }
                    if ($job_downloads_two) { ?>
                        <a href="<?php echo $job_downloads_two; ?>" target="_blank" class="text-base text-darkergreen but hover:underline hover:text-darkergreen w-fit">Extra job information</a>
                    <?php  } ?>


                </div>




            </div>

        </div>
    </div>
    <div class="p-5 lg:hidden">
        <img src="https://tunbridgewells.works/wp-content/uploads/2024/10/ad.png" alt="Ad" class="pt-[10px] pb-[10px]">
        <div class="flex flex-row gap-[10px]">
            <a href="https://apps.apple.com/gb/app/rtw-lovelocal/id6695746434">
                <img src="https://tunbridgewells.works/wp-content/uploads/2024/10/App-Store.svg" alt="app-store">
            </a>
            <a href="https://play.google.com/store/apps/details?id=com.loqiva.tunbridgewells">
                <img src="https://tunbridgewells.works/wp-content/uploads/2024/10/Google-Play.svg" alt="google-play">
            </a>
        </div>
    </div>

</article>

<?php get_footer(); ?>