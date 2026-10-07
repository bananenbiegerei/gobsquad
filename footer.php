</main><!-- .site-content -->
<footer id="colophon" class="site-footer grid-container" role="contentinfo" style="background-image:url('<?php echo get_field('footer_background_illustration', 'option'); ?>')">
	<div class="grid-x grid-margin-x padding-top-medium">
		<div class="cell shrink">
			<?php wp_nav_menu(array('theme_location' => 'footer', 'container' => false, 'depth' => 0, 'items_wrap' => '<ul class="menu footer-menu margin-bottom-1">%3$s</ul>', 'walker' => new insertcart_walker(array('in_top_bar' => true, 'item_type' => 'li', 'menu_type' => 'footer-menu')),)); ?>
		</div>		
	</div>
	<div class="grid-x grid-margin-x">
		<div class="cell small-6 medium-8 large-9">
			<ul class="menu horizontal">
				<li>
					<a href="https://de-de.facebook.com/gobsquad/" target="_blank">
						<i class="fab fa-facebook-f"></i>
					</a>
				</li>
				<?php /* <li>
					<a href="https://twitter.com/gobsquad?lang=en" target="_blank">
						<i class="fab fa-twitter"></i>
					</a>
				</li> */?>
				<li>
					<a href="https://www.instagram.com/gobsquadartscollective/" target="_blank">
						<i class="fab fa-instagram"></i>
					</a>
				</li>
			</ul>
		</div>
		<div class="cell small-6 medium-3 large-2 auto text-right be-berlin-logo">
		<?php if (get_field('be_berlin_image', 'option')) : ?>
			<?php
				$image = get_field('be_berlin_image', 'option');
				$size = 'four-columns'; // (thumbnail, medium, large, full or custom size)
				if ($image) : ?>
				<?php echo wp_get_attachment_image($image, $size); ?>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</div><!-- off canvas -->
</body>

</html>
