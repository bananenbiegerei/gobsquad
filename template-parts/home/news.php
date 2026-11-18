<?php
$projects_title_image = get_field('title_image', 59);
$projects_title_image_size = 'full';
?>
<div class="col-span-12">
  <div class="text-center mb-large">
    <a href="<?php the_permalink(59); ?>">
      <?php gob_the_title_image( $projects_title_image, $projects_title_image_size, get_the_title( 59 ) ); ?>
    </a>
  </div>
</div>
<?php get_template_part('template-parts/partials/news-feeds'); ?>
