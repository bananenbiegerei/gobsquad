<?php
// WP_Query arguments
$args = array(
  'page_id'                => '50',
);
// The Query
$query = new WP_Query( $args );
// The Loop
if ( $query->have_posts() ) {
  while ( $query->have_posts() ) {
    $query->the_post(); ?>
    <div class="title-image space-bottom-small">
      <a href="<?php the_permalink(); ?>">
      <?php
      $image = get_field('title_image');
      $size = 'six-columns'; // (thumbnail, medium, large, full or custom size)
      if( $image ) {
        echo wp_get_attachment_image( $image, $size );
      }
      ?>
      </a>
    </div>
    <div class="caption-container margin-bottom-1">
      <?php the_post_thumbnail('six-columns'); ?>
      <?php get_template_part('template-parts/partials/post-thumbnail-caption'); ?>
    </div>

    <?php the_excerpt(); ?>
    <a href="<?php the_permalink(); ?>" class="button">More about us</a>
  <?php }
} else {
  // no posts found
}
// Restore original Post Data
wp_reset_postdata();
?>
