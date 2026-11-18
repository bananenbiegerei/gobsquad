<?php
$projects_title_image = get_field('title_image', 106);
$projects_title_image_size = 'full';
$projects_meta_image = get_field('meta_image', 106);
$projects_meta_image_size = 'full';
$projects_meta_image_url = ( is_array( $projects_meta_image ) && ! empty( $projects_meta_image['url'] ) ) ? $projects_meta_image['url'] : '';
?>
<section class="projects purple-color"<?php if ( $projects_meta_image_url ) : ?> style="background-image: url('<?php echo esc_url( $projects_meta_image_url ); ?>')"<?php endif; ?>>
  <div class="text-center mb-8 md:mb-16">
    <a href="<?php the_permalink(106) ?>">
    <?php gob_the_title_image( $projects_title_image, $projects_title_image_size, get_the_title( 106 ) ); ?>
    </a>
  </div>
<?php

$posts = get_field('faq_selection');

if( $posts ): ?>
<ul class="accordion m-0 p-0 list-none bg-translucent-white">
  <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
    <?php setup_postdata($post); ?>
    <?php get_template_part('template-parts/partials/faq-card') ?>
  <?php endforeach; ?>
</ul>
<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endif; ?>

<div class="text-center">
  <a class="button" href="<?php the_permalink('106') ?>"><?php esc_html_e( 'More FAQs', 'gobsquad' ); ?></a>
</div>
</section>
