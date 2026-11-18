<?php
$archive_page_id = get_the_ID();
?>
<div class="col-span-12 mb-8">
  <?php
  $value = get_field( "title_image", $archive_page_id );
  if ( $value ) : ?>
    <h1 class="sr-only"><?php the_archive_title();?></h1>
    <?php
    $image = get_field('title_image', $archive_page_id);
    $size = 'full'; // (thumbnail, medium, large, full or custom size)

    if ( $image ) : ?>
      <?php /* Decorative: the visually hidden <h1> above carries the title text. */ echo wp_get_attachment_image( $image, $size, false, array( 'alt' => '', 'aria-hidden' => 'true' ) ); ?>
    <?php endif;?>
  <?php else : ?>
    <h1><?php the_archive_title();?></h1>
  <?php endif;
  ?>
  <div class="page-content mt-12">
    <?php
    while ( have_posts() ) : the_post();
      the_content();
    endwhile;
    ?>
  </div>
</div>
