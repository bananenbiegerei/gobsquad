<?php
$projects_title_image = get_field('title_image', 59);
$projects_title_image_size = 'full';
$projects_meta_image = get_field('meta_image', 59);
$projects_meta_image_size = 'full';
?>
<div class="medium-12 cell">
  <div class="text-center space-bottom-large">
    <a href="<?php the_permalink(59); ?>">
      <?php echo wp_get_attachment_image( $projects_title_image, $projects_title_image_size ); ?>
    </a>
  </div>
</div>
<?php get_template_part('template-parts/partials/news-feeds'); ?>
