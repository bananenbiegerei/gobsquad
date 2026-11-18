<?php get_header();?>
<div class="mx-auto max-w-320 px-gutter-half page-background">
	<div class="grid grid-cols-12 gap-x-gutter pb-large">
		<?php get_template_part('template-parts/page/page-title') ?>
	</div>
	<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-gutter">
		<?php
			$args = array(
				'post_type'					=> array( 'projects' ),
				'posts_per_page'		=> -1,
				'meta_query' 				=> array(
					array(
						'key'						=> 'is_current',
						'compare'				=> '=',
						'value'					=> '1',
					)
				 ),
			);
			$query = new WP_Query( $args );
			// The Loop
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post(); ?>
					<div class="min-w-0">
						<?php get_template_part('template-parts/partials/project-card'); ?>
					</div>
				<?php }
			} else {
				// no posts found
			}
			// Restore original Post Data
			wp_reset_postdata();
		?>
		<div>
			<a class="button" href="<?php echo get_post_type_archive_link( 'projects' ); ?>">go to archive</a>
		</div>
	</div>
</div>
<?php get_footer(); ?>
