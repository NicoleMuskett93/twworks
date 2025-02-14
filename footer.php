</main>

<?php do_action('tw_works_content_end'); ?>

</div>

<?php do_action('tw_works_content_after'); ?>

<footer id="colophon" class="site-footer   " role="contentinfo">
	<div class="bg-offwhite p-5 lg:px-[50px] lg:py-10">
		<div class="grid grid-col-1 lg:grid-cols-3 gap-6 lg:gap-[156px]">
			<div class="flex flex-col gap-6 lg:gap-14">
				<?php if (has_custom_logo()) : ?>
					<div class="site-logo w-48 lg:w-[280px]">
						<?php the_custom_logo(); ?>
					</div>
				<?php endif; ?>
				<?php
				if (is_user_logged_in() && in_array('employer', (array) wp_get_current_user()->roles)) {
					// Display "My Jobs" button for employers
					echo '<a href="' . site_url('/my-jobs') . '" class="loginbutton w-48 lg:w-fit text-center border-darkergreen border-2 rounded-full text-darkergreen px-5 lg:px-10 py-2">My Jobs</a>';
				} else {
					// Display "Employer Login" button for non-employers
					echo '<a href="' . site_url('/my-jobs') . '" class="loginbutton w-48 lg:w-fit text-center border-darkergreen border-2 rounded-full text-darkergreen px-5 lg:px-10 py-2">Employer Login</a>';
				}
				?>

			</div>
			<div class="flex flex-row gap-14 lg:gap-[200px]">
				<div>
					<?php
					wp_nav_menu(
						array(
							'container_id'    => 'footer_primary_menu',
							'container_class' => '',
							'menu_class'      => 'flex flex-col gap-[25px] list-none',
							'theme_location'  => 'primary',
							'li_class'        => 'text-[13px]',
							'fallback_cb'     => false,
						)
					);
					?>

				</div>
				<div>
					<?php
					wp_nav_menu(
						array(
							'container_id'    => 'footer_secondary_menu',
							'container_class' => '',
							'menu_class'      => 'flex flex-col gap-[25px] list-none',
							'theme_location'  => 'footer_secondary',
							'li_class'        => 'text-[13px]',
							'fallback_cb'     => false,
						)
					);
					?>
				</div>
			</div>

		</div>
	</div>
	<div class="mx-auto max-w-[550px] flex flex-col items-center">
		<img src="https://tunbridgewells.works/wp-content/uploads/2024/09/64149e2ffabbf94baa7c1e2dfd266598.png" alt="footer-logo" class="w-[300px]" />
		<p class="text-center text-[13px] px-10">Promoted by Royal Tunbridge Wells Together on behalf of local businesses.
			<br>©2024 TW WORKS - ALL RIGHTS RESERVED
		</p>

	</div>



</footer>

</div>



<?php wp_footer(); ?>
</body>

</html>