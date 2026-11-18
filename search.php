<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
	<div class="mx-auto max-w-320 px-3 sm:px-4">
		<div class="grid grid-cols-12 gap-x-6 sm:gap-x-8"><div class="col-span-12 sm:col-span-8 sm:col-start-3">
			<h1 class="page-title mt-4 md:mt-8"><?php printf( __( 'Suchergebnisse für: %s', 'twentyfifteen' ), get_search_query() ); ?></h1>
		</div></div>
	</div>
	<?php
	while ( have_posts() ) : the_post(); ?>
	<?php ?>
	<div class="mx-auto max-w-320 px-3 sm:px-4">
		<div class="grid grid-cols-12 gap-x-6 sm:gap-x-8"><div class="col-span-12 sm:col-span-8 sm:col-start-3">
			<?php the_title( sprintf( '<h2><a href="%s" rel="bookmark"> → ', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</div></div>
	</div>
<?php endwhile;
else :
	get_template_part( 'content', 'none' );
endif;
?>
<?php get_footer(); ?>
