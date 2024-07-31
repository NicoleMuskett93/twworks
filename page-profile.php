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
            <div class="flex flex-col">
                <h1 class="text-white text-5xl font-semibold">Your profile: <?php echo $current_user->user_login;?> </h1>
            </div>
        </div>
        <div class="flex flex-row">
            <div class="flex flex-col p-20">
                <h2 class="text-black text-3xl font-bold"><?php echo $current_user->user_login;?></h2>
                <h2 class="text-black text-xl font-bold"><?php echo $current_user->user_email;?></h2>
                <h2 class="text-black text-xl font-bold"><?php echo $current_user->company_name;?></h2>
                <?php echo wp_get_attachment_image( $current_user->company_logo );?>
            
            </div>
        </div>

        <div class="px-20">
        <button onclick="location.href='<?php echo esc_url(wp_logout_url()); ?>'" class="border border-1 border-black p-4 rounded bg-gray-300">Logout</button>

        
        </div>

  <?php  }
}

