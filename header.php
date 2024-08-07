<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'font-neuzeit bg-white text-gray-900 antialiased' ); ?>>

<?php do_action( 'tw_works_site_before' ); ?>

<div id="page" class="min-h-screen flex flex-col">

	<?php do_action( 'tw_works_header' ); ?>

	<header>

		<div class="nav">
			<div class="lg:flex items-center bg-blue-50">
				<div class="flex flex-row justify-between items-center">
					<div class="w-48">
						<?php if ( has_custom_logo() ) { ?>
                            <?php the_custom_logo(); ?>
						<?php } else { ?>
							<a href="<?php echo get_bloginfo( 'url' ); ?>" class="font-extrabold text-lg uppercase">
								<?php echo get_bloginfo( 'name' ); ?>
							</a>

							<p class="text-sm font-light text-gray-600">
								<?php echo get_bloginfo( 'description' ); ?>
							</p>

						<?php } ?>
					</div>

					<div class="lg:hidden">
						<a href="#" aria-label="Toggle navigation" id="mobile-menu-toggle">
							<svg viewBox="0 0 20 20" class="inline-block w-6 h-6" version="1.1"
								 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								<g stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
									<g id="icon-shape">
										<path d="M0,3 L20,3 L20,5 L0,5 L0,3 Z M0,9 L20,9 L20,11 L0,11 L0,9 Z M0,15 L20,15 L20,17 L0,17 L0,15 Z"
											  id="Combined-Shape"></path>
									</g>
								</g>
							</svg>
						</a>
					</div>
				</div>

				<div>
					
				<?php wp_nav_menu(
					array(
						'container_id'    => 'mobile',
						'container_class' => 'hidden bg-gray-100 p-4',
						'menu_class'      => 'items-center lg:flex lg:-mx-4 gap-10',
						'theme_location'  => 'mobile',
						'li_class'        => 'lg:mx-4',
						'fallback_cb'     => false,
					)
				);
				?>
				</div>

				<div class="flex flex-col w-full">

					<div class="flex flex-row justify-between bg-blue-50 px-5 py-2">

					<?php
					wp_nav_menu(
						array(
							'container_id'    => 'primary-menu',
							'container_class' => 'hidden bg-gray-100 mt-4 p-4 lg:mt-0 lg:p-0 lg:bg-transparent lg:block',
							'menu_class'      => 'items-center lg:flex lg:-mx-4 gap-10',
							'theme_location'  => 'primary',
							'li_class'        => 'lg:mx-4',
							'fallback_cb'     => false,
						)
					);
					?>
					<?php
					wp_nav_menu(
						array(
							'container_id'    => 'login-menu',
							'container_class' => 'hidden lg:block',
							'menu_class'      => 'items-center lg:flex lg:-mx-4',
							'theme_location'  => 'login',
							'li_class'        => 'lg:mx-4',
							'fallback_cb'     => false,
						)
					);
					?>
					</div>
					<div class="flex flex-row justify-end bg-white">
						<?php wp_nav_menu(
								array(
									'container_id'    => 'secondary-menu',
									'container_class' => 'hidden lg:block',
									'menu_class'      => 'items-center lg:flex',
									'theme_location'  => 'secondary',
									'li_class'        => 'sec-menu text-center font-neuzeit-grotesk ',
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

		<?php do_action( 'tw_works_content_start' ); ?> 

		<main>
