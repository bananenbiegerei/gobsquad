<?php
$value = get_field("title_image");
if ($value) : ?>
<h1 class="screen-reader-text"><?php the_title(); ?></h1>
<?php
$image = get_field('title_image');
$size = 'full'; // (thumbnail, medium, large, full or custom size)
if ($image) : ?>
<div class="mb-8">
  <?php /* Decorative: the visually hidden <h1> above carries the title text. */ echo wp_get_attachment_image( $image, $size, false, array( 'alt' => '', 'aria-hidden' => 'true' ) ); ?>
</div>
<?php endif; ?>
<?php else : ?>
  <h1 class="mb-8"><?php the_title(); ?></h1>
<?php endif;
?>
