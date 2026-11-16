<?php $press_item_id = uniqid(); ?>
<div class="callout" x-data="{ open: false }">
  <a href="#press-item-<?php echo esc_attr( $press_item_id ); ?>" @click.prevent="open = !open" :aria-expanded="open.toString()" aria-controls="press-item-<?php echo esc_attr( $press_item_id ); ?>"><h3><?php the_title(); ?></h3></a>
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
                      <a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( $title ); ?>" target="_blank">
                        <img src="<?php echo esc_url( $icon ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
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
