<div class="card">
  <div class="card-section">
    <?php the_post_thumbnail('four-columns-four-three'); ?>
    <h2 class="padding-top-small text-hide"><?php the_title(); ?></h2>
    <h2>
    <?php
      $post_object = get_field('related_project');
      if( $post_object ):
    ?>
      <a href="<?php echo get_permalink($post_object->ID); ?>"><?php echo get_the_title($post_object->ID); ?></a>
    <?php endif;?>
    <br />
    <?php echo get_field('location'); ?></h2>
    <?php
      $start_date = get_field('start');
      $end_date = get_field('end');
    ?>
    <?php if(get_field('start')): ?>
      <p>
        <?php echo get_field( 'start' ); ?>
        <?php if(get_field('end')&&(get_field('start')!=get_field('end'))):?>
          <?php echo '- '. get_field('end');?>
        <?php endif;?>
      </p>
    <?php endif;?>
    <?php the_content(); ?>
    <?php
      $link = get_field('venue_or_organiser_link');
      if( $link ):
        $link_url = $link['url'];
        $link_title = $link['title'];
        $link_target = $link['target'] ? $link['target'] : '_self';
        ?>
        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
    <?php endif; ?>
  </div>
</div>
