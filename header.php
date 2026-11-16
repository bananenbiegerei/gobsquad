<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<?php get_template_part('head') ?>
<?php
/*
 * Page background image (ACF `background_image`). Shop, blog and archives
 * read it from a fixed source; everything else from the current object.
 * The field may be unset, so only emit the inline style when we have a URL.
 */
if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
	$page_background_image = get_field( 'background_image', 'option' );
} elseif ( is_blog() ) {
	$page_background_image = get_field( 'background_image', 56 );
} elseif ( is_archive() ) {
	$page_background_image = get_field( 'background_image', 64 ); // Press.
} else {
	$page_background_image = get_field( 'background_image' );
}

$page_background_url = ( is_array( $page_background_image ) && ! empty( $page_background_image['url'] ) )
	? $page_background_image['url']
	: '';
?>
<body <?php body_class( 'page-background-image' ); ?><?php if ( $page_background_url ) : ?> style="background-image: url('<?php echo esc_url( $page_background_url ); ?>')"<?php endif; ?>>
	<div class="off-canvas-content">
	<?php get_template_part('template-parts/partials/header-desktop'); ?>
	<?php get_template_part('template-parts/partials/header-mobile'); ?>
<main id="main-content" class="main-content">
