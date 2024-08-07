<?php get_header(); 

$company_logo = get_field('company_logo');
$company_name = get_field('company_name');
$banner_image = get_field('banner_image', 'option');
?>

<?php if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    if (in_array('employer', $current_user->roles)) { 
        ?>

        <div class="flex items-center h-48" style="background-image:url('<?php echo $banner_image['url'];?>'); background-position: center">
            <div class="flex flex-col mx-5">
                <h1 class="text-white text-5xl font-semibold">Your profile: <span class="first-name"><?php echo $current_user->user_firstname; ?></span> <span class="last-name"><?php echo $current_user->user_lastname; ?></span></h1>
            </div>
        </div>
        <div class="flex flex-col gap-5 p-20">
            <div id="profile-section" class="flex flex-col gap-5">
                <div class="flex flex-col gap-5">
                    <h2 class="text-black text-3xl font-bold greeting">Hi, <span class="first-name"><?php echo $current_user->user_firstname; ?></span> <span class="last-name"><?php echo $current_user->user_lastname; ?></span></h2>
                    <div class="w-36 h-36 border border-black border-1 rounded-full p-2 profile"><?php echo wp_get_attachment_image($current_user->company_logo, 'full'); ?></div>
                </div>
            </div>
            <div class="flex flex-col gap-5">
                <form id="profile-update-form" method="post" enctype="multipart/form-data">
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-row gap-5">
                            <h2 class="text-black text-2xl font-bold">First Name: </h2>
                            <h2 class="text-black text-2xl font-bold" id="first_name_display">
                                <span class="first-name"><?php echo $current_user->user_firstname; ?></span>
                            </h2>
                            <input type="text" class="hidden" id="first_name_input" name="firstname" value="<?php echo $current_user->user_firstname; ?>">
                            <button class="border border-1 border-gray-300 p-1 rounded edit-button" type="button" data-field="first_name">Edit</button>
                        </div>
                        <div class="flex flex-row gap-5">
                            <h2 class="text-black text-2xl font-bold">Last Name: </h2>
                            <h2 class="text-black text-2xl font-bold" id="last_name_display">
                                <span class="last-name"><?php echo $current_user->user_lastname; ?></span>
                            </h2>
                            <input type="text" class="hidden" id="last_name_input" name="lastname" value="<?php echo $current_user->user_lastname; ?>">
                            <button class="border border-1 border-gray-300 p-1 rounded edit-button" type="button" data-field="last_name">Edit</button>
                        </div>
                        <h2 class="text-black text-2xl font-bold">Username: <?php echo $current_user->user_login;?></h2>
                        <div class="flex flex-row gap-5">
                            <h2 class="text-black text-2xl font-bold">Email: </h2>
                            <h2 class="text-black text-2xl font-bold email-display" id="email_display">
                                <span><?php echo $current_user->user_email; ?></span>
                            </h2>
                            <input type="text" class="hidden" id="email_input" name="email" value="<?php echo $current_user->user_email; ?>">
                            <button class="border border-1 border-gray-300 p-1 rounded edit-button" type="button" data-field="email">Edit</button>
                        </div>
                        <h2 class="text-black text-2xl font-bold">Company Name: <?php echo $current_user->company_name;?></h2>
                        <div>
                            <button id="profile-update-button" type="submit" class="border border-primary bg-white text-primary border-1 px-8 py-2 rounded hover:bg-primary hover:text-white">Update Profile</button>
                        </div>
                    </div>
                    
                </form>
                <p id="profile-update-success" class="hidden text-green-500">Profile updated successfully!</p>
            </div>
            <div class="">
                <?php $custom_logout_url = 'https://garyb173.sg-host.com/my-jobs/'; ?>
                <button onclick="location.href='<?php echo esc_url(wp_logout_url($custom_logout_url)); ?>'" class="border border-primary bg-white text-primary border-1 px-8 py-2 rounded hover:bg-primary hover:text-white">Logout</button>
            </div>
        </div>
    <?php  }
} ?>

<?php get_footer(); ?>
