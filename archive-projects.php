<?php
//Template Name: Archive Template for Projects
get_header(); ?>
<div class="grid-container page-background">
	<div class="grid-x grid-padding-x padding-bottom-large">
		<?php get_template_part('template-parts/page/page-title') ?>
	</div>
	<?php
		// init years array, to only insert year separator once
		$years = array();
		// filter and order by project_date meta_key
		$args = array(
			'post_type' 			=> array('projects'),
			'meta_key'	=> 'project_date',
			'orderby'	=> 'meta_value_num',
			'order'		=> 'DESC',
			'posts_per_page' => -1,
		);
		$query = new WP_Query($args);
	?>
	<?php if ($query->have_posts()) : ?>
		<?php $loopCount = 0; // initialise counter for loops ?>
		<?php while ($query->have_posts()) : $query->the_post(); ?>
			<?php ++$loopCount; // increment loop counter ?>
			<?php if (get_field('project_date')) : ?>
				<?php
					$date = get_field('project_date'); // write project_date into php date var
					$dateTime = DateTime::createFromFormat("Ymd", $date);
					if (is_object($dateTime)) :
						$month = $dateTime->format('F');
						$year = $dateTime->format('Y');
					endif;
				?>
				<?php if (!in_array($year, $years)) : // check if year is NOT in $years ?>
						<?php $years[] = $year; // add to years ?>
							<?php $hasYearImage = false; // init $hasYearImage ?>
							<?php if (have_rows('year_images_repeater', 'option')) : ?>
								<?php while (have_rows('year_images_repeater', 'option')) : the_row(); ?>
									<?php $yearImage = get_sub_field('year');?>
									<?php if ($yearImage == $year) : ?>
										<?php $hasYearImage = true; ?>
										<?php $image = get_sub_field('image'); ?>
										<?php if (!empty($image)) :
											// vars
											$url = $image['url'];
											$alt = $image['alt'];
											// thumbnail
											$size = 'two-columns';
											$thumb = $image['sizes'][$size];
										?>
										<?php if($loopCount == 1): // if 1st loop, do nothing ?>
										<?php else: // closing divs if not 1st loop ?>
											</div></div></div>
										<?php endif;?>
										<div class="grid-x grid-padding-x padding-bottom-large">
											<div class="medium-4 large-3 cell">
												<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
											</div>
											<div class="medium-8 large-9 cell">
												<div class="grid-x grid-padding-x">
										<?php endif; ?>
									<?php endif; ?>
								<?php endwhile; ?>
							<?php endif; ?>
							<?php if ($hasYearImage == false) : // show year number only when no image available ?>
								<h2><?php echo $year; ?></h2>
							<?php endif; ?>
					<?php endif; ?>
					<div class="small-6 medium-6 large-4 cell">
						<?php include(locate_template('template-parts/partials/project-card.php')); ?>
					</div>
			<?php endif; ?>
		<?php endwhile; ?>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>
<?php get_footer(); ?>
