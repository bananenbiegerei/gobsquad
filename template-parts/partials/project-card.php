<div class="card project-card purple-color">
  <?php
  /*
   * One link per card (WCAG 2.4.4 link-name): the thumbnail and the title
   * previously were two separate links to the same target, the image one
   * unnamed. The image is now decorative inside the single link, the
   * title provides the accessible name.
   */
  ?>
  <a href="<?php the_permalink(); ?>" class="project-card-link">
    <?php the_post_thumbnail( 'four-columns-four-three', array( 'alt' => '', 'aria-hidden' => 'true' ) ); ?>
    <div class="card-section">
      <h2><?php the_title(); ?></h2>
    </div>
  </a>
</div>
