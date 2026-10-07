<?php get_header();?>
<div class="grid-container page-background">
	<div class="grid-x grid-padding-x padding-bottom-large">
		<?php get_template_part('template-parts/page/page','title-index'); ?>
	</div>
	<div class="grid-x grid-padding-x small-up-2 medium-up-3 large-up-4">
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
					<div class="cell">
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
