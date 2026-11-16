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
<div class="mx-auto max-w-360 px-gutter-half">
  <div class="grid grid-cols-12 gap-x-gutter">
    <div class="col-span-12">
      <?php get_template_part('template-parts/page/page-title-project'); ?>
    </div>
    <div class="col-span-12 sm:col-span-8 sm:col-start-3 min-w-0" x-data="{ activeTab: 'panel1' }">
      <?php get_template_part('template-parts/partials/project-gallery'); ?>
      <ul class="tabs mt-9" id="example-tabs">
        <li class="tabs-title" role="presentation" :class="{ 'is-active': activeTab === 'panel1' }">
          <a href="#panel1" role="tab" aria-controls="panel1" id="panel1-label" @click.prevent="activeTab = 'panel1'">
            <button type="button" name="button" class="button">
              Info
            </button>
          </a>
        </li>
        <?php if($related_dates):?>
          <li class="tabs-title" role="presentation" :class="{ 'is-active': activeTab === 'panel2' }">
            <a href="#panel2" role="tab" aria-controls="panel2" id="panel2-label" @click.prevent="activeTab = 'panel2'">
              <button type="button" name="button" class="button">
                Tour Dates
              </button>
            </a>
          </li>
        <?php endif; ?>
        <?php if ( have_rows('custom_meta_infos') ): ?>
          <li class="tabs-title" role="presentation" :class="{ 'is-active': activeTab === 'panel<?php echo $uniq_id; ?>' }">
            <a href="#panel<?php echo $uniq_id; ?>" role="tab" aria-controls="panel<?php echo $uniq_id; ?>" id="panel<?php echo $uniq_id; ?>-label" @click.prevent="activeTab = 'panel<?php echo $uniq_id; ?>'">
              <h3 class="m-0">
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
            <li class="tabs-title" role="presentation" :class="{ 'is-active': activeTab === 'panel-custom-info-<?php echo $i; ?>' }">
              <a href="#panel-custom-info-<?php echo $i; ?>" role="tab" aria-controls="panel-custom-info-<?php echo $i; ?>" id="panel<?php echo $uniq_id; ?>-label" @click.prevent="activeTab = 'panel-custom-info-<?php echo $i; ?>'">
                <h3 class="m-0">
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
          <li class="tabs-title" role="presentation" :class="{ 'is-active': activeTab === 'panel-video' }">
            <a href="#panel-video" role="tab" aria-controls="panel-video" id="panel-video-label" @click.prevent="activeTab = 'panel-video'">
              <button type="button" name="button" class="button">
                Video
              </button>
            </a>
          </li>
        <?php endif; ?>
      </ul>

      <div class="tabs-content">
        <div class="tabs-panel" :class="{ 'is-active': activeTab === 'panel1' }" x-show="activeTab === 'panel1'" id="panel1" role="tabpanel" aria-labelledby="panel1-label">
          <?php
          if (have_posts()) {
            while (have_posts()) {
              the_post();
              the_content();
            } // end while
          } // end if
          ?>
        </div>
        <div class="tabs-panel" :class="{ 'is-active': activeTab === 'panel2' }" x-show="activeTab === 'panel2'" id="panel2" role="tabpanel" aria-labelledby="panel2-label">
          <?php include(locate_template("template-parts/project/dates-aside.php")) ?>
        </div>
        <div class="tabs-panel" :class="{ 'is-active': activeTab === 'panel<?php echo $uniq_id; ?>' }" x-show="activeTab === 'panel<?php echo $uniq_id; ?>'" id="panel<?php echo $uniq_id; ?>" role="tabpanel" aria-labelledby="panel<?php echo $uniq_id; ?>-label">
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
            <div class="tabs-panel" :class="{ 'is-active': activeTab === 'panel-custom-info-<?php echo $j; ?>' }" x-show="activeTab === 'panel-custom-info-<?php echo $j; ?>'" id="panel-custom-info-<?php echo $j; ?>" role="tabpanel" aria-labelledby="panel-custom-info-<?php echo $j; ?>-label">
              <?php the_sub_field( 'custom_meta_infos_content' ); ?>
            </div>
            <?php
            $j++;
            ?>
          <?php endwhile; ?>
        <?php else : ?>
        <?php endif; ?>
        <div class="tabs-panel" :class="{ 'is-active': activeTab === 'panel-video' }" x-show="activeTab === 'panel-video'" id="panel-video" role="tabpanel" aria-labelledby="panel-video-label">
          <?php if( have_rows('project_videos') ):?>
            <?php while ( have_rows('project_videos') ) : the_row(); ?>
              <div class="embed-container mb-4">
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
