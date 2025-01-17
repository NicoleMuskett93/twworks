
</main>

<?php do_action( 'tw_works_content_end' ); ?>

</div>

<?php do_action( 'tw_works_content_after' ); ?>

<?php get_template_part( 'template-parts/content', 'footer' ); ?>

<footer id="colophon" class="site-footer bg-gray-50 py-12" role="contentinfo">
	<?php do_action( 'tw_works_footer' ); ?>

	<div class="container mx-auto text-center text-gray-500">
		&copy; <?php echo date_i18n( 'Y' );?> - <?php echo get_bloginfo( 'name' );?>
	</div>
</footer>

</div>



<?php wp_footer(); ?>
</body>
</html>
