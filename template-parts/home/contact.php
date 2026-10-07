<?php
// WP_Query arguments
$args = array(
  'page_id'                => '67',
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
    <?php the_post_thumbnail(); ?>
    <a href="<?php the_permalink(); ?>"><h2 class="space-top-small text-hide"><?php the_title(); ?></h2></a>
    <?php the_content(); ?>
  <?php }
} else {
  // no posts found
}
// Restore original Post Data
wp_reset_postdata();
?>
