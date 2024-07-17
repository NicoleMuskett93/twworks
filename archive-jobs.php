<? get_header(); 

$job_time_filter = isset($_GET['full_or_part_time']) ? $_GET['full_or_part_time'] : '';

?>

<div class="<?php echo get_post_type(); ?>">

<div class="flex justify-center items-center h-48" style="background-image:url('https://garyb173.sg-host.com/wp-content/uploads/2024/06/pantiles-exterior-hero.jpg'); background-position: center">
    <h1 class="text-white text-center text-5xl font-semibold max-w-xl">Find your pefect job in Tunbridge Wells </h1>
</div>
<div class="flex flex-row">
    <div class="bg-blue-100 w-1/3 flex flex-col items-center p-8 divide-y divide-black">

    <div>

    <?php echo get_search_form();?>

    
    </div>


    <div class="post-filters w-full max-w-96">
                <form id="job-filter-form" class="flex flex-col gap-4 mt-4" method="get">
                    
                    <div class="flex flex-row items-center justify-between">
                        <label class="text-lg font-semibold" for="job_salary">Salary</label>
                        <input class="w-1/2 border border-black border-1 rounded p-2" type="range" id="job_salary" name="job_salary" min="0" max="100000" value="30000" step="5000">
                        <div class="text-lg"><span>£</span><span id="salary_value">30000</span></div>
                    </div>

                    <div class="flex flex-row items-center justify-between">
                        <label class="text-lg font-semibold" for="full_or_part_time">Full / Part time</label>
                        <select class="w-1/2 border border-black border-1 rounded p-2" id="full_or_part_time" name="full_or_part_time" placeholder="Select Time">
                            <option value="full-time">Full-time</option>
                            <option value="part-time">Part-time</option>
                        </select>
                    </div>


                    <button type="submit" class="mt-4 bg-blue-500 text-white p-2 rounded">Filter Jobs</button>
                </form>
            </div>

    </div>
    <div class="bg-blue-50 flex flex-col gap-5 w-2/3 p-8">
        <h2 class="text-2xl font-semibold">Latest Jobs</h2>
        <div id="job-listing-container" class="jobs-content flex flex-col gap-5">
            
            <?php
                    // Define your query arguments
                    $args = array(
                        'post_type' => 'jobs', // Custom post type slug
                        'posts_per_page' => -1, // Display all posts
                        'post_status' => 'publish' , // Only show published posts
                    );

                    // Perform the query
                    $query = new WP_Query($args);

                    if ($query->have_posts()) :
                        while ($query->have_posts()) :
                            $query->the_post();
                           
                        
                       
                            get_template_part( 'template-parts/content', get_post_type() ); 
                    
                        endwhile;
                        wp_reset_postdata(); // Restore original post data
                    else :
                        echo 'No jobs to display';
                    endif;
                    ?>
            </div>
        </div>
    </div>
</div>

</div>

<?php get_footer(); ?>

<script>
    // Get the input and span elements
    const salaryInput = document.getElementById('job_salary');
    const salaryValueDisplay = document.getElementById('salary_value');

    // Function to update the span with the input's current value
    function updateSalaryDisplay() {
        salaryValueDisplay.textContent = salaryInput.value;
    }

    // Listen for input event to handle real-time updates
    salaryInput.addEventListener('input', updateSalaryDisplay);

    // Initialize the display on page load
    updateSalaryDisplay();
</script>