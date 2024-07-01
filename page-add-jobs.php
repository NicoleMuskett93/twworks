<?php get_header();?>

<?php if( is_user_logged_in() ) {
?>
    <div>
        <div class="flex items-center h-48" style="background-image:url('https://garyb173.sg-host.com/wp-content/uploads/2024/06/pantiles-exterior-hero.jpg'); background-position: center">
        	<div class="flex flex-col">
                <h1 class="text-white text-5xl font-semibold">Your jobs: </h1>
                search
            </div>
        </div>
        <div class="flex flex-row">
			<div class="bg-blue-100 w-1/3 flex flex-col justify-start text-center p-5">
				<a href="<?php echo home_url('/jobs/');?>" class="text-xl text-black border border-black border-1 bg-gray-300 rounded">Back to jobs list</a>
			</div>
			<div class="bg-blue-50 w-2/3 p-5">
				<div class="flex flex-col">
					<h2>User</h2>
                    <form class="flex flex-col gap-3" id="job_form" action="" method="post">
                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_title">Job Title</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" type="text" id="job_title" name="job_title" placeholder="Retail Store Manager" />
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_salary">Salary</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" type="text" id="job_salary" name="job_salary" placeholder="£26,000 a year - Full-time" required />
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_supplemental_pay">Supplemental Pay</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" type="text" id="job_supplemental_pay" name="job_supplemental_pay" placeholder="Commission pay" required />
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_time">Supplemental Pay</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" type="text" id="job_time" name="job_time" placeholder="Full-time" required />
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_schedule">Shift/schedule</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" type="text" id="job_shift" name="job_shift" placeholder="Weekend availablity. Every weekend, Monday to Friday" required />
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_location">Work Location</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" type="text" id="job_location" name="job_location" placeholder="In person" required />
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_start_date">Start Date</label>
                            <input class="w-1/2 border border-black border-1 rounded p-2" type="date" id="job_start_date" name="job_start_date" placeholder="08/07/2024" required />
                        </div>

                        <div class="flex flex-col">
                            <label class="text-xl font-semibold" for="job_description">Full job description</label>
                            <textarea class="w-1/2 border border-black border-1 rounded p-2" id="job_description" name="job_description" required></textarea>
                        </div>

                        <div class="flex flex-row gap-10 items-center">
                            <label class="text-xl" for="job_downloads">Downloads</label>
                            <input class="w-1/2" type="file" id="job_downloads" name="job_downloads" />
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
    
                        <div class="flex flex-row gap-10">
                            <?php wp_nonce_field('custom_job_form_action', 'custom_job_form_nonce'); ?>
                            <input id="publish_button" class="border border-1 border-black bg-gray-300 py-2 px-10 rounded" type="submit" value="Publish" />
                        </div>

                        <!-- Editing options

                         <div class="flex flex-row justify-start items-center gap-10">
                            <div class="flex flex-row">
                                <label class="text-xl" for="job_status"></label>
                                    <div class="flex flex-row gap-2">
                                        <input type="radio" id="published" name="job_published" value="published">
                                        <label for="html">Published</label><br>
                                    </div>
                                    <div class="flex flex-row gap-2">
                                        <input type="radio" id="draft" name="job_draft" value="draft">
                                        <label for="css">Draft</label><br>
                                    </div>
                                    <div class="flex flex-row gap-2">
                                        <input type="radio" id="archive" name="job_archive" value="archive">
                                        <label for="javascript">Archive</label>
                                    </div>
                            </div>
                            <div class="">
                               remeber to put form nonce here
                                <input class="border border-1 border-black bg-gray-300 py-2 px-10 rounded" type="submit" value="Update" />
                            </div>
                        </div> -->
   
                    </form>

				</div>
			</div>
        
        </div>
    </div>

<?php } ?>

<script>
        document.addEventListener("DOMContentLoaded", function() {
            let publishDateInput = document.getElementById("job_publish_date");
            let submitButton = document.getElementById("publish_button");

            function updateButtonValue() {
                let publishDate = new Date(publishDateInput.value);
                let now = new Date();

                // Check if the publish date is valid and in the future
                if (!isNaN(publishDate) && publishDate >= now) {
                    submitButton.value = "Schedule";
                } else {
                    submitButton.value = "Publish";
                }
            }

            publishDateInput.addEventListener("input", updateButtonValue);
            updateButtonValue();
        });
    </script>
