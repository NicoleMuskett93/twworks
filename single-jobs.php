<?php get_header(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div>
        <div class="flex justify-center items-center h-48" style="background-image:url('https://garyb173.sg-host.com/wp-content/uploads/2024/06/pantiles-exterior-hero.jpg'); background-position: center">
            <h1 class="text-white text-center text-5xl font-semibold max-w-xl">Find your perfect job in Tunbridge Wells</h1>
        </div>
        <div class="flex flex-row">
            <div class="bg-blue-100 w-1/3 flex flex-col justify-start text-center p-5">
                <a href="<?php echo home_url('/jobs/'); ?>" class="text-xl text-black border border-black border-1 bg-gray-300 rounded">See jobs</a>
            </div>
            <div class="bg-blue-50 w-2/3 p-5">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-row gap-5 justify-between">
                        <div class="flex flex-col">
                            <h2 class="text-xl text-black font-bold"><?php the_title(); ?></h2>
                            <p class="text-lg text-black font-bold">Company Name</p>
                            <div class="flex flex-row">
                                <p><?php echo $job_salary; ?></p>
                                <p><?php echo $job_shift; ?></p>
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
                        <p class="text-lg text-black"><strong>Pay:</strong> <?php echo $job_salary = get_post_meta(get_the_ID(), 'job_salary', true);?></p>
                        <p class="text-lg text-black"><strong>Job type:</strong> <?php echo $job_time = get_post_meta(get_the_ID(), 'job_time', true);?></p>
                        <p class="text-lg text-black"><strong>Shift and schedule:</strong> <?php echo  $job_shift = get_post_meta(get_the_ID(), 'job_shift', true); ?></p>
                        <p class="text-lg text-black"><strong>Location:</strong></p>
                        <p class="text-lg text-black"><strong>Supplemental pay types:</strong> <?php echo $job_supplemental_pay = get_post_meta(get_the_ID(), 'job_supplemental_pay', true);?></p>
                        <p class="text-lg text-black"><strong>Work location:</strong> <?php echo $job_location = get_post_meta(get_the_ID(), 'job_location', true); ?></p>
                        <p class="text-lg text-black"><strong>Expected start date:</strong> <?php echo $job_start_date = get_post_meta(get_the_ID(), 'job_start_date', true);?></p>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <h2 class="text-xl font-bold">Full job description</h2>
                    <div class="flex flex-col">
                        <p class="text-lg text-black"><?php the_content(); ?></p>
                    </div>
                </div>

                <div>
                    <a href="<?php echo $job_application_link = get_post_meta(get_the_ID(), 'job_application_link', true);?>" class="w-fit text-lg text-black border border-black border-1 bg-gray-300 rounded py-1 px-4">Apply</a>
                </div>
            </div>
        </div>
    </div>

</article>

<?php get_footer(); ?>
