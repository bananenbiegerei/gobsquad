<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
	<div class="mx-auto max-w-320 px-gutter-half">
		<div class="grid grid-cols-12 gap-x-gutter"><div class="col-span-12 sm:col-span-8 sm:col-start-3">
			<h1 class="page-title mt-medium"><?php printf( __( 'Suchergebnisse für: %s', 'twentyfifteen' ), get_search_query() ); ?></h1>
		</div></div>
	</div>
	<?php
	while ( have_posts() ) : the_post(); ?>
	<?php ?>
	<div class="mx-auto max-w-320 px-gutter-half">
		<div class="grid grid-cols-12 gap-x-gutter"><div class="col-span-12 sm:col-span-8 sm:col-start-3">
			<?php the_title( sprintf( '<h2><a href="%s" rel="bookmark"> → ', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</div></div>
	</div>
<?php endwhile;
else :
	get_template_part( 'content', 'none' );
endif;
?>
<?php get_footer(); ?>
