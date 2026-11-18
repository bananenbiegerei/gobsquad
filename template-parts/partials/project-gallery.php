<?php
$gallery = get_field("gallery");
if ($gallery) : ?>
<?php
$images = get_field('gallery');
$size = 'eight-columns'; // (thumbnail, medium, large, full or custom size)
if ($images) : ?>


<div class="swiper overlay-nav project-gallery group/swiper relative">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
      <div class="group relative">
        <?php the_post_thumbnail('eight-columns');?>
        <?php get_template_part( 'template-parts/partials/post-thumbnail-caption' ); ?>
      </div>
    </div>
    <?php foreach ($images as $image) : ?>
      <div class="swiper-slide">
        <div class="group relative">
        <?php echo wp_get_attachment_image( $image['ID'], $size, false, ['loading' => 'eager'] ); ?>
          <?php
          get_template_part(
            'template-parts/partials/post-thumbnail-caption',
            null,
            array( 'caption' => $image['description'] ?: $image['caption'] )
          );
          ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php get_template_part('template-parts/partials/swiper-navigation-overlay') ?>
</div>
<?php endif; ?>
<?php else : ?>
  <div class="w-full h-auto [&_img]:w-full [&_img]:h-auto">
    <?php the_post_thumbnail(); ?>
  </div>
<?php endif;
?>
