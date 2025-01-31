<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class('font-nunito bg-white text-gray-900 antialiased'); ?>>

	<?php do_action('tw_works_site_before'); ?>

	<div id="page" class="min-h-screen flex flex-col">

		<?php do_action('tw_works_header'); ?>

		<header>

			<div class="nav">
				<div class="">

					<div class="lg:hidden flex justify-between bg-offwhite px-5 py-3 lg:p-0">
						<div class=" lg:hidden w-36 ">
							<?php if (has_custom_logo()) { ?>
								<?php the_custom_logo(); ?>
							<?php } ?>
						</div>
						<a href="#" aria-label="Toggle navigation" id="mobile-menu-toggle" class="flex items-center justify-center">
							<svg id="burger" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
								<path d="M0 12H18V10H0V12ZM0 7H18V5H0V7ZM0 0V2H18V0H0Z" fill="#1E1E1E" />
							</svg>
							<svg id="close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" style="display: none;">
								<path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="black" />
							</svg>
						</a>
					</div>


					<div>

						<?php wp_nav_menu(
							array(
								'container_id'    => 'mobile',
								'container_class' => 'hidden h-auto',
								'menu_class'      => 'flex flex-col items-center lg:flex-row list-none pl-0',
								'theme_location'  => 'mobile',
								'li_class'        => 'lg:mx-4 text-base',
								'fallback_cb'     => false,
							)
						);
						?>
					</div>

					<div class="flex flex-col w-full">

						<div class="hidden lg:flex md:flex-row md:justify-end md:bg-offwhite md:px-5 md:py-6">

							<?php
							wp_nav_menu(
								array(
									'container_id'    => 'primary-menu',
									'container_class' => 'hidden bg-gray-100 mt-4 p-4 lg:mt-0 lg:p-0 lg:bg-transparent lg:block',
									'menu_class'      => 'items-center lg:flex lg:-mx-4 gap-20 list-none',
									'theme_location'  => 'primary',
									'li_class'        => 'lg:mx-4 text-primary',
									'fallback_cb'     => false,
								)
							);
							?>
							<?php
							// wp_nav_menu(
							// 	array(
							// 		'container_id'    => 'login-menu',
							// 		'container_class' => 'hidden lg:block',
							// 		'menu_class'      => 'items-center lg:flex lg:-mx-4',
							// 		'theme_location'  => 'login',
							// 		'li_class'        => 'lg:mx-4',
							// 		'fallback_cb'     => false,
							// 	)
							// );
							?>
						</div>
						<div class="flex flex-row justify-between bg-white">
							<div class="hidden lg:block lg:w-72 lg:-mt-[25px] ml-5">
								<?php if (has_custom_logo()) { ?>
									<?php the_custom_logo(); ?>
								<?php } ?>
							</div>

							<?php wp_nav_menu(
								array(
									'container_id'    => 'secondary-menu',
									'container_class' => 'hidden lg:block',
									'menu_class'      => 'items-center lg:flex',
									'theme_location'  => 'secondary',
									'li_class'        => 'sec-menu text-center ',
									'fallback_cb'     => false,
								)
							);
							?>
						</div>

					</div>
				</div>
			</div>
		</header>

		<div id="content" class="site-content flex-grow">

			<?php do_action('tw_works_content_start'); ?>

			<main>