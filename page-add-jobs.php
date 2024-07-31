<?php get_header();

$banner_image = get_field('banner_image', 'option');

?>

<?php if( is_user_logged_in() ) {
?>
    <div>
        <div class="flex items-center h-48" style="background-image:url('<?php echo $banner_image['url'];?>'); background-position: center">
        	<div class="flex flex-col mx-5">
                <h1 class="text-white text-5xl font-semibold">Add a job: <?php echo $current_user->company_name;?> </h1>
            </div>
        </div>
        <div class="flex flex-row">
			<div class="bg-blue-100 w-1/3 flex flex-col justify-start text-center p-5">
				<a href="<?php echo home_url('/jobs/');?>" class="text-xl text-black border border-black border-1 bg-gray-300 rounded">Back to jobs list</a>
			</div>
			<div class="bg-blue-50 w-2/3 p-5">
				<div class="flex flex-col gap-3">
					<h2 class="font-bold text-2xl"><?php echo $current_user->company_name;?></h2>
                    <form class="flex flex-col gap-3" id="job_form" action="" method="post" enctype="multipart/form-data">
                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_title">Job Title</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" type="text" id="job_title" name="job_title" placeholder="Retail Store Manager" required />
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_salary">Salary</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" type="number" id="job_salary" name="job_salary" placeholder="£26,000 a year" required />
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_supplemental_pay">Supplemental Pay</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" type="text" id="job_supplemental_pay" name="job_supplemental_pay" placeholder="Commission pay" required />
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_time">Full or Part time</label>
                            <select class="w-1/2 border border-black border-1 rounded p-2" id="job_time" name="job_time" required>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                            </select>
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_schedule">Shift/schedule</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" type="text" id="job_shift" name="job_shift" placeholder="Weekend availablity. Every weekend, Monday to Friday" required />
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_location">Work Location</label>
                            <select class="w-1/2 border border-black border-1 rounded p-2" type="text" id="job_location" name="job_location" required >
                                <option value="In person">In person</option>
                                <option value="Hybrid">Hybrid</option>
                                <option value="Remote">Remote</option>

                            </select>
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_start_date">Start Date</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" type="date" id="job_start_date" name="job_start_date" placeholder="08/07/2024" required />
                        </div>

                        <div class="flex flex-col">
                            <label class="text-xl font-semibold" for="job_description">Full job description</label>
                            <?php 
                                wp_editor('','job_description', array(
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




                        <div class="flex flex-col gap-2">
                            <p class="text-xl">Downloads</p>
                            <div class="flex flex-row gap-3">
                                <label class="text-lg" for="job_downloads_one ">About your company</label>
                                <input class="" type="file" id="job_downloads_one" name="job_downloads_one" />
                                <label class="text-lg" for="job_downloads_two ">Extra job information</label>
                                <input class="" type="file" id="job_downloads_two" name="job_downloads_two" />
                            </div>
                        </div>

                        <div class="flex flex-row gap-10">
                            <label class="text-xl" for="job_application_link">Application link</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" id="job_application_link" name="job_application_link" placeholder="https://uk.indeed.com/viewjob" required />
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_publish_date">Publish Date</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" type="date" id="job_publish_date" name="job_publish_date" placeholder="08/07/2024" required />
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_expiry_date">Expiry Date</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" type="date" id="job_expiry_date" name="job_expiry_date" placeholder="08/07/2024" required />
                        </div>

                        <input type="hidden" id="job_status" name="job_status" value="draft" />
    
                        <div class="flex flex-row gap-10">
                            <?php wp_nonce_field('custom_job_form_action', 'custom_job_form_nonce'); ?>
                            
                            <input id="save_draft_button" class="cursor-pointer border border-1 border-black bg-gray-300 py-2 px-10 rounded" type="submit" value="Save Draft" />
                            <input id="publish_button" class="cursor-pointer border border-1 border-black bg-gray-300 py-2 px-10 rounded" type="submit" value="Publish"/>
                        </div>
   
                    </form>

				</div>
			</div>
        
        </div>
    </div>

<?php } ?>

<?php get_footer();?>

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

        draftButton.addEventListener('click', function(){
            formActionInput.value = "draft"
        });

    });
    
</script>
