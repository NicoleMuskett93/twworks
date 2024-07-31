<?php get_header();

$banner_image = get_field('banner_image', 'option');

?>

<?php if (is_user_logged_in()) { ?>
    <div>
        <div class="flex items-center h-48" style="background-image:url('<?php echo $banner_image['url'];?>'); background-position: center">
            <div class="flex flex-col mx-5">
                <h1 class="text-white text-5xl font-semibold">Edit your job: <?php echo esc_html($current_user->company_name); ?></h1>
            </div>
        </div>
        <div class="flex flex-row">
            <div class="bg-blue-100 w-1/3 flex flex-col justify-start text-center p-5">
                <a href="<?php echo esc_url(home_url('/jobs/')); ?>" class="text-xl text-black border border-black border-1 bg-gray-300 rounded">Back to jobs list</a>
            </div>
            <div class="bg-blue-50 w-2/3 p-5">
                <div class="flex flex-col gap-3">
                    <h2 class="font-bold text-2xl"><?php echo $current_user->company_name;?></h2>

                    <?php
                    // Check if post_id is set and sanitize it
                    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

                    // Fetch the job post based on post_id
                    $job_post = get_post($post_id);

                    if ($job_post && $job_post->post_type === 'jobs' && $job_post->post_author == get_current_user_id()) :
                        // Prepopulate form fields with existing data
                        $job_salary = get_post_meta($job_post->ID, 'job_salary', true);
                        $job_supplemental_pay = get_post_meta($job_post->ID, 'job_supplemental_pay', true);
                        $job_time = get_post_meta($job_post->ID, 'job_time', true);
                        $job_shift = get_post_meta($job_post->ID, 'job_shift', true);
                        $job_location = get_post_meta($job_post->ID, 'job_location', true);
                        $job_downloads_one = get_post_meta($job_post->ID, 'job_downloads_one', true);
                        $job_downloads_two = get_post_meta($job_post->ID, 'job_downloads_two', true);
                        $job_start_date = get_post_meta($job_post->ID, 'job_start_date', true);
                        $job_publish_date = get_post_meta($job_post->ID, 'job_publish_date', true);
                        $job_expiry_date = get_post_meta($job_post->ID, 'job_expiry_date', true);
                        $job_application_link = get_post_meta($job_post->ID, 'job_application_link', true);
                        ?>

                        <form class="flex flex-col gap-3" id="job_form_<?php echo esc_attr($job_post->ID); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="post_id" value="<?php echo esc_attr($job_post->ID); ?>" />
                            <?php wp_nonce_field('custom_job_form_action', 'custom_job_form_nonce'); ?>

                            <div class="flex flex-row gap-10 items-center">
                                <label class="text-xl" for="job_title">Job Title</label>
                                <input class="w-1/2 border border-black border-1 rounded p-2" type="text" id="job_title" name="job_title" placeholder="Retail Store Manager" value="<?php echo esc_attr($job_post->post_title); ?>" required />
                            </div>

                            <div class="flex flex-row gap-10 items-center">
                                <label class="text-xl" for="job_salary">Salary</label>
                                <input class="w-1/2 border border-black border-1 rounded p-2" type="number" id="job_salary" name="job_salary" placeholder="£26,000 a year - Full-time" value="<?php echo esc_attr($job_salary); ?>" required />
                            </div>

                            <div class="flex flex-row gap-10 items-center">
                                <label class="text-xl" for="job_supplemental_pay">Supplemental Pay</label>
                                <input class="w-1/2 border border-black border-1 rounded p-2" type="text" id="job_supplemental_pay" name="job_supplemental_pay" placeholder="Commission pay" value="<?php echo esc_attr($job_supplemental_pay); ?>" required />
                            </div>

                            <div class="flex flex-row gap-10 items-center">
                                <label class="text-xl" for="job_time">Full or Part time</label>
                                <select class="w-1/2 border border-black border-1 rounded p-2" id="job_time" name="job_time" required>
                                    <option value="Full-time" <?php selected($job_time, 'Full-time'); ?>>Full-time</option>
                                    <option value="Part-time" <?php selected($job_time, 'Part-time'); ?>>Part-time</option>
                                </select>
                            </div>

                            <div class="flex flex-row gap-10 items-center">
                                <label class="text-xl" for="job_shift">Shift/schedule</label>
                                <input class="w-1/2 border border-black border-1 rounded p-2" type="text" id="job_shift" name="job_shift" placeholder="Weekend availability, Monday to Friday" value="<?php echo esc_attr($job_shift); ?>" required />
                            </div>

                            <div class="flex flex-row gap-10 items-center">
                                <label class="text-xl" for="job_location">Work Location</label>
                                <select class="w-1/2 border border-black border-1 rounded p-2" type="text" id="job_location" name="job_location" placeholder="In person" value="<?php echo esc_attr($job_location); ?>" required >
                                    <option value="In person" <?php selected($job_location, 'In person'); ?>>In person</option>
                                    <option value="Hybrid" <?php selected($job_location, 'Hybrid'); ?>>Hybrid</option>
                                    <option value="Remote" <?php selected($job_location, 'Remote'); ?>>Remote</option>
                                </select>
                            </div>

                            <div class="flex flex-row gap-10 items-center">
                                <label class="text-xl" for="job_start_date">Start Date</label>
                                <input class="w-1/2 border border-black border-1 rounded p-2" type="date" id="job_start_date" name="job_start_date" value="<?php echo esc_attr($job_start_date); ?>" />
                            </div>

                            <div class="flex flex-col">
                                <label class="text-xl font-semibold" for="job_description">Full Job Description</label>
                                <?php 
                                    wp_editor(
                                        esc_textarea($job_post->post_content), // Populate with the actual post content
                                        'job_description', // Editor ID
                                        array(
                                            'wpautop' => true,
                                            'media_buttons' => true,
                                            'textarea_name' => 'job_description',
                                            'textarea_rows' => 10,
                                            'teeny' => false,
                                            'quicktags' => true,
                                            'drag_drop_upload' => true,
                                            'tinymce' => array(
                                                'toolbar1' => 'bold italic underline | bullist numlist | link unlink | undo redo',
                                                'block_formats' => 'Paragraph=p; Header 1=h1; Header 2=h2; Header 3=h3',
                                            ),
                                        )
                                    ); 
                                ?>
                            </div>

                            <div class="flex flex-col gap-2">
                            <p class="text-xl">Downloads</p>
                            <div class="flex flex-col gap-3">
                                <div class="flex flex-row gap-2">
                                <label class="text-lg" for="job_downloads_one ">About your company</label>
                                <input class="" type="file" id="job_downloads_one" name="job_downloads_one" />
                                <?php if ($job_downloads_one) : ?>
                                    <p>Current File: <a href="<?php echo esc_url($job_downloads_one); ?>" target="_blank"><?php echo basename($job_downloads_one); ?></a></p>
                                <?php endif; ?>
                                </div>
                                <div class="flex flex-row gap-2">
                                <label class="text-lg" for="job_downloads_two ">Extra job information</label>
                                <input class="" type="file" id="job_downloads_two" name="job_downloads_two" />
                                <?php if ($job_downloads_two) : ?>
                                    <p>Current File: <a href="<?php echo esc_url($job_downloads_two); ?>" target="_blank"><?php echo basename($job_downloads_two); ?></a></p>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>


                            <div class="flex flex-row gap-10 items-center">
                                <label class="text-xl" for="job_application_link">Application Link</label>
                                <input class="w-1/2 border border-black border-1 rounded p-2" type="url" id="job_application_link" name="job_application_link" placeholder="https://uk.indeed.com/viewjob" value="<?php echo esc_url($job_application_link); ?>" />
                            </div>

                            <div class="flex flex-row gap-10 items-center">
                                <label class="text-xl" for="job_publish_date">Publish Date</label>
                                <input class="w-1/2 border border-black border-1 rounded p-2" type="date" id="job_publish_date" name="job_publish_date" value="<?php echo esc_attr($job_publish_date); ?>" />
                            </div>

                            <div class="flex flex-row gap-10 items-center">
                                <label class="text-xl" for="job_expiry_date">Expiry Date</label>
                                <input class="w-1/2 border border-black border-1 rounded p-2" type="date" id="job_expiry_date" name="job_expiry_date" value="<?php echo esc_attr($job_expiry_date); ?>" />
                            </div>

                            <div class="flex flex-row justify-start items-center gap-10">
                                <div class="flex flex-row gap-2">
                                    <label class="text-xl" for="job_status"></label>
                                    <div class="flex flex-row gap-2">
                                        <input type="radio" id="job_published" name="job_status" class="cursor-pointer" value="publish" <?php checked($job_post->post_status, 'publish'); ?>>
                                        <label for="job_published">Published</label>
                                    </div>
                                    <div class="flex flex-row gap-2">
                                        <input type="radio" id="job_draft" name="job_status" class="cursor-pointer" value="draft" <?php checked($job_post->post_status, 'draft'); ?>>
                                        <label for="job_draft">Draft</label>
                                    </div>
                                    <div class="flex flex-row gap-2">
                                        <input type="radio" id="job_archive" name="job_status" class="cursor-pointer" value="archive" <?php checked($job_post->post_status, 'archive'); ?>>
                                        <label for="job_archive">Archive</label>
                                    </div>
                                </div>

                                <div class="flex flex-row gap-10">
                                    <input class="cursor-pointer border border-1 border-black bg-gray-300 py-2 px-10 rounded" type="submit" value="Update" />
                                </div>
                            </div>
                        </form>

                    <?php else : ?>
                        <p>No job found or you do not have permission to edit this job.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php } else { ?>
    <p class="notice notice-error">Please log in to edit jobs.</p>
<?php } ?>

<?php get_footer(); ?>
