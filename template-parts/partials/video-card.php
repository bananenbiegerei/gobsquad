<div class="flex flex-col grow mb-4 overflow-hidden text-black [&_:last-child]:mb-0">
  <div class="relative aspect-video overflow-hidden max-w-full [&_iframe]:absolute [&_iframe]:inset-0 [&_iframe]:size-full [&_object]:absolute [&_object]:inset-0 [&_object]:size-full [&_embed]:absolute [&_embed]:inset-0 [&_embed]:size-full">
    <?php echo get_field('video_embed'); ?>
  </div>
  <div class="flex-[1_0_auto] py-4 px-0 [&_:last-child]:mb-0">
    <h2><?php the_title(); ?></h2>
    <?php
    $post_object = get_field('related_project');
    if( $post_object ):
      // override $post
      $post = $post_object;
      setup_postdata( $post );
      ?>
      <p class="text-xs leading-small m-0">related project:</p>
      <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
      <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
    <?php endif; ?>
  </div>
</div>
