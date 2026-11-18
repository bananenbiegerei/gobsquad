<?php get_header();?>
<div class="mx-auto max-w-320 px-gutter-half">
	<div class="grid grid-cols-12 gap-x-gutter">
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
