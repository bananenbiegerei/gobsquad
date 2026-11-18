<?php if( get_field( 'title_image_option','option' ) ) : ?>
  <?php
  $image = get_field('title_image_option','option');
  $size = 'full'; // (thumbnail, medium, large, full or custom size)
  if ( $image ) : ?>
    <div class="relative z-[9] [&_img]:absolute [&_img]:h-[160px] [&_img]:w-auto [&_img]:max-w-none [&_img]:-top-[70px] [&_img]:left-[5px] sm:[&_img]:-top-[60px] sm:[&_img]:-left-[45px]">
      <?php gob_the_title_image( $image, $size, __( 'Shop', 'gobsquad' ) ); ?>
    </div>
  <?php endif;?>
<?php endif; ?>
