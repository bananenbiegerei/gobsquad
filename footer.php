</main><!-- .site-content -->
<footer id="colophon" class="site-footer mx-auto max-w-320 px-gutter-half" role="contentinfo" style="background-image:url('<?php echo esc_url( get_field('footer_background_illustration', 'option') ); ?>')">
	<nav class="pt-medium" aria-label="<?php esc_attr_e( 'Footer', 'gobsquad' ); ?>">
		<?php wp_nav_menu(array('theme_location' => 'footer', 'container' => false, 'depth' => 0, 'items_wrap' => '<ul class="menu footer-menu mb-4">%3$s</ul>', 'walker' => new insertcart_walker(array('in_top_bar' => true, 'item_type' => 'li', 'menu_type' => 'footer-menu')),)); ?>
	</nav>
	<div class="grid grid-cols-12 gap-x-gutter">
		<nav class="col-span-6 sm:col-span-8 md:col-span-9" aria-label="<?php esc_attr_e( 'Social media', 'gobsquad' ); ?>">
			<ul class="menu">
				<li>
					<a href="https://de-de.facebook.com/gobsquad/" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Gob Squad on Facebook (opens in a new tab)', 'gobsquad' ); ?>">
						<i class="fab fa-facebook-f" aria-hidden="true"></i>
					</a>
				</li>
				<?php /* <li>
					<a href="https://twitter.com/gobsquad?lang=en" target="_blank">
						<i class="fab fa-twitter"></i>
					</a>
				</li> */?>
				<li>
					<a href="https://www.instagram.com/gobsquadartscollective/" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Gob Squad on Instagram (opens in a new tab)', 'gobsquad' ); ?>">
						<i class="fab fa-instagram" aria-hidden="true"></i>
					</a>
				</li>
			</ul>
		</nav>
		<div class="col-span-6 sm:col-span-4 md:col-span-3 text-right be-berlin-logo">
		<?php if (get_field('be_berlin_image', 'option')) : ?>
			<?php
				$image = get_field('be_berlin_image', 'option');
				$size = 'four-columns'; // (thumbnail, medium, large, full or custom size)
				if ($image) : ?>
				<?php gob_the_title_image( $image, $size, __( 'Supported by the Berlin Senate Department for Culture and Social Cohesion', 'gobsquad' ) ); ?>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</div><!-- off canvas -->
</body>

</html>
