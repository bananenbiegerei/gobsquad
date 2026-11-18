<?php $press_item_id = uniqid(); ?>
<div class="callout" x-data="{ open: false }">
  <?php
  /*
   * aria-expanded is only allowed on roles that support it (axe:
   * aria-allowed-attr). A plain <a> does not, so the toggle is a <button>
   * inside the heading (disclosure pattern).
   */
  ?>
  <h3><button type="button" class="press-toggle" @click="open = !open" :aria-expanded="open.toString()" aria-controls="press-item-<?php echo esc_attr( $press_item_id ); ?>"><?php the_title(); ?></button></h3>
  <?php if ( have_rows('press_kit_item') ): ?>
    <ul class="list-none m-0" id="press-item-<?php echo esc_attr( $press_item_id ); ?>" x-show="open" x-collapse x-cloak>
      <?php while ( have_rows('press_kit_item') ) : the_row(); ?>
        <li>
          <?php if( get_sub_field( 'title' ) ) : ?>
            <hr>
          <?php endif; ?>
          <?php if ( have_rows('files') ): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-gutter">
              <?php while ( have_rows('files') ) : the_row(); ?>
                <div class="min-w-0">
                  <?php
                  $file = get_sub_field('file');
                  if( $file ):
                    // vars
                    $url = $file['url'];
                    $title = $file['title'];
                    $caption = $file['caption'];
                    // icon
                    $icon = $file['icon'];
                    if( $file['type'] == 'image' ) {
                      $icon =  $file['sizes']['two-columns'];
                    }
                    ?>
                    <div class="mb-xsmall pt-4 text-center">
                      <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"
                         aria-label="<?php echo esc_attr( sprintf( /* translators: %s: file title */ __( 'Download %s (opens in a new tab)', 'gobsquad' ), $title ) ); ?>">
                        <img src="<?php echo esc_url( $icon ); ?>" alt="" aria-hidden="true" />
                      </a>
                    </div>

                    <p class="small"><?php echo esc_html( $title ); ?></p>
                  <?php endif; ?>
                </div>
              <?php endwhile; ?>
            </div>
          <?php endif; ?>
        </li>
      <?php endwhile; ?>
    </ul>
  <?php endif; ?>
</div>
