<?php 
     $job_salary = get_post_meta(get_the_ID(), 'job_salary', true);
     $job_supplemental_pay = get_post_meta(get_the_ID(), 'job_supplemental_pay', true);
     $job_time = get_post_meta(get_the_ID(), 'job_time', true);
     $job_shift = get_post_meta(get_the_ID(), 'job_shift', true);
     $job_location = get_post_meta(get_the_ID(), 'job_location', true);
     $job_start_date = get_post_meta(get_the_ID(), 'job_start_date', true);
     $job_publish_date = get_post_meta(get_the_ID(), 'job_publish_date', true);

     $company_logo = get_field('company_logo', 'user_' . get_the_author_meta('ID'));
 ?>
 <div class="job-post flex flex-row" data-status="<?php echo esc_attr($status); ?>">
     <div class="flex flex-col gap-3 w-1/6">
         <?php if ($company_logo) : ?>
         <img class="w-full h-full rounded-md object-contain p-3 bg-white" src="<?php echo esc_url($company_logo); ?>" alt="<?php echo esc_attr(get_the_author_meta('display_name', get_the_author_meta('ID'))); ?>">
         <?php endif; ?>
     </div>
     <div class="flex flex-col bg-white w-5/6 p-3">
         <div>
             <h2 class="text-xl text-black font-bold"><?php the_title(); ?></h2>
             <p class="text-xl text-black"><?php echo esc_html($current_user->company_name); ?></p>
         </div>
         <div class="flex flex-row gap-1">
             <p class="text-xl text-black">£<?php echo format_salary($job_salary); ?></p>
             <p class="text-xl text-black"> - <?php echo esc_html($job_shift); ?></p>
         </div>
         <div class="flex flex-row justify-between">
            <?php
            if ($job_publish_date) {
                // Create a DateTime object from the job publish date
                $date = date('j F Y', $job_publish_date);
                // Format the date
               //  $formatted_date = $date->format('j F Y');
               echo '<p class="text-xl text-black">' . esc_html( $date ) . '</p>';
            }
            ?>
             <a href="<?php echo esc_url(home_url('/edit-jobs/?post_id=' . get_the_ID())); ?>" class="cursor-pointer text-xl text-black border border-black border-1 bg-gray-300 p-2 rounded">Edit</a>
         </div>
     </div>
 </div>