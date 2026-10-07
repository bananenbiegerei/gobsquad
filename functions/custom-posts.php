<?php
function custom_post_type() {

	register_post_type(
		'projects', array(
			'labels' => array('name' => __( 'Projects' ), 'singular_name' => __( 'Project' ) ),
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor', 'thumbnail')
		)
	);

	register_post_type(
		'press', array(
			'labels' => array('name' => __( 'Press Items' ), 'singular_name' => __( 'Press Item' ) ),
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor')
		)
	);

	// register_post_type(
	// 	'videos', array(
	// 		'labels' => array('name' => __( 'Videos' ), 'singular_name' => __( 'Video' ) ),
	// 		'public' => true,
	// 		'has_archive' => true,
	// 		'supports' => array('title', 'editor', 'thumbnail')
	// 	)
	// );

	register_post_type(
		'faqs', array(
			'labels' => array('name' => __( 'FAQs' ), 'singular_name' => __( 'FAQ' ) ),
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor'),
			'taxonomies' => array('faq_categories'),
		)
	);

}
add_action( 'init', 'custom_post_type' );

// NEEDED to get title etc. on category / archive template files
function my_query_post_type($query) {
    if ( is_category() && ( ! isset( $query->query_vars['suppress_filters'] ) || false == $query->query_vars['suppress_filters'] ) ) {
        $query->set( 'post_type', array( 'post', 'faqs' ) );
        return $query;
    }
}
add_filter('pre_get_posts', 'my_query_post_type');
