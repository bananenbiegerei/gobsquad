<?php
$gallery = get_field("gallery");
if ($gallery) : ?>
<?php
$images = get_field('gallery');
$size = 'eight-columns'; // (thumbnail, medium, large, full or custom size)
if ($images) : ?>


<div class="swiper overlay-nav project-gallery">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
      <div class="caption-container">
        <?php the_post_thumbnail('eight-columns');?>
        <?php get_template_part( 'template-parts/partials/post-thumbnail-caption' ); ?>
      </div>
    </div>
    <?php foreach ($images as $image) : ?>
      <div class="swiper-slide">
        <div class="caption-container">
        <?php echo wp_get_attachment_image( $image['ID'], $size, false, ['loading' => 'eager'] ); ?>
          <?php $caption = $image['description'] ?: $image['caption']; ?>
          <?php if ( $caption ) : ?>
            <p class="small caption"><?php echo wp_kses_post( $caption ); ?></p>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php get_template_part('template-parts/partials/swiper-navigation-overlay') ?>
</div>
<?php endif; ?>
<?php else : ?>
  <div class="fullwidth">
    <?php the_post_thumbnail(); ?>
  </div>
<?php endif;
?>
