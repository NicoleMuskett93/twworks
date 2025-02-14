<button id="searchandfilters" class="lg:hidden m-5 text-base border-2 border-darkergreen text-darkergreen hover:bg-darkergreen font-medium hover:text-white px-10 py-2 rounded-full w-fit">Search and Filters </button>




<form id="job-filter-form" class=" p-5 lg:p-0">


    <div class="hidden lg:flex md:justify-end md:mt-4 md:mx-8">

        <select class="border-grey border rounded-sm p-3 text-base md:w-[300px] select-custom" id="when_published" name="when_published" placeholder="Lastest">
            <option value="" selected>Sort by date added</option>
            <option value="today">Today</option>
            <option value="this-week">This Week</option>
            <option value="this-month">This Month</option>
        </select>
    </div>



    <div class="flex flex-col lg:flex-row">
        <div id="mobilefilters" class="hidden w-full lg:w-1/3 lg:flex flex-col items-center pb-[30px] lg:mt-5 lg:px-8 lg:my-8 lg:border-r-2 lg:border-lightgreen">
            <!-- <input type="hidden" name="form_type" value="<?php echo $form; ?>"> -->
            <div class="w-full lg:max-w-96">

                <?php echo get_search_form(); ?>


            </div>


            <div class="post-filters w-full lg:max-w-96">


                <div class="flex flex-col gap-4 mt-4" method="get">



                    <!-- <div id="salary_slider" class="w-1/2"></div>
                    <input type="hidden" id="min_salary" name="min_salary">
                    <input type="hidden" id="max_salary" name="max_salary">
                    <div class="text-lg">
                        <span id="salary_value">£20000 - £50000</span>
                    </div> -->

                    <!-- <div class="text-lg"><span>£</span><span id="salary_value">20000 - 40000</span></div> -->
                    <?php if (is_page('jobs')) : ?>
                        <select class=" border border-grey rounded-sm p-3 text-base select-custom" id="salary" name="salary">
                            <option value="" class="text-grey" selected>Salary</option>
                            <option value="hundred">£100,000 +</option>
                            <option value="eighty">£80,000 - £100,000</option>
                            <option value="sixty">£60,000 - £80,000</option>
                            <option value="forty">£40,000 - £60,000</option>
                            <option value="twenty">£20,000 - £40,000</option>
                            <option value="zero">Up to £20,000</option>
                            <option value="unspecified">Unspecified</option>
                        </select>
                    <?php endif; ?>

                    <select class=" border border-grey rounded-sm p-3 text-base select-custom" id="shift_type" name="shift_type">
                        <option value="" class="text-grey" selected>Shift Schedule</option>
                        <option value="Day shift">Day shift</option>
                        <option value="Night shift">Night shift</option>
                        <option value="Weekend shift">Weekend shift</option>
                        <option value="Rotating shift">Rotating shift</option>
                        <option value="On call">On call</option>
                    </select>

                    <select class="border border-grey rounded-sm p-3 text-base select-custom" id="sector" name="sector">
                        <option value="" selected>Sector or Industry</option>
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


                    <select class="border border-grey rounded-sm p-3 text-base select-custom" id="full_or_part_time" name="full_or_part_time">
                        <option value="" selected>Type of Contract</option>
                        <option value="full-time">Full-time</option>
                        <option value="part-time">Part-time</option>
                        <option value="contract-temp">Contract / Temporary</option>
                    </select>


                    <select class="border border-grey rounded-sm p-3 text-base select-custom" id="location" name="location" placeholder="Select Location">
                        <option class="" value="" selected>Workplace</option>
                        <option value="In person">On-site</option>
                        <option value="Hybrid">Hybrid</option>
                        <option value="Remote">Remote</option>
                    </select>

                    <!-- <button type="submit" class="mt-4 bg-blue-500 text-white p-2 rounded">Filter Jobs</button> -->
                    <div class="flex">
                        <button id="filter-reset" class="mt-4 text-base border-2 border-darkergreen but text-darkergreen but hover:bg-darkergreen font-medium hover:text-white px-10 py-2 rounded-full w-1/2 lg:w-fit" type="reset">Clear Filters </button>
                    </div>
                </div>
</form>

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