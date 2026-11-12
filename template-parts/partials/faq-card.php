<li class="accordion-item faq-card" x-data="{ open: false }">
  <!-- Accordion tab title -->
  <a href="#" class="accordion-title" :class="{ 'is-active': open }" @click.prevent="open = !open">
    <h3 class="mb-0"><?php the_title(); ?></h3>
  </a>

  <!-- Accordion tab content -->
  <div class="accordion-content" :class="{ 'is-active': open }" x-show="open" x-collapse>
    <?php if ( have_rows('faq_videos') ): ?>
      <div class="block-grid grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
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
