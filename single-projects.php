<?php get_header(); ?>
<?php
$uniq_id = uniqid();
?>
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
    // array(
    //   'key'						=> 'end',
    //   'compare'				=> '>=',
    //   'value'					=> $today,
    // )
  ),
  // order by end date
  'meta_key'				=> 'end',
  'orderby'   			=> 'meta_value_num',
  'order'     			=> 'ASC',
));
?>
<div class="grid-container">
  <div class="grid-x grid-margin-x">
    <div class="medium-12 cell">
      <?php get_template_part('template-parts/page/page-title-project'); ?>
    </div>
    <div class="cell medium-8 medium-offset-2">
      <?php get_template_part('template-parts/partials/project-gallery'); ?>
      <ul class="tabs margin-top-2" id="example-tabs" data-responsive-accordion-tabs="tabs small-accordion medium-accordion large-tabs">
        <li class="tabs-title is-active" role="presentation">
          <a href="#panel1" aria-selected="true" role="tab" aria-controls="panel1" id="panel1-label" tabindex="0">
            <button type="button" name="button" class="button">
              Info
            </button>
          </a>
        </li>
        <?php if($related_dates):?>
          <li class="tabs-title" role="presentation">
            <a href="#panel2" role="tab" aria-controls="panel2" aria-selected="false" id="panel2-label" tabindex="-1">
              <button type="button" name="button" class="button">
                Tour Dates
              </button>
            </a>
          </li>
        <?php endif; ?>
        <?php if ( have_rows('custom_meta_infos') ): ?>
          <li class="tabs-title" role="presentation">
            <a href="#panel<?php echo $uniq_id; ?>" role="tab" aria-controls="panel<?php echo $uniq_id; ?>" aria-selected="false" id="panel<?php echo $uniq_id; ?>-label" tabindex="-1">
              <h3 class="no-space">
                <button type="button" name="button" class="button">
                  Credits
                </button>
              </h3>
            </a>
          </li>
        <?php endif; ?>
        <?php if ( have_rows( 'custom_infos' ) ) : ?>
          <?php
          $i = 0;
          ?>
          <?php while ( have_rows( 'custom_infos' ) ) : the_row(); ?>
            <li class="tabs-title" role="presentation">
              <a href="#panel-custom-info-<?php echo $i; ?>" role="tab" aria-controls="panel-custom-info-<?php echo $i; ?>" aria-selected="false" id="panel<?php echo $uniq_id; ?>-label" tabindex="-1">
                <h3 class="no-space">
                  <button type="button" name="button" class="button">
                    <?php the_sub_field( 'custom_meta_infos_title' ); ?>
                  </button>
                </h3>
              </a>
            </li>
            <?php
            $i++;
            ?>
          <?php endwhile; ?>
        <?php else : ?>
        <?php endif; ?>

        <?php if( have_rows('project_videos') ):?>
          <li class="tabs-title" role="presentation">
            <a href="#panel-video" role="tab" aria-controls="panel-video" aria-selected="false" id="panel-video-label" tabindex="-1">
              <button type="button" name="button" class="button">
                Video
              </button>
            </a>
          </li>
        <?php endif; ?>
      </ul>

      <div class="tabs-content" data-tabs-content="example-tabs">
        <div class="tabs-panel is-active" id="panel1" role="tabpanel" aria-labelledby="panel1-label">
          <?php
          if (have_posts()) {
            while (have_posts()) {
              the_post();
              the_content();
            } // end while
          } // end if
          ?>
        </div>
        <div class="tabs-panel" id="panel2" role="tabpanel" aria-labelledby="panel2-label" aria-hidden="true">
          <?php include(locate_template("template-parts/project/dates-aside.php")) ?>
        </div>
        <div class="tabs-panel" id="panel<?php echo $uniq_id; ?>" role="tabpanel" aria-labelledby="panel<?php echo $uniq_id; ?>-label" aria-hidden="true">
          <?php if (have_rows('custom_meta_infos')) : ?>
            <?php while (have_rows('custom_meta_infos')) : the_row(); ?>
              <?php
              the_sub_field('custom_meta_infos_content');
              ?>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
        
        <?php if ( have_rows( 'custom_infos' ) ) : ?>
          <?php
          $j = 0;
          ?>
          <?php while ( have_rows( 'custom_infos' ) ) : the_row(); ?>
            <div class="tabs-panel" id="panel-custom-info-<?php echo $j; ?>" role="tabpanel" aria-labelledby="panel-custom-info-<?php echo $j; ?>-label" aria-hidden="true">
              <?php the_sub_field( 'custom_meta_infos_content' ); ?>
            </div>
            <?php
            $j++;
            ?>
          <?php endwhile; ?>
        <?php else : ?>
        <?php endif; ?>
        <div class="tabs-panel" id="panel-video" role="tabpanel" aria-labelledby="panel-video-label" aria-hidden="true">
          <?php if( have_rows('project_videos') ):?>
            <?php while ( have_rows('project_videos') ) : the_row(); ?>
              <div class="embed-container margin-bottom-1">
                <?php the_sub_field('video'); ?>
              </div>
            <?php endwhile;?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
