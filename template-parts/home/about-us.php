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
    <div class="title-image mb-small">
      <a href="<?php the_permalink(); ?>">
      <?php
      $image = get_field('title_image');
      $size = 'six-columns'; // (thumbnail, medium, large, full or custom size)
      if( $image ) {
        // Image of the words "About Us": alt falls back to the page title (WCAG 1.1.1).
        gob_the_title_image( $image, $size, get_the_title() );
      } else {
        echo '<h2>' . esc_html( get_the_title() ) . '</h2>';
      }
      ?>
      </a>
    </div>
    <div class="caption-container mb-4">
      <?php the_post_thumbnail('six-columns'); ?>
      <?php get_template_part('template-parts/partials/post-thumbnail-caption'); ?>
    </div>

    <?php the_excerpt(); ?>
    <a href="<?php the_permalink(); ?>" class="button"><?php esc_html_e( 'More about us', 'gobsquad' ); ?></a>
  <?php }
} else {
  // no posts found
}
// Restore original Post Data
wp_reset_postdata();
?>
