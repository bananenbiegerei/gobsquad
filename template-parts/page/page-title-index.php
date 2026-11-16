<?php
$page_id = '56';
?>
<div class="col-span-12 mb-9">
  <?php $post = get_queried_object(); ?>
  <?php
  $value = get_field( 'title_image', $page_id );
  if ( $value ) : ?>
    <h1 class="text-hide"><?php the_title(); ?></h1>
    <?php
    $image = get_field('title_image', $page_id);
    $size = 'full'; // (thumbnail, medium, large, full or custom size)

    if ( $image ) : ?>
      <?php echo wp_get_attachment_image( $image, $size ); ?>
    <?php endif;?>
  <?php else : ?>
    <h1><?php the_title(); ?></h1>
  <?php endif;
  ?>
</div>
