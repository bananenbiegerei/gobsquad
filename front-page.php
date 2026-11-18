<?php get_header();?>
<div class="mx-auto max-w-320 px-gutter-half">
  <h1 class="sr-only"><?php echo esc_html( get_bloginfo( 'name' ) ); ?> – <?php echo esc_html( get_bloginfo( 'description' ) ); ?></h1>
  <div class="grid grid-cols-12 gap-x-gutter">
    <div class="col-span-12 sm:col-span-6 purple-color bg-translucent-white">
      <?php get_template_part('template-parts/home/featured-project') ?>
    </div>
    <div class="col-span-12 sm:col-span-6 fuchsia-color bg-translucent-white">
      <?php get_template_part('template-parts/home/about-us') ?>
    </div>
    <div class="col-span-12 pt-large pb-large text-center bg-translucent-white">
      <?php the_content(); ?>
    </div>
    <div class="col-span-12 min-w-0 relative green-color">
      <?php get_template_part('template-parts/home/dates') ?>
    </div>
    <div class="col-span-12 min-w-0 pt-large relative purple-color">
      <?php get_template_part('template-parts/home/projects') ?>
    </div>
    <?php //get_template_part('template-parts/home/news') ?>
    <div class="col-span-12 pt-large pb-large relative red-color">
      <?php get_template_part('template-parts/home/faqs') ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
