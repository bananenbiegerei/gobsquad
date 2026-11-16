<div class="card video-card">
  <div class="embed-container">
    <?php echo get_field('video_embed'); ?>
  </div>
  <div class="card-section">
    <h2><?php the_title(); ?></h2>
    <?php
    $post_object = get_field('related_project');
    if( $post_object ):
      // override $post
      $post = $post_object;
      setup_postdata( $post );
      ?>
      <p class="small m-0">related project:</p>
      <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
      <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
    <?php endif; ?>
  </div>
</div>
