<?php get_header(); ?>
<div class="grid-container">
	<div class="grid-x grid-margin-x">
		<div class="medium-12 cell">
			<?php get_template_part('template-parts/page/page', 'title'); ?>
		</div>
		<div class="medium-8 medium-offset-2 cell">
			<div class="grid-x grid-margin-x">
				<div class="cell medium-6">
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
				<div class="cell medium-6">
					<?php echo get_field("faq_video"); ?>
				</div>
			</div>
			<?php
			$terms = get_field('faq_category_selection');
			if ($terms) : ?>
			<div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-3 padding-top-medium">
				<?php foreach ($terms as $term) : ?>
					<div class="cell">
						<div class="callout">
							<a href="<?php echo get_term_link($term); ?>">
								<h3 class="no-space"><?php echo $term->name; ?></h3>
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
</div>
<?php get_footer(); ?>
