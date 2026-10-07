<?php
$projects_title_image = get_field('title_image', 106);
$projects_title_image_size = 'full';
$projects_meta_image = get_field('meta_image', 106);
$projects_meta_image_size = 'full';
?>
<section class="projects purple-color" style="background-image: url('<?php echo $projects_meta_image['url']; ?>')">
  <div class="text-center space-bottom-large">
    <a href="<?php the_permalink(106) ?>">
    <?php echo wp_get_attachment_image( $projects_title_image, $projects_title_image_size ); ?>
    </a>
  </div>
<?php

$posts = get_field('faq_selection');

if( $posts ): ?>
<ul class="accordion" data-accordion data-allow-all-closed="true">
  <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
    <?php setup_postdata($post); ?>
    <?php get_template_part('template-parts/partials/faq-card') ?>
  <?php endforeach; ?>
</ul>
<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endif; ?>

<div class="text-center">
  <a class="button" href="<?php the_permalink('106') ?>">More FAQs</a>
</div>
</section>
