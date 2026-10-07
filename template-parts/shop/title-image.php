<?php if( get_field( 'title_image_option','option' ) ) : ?>
  <?php
  $image = get_field('title_image_option','option');
  $size = 'full'; // (thumbnail, medium, large, full or custom size)
  if ( $image ) : ?>
    <div class="now-image-container">
      <?php echo wp_get_attachment_image( $image, $size ); ?>
    </div>
  <?php endif;?>
<?php endif; ?>
