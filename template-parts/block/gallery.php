<section class="mb-4 md:mb-8">
  <!-- Swiper -->
  <?php

  $images = get_sub_field('gallery');
  $size = 'full'; // (thumbnail, medium, large, full or custom size)
  if( $images ):?>
  <div class="swiper overlay-nav swiper-flex group/swiper relative mt-12 mb-12">
    <div class="swiper-wrapper mb-4">
      <?php foreach( $images as $image ): ?>
        <div class="swiper-slide">
          <div class="group relative">
            <?php echo wp_get_attachment_image( $image['ID'], $size, false, ['loading' => 'eager'] ); ?>
            <?php
            get_template_part(
              'template-parts/partials/post-thumbnail-caption',
              null,
              array( 'caption' => $image['description'] )
            );
            ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php get_template_part('template-parts/partials/swiper-navigation-overlay'); ?>
  </div>
  <?php endif; ?>
</section>
