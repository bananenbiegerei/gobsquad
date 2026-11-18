<?php
$dates_title_image = get_field('title_image', 56);
$dates_title_image_size = 'full';
$dates_meta_image = get_field('meta_image', 56);
$dates_meta_image_size = 'full';
?>
<section class="dates green relative pb-xxlarge">
  <div class="text-center mb-large">
    <a href="<?php the_permalink(56); ?>">
      <?php gob_the_title_image( $dates_title_image, $dates_title_image_size, get_the_title( 56 ) ); ?>
    </a>
  </div>

  <div class="swiper swiper-dates green-color" role="region" aria-label="<?php esc_attr_e( 'Upcoming dates', 'gobsquad' ); ?>">
    <?php get_template_part('template-parts/partials/swiper-navigation') ?>
    <div class="swiper-wrapper">
      <?php
  			$today = current_time('Ymd');
  			$args = array (
  	    'post_type' 				=> 'post',
  			'posts_per_page'		=> 20,
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
            <div class="swiper-slide">
              <?php get_template_part('template-parts/partials/date-card') ?>
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
  <div class="text-center">
    <a class="button" href="<?php the_permalink('56') ?>"><?php esc_html_e( 'View all dates', 'gobsquad' ); ?></a>
  </div>
  <?php if ( ! empty( $dates_meta_image['url'] ) ) : ?>
    <?php // Decorative background illustration. ?>
    <img class="absolute z-[-1] -bottom-[80px] left-0 w-[500px]" src="<?php echo esc_url( $dates_meta_image['url'] ); ?>" alt="" aria-hidden="true" />
  <?php endif; ?>
</section>
