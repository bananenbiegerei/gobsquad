<div class="relative flex flex-col grow mb-4 overflow-hidden text-black purple-color [&_:last-child]:mb-0">
  <?php
  /*
   * One link per card (WCAG 2.4.4 link-name): the thumbnail and the title
   * previously were two separate links to the same target, the image one
   * unnamed. The image is now decorative inside the single link, the
   * title provides the accessible name.
   */
  ?>
  <a href="<?php the_permalink(); ?>">
    <?php the_post_thumbnail( 'four-columns-four-three', array( 'alt' => '', 'aria-hidden' => 'true' ) ); ?>
    <div class="flex-[1_0_auto] py-4 px-0 [&_:last-child]:mb-0">
      <h2 class="hyphens-auto"><?php the_title(); ?></h2>
    </div>
  </a>
</div>
