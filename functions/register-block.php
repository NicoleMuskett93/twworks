<?php

/**
 * Register Block Types (ACF)
 */

function twworks_register_blocks()
{
	if (function_exists('twworks_register_blocks')) {
		// Hero Block
		acf_register_block(array(
			'name'				=> 'twworks-hero',
			'title'				=> __('TW Works Hero'),
			'description'		=> __('Create a hero block for the TW Works website'),
			'render_template'	=> 'template-parts/blocks/hero.php',
			'category'			=> 'twworks_category',
			'icon'				=> 'slides',
			'keywords'			=> array('twworks, hero')
		));
        // Main Content Block
		acf_register_block(array(
			'name'				=> 'twworks-main-content',
			'title'				=> __('TW Works Main Content Block'),
			'description'		=> __('Create a main content block for the TW Works website'),
			'render_template'	=> 'template-parts/blocks/main-content.php',
			'category'			=> 'twworks_category',
			'icon'				=> 'slides',
			'keywords'			=> array('twworks, main-content')
		));

		// Testimonials block
		acf_register_block(array(
			'name'				=> 'twworks-testimonials',
			'title'				=> __('TWWorks Testimonials'),
			'description'		=> __('Create a Testimonials block for the TWWorks website'),
			'render_template'	=> 'template-parts/blocks/testimonials.php',
			'category'			=> 'twworks_category',
			'icon'				=> 'slides',
			'keywords'			=> array('twworks, testimonial')
		));


		
	}
}



add_action('acf/init', 'twworks_register_blocks');
