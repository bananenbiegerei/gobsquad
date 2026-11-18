<?php
$projects_title_image = get_field('title_image', 201);
$projects_title_image_size = 'full';
?>
<section class="projects purple-color pb-xxlarge relative">
  <div class="text-center mb-large">
      <a href="<?php the_permalink(201); ?>">
      <?php gob_the_title_image( $projects_title_image, $projects_title_image_size, get_the_title( 201 ) ); ?>
    </a>
  </div>

  <div class="swiper swiper-current-projects" role="region" aria-label="<?php esc_attr_e( 'Current projects', 'gobsquad' ); ?>">
    <?php get_template_part('template-parts/partials/swiper-navigation') ?>
    <div class="swiper-wrapper mt-4">
      <?php
      // WP_Query arguments
      $args = array(
        'post_type'              => array( 'projects' ),
        'meta_key'		=> 'is_current',
        'meta_value'	=> true,
        'posts_per_page' => '-1'
      );
      $query = new WP_Query( $args );
      // The Loop
      if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
          $query->the_post(); ?>
          <div class="swiper-slide">
            <?php get_template_part('template-parts/partials/project-card') ?>
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
    <a class="button" href="<?php the_permalink('201') ?>"><?php esc_html_e( 'More projects', 'gobsquad' ); ?></a>
  </div>
  <?php

  $image = get_field('meta_image', 201);

  if( ! empty( $image['url'] ) ): ?>

  <?php // Decorative background illustration. ?>
  <img class="meta-image" src="<?php echo esc_url( $image['url'] ); ?>" alt="" aria-hidden="true" />

  <?php endif; ?>
</section>
