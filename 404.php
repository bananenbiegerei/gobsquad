<?php
/**
* The template for displaying 404 pages (not found)
*
* @package WordPress
* @subpackage Twenty_Fifteen
* @since Twenty Fifteen 1.0
*/
get_header(); ?>
<section class="error-404 not-found mx-auto max-w-360 px-gutter-half">
	<div class="grid grid-cols-12 gap-x-gutter">
	<div class="col-span-12 sm:col-span-8 sm:col-start-3 text-center">
		<img class="404-image" src="<?php echo get_stylesheet_directory_uri() ?>/dist/assets/img/404-image.png" alt="4040 Image">
		<h1 class="page-title">This page could not be found</h1>
		<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Go to homepage →</a></p>
	</div>
	</div>
</section>
<?php get_footer(); ?>
