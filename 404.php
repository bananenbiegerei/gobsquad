<?php
/**
* The template for displaying 404 pages (not found)
*
* @package WordPress
* @subpackage Twenty_Fifteen
* @since Twenty Fifteen 1.0
*/
get_header(); ?>
<section class="row error-404 not-found">
	<div class="small-8 columns small-centered text-center">
		<img class="404-image" src="<?php echo get_stylesheet_directory_uri() ?>/dist/assets/img/404-image.png" alt="4040 Image">
		<h1 class="page-title">This page could not be found</h1>
		<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Go to homepage →</a></p>
	</div>
</section>
<?php get_footer(); ?>
