<?php get_header();

$company_logo = get_field('company_logo');
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
?>

<?php if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    if (in_array('employer', $current_user->roles)) {
?>

        <!-- <div class="flex items-center h-48" style="background-image:url('<?php echo $banner_image['url']; ?>'); background-position: center">
            <div class="flex flex-col mx-5">
                <h1 class="text-white text-5xl font-semibold">Your profile: <span class="first-name"><?php echo $current_user->user_firstname; ?></span> <span class="last-name"><?php echo $current_user->user_lastname; ?></span></h1>
            </div>
        </div> -->

        <div class="flex flex-col px-5 pt-7 pb-10 lg:p-0 lg:flex-row lg:mt-[50px] gap-6 lg:gap-0">

            <div class="lg:w-1/3 flex flex-col gap-6 justify-start lg:px-8 lg:my-8 lg:border-r-2 border-lightgreen">

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


            <div class="lg:w-2/3 flex flex-col gap-5 lg:px-8 lg:my-8 ">
                <div id="profile-section" class="flex flex-col gap-5">
                    <div class="flex flex-col gap-5">
                        <h2 class="text-black text-2xl font-bold greeting"><span class="first-name"><?php echo $current_user->user_firstname; ?></span> <span class="last-name"><?php echo $current_user->user_lastname; ?></span> - Profile</h2>
                        <!-- <div class="w-36 h-36 border border-black border-1 rounded-full p-2 profile"><?php echo wp_get_attachment_image($current_user->company_logo, 'full'); ?></div> -->
                    </div>
                </div>
                <div class="flex flex-col gap-5">
                    <form id="profile-update-form" method="post" enctype="multipart/form-data">
                        <div class="flex flex-col gap-3">
                            <div class="flex flex-col gap-3 lg:flex-row">
                                <div class="flex flex-col gap-2 min-w-[150px]">
                                    <h2 class="text-black text-base">Username: </h2>
                                    <p class="text-[12px]">This cannot be changed</p>
                                </div>
                                <div class="bg-offwhite w-full lg:w-3/4 px-5 py-3">
                                    <span class="text-grey text-base "> <?php echo $current_user->user_login; ?> </span>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 lg:flex-row ">
                                <div class="flex flex-col gap-2 min-w-[150px]">
                                    <h2 class="text-black text-base">Company: </h2>
                                    <p class="text-[12px]">Need to change this?</p>
                                    <a href="mailto:biddirector@rtwtogether.com" class="text-[12px] text-darkergreen">Contact TW Works</a>
                                </div>
                                <div class="bg-offwhite w-full lg:w-3/4 px-5 py-3">
                                    <span class="text-grey text-base"><?php echo $company_name; ?></span>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2 lg:flex-row items-start lg:items-center">
                                <h2 class="text-black text-base min-w-[150px]">First Name: </h2>
                                <input type="text" class="w-3/4 bg-lightergreen px-5 py-3 text-base" id="first_name_input" type="text" name="firstname" value="<?php echo $current_user->user_firstname; ?>" required>


                            </div>
                            <div class="flex flex-col gap-2 lg:flex-row items-start lg:items-center">
                                <h2 class="text-black text-base min-w-[150px]">Last Name: </h2>

                                <input type="text" class="w-3/4 bg-lightergreen px-5 py-3 text-base" id="last_name_input" name="lastname" value="<?php echo $current_user->user_lastname; ?>" required>

                            </div>
                            <div class="flex flex-col gap-2 lg:flex-row items-start lg:items-center">
                                <h2 class="text-black text-base min-w-[150px]">Email: </h2>

                                <input type="text" class="w-full lg:w-3/4 bg-lightergreen px-5 py-3 text-base" id="email_input" name="email" value="<?php echo $current_user->user_email; ?>" required>

                            </div>


                            <button id="profile-update-button" type="submit" class="mt-8 w-fit border-darkergreen border-2 text-darkergreen hover:bg-darkergreen hover:text-white  px-8 py-2 rounded-full">Save Changes</button>

                        </div>

                    </form>
                    <p id="profile-update-success" class="hidden text-green-500">Profile updated successfully!</p>
                </div>
                <!-- <div class="">
                    <?php $custom_logout_url = 'https://tunbridgewells.works/my-jobs/'; ?>
                    <button onclick="location.href='<?php echo esc_url(wp_logout_url($custom_logout_url)); ?>'" class="border border-primary bg-white text-primary border-1 px-8 py-2 rounded hover:bg-primary hover:text-white">Logout</button>
                </div> -->
            </div>
        </div>
<?php  }
} ?>

<?php get_footer(); ?>