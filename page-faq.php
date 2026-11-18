<?php get_header(); ?>
<div class="mx-auto max-w-320 px-gutter-half">
	<div class="grid grid-cols-12 gap-x-gutter">
		<?php get_template_part('template-parts/page/page', 'title'); ?>
		<div class="col-span-12 sm:col-span-8 sm:col-start-3 min-w-0">
			<div class="grid grid-cols-12 gap-x-gutter">
				<div class="col-span-12 sm:col-span-6">
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
				<div class="col-span-12 sm:col-span-6">
					<?php echo get_field("faq_video"); ?>
				</div>
			</div>
			<?php
			$terms = get_field('faq_category_selection');
			if ($terms) : ?>
			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-gutter pt-medium">
				<?php foreach ($terms as $term) : ?>
					<div>
						<div class="callout relative m-0 mb-4 p-4 border-[3px] border-[var(--scheme-accent,var(--color-primary))] rounded-none bg-white text-black [&_:first-child]:mt-0 [&_:last-child]:mb-0">
							<a href="<?php echo esc_url( get_term_link($term) ); ?>">
								<h3 class="m-0"><?php echo esc_html( $term->name ); ?></h3>
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
