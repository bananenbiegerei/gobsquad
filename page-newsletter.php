<?php get_header();?>
<div class="mx-auto max-w-320 px-gutter-half">
	<div class="grid grid-cols-12 gap-x-gutter">
		<div class="col-span-12">
		  <?php $post = get_queried_object(); ?>
		  <?php
		  $value = get_field( 'title_image', '2991' );
		  if ( $value ) : ?>
		    <h1 class="sr-only"><?php the_title(); ?></h1>
		    <?php
		    $image = get_field('title_image', '2991');
		    $size = 'full'; // (thumbnail, medium, large, full or custom size)

		    if ( $image ) : ?>
		      <?php /* Decorative: the visually hidden <h1> above carries the title text. */ echo wp_get_attachment_image( $image, $size, false, array( 'alt' => '', 'aria-hidden' => 'true' ) ); ?>
		    <?php endif;?>
		  <?php else : ?>
		    <h1><?php the_title(); ?></h1>
		  <?php endif;
		  ?>
		</div>
		<div class="col-span-12 sm:col-span-8">
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
			<!-- Begin Mailchimp Signup Form -->
			<div id="mc_embed_signup" class="mt-8 mb-8">
				<form action="https://gobsquad.us5.list-manage.com/subscribe/post?u=ba8aa97d0616b568bde5fe98f&amp;id=b604a4e92a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" aria-labelledby="newsletter-heading" aria-describedby="newsletter-privacy">
					<div id="mc_embed_signup_scroll">
						<h2 id="newsletter-heading"><?php esc_html_e( 'Subscribe to the Gob Squad newsletter', 'gobsquad' ); ?></h2>
						<p id="newsletter-intro"><?php esc_html_e( 'Get tour dates, new projects and workshop news a few times a year. No spam, unsubscribe any time.', 'gobsquad' ); ?></p>
						<p class="indicates-required text-xs leading-small"><?php esc_html_e( 'All fields are required.', 'gobsquad' ); ?></p>
						<div class="mc-field-group">
							<label for="mce-EMAIL"><?php esc_html_e( 'Email address', 'gobsquad' ); ?> <span class="required-mark" aria-hidden="true">*</span></label>
							<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" required aria-required="true" autocomplete="email" inputmode="email" placeholder="<?php esc_attr_e( 'e.g. name@example.com', 'gobsquad' ); ?>" aria-describedby="mce-EMAIL-hint">
							<span id="mce-EMAIL-hint" class="field-hint text-xs leading-small"><?php esc_html_e( 'We will send a confirmation email to this address.', 'gobsquad' ); ?></span>
						</div>
						<div class="mc-field-group">
							<label for="mce-FNAME"><?php esc_html_e( 'First name', 'gobsquad' ); ?> <span class="required-mark" aria-hidden="true">*</span></label>
							<input type="text" value="" name="FNAME" class="required" id="mce-FNAME" required aria-required="true" autocomplete="given-name" placeholder="<?php esc_attr_e( 'e.g. Sarah', 'gobsquad' ); ?>">
						</div>
						<div class="mc-field-group">
							<label for="mce-LNAME"><?php esc_html_e( 'Last name', 'gobsquad' ); ?> <span class="required-mark" aria-hidden="true">*</span></label>
							<input type="text" value="" name="LNAME" class="required" id="mce-LNAME" required aria-required="true" autocomplete="family-name" placeholder="<?php esc_attr_e( 'e.g. Thom', 'gobsquad' ); ?>">
						</div>
						<div id="mce-responses" class="clear" aria-live="polite">
							<div class="response" id="mce-error-response" style="display:none"></div>
							<div class="response" id="mce-success-response" style="display:none"></div>
						</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
						<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_ba8aa97d0616b568bde5fe98f_b604a4e92a" tabindex="-1" value="" autocomplete="off"></div>
						<div class="clear"><button type="submit" name="subscribe" id="mc-embedded-subscribe" class="button"><?php esc_html_e( 'Subscribe to the newsletter', 'gobsquad' ); ?></button></div>
						<p class="text-xs leading-small mt-4" id="newsletter-privacy">
							<?php
							printf(
								/* translators: %s: link to the privacy policy */
								esc_html__( 'By subscribing and confirming your email address you agree to receive our newsletter about Gob Squad events and news. You can unsubscribe at any time via the link in every email. Details on how we handle your data are in %s.', 'gobsquad' ),
								'<a href="' . esc_url( home_url( '/privacy-policy-2/' ) ) . '">' . esc_html__( 'our privacy policy', 'gobsquad' ) . '</a>'
							);
							?>
						</p>
					</div>
				</form>
			</div>
			<!--End mc_embed_signup-->
		</div>
	</div>
</div>
<?php get_footer(); ?>
