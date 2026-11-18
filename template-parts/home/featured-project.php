<?php if( get_field( 'featured_project_image','option' ) ) : ?>
  <?php
  $image = get_field('featured_project_image','option');
  $size = 'full'; // (thumbnail, medium, large, full or custom size)
  if ( $image ) : ?>
    <div class="relative z-[9] [&_img]:absolute [&_img]:h-[160px] [&_img]:w-auto [&_img]:max-w-none [&_img]:-top-[70px] [&_img]:left-[5px] sm:[&_img]:-top-[60px] sm:[&_img]:-left-[45px]">
      <?php // "NOW!" lettering: image of text, alt falls back to the word. ?>
      <?php gob_the_title_image( $image, $size, __( 'Now', 'gobsquad' ) ); ?>
    </div>
  <?php endif;?>
<?php endif; ?>
<?php
$posts = get_field('choose_featured_project');
if( $posts ): ?>
<?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
  <?php setup_postdata($post); ?>
  <div class="group relative">
    <?php the_post_thumbnail('six-columns'); ?>
    <?php get_template_part('template-parts/partials/post-thumbnail-caption'); ?>
  </div>
<h2 class="mt-4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php the_excerpt(); ?>
<a href="<?php the_permalink(); ?>" class="button" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: project title */ __( 'More about %s', 'gobsquad' ), get_the_title() ) ); ?>"><?php esc_html_e( 'More', 'gobsquad' ); ?></a>
<?php endforeach; ?>
<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endif; ?>
