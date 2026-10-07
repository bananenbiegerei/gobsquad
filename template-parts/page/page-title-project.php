<?php
$value = get_field("title_image");
if ($value) : ?>
<h1 class="text-hide"><?php the_title(); ?></h1>
<?php
$image = get_field('title_image');
$size = 'full'; // (thumbnail, medium, large, full or custom size)
if ($image) : ?>
<div class="margin-bottom-2">
  <?php echo wp_get_attachment_image($image, $size); ?>
</div>
<?php endif; ?>
<?php else : ?>
  <h1 class="margin-bottom-2"><?php the_title(); ?></h1>
<?php endif;
?>
