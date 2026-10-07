<?php
//Template Name: Archive Template for Press items
get_header(); ?>
<div class="grid-container">
	<div class="grid-x grid-padding-x padding-bottom-large">
		<?php get_template_part('template-parts/page/page-title-press') ?>
	</div>
	<div class="medium-8 medium-offset-2 cell">
		<?php
		echo get_post_field('post_content', 64);
		?>
		<div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-3">
			<?php
			// WP_Query arguments
			$args = array(
				'post_type'              => array( 'press' )
			);
			$query = new WP_Query( $args );
			// The Loop
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post(); ?>
					<div class="cell">
						<?php get_template_part('template-parts/partials/press-card'); ?>
					</div>
				<?php }
			} else {
				// no posts found
			}
			// Restore original Post Data
			wp_reset_postdata();
			?>
		</div>
	</div>

</div>
<?php get_footer(); ?>
