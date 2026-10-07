<?php
//Template Name: Archive Template for FAQ

get_header();
?>
<div class="grid-container">
	<div class="grid-x grid-margin-x">
		<div class="cell medium-12">
			<h1 class="margin-bottom-2"><?php the_archive_title(); ?></h1>
			<ul class="accordion" data-accordion data-multi-expand="true" data-allow-all-closed="true">
				<?php
				$query = new WP_Query( array ( 'orderby' => 'date', 'order' => 'ASC' ) ); /* @BS query not working… need to sort after date and descending */
				?>
				<?php if ( $query->have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php get_template_part('template-parts/partials/faq-card') ?>
				<?php endwhile; endif; ?>
			</ul>
			<button class="button" onclick="goBack()">Back</button>

			<script>
			function goBack() {
				window.history.back();
			}
			</script>
		</div>
	</div>
</div>

<?php
get_footer();
