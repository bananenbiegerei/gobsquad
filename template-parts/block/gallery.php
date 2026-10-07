<section class="block">
  <!-- Swiper -->
  <?php

  $images = get_sub_field('gallery');
  $size = 'full'; // (thumbnail, medium, large, full or custom size)
  if( $images ):?>
  <div class="swiper-container overlay-nav swiper-flex margin-top-3 margin-bottom-3">
    <div class="swiper-wrapper margin-bottom-1">
      <?php foreach( $images as $image ): ?>
        <div class="swiper-slide">
          <div class="caption-container">
            <?php echo wp_get_attachment_image( $image['ID'], $size, false, ['loading' => 'eager'] ); ?>
            <p class="small caption"><?php echo $image['description']; ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php get_template_part('template-parts/partials/swiper-navigation-overlay'); ?>
  </div>
  <?php endif; ?>
</section>
