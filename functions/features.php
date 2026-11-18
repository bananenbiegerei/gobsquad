<?php
// %%%%%%%%%% Theme supports
add_theme_support( 'title-tag' );
add_post_type_support( 'page', 'excerpt' );

// %%%%%%%%%% Custom Excerpt Length %%%%%%%%%
function custom_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/*
 * Excerpts end with an ellipsis only. The previous empty <a class="read-more">
 * had no accessible name (axe: link-name); every card that prints an excerpt
 * already carries a named link to the same permalink.
 */
function new_excerpt_more( $more ) {
	return ' …';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

add_filter( "the_excerpt", "add_class_to_excerpt" );

function add_class_to_excerpt( $excerpt ) {
	return str_replace( '<p', '<p class="' . esc_attr( gob_lead_class() ) . '"', $excerpt );
}

// %%%%%%%%% Custom Post Archive Page

// function archive_add_custom_types( $query ) {
//   if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
//     $query->set( 'post_type', array(
//      'post', 'nav_menu_item', 'projekt'
//         ));
//       return $query;
//     }
// }
// add_filter( 'pre_get_posts', 'archive_add_custom_types' );

// %%%%%%%% SVG Support in Media
function svg_support ( $svg_mime ){
	$svg_mime['svg'] = 'image/svg+xml';
	return $svg_mime;
}
add_filter( 'upload_mimes', 'svg_support' );

// Disable admin bar in site view
show_admin_bar(false);

// ACF Options page
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page();

}

// add color scheme to body_class
add_filter('body_class', 'add_acf_body_class');
function add_acf_body_class($class) {
    $field = get_field_object( 'color_scheme', get_queried_object_id() );
    $value = ( is_array( $field ) && ! empty( $field['value'] ) ) ? $field['value'] : '';
    if ( $value ) {
        $class[] = str_replace( '_', '-', $value ); // Change _ to -.
    }

    return $class;
}

// Rename posts
function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Dates';
    $submenu['edit.php'][5][0] = 'Dates';
    $submenu['edit.php'][10][0] = 'Add Dates';
    $submenu['edit.php'][16][0] = 'Dates Tags';
}
function revcon_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Dates';
    $labels->singular_name = 'Dates';
    $labels->add_new = 'Add Dates';
    $labels->add_new_item = 'Add Dates';
    $labels->edit_item = 'Edit Dates';
    $labels->new_item = 'Dates';
    $labels->view_item = 'View Dates';
    $labels->search_items = 'Search Dates';
    $labels->not_found = 'No Dates found';
    $labels->not_found_in_trash = 'No Dates found in Trash';
    $labels->all_items = 'All Dates';
    $labels->menu_name = 'Dates';
    $labels->name_admin_bar = 'Dates';
}

add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );

// Upload file sizes
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

// Anti Spam Bot
function hide_email_shortcode( $atts , $content = null ) {
	if ( ! is_email( $content ) ) {
		return;
	}

	return '<a href="mailto:' . antispambot( $content ) . '">' . antispambot( $content ) . '</a>';
}

add_shortcode( 'email', 'hide_email_shortcode' );

// add is_blog function to check if site is home but not static front page
function is_blog () {
    return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}

add_filter( 'get_the_archive_title', 'my_theme_archive_title' );
/**
 * Remove archive labels.
 *
 * @param  string $title Current archive title to be displayed.
 * @return string        Modified archive title to be displayed.
 */
function my_theme_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} elseif ( is_home() ) {
		$title = single_post_title( '', false );
	}

	return $title;
}

// Increase Upload size
// @ini_set( 'upload_max_size' , '64M' );
// @ini_set( 'post_max_size', '64M');
// @ini_set( 'max_execution_time', '300' );
