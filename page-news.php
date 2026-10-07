<?php get_header();?>
<div class="grid-container">
	<div class="grid-x grid-margin-x">
		<?php get_template_part('template-parts/page/page-title') ?>
		<div class="cell medium-12">
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
