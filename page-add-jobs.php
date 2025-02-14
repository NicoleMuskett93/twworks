<?php get_header();

$banner_image = get_field('banner_image', 'option');

// Get the current user's ID
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

// Debugging
// var_dump($company_term_id->name); // Should return the term ID
// var_dump($company_term);    // Should return the term object
// var_dump($company_name);    // Should return the term name
?>



<?php if (is_user_logged_in()) {
?>
    <div class="lg:mt-[50px] px-5 pt-7 pb-10 lg:p-0">
        <!-- <div class="flex items-center h-48" style="background-image:url('<?php echo $banner_image['url']; ?>'); background-position: center">
            <div class="flex flex-col mx-5">
                <h1 class="text-white text-5xl font-semibold">Add a job: <?php echo $company_name; ?> </h1>
            </div>
        </div> -->
        <div class="flex flex-col gap-5 lg:gap-0 lg:flex-row">
            <div class="lg:w-1/3 flex flex-col gap-5 lg:px-8 lg:my-8 lg:border-r-2 border-lightgreen activelinks">

                <div class="flex flex-row gap-3 text-black text-base font-bold">
                    <p><span class="first-name"><?php echo $current_user->user_firstname; ?></span> <span class="last-name"><?php echo $current_user->user_lastname; ?></span></p> |
                    <p><?php echo esc_html($company_name); ?></p>
                </div>

                <div class="flex flex-row lg:flex-col gap-3">
                    <div class="flex flex-row lg:flex-col gap-3 ">
                        <a href="<?php echo esc_url(home_url('/my-jobs/')); ?>" class="myjobs text-sm lg:text-base text-darkergreen active:text-black focus:text-black hover:underline ">My vacancies</a>
                        <a href="<?php echo esc_url(home_url('/add-jobs/')); ?>" class="newjobs text-sm lg:text-base text-darkergreen active:text-black hover:underline ">Add new vacancy</a>
                    </div>

                    <div class="flex flex-row lg:flex-col gap-3">
                        <a href="<?php echo esc_url(home_url('/profile/')); ?>" class="profile text-sm lg:text-base text-darkergreen active:text-black hover:underline ">Profile</a>
                        <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="text-sm lg:text-base text-darkergreen hover:text-black hover:underline ">Logout</a>
                    </div>
                </div>
            </div>

            <div class="lg:w-2/3 lg:p-5">
                <div class="flex flex-col gap-3">
                    <h2 class="font-bold text-2xl">New vacancy - <?php echo $company_name; ?></h2>
                    <form class="flex flex-col gap-3" id="job_form" action="" method="post" enctype="multipart/form-data">

                        <!-- add volunteering tag -->

                        <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                            <label class="text-base min-w-[130px]" for="volunteering">Voluntary Position?</label>
                            <input type="checkbox" name="volunteering" value="volunteering" id="volunteering" />
                        </div>

                        <input type="hidden" id="job_company_name" name="job_company_name" value="<?php echo $company_name; ?>" />
                        <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                            <label class="text-base min-w-[130px]" for="job_title">Job Title</label>
                            <input class="w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" type="text" id="job_title" name="job_title" placeholder="e.g. Retail Store Manager" required />
                        </div>

                        <div id="salary_band" class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center hiddenfield">
                            <label class="text-base min-w-[130px]" for="job_salary">Salary</label>
                            <input class="w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" type="number" step="1" id="job_salary" name="job_salary" placeholder="e.g. £26,000" />
                        </div>


                        <p id="unspecified-text" class="hiddenfield">Enter 0 to show 'unspecified'</p>

                        <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center hiddenfield">
                            <label class="text-base lg:min-w-[130px]" for="job_supplemental_pay">Supplemental Pay</label>
                            <input class="w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" type="text" id="job_supplemental_pay" name="job_supplemental_pay" placeholder="e.g. Commission" />
                        </div>

                        <div class="flex flex-col items-start gap-3 lg:flex-row lg:gap-1 lg:items-center">
                            <label class="text-base min-w-[150px]" for="job_workplace_benefits">Workplace benefits</label>

                            <div class="flex flex-row gap-4 flex-wrap w-full lg:w-3/4">
                                <label class="min-w-[120px]">
                                    <input type="checkbox" name="job_workplace_benefits[]" value="Flexible Hours" /> Flexible Hours
                                </label>
                                <label class="min-w-[120px]">
                                    <input type="checkbox" name="job_workplace_benefits[]" value="Free Parking" /> Free Parking
                                </label>
                                <label class="min-w-[120px]">
                                    <input type="checkbox" name="job_workplace_benefits[]" value="Private Healthcare" /> Private Healthcare
                                </label>
                                <label class="min-w-[120px]">
                                    <input type="checkbox" name="job_workplace_benefits[]" value="Additional Memberships" /> Additional Memberships
                                </label>
                                <label class="min-w-[120px]">
                                    <input type="checkbox" name="job_workplace_benefits[]" value="Cycle to Work" /> Cycle to Work Scheme
                                </label>
                                <label class="min-w-[120px]">
                                    <input type="checkbox" name="job_workplace_benefits[]" value="Workplace Discounts" /> Workplace Discounts
                                </label>
                                <label class="min-w-[120px]">
                                    <input type="checkbox" name="job_workplace_benefits[]" value="Expenses Paid" /> Expenses Paid
                                </label>
                            </div>
                        </div>


                        <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                            <label class="text-base min-w-[130px]" for="job_time">Full or Part time</label>
                            <select class="select-custom w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" id="job_time" name="job_time" required>

                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                            </select>
                        </div>

                        <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                            <label class="text-base min-w-[130px]" for="job_schedule">Shift/schedule</label>
                            <select class="select-custom w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" id="job_shift" name="job_shift" required>
                                <option value="Day shift">Day shift</option>
                                <option value="Night shift">Night shift</option>
                                <option value="Weekend shift">Weekend shift</option>
                                <option value="Rotating shift">Rotating shift</option>
                                <option value="On call">On call</option>
                            </select>
                        </div>

                        <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                            <label class="text-base min-w-[130px]" for="job_sector">Sector</label>
                            <select class="select-custom w-full lg:w-3/4 rounded px-5 py-3 bg-lightergreen" id="job_sector" name="job_sector" required>
                                <option value="Advertising, Creative and Culture">Advertising, Creative and Culture</option>
                                <option value="Charities">Charities</option>
                                <option value="Construction and Real Estate">Construction and Real Estate</option>
                                <option value="Education and Training">Education and Training</option>
                                <option value="Government and Public Administration">Government and Public Administration</option>
                                <option value="Healthcare, Beauty and Social Assistance">Healthcare, Beauty and Social Assistance</option>
                                <option value="Techonology Information Technology and Telecommunications">Information Technology and Telecommunications</option>
                                <option value="Legal, Finance and Insurance">Legal, Finance and Insurance</option>
                                <option value="Retail, Hospitality and Food Services">Retail, Hospitality and Food Services</option>
                                <option value="Transportation and Logistics">Transportation and Logistics</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                            <label class="text-base min-w-[130px]" for="job_role">Job Role</label>
                            <select class="select-custom w-full lg:w-3/4 rounded px-5 py-3 bg-lightergreen" id="job_role" name="job_role" required>
                                <option value="Administrative, Finance & HR">Administrative, Finance & HR</option>
                                <option value="Creative and Design">Creative and Design</option>
                                <option value="Customer Service and Support">Customer Service and Support</option>
                                <option value="Education and Training">Education and Training</option>
                                <option value="Healthcare and Medical">Healthcare and Medical</option>
                                <option value="Management and Leadership">Management and Leadership</option>
                                <option value="Sales and Marketing">Sales and Marketing</option>
                                <option value="Skilled Trades and Labour">Skilled Trades and Labour</option>
                                <option value="Technical and Operations">Technical and Operations</option>
                                <option value="Other">Other</option>
                            </select>

                        </div>

                        <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                            <label class="text-base min-w-[130px]" for="job_location">Work Location</label>
                            <select class="select-custom w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" type="text" id="job_location" name="job_location" required>
                                <option value="In person">In person</option>
                                <option value="Hybrid">Hybrid</option>
                                <option value="Remote">Remote</option>

                            </select>
                        </div>

                        <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                            <label class="text-base min-w-[130px]" for="job_start_date">Start Date</label>
                            <input class="w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" type="date" id="job_start_date" name="job_start_date" placeholder="08/07/2024" required />
                        </div>

                        <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 lg:items-center">
                            <label class="text-base min-w-[130px]" for="job_application_link">Application link</label>
                            <input
                                type="url"
                                class="w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3"
                                id="job_application_link"
                                name="job_application_link"
                                placeholder="e.g. https://yourcompany.com/job"
                                required
                                pattern="https?://.+"
                                title="Please enter a valid URL starting with http:// or https://" />
                        </div>


                        <div class="flex flex-col items-start gap-2 lg:flex-row lg:gap-5 ">
                            <label class="text-base min-w-[130px]" for="job_description_summary">Job summary</label>
                            <textarea
                                class="w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3"
                                id="job_description_summary"
                                name="job_description_summary"
                                placeholder="e.g. Add a summary here (max 40 words)"
                                required
                                oninput="limitWords(this, 40)"
                                rows="4"></textarea>

                        </div>



                        <div class="flex flex-col">
                            <label class="text-base font-semibold" for="job_description">Full job description</label>
                            <?php
                            wp_editor('', 'job_description', array(
                                'wpautop' => true,
                                'media_buttons' => true,
                                'textarea_name' => 'job_description',
                                'textarea_rows' => 10,
                                'teeny' => false,
                                'quicktags' => true,
                                'drag_drop_upload' => true,
                                'tinymce' => array(
                                    'toolbar1' => 'bold italic underline | bullist numlist | link unlink | undo redo',
                                ),
                            ));
                            ?>
                        </div>


                        <div class="flex flex-col gap-2 mt-8">
                            <p class="text-base font-bold">Downloads</p>
                            <div class="flex flex-col gap-5">
                                <div class="flex flex-row gap-5">
                                    <label class="text-base md:w-[300px]" for="job_downloads_one ">About your company</label>
                                    <input class="text-darkergreen " type="file" id="job_downloads_one" name="job_downloads_one" />
                                </div>
                                <div class="flex flex-row gap-5">
                                    <label class="text-base md:w-[300px]" for="job_downloads_two ">Extra information about the vacancy</label>
                                    <input class="text-darkergreen" type="file" id="job_downloads_two" name="job_downloads_two" />
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col mt-8 gap-2">
                            <p class="text-base font-bold">Publish settings</p>

                            <div class="flex flex-row gap-3 lg:gap-5 items-center">
                                <label class="text-base min-w-[130px]" for="job_publish_date">Publish Date</label>
                                <input class="w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" type="date" id="job_publish_date" name="job_publish_date" placeholder="08/07/2024" required />
                            </div>

                            <div class="flex flex-row gap-3 lg:gap-5 items-center">
                                <label class="text-base min-w-[130px]" for="job_expiry_date">Expiry Date</label>
                                <input class="w-full lg:w-3/4 bg-lightergreen rounded px-5 py-3" type="date" id="job_expiry_date" name="job_expiry_date" placeholder="08/07/2024" />

                            </div>
                            <p>For job roles which are continually hiring you can leave this field blank </p>

                        </div>

                        <input type="hidden" id="job_status" name="job_status" value="draft" />

                        <div class="flex flex-row justify-between md:justify-start gap-4 mt-6 lg:mt-8">
                            <?php wp_nonce_field('custom_job_form_action', 'custom_job_form_nonce'); ?>

                            <input id="save_draft_button" class="cursor-pointer border-darkergreen border-2 text-darkergreen py-2 px-10 rounded-full" type="submit" value="Save Draft" />
                            <input id="publish_button" class="cursor-pointer border-darkergreen border-2 text-darkergreen py-2 px-10 rounded-full" type="submit" value="Publish" />
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

<?php } ?>

<?php get_footer(); ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let publishDateInput = document.getElementById("job_publish_date");
        let submitButton = document.getElementById("publish_button");
        let draftButton = document.getElementById("save_draft_button");
        let formActionInput = document.getElementById("job_status");

        function updateButtonValue() {
            let publishDate = new Date(publishDateInput.value);
            let now = new Date();

            // Check if the publish date is valid and in the future
            if (!isNaN(publishDate) && publishDate > now) {
                submitButton.value = "Schedule";
            } else {
                submitButton.value = "Publish";
            }
        }

        publishDateInput.addEventListener("input", updateButtonValue);

        // Ensure form action is set correctly on publish button click
        submitButton.addEventListener('click', function() {
            let publishDate = new Date(publishDateInput.value);
            let now = new Date();

            if (!isNaN(publishDate) && publishDate > now) {
                formActionInput.value = "future";
            } else {
                formActionInput.value = "publish";
            }
        });

        draftButton.addEventListener('click', function() {
            formActionInput.value = "draft"
        });

    });

    function limitWords(input, maxWords) {
        const words = input.value.split(/\s+/).filter((word) => word.length > 0);

        if (words.length > maxWords) {
            input.value = words.slice(0, maxWords).join(" ") + " ";

        }
    }
</script>