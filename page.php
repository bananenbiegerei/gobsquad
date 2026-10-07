<?php get_header();?>
<div class="grid-container">
	<div class="grid-x grid-margin-x">
		<?php get_template_part('template-parts/page/page', 'title'); ?>
		<?php get_template_part('template-parts/page/page','content'); ?>
	</div>
	<div class="grid-x grid-margin-x">
		<div class="cell medium-8 medium-offset-2">
			<?php get_template_part('template-parts/block/block-loop'); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
