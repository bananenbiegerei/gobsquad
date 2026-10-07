<?php $press_item_id = uniqid(); ?>
<div class="callout">
  <a data-toggle="press-item-<?php echo $press_item_id ?>"><h3><?php the_title(); ?></h3></a>
  <?php if ( have_rows('press_kit_item') ): ?>
    <ul class="no-bullet"  id="press-item-<?php echo $press_item_id ?>" data-toggler data-animate="fade-in fade-out" aria-expanded="false" style="display: none;">
      <?php while ( have_rows('press_kit_item') ) : the_row(); ?>
        <li>
          <?php if( get_sub_field( 'title' ) ) : ?>
            <hr>

          <?php endif; ?>
          <?php if ( have_rows('files') ): ?>
            <div class="grid-x grid-margin-x small-up-1 medium-up-1 large-up-2">
              <?php while ( have_rows('files') ) : the_row(); ?>
                <div class="cell">
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
                    <div class="space-bottom-xsmall padding-top-1 text-center">
                      <a href="<?php echo $url; ?>" title="<?php echo $title; ?>" target="_blank">
                        <img src="<?php echo $icon; ?>" />
                      </a>
                    </div>

                    <p class="small"><?php echo $title; ?></p>
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
