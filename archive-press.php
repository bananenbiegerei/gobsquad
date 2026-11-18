<?php
//Template Name: Archive Template for Press items
get_header(); ?>
<div class="mx-auto max-w-320 px-3 sm:px-4">
	<div class="grid grid-cols-12 gap-x-6 sm:gap-x-8 pb-8 md:pb-16">
		<?php get_template_part('template-parts/page/page-title-press') ?>
	</div>
	<div class="grid grid-cols-12 gap-x-6 sm:gap-x-8">
		<div class="col-span-12 sm:col-span-8 sm:col-start-3 min-w-0">
			<?php
			echo get_post_field('post_content', 64);
			?>
			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-6 sm:gap-x-8">
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
						<div class="min-w-0">
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
</div>
<?php get_footer(); ?>
