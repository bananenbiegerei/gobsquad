<?php get_header();?>
<div class="grid-container">
	<div class="grid-x grid-margin-x">
		<div class="medium-12 cell">
		  <?php $post = get_queried_object(); ?>
		  <?php
		  $value = get_field( 'title_image', '2991' );
		  if ( $value ) : ?>
		    <h1 class="text-hide"><?php the_title(); ?></h1>
		    <?php
		    $image = get_field('title_image', '2991');
		    $size = 'full'; // (thumbnail, medium, large, full or custom size)

		    if ( $image ) : ?>
		      <?php echo wp_get_attachment_image( $image, $size ); ?>
		    <?php endif;?>
		  <?php else : ?>
		    <h1><?php the_title(); ?></h1>
		  <?php endif;
		  ?>
		</div>
		<div class="medium-8 cell">
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
			<div id="mc_embed_signup margin-top-2 margin-bottom-2">
				<form action="https://gobsquad.us5.list-manage.com/subscribe/post?u=ba8aa97d0616b568bde5fe98f&amp;id=b604a4e92a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					<div id="mc_embed_signup_scroll">
						<h2>Subscribe</h2>
						<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
						<div class="mc-field-group">
							<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
							</label>
							<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
						</div>
						<div class="mc-field-group">
							<label for="mce-FNAME">First Name  <span class="asterisk">*</span>
							</label>
							<input type="text" value="" name="FNAME" class="required" id="mce-FNAME">
						</div>
						<div class="mc-field-group">
							<label for="mce-LNAME">Last Name  <span class="asterisk">*</span>
							</label>
							<input type="text" value="" name="LNAME" class="required" id="mce-LNAME">
						</div>
						<div id="mce-responses" class="clear">
							<div class="response" id="mce-error-response" style="display:none"></div>
							<div class="response" id="mce-success-response" style="display:none"></div>
						</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
						<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_ba8aa97d0616b568bde5fe98f_b604a4e92a" tabindex="-1" value=""></div>
						<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
					</div>
				</form>
			</div>
			<p class="small margin-top-2">
				By clicking 'Subscribe' and confirming your mail address, you consent to receiving our newsletter via email, informing you about events and news from Gob Squad. You can revoke this at any time. Please find detailed information on the data we gather by sending you the newsletter in <a href="https://www.gobsquad.com/privacy-policy-2/">our privacy policy.</a>
			</p>
			<!--End mc_embed_signup-->
		</div>
	</div>
</div>
<?php get_footer(); ?>
