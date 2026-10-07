<?php get_header();?>
<div class="grid-container page-background">
	<div class="grid-x grid-padding-x padding-bottom-large">
		<?php get_template_part('template-parts/page/page-title') ?>
	</div>
	<div class="grid-x grid-padding-x small-up-1 medium-up-2 large-up-3">
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
					<div class="cell">
						<?php get_template_part('template-parts/partials/project-card'); ?>
					</div>
				<?php }
			} else {
				// no posts found
			}
			// Restore original Post Data
			wp_reset_postdata();
		?>
		<div class="cell">
			<a class="button" href="<?php echo get_post_type_archive_link( 'projects' ); ?>">go to archive</a>
		</div>
	</div>
</div>
<?php get_footer(); ?>
