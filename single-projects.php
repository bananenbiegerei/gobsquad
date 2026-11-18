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
<div class="mx-auto max-w-320 px-gutter-half">
  <div class="grid grid-cols-12 gap-x-gutter">
    <div class="col-span-12">
      <?php get_template_part('template-parts/page/page-title-project'); ?>
    </div>
    <div class="col-span-12 sm:col-span-8 sm:col-start-3 min-w-0" x-data="projectTabs('panel1')">
      <?php get_template_part('template-parts/partials/project-gallery'); ?>
      <?php
      /*
       * WAI-ARIA tabs pattern. Each tab is a single <button role="tab"> (the
       * old markup nested a <button> inside an <a>, axe: nested-interactive).
       * Roving tabindex + Left/Right/Home/End handling lives in the
       * `projectTabs` Alpine component (src/assets/js/app.js).
       */
      ?>
      <ul class="tabs flex flex-wrap m-0 p-0 border border-transparent bg-white list-none mt-8" role="tablist" aria-label="<?php esc_attr_e( 'Project information', 'gobsquad' ); ?>" @keydown="onKeydown($event)">
        <li class="tabs-title" role="presentation" :class="{ 'is-active': activeTab === 'panel1' }">
          <button type="button" class="button" role="tab" id="panel1-label" aria-controls="panel1"
                  :aria-selected="(activeTab === 'panel1').toString()" :tabindex="activeTab === 'panel1' ? 0 : -1"
                  @click="select('panel1')"><?php esc_html_e( 'Info', 'gobsquad' ); ?></button>
        </li>
        <?php if($related_dates):?>
          <li class="tabs-title" role="presentation" :class="{ 'is-active': activeTab === 'panel2' }">
            <button type="button" class="button" role="tab" id="panel2-label" aria-controls="panel2"
                    :aria-selected="(activeTab === 'panel2').toString()" :tabindex="activeTab === 'panel2' ? 0 : -1"
                    @click="select('panel2')"><?php esc_html_e( 'Tour Dates', 'gobsquad' ); ?></button>
          </li>
        <?php endif; ?>
        <?php if ( have_rows('custom_meta_infos') ): ?>
          <li class="tabs-title" role="presentation" :class="{ 'is-active': activeTab === 'panel<?php echo $uniq_id; ?>' }">
            <button type="button" class="button" role="tab" id="panel<?php echo $uniq_id; ?>-label" aria-controls="panel<?php echo $uniq_id; ?>"
                    :aria-selected="(activeTab === 'panel<?php echo $uniq_id; ?>').toString()" :tabindex="activeTab === 'panel<?php echo $uniq_id; ?>' ? 0 : -1"
                    @click="select('panel<?php echo $uniq_id; ?>')"><?php esc_html_e( 'Credits', 'gobsquad' ); ?></button>
          </li>
        <?php endif; ?>
        <?php if ( have_rows( 'custom_infos' ) ) : ?>
          <?php
          $i = 0;
          ?>
          <?php while ( have_rows( 'custom_infos' ) ) : the_row(); ?>
            <li class="tabs-title" role="presentation" :class="{ 'is-active': activeTab === 'panel-custom-info-<?php echo $i; ?>' }">
              <button type="button" class="button" role="tab" id="panel-custom-info-<?php echo $i; ?>-label" aria-controls="panel-custom-info-<?php echo $i; ?>"
                      :aria-selected="(activeTab === 'panel-custom-info-<?php echo $i; ?>').toString()" :tabindex="activeTab === 'panel-custom-info-<?php echo $i; ?>' ? 0 : -1"
                      @click="select('panel-custom-info-<?php echo $i; ?>')"><?php the_sub_field( 'custom_meta_infos_title' ); ?></button>
            </li>
            <?php
            $i++;
            ?>
          <?php endwhile; ?>
        <?php endif; ?>

        <?php if( have_rows('project_videos') ):?>
          <li class="tabs-title" role="presentation" :class="{ 'is-active': activeTab === 'panel-video' }">
            <button type="button" class="button" role="tab" id="panel-video-label" aria-controls="panel-video"
                    :aria-selected="(activeTab === 'panel-video').toString()" :tabindex="activeTab === 'panel-video' ? 0 : -1"
                    @click="select('panel-video')"><?php esc_html_e( 'Video', 'gobsquad' ); ?></button>
          </li>
        <?php endif; ?>
      </ul>

      <div class="tabs-content border border-t-0 border-transparent bg-translucent-white text-black transition-all duration-500 ease-[ease]">
        <div class="tabs-panel py-4 px-0" :class="{ 'is-active': activeTab === 'panel1' }" x-show="activeTab === 'panel1'" id="panel1" role="tabpanel" tabindex="0" aria-labelledby="panel1-label">
          <?php
          if (have_posts()) {
            while (have_posts()) {
              the_post();
              the_content();
            } // end while
          } // end if
          ?>
        </div>
        <div class="tabs-panel py-4 px-0" :class="{ 'is-active': activeTab === 'panel2' }" x-show="activeTab === 'panel2'" id="panel2" role="tabpanel" tabindex="0" aria-labelledby="panel2-label">
          <?php include(locate_template("template-parts/project/dates-aside.php")) ?>
        </div>
        <div class="tabs-panel py-4 px-0" :class="{ 'is-active': activeTab === 'panel<?php echo $uniq_id; ?>' }" x-show="activeTab === 'panel<?php echo $uniq_id; ?>'" id="panel<?php echo $uniq_id; ?>" role="tabpanel" tabindex="0" aria-labelledby="panel<?php echo $uniq_id; ?>-label">
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
            <div class="tabs-panel py-4 px-0" :class="{ 'is-active': activeTab === 'panel-custom-info-<?php echo $j; ?>' }" x-show="activeTab === 'panel-custom-info-<?php echo $j; ?>'" id="panel-custom-info-<?php echo $j; ?>" role="tabpanel" tabindex="0" aria-labelledby="panel-custom-info-<?php echo $j; ?>-label">
              <?php the_sub_field( 'custom_meta_infos_content' ); ?>
            </div>
            <?php
            $j++;
            ?>
          <?php endwhile; ?>
        <?php else : ?>
        <?php endif; ?>
        <div class="tabs-panel py-4 px-0" :class="{ 'is-active': activeTab === 'panel-video' }" x-show="activeTab === 'panel-video'" id="panel-video" role="tabpanel" tabindex="0" aria-labelledby="panel-video-label">
          <?php if( have_rows('project_videos') ):?>
            <?php while ( have_rows('project_videos') ) : the_row(); ?>
              <div class="<?php echo esc_attr( gob_embed_class() ); ?> mb-4">
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
