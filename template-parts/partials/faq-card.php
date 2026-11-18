<?php $faq_id = 'faq-' . get_the_ID(); ?>
<li class="accordion-item faq-card" x-data="{ open: false }">
  <?php
  /*
   * Disclosure pattern: the heading wraps a real <button> (not an <a href="#">)
   * so it is keyboard-operable, exposes aria-expanded and has no bogus
   * navigation target (WCAG 2.1.1 / 4.1.2).
   */
  ?>
  <h3 class="accordion-heading mb-0">
    <button type="button" class="accordion-title" :class="{ 'is-active': open }"
            @click="open = !open" :aria-expanded="open.toString()"
            aria-controls="<?php echo esc_attr( $faq_id ); ?>" id="<?php echo esc_attr( $faq_id ); ?>-label">
      <?php the_title(); ?>
    </button>
  </h3>

  <div class="accordion-content" id="<?php echo esc_attr( $faq_id ); ?>" role="region"
       aria-labelledby="<?php echo esc_attr( $faq_id ); ?>-label"
       :class="{ 'is-active': open }" x-show="open" x-collapse x-cloak>
    <?php if ( have_rows('faq_videos') ): ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-gutter">
        <?php while ( have_rows('faq_videos') ) : the_row(); ?>
          <div class="mb-medium">
            <?php if( get_sub_field( 'faq_video_title' ) ) : ?>
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
