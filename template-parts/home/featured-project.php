<?php if( get_field( 'featured_project_image','option' ) ) : ?>
  <?php
  $image = get_field('featured_project_image','option');
  $size = 'full'; // (thumbnail, medium, large, full or custom size)
  if ( $image ) : ?>
    <div class="now-image-container">
      <?php echo wp_get_attachment_image( $image, $size ); ?>
    </div>
  <?php endif;?>
<?php endif; ?>
<?php
$posts = get_field('choose_featured_project');
if( $posts ): ?>
<?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
  <?php setup_postdata($post); ?>
  <div class="caption-container">
    <?php the_post_thumbnail('six-columns'); ?>
    <?php get_template_part('template-parts/partials/post-thumbnail-caption'); ?>
  </div>
<a href="<?php the_permalink(); ?>"><h2 class="space-top-small"><?php the_title(); ?></h2></a>
<?php the_excerpt(); ?>
<a href="<?php the_permalink(); ?>" class="button">More</a>
<?php endforeach; ?>
<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endif; ?>
