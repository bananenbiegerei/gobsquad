<?php get_header();?>
<div class="mx-auto max-w-320 px-gutter-half">
	<div class="grid grid-cols-12 gap-x-gutter">
		<?php get_template_part('template-parts/page/page', 'title'); ?>
		<?php get_template_part('template-parts/page/page','content'); ?>
	</div>
	<div class="grid grid-cols-12 gap-x-gutter">
		<div class="col-span-12 sm:col-span-8 sm:col-start-3 min-w-0">
			<?php get_template_part('template-parts/block/block-loop'); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
