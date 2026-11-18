<section class="mb-4 md:mb-8">
  <?php

  $image = get_sub_field('image');
  $size = 'eight-columns'; // (thumbnail, medium, large, full or custom size)

  if( $image ) {

  	echo wp_get_attachment_image( $image, $size );

  }

  ?>
</section>
