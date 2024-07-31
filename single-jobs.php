<?php get_header();

$author_id = get_post_field('post_author', get_the_ID());


$company_name = get_the_author_meta('company_name', $author_id);
$job_downloads_one = get_post_meta(get_the_ID(), 'job_downloads_one', true);
$job_downloads_two = get_post_meta(get_the_ID(), 'job_downloads_two', true);





function format_salary($salary) {
    return number_format($salary);
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div>
        <div class="flex justify-center items-center h-48" style="background-image:url('https://garyb173.sg-host.com/wp-content/uploads/2024/06/pantiles-exterior-hero.jpg'); background-position: center">
            <h1 class="text-white text-center text-5xl font-semibold max-w-xl">Find your perfect job in Tunbridge Wells</h1>
        </div>
        <div class="flex flex-row">
            <div class="bg-blue-100 w-1/3 flex flex-col justify-start text-center p-5">
                <a href="<?php echo home_url('/jobs/'); ?>" class="text-xl text-black border border-black border-1 bg-gray-300 rounded">See jobs</a>
            </div>
            <div class="bg-blue-50 w-2/3 p-5 flex flex-col gap-5">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-row gap-5 justify-between">
                        <div class="flex flex-col gap-1">
                            <h2 class="text-2xl text-black font-bold"><?php the_title(); ?></h2>
                            <p class="text-lg text-black font-bold"><?php echo $company_name;?></p>
                            <div class="flex flex-row items-center gap-1">
                            <p class="text-lg">£<?php echo format_salary(get_post_meta(get_the_ID(), 'job_salary', true));?></p> -
                                <p class="text-lg"> <?php echo  $job_shift = get_post_meta(get_the_ID(), 'job_shift', true); ?></p>
                            </div>
                        </div>
                        <div>
                            <a href="<?php echo $job_application_link = get_post_meta(get_the_ID(), 'job_application_link', true);?>" class="text-xl text-black border border-black border-1 bg-gray-300 py-1 px-4 rounded">Apply</a>
                        </div>
                        <div>
                            <p class="text-sm text-black"><?php echo 'Added ' . human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?></p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <h2 class="text-xl font-bold">Job details</h2>
                    <div class="flex flex-col">
                    <p class="text-lg text-black"><strong>Pay:</strong> £<?php echo format_salary(get_post_meta(get_the_ID(), 'job_salary', true));?></p>
                        <p class="text-lg text-black"><strong>Job type:</strong> <?php echo $job_time = get_post_meta(get_the_ID(), 'job_time', true);?></p>
                        <p class="text-lg text-black"><strong>Shift and schedule:</strong> <?php echo  $job_shift = get_post_meta(get_the_ID(), 'job_shift', true); ?></p>
                        <p class="text-lg text-black"><strong>Location:</strong></p>
                        <p class="text-lg text-black"><strong>Supplemental pay types:</strong> <?php echo $job_supplemental_pay = get_post_meta(get_the_ID(), 'job_supplemental_pay', true);?></p>
                        <p class="text-lg text-black"><strong>Work location:</strong> <?php echo $job_location = get_post_meta(get_the_ID(), 'job_location', true); ?></p>
                        <?php $job_start_date = get_post_meta(get_the_ID(), 'job_start_date', true);
                        if ($job_start_date) {
                            // Create a DateTime object from the job start date
                            $date = new DateTime($job_start_date);
                            // Format the date
                            $formatted_date = $date->format('j F Y');
                            echo '<p class="text-lg text-black"><strong>Expected start date:</strong> ' . $formatted_date . '</p>';
                        } ?>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <h2 class="text-xl font-bold">Full job description</h2>
                    <div class="flex flex-col text-lg">
                    <?php the_content(); ?>
                    </div>
                </div>

                <div class="flex flex-row gap-1">
                    <h2 class="text-xl font-bold">Job Expiry Date:</h2>
                    <?php $job_end_date = get_post_meta(get_the_ID(), 'job_expiry_date', true);
                        if ($job_end_date) {
                            // Create a DateTime object from the job start date
                            $date = new DateTime($job_end_date);
                            // Format the date
                            $formatted_expiry_date = $date->format('j F Y');
                            echo '<p class="text-lg text-black"> ' . $formatted_expiry_date . '</p>';
                        } ?>

                </div>

                <div class="flex flex-row justify-between align-top">
                    <div>
                        <a href="<?php echo $job_application_link = get_post_meta(get_the_ID(), 'job_application_link', true);?>" class="w-fit text-lg text-black border border-black border-1 bg-gray-300 rounded py-1 px-4">Apply</a>
                    </div>
                    <div class="flex flex-col gap-5">
                        <?php if($job_downloads_one){ ?>
                        <a href="<?php echo $job_downloads_one; ?>" target="_blank" class="w-fit text-lg text-black border border-black border-1 bg-gray-300 rounded py-1 px-4">About employer</a>
                       <?php } 
                       if($job_downloads_two){ ?>
                        <a href="<?php echo $job_downloads_two; ?>" target="_blank" class="w-fit text-lg text-black border border-black border-1 bg-gray-300 rounded py-1 px-4">Job Information</a>
                      <?php  }?>
                    </div>
                </div>

                

                
            </div>

        </div>
    </div>

</article>

<?php get_footer(); ?>