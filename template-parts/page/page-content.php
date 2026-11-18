<div class="page-content col-span-12 sm:col-span-8 sm:col-start-3 min-w-0">
  <?php
  if( have_rows('flexible_contents') ): ?>
    <?php while ( have_rows('flexible_contents') ) : the_row();
        if( get_row_layout() == 'gallery' ): ?>
        <?php endif;
    endwhile;
    else : ?>
    <?php
    if ( has_post_thumbnail() ) { ?>
      <div class="mb-8">
        <div class="group relative">
          <?php the_post_thumbnail('eight-columns'); ?>
          <?php get_template_part( 'template-parts/partials/post-thumbnail-caption' ); ?>
        </div>
      </div>
    <?php }
    ?>
  <?php endif;
  ?>
  <div class="bg-translucent-white">
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
