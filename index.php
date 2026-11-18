<?php get_header();?>
<div class="mx-auto max-w-320 px-gutter-half page-background">
	<div class="grid grid-cols-12 gap-x-gutter pb-large">
		<?php get_template_part('template-parts/page/page','title-index'); ?>
	</div>
	<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-x-gutter">
		<?php
			$today = current_time('Ymd');
			$args = array (
		    'post_type' 				=> 'post',
				'posts_per_page'		=> -1,
		    'meta_query' 				=> array(
					array(
		        'key'						=> 'end',
		        'compare'				=> '>=',
		        'value'					=> $today,
				  )
			   ),
				'meta_key'				=> 'start',
				'orderby'   			=> 'meta_value_num',
				'order'     			=> 'ASC',
			);
			$query = new WP_Query( $args );
			// The Loop
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post(); ?>
					<div class="min-w-0">
						<?php get_template_part('template-parts/partials/date-card'); ?>
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
<!-- @LG help with current and past dates -->
<?php get_footer(); ?>
