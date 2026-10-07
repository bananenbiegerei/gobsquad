<?php

// Register a swiper ACF Block
if( function_exists('acf_register_block') ) {

	$result = acf_register_block(array(
  	'name'				=> 'swiper',
		'title'				=> __('Swiper'),
		'description'		=> __('A custom swiper block.'),
		'render_callback'	=> 'my_swiper_block_html'
		//'category'		=> '',
		//'icon'			=> '',
		//'keywords'		=> array(),
	));
}
/* function my_acf_block_render_callback( $block ) {

	// convert name ("acf/swiper") into path friendly slug ("swiper")
	$slug = str_replace('acf/', '', $block['name']);

	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/template-parts/block/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/template-parts/block/content-{$slug}.php") );
	}
}*/
// Callback to render the testimonial ACF Block
function my_testimonial_block_html() {

	// vars
	$testimonial = get_field('swiper');


	?>
	    <p><?php echo $testimonial; ?></p>
	<?php
}
