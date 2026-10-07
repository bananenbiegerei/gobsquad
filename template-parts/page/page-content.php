<div class="page-content medium-8 medium-offset-2 cell">
  <?php
  if( have_rows('flexible_contents') ): ?>
    <?php while ( have_rows('flexible_contents') ) : the_row();
        if( get_row_layout() == 'gallery' ): ?>
        <?php endif;
    endwhile;
    else : ?>
    <?php
    if ( has_post_thumbnail() ) { ?>
      <div class="margin-bottom-2">
        <div class="caption-container">
          <?php the_post_thumbnail('eight-columns'); ?>
          <p class="small caption"><?php echo get_post(get_post_thumbnail_id())->post_content; ?></p>
        </div>
      </div>
    <? }
    ?>
  <?php endif;
  ?>
  <div class="transparent-bg">
    <?php
    if ( have_posts() ) {
      while ( have_posts() ) {
        the_post();
        //
        the_content();
        //
      } // end while
    } // end if
    ?>
  </div>
</div>
