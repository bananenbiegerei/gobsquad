<?php get_header();?>
<div class="grid-container">
  <div class="grid-x grid-margin-x">
    <div class="medium-6 cell purple-color transparent-bg">
      <?php get_template_part('template-parts/home/featured-project') ?>
    </div>
    <div class="medium-6 cell fuchsia-color transparent-bg">
      <?php get_template_part('template-parts/home/about-us') ?>
    </div>
    <div class="medium-12 cell home-content padding-top-large padding-bottom-large text-center transparent-bg">
      <?php the_content(); ?>
    </div>
    <div class="medium-12 cell position-relative green-color">
      <?php get_template_part('template-parts/home/dates') ?>
    </div>
    <div class="medium-12 cell padding-top-large position-relative purple-color">
      <?php get_template_part('template-parts/home/projects') ?>
    </div>
    <?php get_template_part('template-parts/home/news') ?>
    <div class="medium-12 cell padding-top-large padding-bottom-large position-relative red-color">
      <?php get_template_part('template-parts/home/faqs') ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
