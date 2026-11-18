<?php
//Template Name: Archive Template for FAQ

get_header();
?>
<div class="mx-auto max-w-320 px-gutter-half">
	<div class="grid grid-cols-12 gap-x-gutter">
		<div class="col-span-12 sm:col-span-8 sm:col-start-3 min-w-0">
			<h1 class="mb-8"><?php the_archive_title(); ?></h1>
			<ul class="accordion">
				<?php
				$query = new WP_Query( array ( 'orderby' => 'date', 'order' => 'ASC' ) ); /* @BS query not working… need to sort after date and descending */
				?>
				<?php if ( $query->have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php get_template_part('template-parts/partials/faq-card') ?>
				<?php endwhile; endif; ?>
			</ul>
			<a class="button" href="<?php echo esc_url( get_permalink( 106 ) ); ?>"><?php esc_html_e( 'Back to all FAQ topics', 'gobsquad' ); ?></a>
		</div>
	</div>
</div>

<?php
get_footer();
