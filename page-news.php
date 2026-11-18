<?php get_header();?>
<div class="mx-auto max-w-320 px-3 sm:px-4">
	<div class="grid grid-cols-12 gap-x-6 sm:gap-x-8">
		<?php get_template_part('template-parts/page/page-title') ?>
		<div class="col-span-12">
			<?php
	    if ( have_posts() ) {
	      while ( have_posts() ) {
	        the_post();
	        //
	        the_content();
	        //
	      } // end while
	    } // end if
	    ?>
		</div>
		<?php get_template_part('template-parts/partials/news-feeds') ?>
	</div>
</div>
<?php get_footer(); ?>
