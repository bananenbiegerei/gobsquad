<?php
/*
 * Page title (<h1>) with optional ACF "title_image".
 *
 * Also used on archives (e.g. archive-projects.php) where there is no
 * singular post: fall back to the archive title so the <h1> is never empty.
 */
$page_id = is_singular() ? get_the_ID() : 0;
$title   = is_singular() ? get_the_title( $page_id ) : get_the_archive_title();
$image   = $page_id ? get_field( 'title_image', $page_id ) : null;
$size    = 'full'; // (thumbnail, medium, large, full or custom size)
?>
<div class="col-span-12 mb-8">
  <?php if ( $image ) : ?>
    <h1 class="text-hide"><?php echo esc_html( $title ); ?></h1>
    <?php /* Decorative: the visually hidden <h1> above carries the title text. */ echo wp_get_attachment_image( $image, $size, false, array( 'alt' => '', 'aria-hidden' => 'true' ) ); ?>
  <?php else : ?>
    <h1><?php echo esc_html( $title ); ?></h1>
  <?php endif; ?>
</div>
