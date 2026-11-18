<?php if( get_field( 'title_image_option','option' ) ) : ?>
  <?php
  $image = get_field('title_image_option','option');
  $size = 'full'; // (thumbnail, medium, large, full or custom size)
  if ( $image ) : ?>
    <div class="now-image-container">
      <?php gob_the_title_image( $image, $size, __( 'Shop', 'gobsquad' ) ); ?>
    </div>
  <?php endif;?>
<?php endif; ?>
