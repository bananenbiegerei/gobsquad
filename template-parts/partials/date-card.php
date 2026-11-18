<?php
$post_object = get_field('related_project');
$location    = get_field('location');
$start_date  = get_field('start');
$end_date    = get_field('end');
?>
<div class="flex flex-col grow mb-4 overflow-hidden text-black [&_:last-child]:mb-0">
  <div class="flex-[1_0_auto] py-4 px-0 [&_:last-child]:mb-0">
    <?php the_post_thumbnail('four-columns-four-three'); ?>
    <h2 class="pt-small sr-only"><?php the_title(); ?></h2>
    <h2>
    <?php if( $post_object ): ?>
      <a href="<?php echo esc_url( get_permalink($post_object->ID) ); ?>"
         aria-label="<?php echo esc_attr( sprintf( /* translators: 1: project title, 2: location */ __( '%1$s in %2$s – project page', 'gobsquad' ), get_the_title($post_object->ID), $location ) ); ?>"><?php echo esc_html( get_the_title($post_object->ID) ); ?></a>
    <?php endif;?>
    <br />
    <?php echo esc_html( $location ); ?></h2>
    <?php if( $start_date ): ?>
      <p>
        <?php echo esc_html( $start_date ); ?>
        <?php if( $end_date && ( $start_date != $end_date ) ):?>
          <?php echo '- ' . esc_html( $end_date );?>
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
        $new_tab = ( '_blank' === $link_target );
        ?>
        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"<?php if ( $new_tab ) : ?> rel="noopener"<?php endif; ?>
           aria-label="<?php echo esc_attr( $link_title . ( $new_tab ? ' (' . __( 'opens in a new tab', 'gobsquad' ) . ')' : '' ) ); ?>"><?php echo esc_html($link_title); ?></a>
    <?php endif; ?>
  </div>
</div>
