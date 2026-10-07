<?php
$archive_page_id = get_the_ID();
echo $archive_page_id;
?>
<div class="medium-12 cell margin-bottom-2">
  <?php
  $value = get_field( "title_image", $archive_page_id );
  if ( $value ) : ?>
    <h1 class="text-hide"><?php the_archive_title();?></h1>
    <?php
    $image = get_field('title_image', $archive_page_id);
    $size = 'full'; // (thumbnail, medium, large, full or custom size)

    if ( $image ) : ?>
      <?php echo wp_get_attachment_image( $image, $size ); ?>
    <?php endif;?>
  <?php else : ?>
    <h1><?php the_archive_title();?></h1>
  <?php endif;
  ?>
  <div class="page-content margin-top-3">
    <?php
    while ( have_posts() ) : the_post();
      the_content();
    endwhile;
    ?>
  </div>
</div>
