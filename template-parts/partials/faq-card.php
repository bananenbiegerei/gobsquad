<li class="accordion-item faq-card" data-accordion-item>
  <!-- Accordion tab title -->
  <a href="#" class="accordion-title">
    <?php /*
    //get all the categories the post belongs to
    $categories = wp_get_post_categories( get_the_ID() );
    //loop through them
    foreach($categories as $c){
      $cat = get_category( $c );
      //get the name of the category
      $cat_id = get_cat_ID( $cat->name );
      //make a list item containing a link to the category
      echo '<label class="small">'.$cat->name.'</label>';
    }
    */ ?>
    <h3 class="margin-bottom-0"><?php the_title(); ?></h3>
  </a>

  <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
  <div class="accordion-content" data-tab-content>
    <?php if ( have_rows('faq_videos') ): ?>
      <div class="grid-x grid-margin-x block-grid small-up-1 medium-up-2 large-up-4">
        <?php while ( have_rows('faq_videos') ) : the_row(); ?>
          <div class="cell">
            <?php if( get_field( 'faq_video_title' ) ) : ?>
              <h4>
                <?php the_sub_field('faq_video_title'); ?>
              </h4>
            <?php endif; ?>
            <div class="embed-container">
              <?php the_sub_field('faq_video') ?>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</li>
