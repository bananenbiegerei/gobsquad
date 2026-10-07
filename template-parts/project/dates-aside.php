<?php
// show upcoming dates:
// first get postID from project
$postID = get_the_ID();
$today = current_time('Ymd');
$related_dates = get_posts(array(
  'post_type' => 'post',
  'posts_per_page' => -1,
  'meta_query' => array(
    // filter to only have posts that have the project's ID as related_project post_object value
    array(
      'key' => 'related_project',
      'value' => $postID,
      'compare' => '='
    ),
    // filter out posts whose end date is older than today
    array(
      'key'						=> 'end',
      'compare'				=> '>=',
      'value'					=> $today,
    )
  ),
  // order by end date
  'meta_key'				=> 'end',
  'orderby'   			=> 'meta_value_num',
  'order'     			=> 'ASC',
));
?>
<div class="grid-x grid-margin-x">
  <?php if($related_dates):?>
    <div class="cell medium-6">
      <h3>Forthcoming Dates:</h3>
      <?php foreach($related_dates as $related_date):?>
        <div class="grid-x grid-margin-x small-up-2 medium-up-2 large-up-2 margin-bottom-1">
          <div class="cell padding-bottom-1">
            <?php $thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id($related_date->ID), array('220','220'), true );?>
            <img src="<?php echo $thumb_url[0];?> " alt=""/>
          </div>
          <div class="cell">
            <?php $date = DateTime::createFromFormat('Ymd', $related_date->end);?>
            <?php $date_start = DateTime::createFromFormat('Ymd', $related_date->start);?>
            <?php // check if start date and end date are the same
            if($date_start->format('d M Y') == ($date->format('d M Y'))):
              // show only start date
              echo '<strong>' . $date_start->format('d M Y') . '</strong>';
            else:
              // show start and end date
              echo '<strong>' . $date_start->format('d M') . '– </strong>' . '<strong>' . $date->format('d M Y') . '</strong>';
            endif;
            ?> 
            <?php $location = $related_date->location ?>
            <?php echo $location ?>,
            <?php
            $link = get_field( 'venue_or_organiser_link', $related_date->ID );
            if( $link ):
              $link_url = $link['url'];
              $link_title = $link['title'];
              $link_target = $link['target'] ? $link['target'] : '_self';
              ?>
              <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
            <?php else:?>
              <?php if(get_field('venue', $related_date->ID)):?>
                <?php echo get_field('venue', $related_date->ID);?>
              <?php endif;?>
            <?php endif; ?>                
              <?php if(get_post_field('post_content', $related_date->ID)):?>
              <div class="entry-content">
                <?php echo get_post_field('post_content', $related_date->ID);?>
              </div>
            <?php endif;?>
          </div>
        </div>
      <?php endforeach;?>
    </div>
  <?php endif;?>
  <div class="cell medium-6">
    <?php  // show past dates: ?>
    <?php
    $related_dates = get_posts(array(
      'post_type' => 'post',
      'posts_per_page' => -1,
      'meta_query' => array(
        // filter to only have posts that have the project's ID as related_project post_object value
        array(
          'key' => 'related_project',
          'value' => $postID,
          'compare' => '='
        ),
        // filter out posts whose end date is newer/equal to today
        array(
          'key'						=> 'end',
          'compare'				=> '<',
          'value'					=> $today,
        )
      ),
      // order by end date
      'meta_key'				=> 'end',
      'orderby'   			=> 'meta_value_num',
      'order'     			=> 'DESC',
    ));
    ?>
    <?php  if($related_dates):?>
      <h3>Past Dates:</h3>
      <div class="grid-x grid-margin-x small-up-1">
        <?php foreach($related_dates as $related_date):?>
          <div class="cell margin-bottom-1">
            <?php $date = DateTime::createFromFormat('Ymd', $related_date->end);?>
            <?php if(!empty($date)):?>
              <strong><?php echo $date->format('F Y');?></strong>
            <?php endif;?>
            <?php $location = $related_date->location ?>
            <?php if(!empty($date)):?>
             <?php echo $location;?>,
             <?php endif;?>
            <?php
            if(get_field('venue', $related_date->ID)):
              echo get_field('venue', $related_date->ID);
            else:
              $past_link = get_field('venue_or_organiser_link', $related_date->ID);
              if($past_link):
                $link_url = $past_link['url'];
                $link_title = $past_link['title'];
                $link_target = $past_link['target'] ? $link['target'] : '_self';
                echo esc_html( $link_title );
              endif;
            endif;
            ?>
          </div>
        <?php endforeach;?>
      </div>
    <?php endif;?>
  </div>
</div>
