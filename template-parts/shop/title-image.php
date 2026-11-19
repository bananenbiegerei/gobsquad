<?php if( get_field( 'title_image_option','option' ) ) : ?>
  <?php
  $image = get_field('title_image_option','option');
  $size = 'full'; // (thumbnail, medium, large, full or custom size)
  if ( $image ) : ?>
    <div class="relative [&_img]:h-[160px] [&_img]:w-auto [&_img]:max-w-none">
      <?php gob_the_title_image( $image, $size, __( 'Shop', 'gobsquad' ) ); ?>
    </div>
  <?php endif;?>
<?php endif; ?>
