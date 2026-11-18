<div class="relative flex flex-col grow mb-4 overflow-hidden text-black purple-color [&_:last-child]:mb-0">
  <?php
  /*
   * Stretched headline link (WCAG 2.4.4): one named link covers the card
   * via ::after so the decorative thumbnail is clickable without a second,
   * unnamed image link.
   */
  ?>
  <?php the_post_thumbnail( 'four-columns-four-three', array( 'alt' => '', 'aria-hidden' => 'true' ) ); ?>
  <div class="flex-[1_0_auto] py-4 px-0 [&_:last-child]:mb-0">
    <h2 class="hyphens-auto">
      <a href="<?php the_permalink(); ?>" class="after:absolute after:inset-0 after:z-[1] after:content-['']"><?php the_title(); ?></a>
    </h2>
  </div>
</div>
