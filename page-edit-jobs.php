<?php get_header();


$post_id = get_the_ID();

$banner_image = get_field('banner_image', 'option');

$user_id = get_current_user_id();

// Retrieve the term ID from the ACF field
$company_term_object = get_field('company_name', 'user_' . $user_id);
$company_term_id = $company_term_object ? $company_term_object->term_id : 0;

$active_users = []; // Initialize $active_users

if ($company_term_id) {
    // Fetch the term object using the term ID
    $company_term = get_term($company_term_id);

    // Get the term name or set a fallback
    $company_name = $company_term ? $company_term->name : 'Unknown Company';
    // Get currently active users for the same company
    // $active_users =  get_active_users_by_company($company_term_id);
} else {
    $company_name = 'Unknown Company'; // Fallback for missing term ID
}




?>


<?php if (is_user_logged_in()) { ?>
    <div class="lg:mt-[50px] px-5 pt-7 pb-10 lg:p-0">
        <!-- <div class="flex items-center h-48" style="background-image:url('<?php echo $banner_image['url']; ?>'); background-position: center">
            <div class="flex flex-col mx-5">
                <h1 class="text-white text-5xl font-semibold">Edit your job: <?php echo esc_html($current_user->company_name); ?></h1>
            </div>
        </div> -->
        <div class="flex flex-col gap-5 lg:gap-0 lg:flex-row">

            <div class="lg:w-1/3 flex flex-col gap-5 justify-start lg:px-8 lg:my-8 lg:border-r-2 border-lightgreen">

                <div class="flex flex-row gap-3 text-black font-bold text-base">
                    <p><span class="first-name"><?php echo $current_user->user_firstname; ?></span> <span class="last-name"><?php echo $current_user->user_lastname; ?></span></p> |
                    <p><?php echo esc_html($company_name); ?></p>
                </div>

                <div class="flex flex-row lg:flex-col gap-3">
                    <div class="flex flex-row lg:flex-col gap-3">
                        <a href="<?php echo esc_url(home_url('/my-jobs/')); ?>" class="text-sm lg:text-base text-black underline">My vacancies</a>
                        <a href="<?php echo esc_url(home_url('/add-jobs/')); ?>" class="text-sm lg:text-base text-darkergreen">Add new vacancy</a>
                    </div>

                    <div class="flex flex-row lg:flex-col gap-3">
                        <a href="<?php echo esc_url(home_url('/profile/')); ?>" class="text-sm lg:text-base text-darkergreen">Profile</a>
                        <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="text-sm lg:text-base text-darkergreen">Logout</a>
                    </div>
                </div>
            </div>

            <div class="lg:w-2/3 lg:p-5">
                <div class="flex flex-col gap-3">
                    <h2 class="font-bold text-2xl">Edit vacancy - <?php echo $company_name; ?></h2>

                    <?php
                    // Check if post_id is set and sanitize it
                    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

                    // Fetch the job post based on post_id
                    $job_post = get_post($post_id);

                    //check if job is locked





                    if ($job_post && $job_post->post_type === 'jobs') :
                        // Prepopulate form fields with existing data
                        $job_salary = get_post_meta($job_post->ID, 'job_salary', true);
                        $job_supplemental_pay = get_post_meta($job_post->ID, 'job_supplemental_pay', true);
                        $job_time = get_post_meta($job_post->ID, 'job_time', true);
                        $job_shift = get_post_meta($job_post->ID, 'job_shift', true);
                        $job_role = get_post_meta($job_post->ID, 'job_role', true);
                        $job_sector = get_post_meta($job_post->ID, 'job_sector', true);
                        $job_workplace_benefits = get_post_meta($job_post->ID, 'job_workplace_benefits', true);
                        $job_location = get_post_meta($job_post->ID, 'job_location', true);
                        $job_downloads_one = get_post_meta($job_post->ID, 'job_downloads_one', true);
                        $job_downloads_two = get_post_meta($job_post->ID, 'job_downloads_two', true);
                        $job_start_date = get_post_meta($job_post->ID, 'job_start_date', true);
                        $job_publish_date = get_post_meta($job_post->ID, 'job_publish_date', true);
                        // if ($job_publish_date) {
                        //     // Create a DateTime object from the job publish date
                        // //     $job_publish_date = strtotime($job_publish_date);
                        // //     $date = date('j F Y', $job_publish_date);
                        // //     // Format the date
                        // //    //  $formatted_date = $date->format('j F Y');
                        //     }
                        if (is_numeric($job_publish_date)) {
                            $job_publish_date = date('Y-m-d', $job_publish_date);
                        }
                        $job_expiry_date = get_post_meta($job_post->ID, 'job_expiry_date', true);
                        $job_application_link = get_post_meta($job_post->ID, 'job_application_link', true);
                        $job_description = get_post_meta($job_post->ID, 'job_description', true);
                        $job_description_summary = get_post_meta($job_post->ID, 'job_description_summary', true);
                        $job_company_name = get_post_meta($job_post->ID, 'job_company_name', true);
                        $volunteering = get_post_meta($job_post->ID, 'volunteering', true);
                    ?>

                        <form class="flex flex-col gap-3" id="job_form_<?php echo esc_attr($job_post->ID); ?>" method="post" enctype="multipart/form-data">



                            <input type="hidden" name="post_id" value="<?php echo esc_attr($job_post->ID); ?>" />
                            <input type="hidden" id="job_company_name" name="job_company_name" value="<?php echo $current_user->company_name; ?>" />
                            <?php wp_nonce_field('custom_job_form_action', 'custom_job_form_nonce'); ?>

                            <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                                <label class="text-base min-w-[130px]" for="volunteering">Voluntary Position?</label>
                                <input type="checkbox" name="volunteering" id="volunteering" value="volunteering" <?php checked($volunteering, 1); ?> />



                            </div>

                            <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                                <label class="text-base min-w-[130px]" for="job_title">Job Title</label>
                                <input class="w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" type="text" id="job_title" name="job_title" placeholder="Retail Store Manager" value="<?php echo esc_attr($job_post->post_title); ?>" required />
                            </div>

                            <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center hiddenfield">
                                <label class="text-base min-w-[130px]" for="job_salary">Salary</label>
                                <input class="w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" type="number" step="1" id="job_salary" name="job_salary" placeholder="£26,000 a year - Full-time" value="<?php echo esc_attr($job_salary); ?>" />
                            </div>


                            <p class="hiddenfield">Enter 0 to show 'unspecified'</p>


                            <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center hiddenfield">
                                <label class="text-base lg:min-w-[130px]" for="job_supplemental_pay">Supplemental Pay</label>
                                <input class="w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" type="text" id="job_supplemental_pay" name="job_supplemental_pay" placeholder="Commission pay" value="<?php echo esc_attr($job_supplemental_pay); ?>" />
                            </div>

                            <div class="flex flex-col items-start gap-3 lg:flex-row lg:gap-1 lg:items-center">
                                <label class="text-base min-w-[150px]" for="job_workplace_benefits[]">Workplace Benefits</label>

                                <div class="flex flex-row gap-4 flex-wrap w-full lg:w-3/4">
                                    <?php
                                    // Ensure $job_post->job_workplace_benefits is an array
                                    $benefits = isset($job_post->job_workplace_benefits) && is_array($job_post->job_workplace_benefits) ? $job_post->job_workplace_benefits : [];
                                    ?>

                                    <div class="flex gap-2 min-w-[130px] items-center">
                                        <input type="checkbox" id="flexible-hours" name="job_workplace_benefits[]" value="Flexible Hours"
                                            <?php echo in_array('Flexible Hours', $benefits) ? 'checked' : ''; ?> />
                                        <label for="flexible-hours">Flexible Hours</label>
                                    </div>

                                    <div class="flex gap-2 min-w-[130px] items-center">
                                        <input type="checkbox" id="free-parking" name="job_workplace_benefits[]" value="Free Parking"
                                            <?php echo in_array('Free Parking', $benefits) ? 'checked' : ''; ?> />
                                        <label for="free-parking">Free Parking</label>
                                    </div>

                                    <div class="flex gap-2 min-w-[130px] items-center">
                                        <input type="checkbox" id="private-healthcare" name="job_workplace_benefits[]" value="Private Healthcare"
                                            <?php echo in_array('Private Healthcare', $benefits) ? 'checked' : ''; ?> />
                                        <label for="private-healthcare">Private Healthcare</label>
                                    </div>

                                    <div class="flex gap-2 min-w-[130px] items-center">
                                        <input type="checkbox" id="additional-memberships" name="job_workplace_benefits[]" value="Additional Memberships"
                                            <?php echo in_array('Additional Memberships', $benefits) ? 'checked' : ''; ?> />
                                        <label for="additional-memberships">Additional Memberships</label>
                                    </div>

                                    <div class="flex gap-2 min-w-[130px] items-center">
                                        <input type="checkbox" id="cycle-to-work" name="job_workplace_benefits[]" value="Cycle To Work"
                                            <?php echo in_array('Cycle To Work', $benefits) ? 'checked' : ''; ?> />
                                        <label for="cycle-to-work">Cycle to Work Scheme</label>
                                    </div>

                                    <div class="flex gap-2 min-w-[130px] items-center">
                                        <input type="checkbox" id="workplace-discounts" name="job_workplace_benefits[]" value="Workplace Discounts"
                                            <?php echo in_array('Workplace Discounts', $benefits) ? 'checked' : ''; ?> />
                                        <label for="workplace-discounts">Workplace Discounts</label>
                                    </div>

                                    <div class="flex gap-2 min-w-[130px] items-center">
                                        <input type="checkbox" id="workplace-discounts" name="job_workplace_benefits[]" value="Expenses Paid"
                                            <?php echo in_array('Expenses Paid', $benefits) ? 'checked' : ''; ?> />
                                        <label for="workplace-discounts">Expenses Paid</label>
                                    </div>
                                </div>
                            </div>


                            <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                                <label class="text-base min-w-[130px]" for="job_role">Job Role</label>
                                <select class="select-custom w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" id="job_role" name="job_role" required>
                                    <option value="Administrative, Finance & HR" <?php selected($job_role, 'Administrative, Finance & HR'); ?>>Administrative, Finance & HR</option>
                                    <option value="Creative and Design" <?php selected($job_role, 'Creative and Design'); ?>>Creative and Design</option>
                                    <option value="Customer Service and Support" <?php selected($job_role, 'Customer Service and Support'); ?>>Customer Service and Support</option>
                                    <option value="Education and Training" <?php selected($job_role, 'Education and Training'); ?>>Education and Training</option>
                                    <option value="Healthcare and Medical" <?php selected($job_role, 'Healthcare and Medical'); ?>>Healthcare and Medical</option>
                                    <option value="Management and Leadership" <?php selected($job_role, 'Management and Leadership'); ?>>Management and Leadership</option>
                                    <option value="Sales and Marketing" <?php selected($job_role, 'Sales and Marketing'); ?>>Sales and Marketing</option>
                                    <option value="Skilled Trades and Labour" <?php selected($job_role, 'Skilled Trades and Labour'); ?>>Skilled Trades and Labour</option>
                                    <option value="Technical and Operations" <?php selected($job_role, 'Technical and Operations'); ?>>Technical and Operations</option>
                                    <option value="Other" <?php selected($job_role, 'Other'); ?>>Other</option>
                                </select>
                            </div>

                            <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                                <label class="text-base min-w-[130px]" for="job_time">Sector</label>
                                <select class="select-custom w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" id="job_sector" name="job_sector" required>
                                    <option value="Advertising, Creative and Culture" <?php selected($job_role, 'Advertising, Creative and Culture'); ?>>Advertising, Creative and Culture</option>
                                    <option value="Charities" <?php selected($job_role, 'Charities'); ?>>Charities</option>
                                    <option value="Construction and Real Estate" <?php selected($job_role, 'Construction and Real Estate'); ?>>Construction and Real Estate</option>
                                    <option value="Education and Training" <?php selected($job_role, 'Advertising, Creative and Culture'); ?>>Education and Training</option>
                                    <option value="Government and Public Administration" <?php selected($job_role, 'Government and Public Administration'); ?>>Government and Public Administration</option>
                                    <option value="Healthcare, Beauty and Social Assistance" <?php selected($job_role, 'Healthcare, Beauty and Social Assistance'); ?>>Healthcare, Beauty and Social Assistance</option>
                                    <option value="Techonology Information Technology and Telecommunications" <?php selected($job_role, 'Techonology Information Technology and Telecommunications'); ?>>Information Technology and Telecommunications</option>
                                    <option value="Legal, Finance and Insurance" <?php selected($job_role, 'Legal, Finance and Insurance'); ?>>Legal, Finance and Insurance</option>
                                    <option value="Retail, Hospitality and Food Services" <?php selected($job_role, 'Retail, Hospitality and Food Servicese'); ?>>Retail, Hospitality and Food Services</option>
                                    <option value="Transportation and Logistics" <?php selected($job_role, 'Transportation and Logistics'); ?>>Transportation and Logistics</option>
                                    <option value="Other" <?php selected($job_role, 'Other'); ?>>Other</option>
                                </select>


                            </div>

                            <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                                <label class="text-base min-w-[130px]" for="job_time">Full or Part time</label>
                                <select class="select-custom w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" id="job_time" name="job_time" required>
                                    <option value="Full-time" <?php selected($job_time, 'Full-time'); ?>>Full-time</option>
                                    <option value="Part-time" <?php selected($job_time, 'Part-time'); ?>>Part-time</option>
                                </select>
                            </div>

                            <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                                <label class="text-base min-w-[130px]" for="job_shift">Shift/schedule</label>
                                <select class="select-custom w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" id="job_shift" name="job_shift" required>
                                    <option value="Day shift" <?php selected($job_shift, 'Day shift'); ?>>Day shift</option>
                                    <option value="Night shift" <?php selected($job_shift, 'Night shift'); ?>>Night shift</option>
                                    <option value="Weekend shift <?php selected($job_shift, 'Weekend shift'); ?>">Weekend shift</option>
                                    <option value="Rotating shift" <?php selected($job_shift, 'Rotating shift'); ?>>Rotating shift</option>
                                    <option value="On call" <?php selected($job_shift, 'On call'); ?>>On call</option>
                                </select>
                            </div>

                            <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                                <label class="text-base min-w-[130px]" for="job_location">Work Location</label>
                                <select class="select-custom w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" type="text" id="job_location" name="job_location" placeholder="In person" value="<?php echo esc_attr($job_location); ?>" required>
                                    <option value="In person" <?php selected($job_location, 'In person'); ?>>In person</option>
                                    <option value="Hybrid" <?php selected($job_location, 'Hybrid'); ?>>Hybrid</option>
                                    <option value="Remote" <?php selected($job_location, 'Remote'); ?>>Remote</option>
                                </select>
                            </div>

                            <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                                <label class="text-base min-w-[130px]" for="job_start_date">Start Date</label>
                                <input class="w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" type="date" id="job_start_date" name="job_start_date" value="<?php echo esc_attr($job_start_date); ?>" />
                            </div>

                            <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                                <label class="text-base min-w-[130px]" for="job_application_link">Link to application</label>
                                <input class="w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" type="url" id="job_application_link" name="job_application_link" placeholder="https://uk.indeed.com/viewjob" value="<?php echo esc_url($job_application_link); ?>" />
                            </div>

                            <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 ">
                                <label class="text-base min-w-[130px]" for="job_description_summary">Job summary</label>
                                <textarea
                                    class="w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3"
                                    id="job_description_summary"
                                    name="job_description_summary"
                                    placeholder="Add a summary here (max 40 words)"
                                    required
                                    oninput="limitWords(this, 40)"
                                    rows="4"><?php echo esc_attr($job_description_summary); ?>
                                </textarea>
                            </div>


                            <div class="flex flex-col mt-8">
                                <label class="text-base font-semibold" for="job_description">Full Job Description</label>
                                <?php
                                wp_editor(
                                    $job_description,
                                    'job_description',
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

                            <div class="flex flex-col gap-2 mt-8">
                                <p class="text-base font-bold">Downloads</p>
                                <div class="flex flex-col gap-3">
                                    <div class="flex flex-col lg:flex-row gap-5">
                                        <label class="text-base md:w-[300px]" for="job_downloads_one ">About your company</label>
                                        <input class="" type="file" id="job_downloads_one" name="job_downloads_one" />
                                        <?php if ($job_downloads_one) : ?>
                                            <p>Current File: <a href="<?php echo esc_url($job_downloads_one); ?>" class="text-darkergreen" target="_blank"><?php echo basename($job_downloads_one); ?></a></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex flex-col lg:flex-row gap-5">
                                        <label class="text-base md:w-[300px]" for="job_downloads_two ">Extra information about the vacancy</label>
                                        <input class="" type="file" id="job_downloads_two" name="job_downloads_two" />
                                        <?php if ($job_downloads_two) : ?>
                                            <p>Current File: <a href="<?php echo esc_url($job_downloads_two); ?>" class="text-darkergreen" target="_blank"><?php echo basename($job_downloads_two); ?></a></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col mt-4 lg:mt-8 gap-2">
                                <p class="text-base font-bold">Publish settings</p>

                                <div class="flex flex-row gap-3 lg:gap-5 items-center">
                                    <label class="text-base min-w-[100px]" for="job_publish_date">Publish Date</label>
                                    <input class="w-3/4 bg-lightergreen rounded px-5 py-3" type="date" id="job_publish_date_edit" name="job_publish_date" value="<?php echo esc_html($job_publish_date); ?>" />
                                </div>

                                <div class="flex flex-row gap-3 lg:gap-5 items-center">
                                    <label class="text-base min-w-[100px]" for="job_expiry_date">Expiry Date</label>
                                    <input class="w-3/4 bg-lightergreen rounded px-5 py-3" type="date" id="job_expiry_date" name="job_expiry_date" value="<?php echo esc_attr($job_expiry_date); ?>" />
                                </div>
                                <p>For job roles which are continually hiring you can leave this field blank </p>
                            </div>

                            <div class="flex flex-col justify-start mt-6 lg:mt-8 gap-6 lg:gap-3">
                                <div class="flex flex-row">
                                    <label class="text-xl" for="job_status"></label>
                                    <div id="cont_job_published" class="flex flex-row gap-2 mr-8">
                                        <input type="radio" id="job_published" name="job_status" class="cursor-pointer" value="publish" <?php checked($job_post->post_status, 'publish'); ?>>
                                        <label for="job_published">Publish</label>
                                    </div>

                                    <div id="cont_job_future" class="flex flex-row gap-2 mr-8 hidden">
                                        <input type="radio" id="job_future" name="job_status" class="cursor-pointer" value="future" <?php checked($job_post->post_status, 'future'); ?>>
                                        <label for="job_future">Schedule</label>
                                    </div>

                                    <div class="flex flex-row gap-2 mr-8 ">
                                        <input type="radio" id="job_draft" name="job_status" class="cursor-pointer" value="draft" <?php checked($job_post->post_status, 'draft'); ?>>
                                        <label for="job_draft">Draft</label>
                                    </div>
                                    <div class="flex flex-row gap-2 mr-8 ">
                                        <input type="radio" id="job_archive" name="job_status" class="cursor-pointer" value="archive" <?php checked($job_post->post_status, 'archive'); ?>>
                                        <label for="job_archive">Archive</label>
                                    </div>


                                </div>


                                <input id="job_update" class="w-fit cursor-pointer border-2 border-darkergreen text-darkergreen py-2 px-10 rounded-full" type="submit" value="Update" />

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
    <p>You must be logged in to access this page. </p>
<?php } ?>



<?php get_footer(); ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let publishDateField = document.getElementById("job_publish_date_edit");
        let publishButton = document.getElementById("cont_job_published");
        let futureButton = document.getElementById("cont_job_future");
        let submitButton = document.getElementById("job_update");
        let formActionInput = document.getElementById("job_status");

        function updateButtonValuee() {
            let publishDateInput = publishDateField.value; // Use dynamic value
            let editPublishDate = new Date(publishDateInput);
            let now = new Date();

            //use gmt here


            console.log(publishDateInput);
            console.log(now);

            console.log("Publish Date:", publishDateInput, "Now:", now);

            if (!isNaN(editPublishDate) && editPublishDate > now) {
                futureButton.classList.remove("hidden");
                futureButton.classList.add("block");
                publishButton.classList.add("hidden");
            }
            if (!isNaN(editPublishDate) && editPublishDate <= now) {
                publishButton.classList.remove("hidden");
                publishButton.classList.add("block");
                futureButton.classList.add("hidden");
            }

            console.log(editPublishDate);
        }

        // Listen for input changes dynamically
        publishDateField.addEventListener("input", updateButtonValuee);

        // submitButton.addEventListener('click', function() {
        //     let publishDateInput = publishDateField.value;  // Use dynamic value
        //     let publishDate = new Date(publishDateInput);
        //     let now = new Date();

        //     console.log("Submit Button Clicked:", publishDate);

        //     if (!isNaN(publishDate) && publishDate > now) {
        //         formActionInput.value = "future";

        //     } else {
        //         formActionInput.value = "publish";
        //     }

        //     console.log("Form Action:", formActionInput.value);
        // });
    });

    function limitWords(input, maxWords) {
        const words = input.value.split(/\s+/).filter((word) => word.length > 0);

        if (words.length > maxWords) {
            input.value = words.slice(0, maxWords).join(" ") + " ";

        }
    }
</script>