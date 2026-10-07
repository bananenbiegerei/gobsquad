<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<?php get_template_part('head') ?>
<!-- Default -->
<?php
$page_background_image = get_field('background_image');
$page_background_size = 'full';
$page_background_url = $page_background_image['url'];
?>
<!-- Press -->
<?php
$page_background_image_press = get_field('background_image', 64);
$page_background_size_press = 'full';
$page_background_url_press = $page_background_image_press['url'];
?>
<!-- Index -->
<?php
$page_background_image_blog = get_field('background_image', 56);
$page_background_size_blog = 'full';
$page_background_url_blog = $page_background_image_blog['url'];
?>
<!-- Shop -->
<?php
$page_background_image_shop = get_field('background_image','option');
$page_background_size_shop = 'full';
$page_background_url_shop = $page_background_image_shop['url'];
?>
<?php if(is_woocommerce()): ?>
	<body <?php body_class('page-background-image'); ?> style="background-image: url('<?php echo $page_background_url_shop; ?>')">
<?php elseif(is_blog()): ?>
	<body <?php body_class('page-background-image'); ?> style="background-image: url('<?php echo $page_background_url_blog; ?>')">
<?php elseif(is_archive('press')): ?>
		<body <?php body_class('page-background-image'); ?> style="background-image: url('<?php echo $page_background_url_press; ?>')">
<?php else: // if neither blog or woocommerce ?>
	<body <?php body_class('page-background-image'); ?> style="background-image: url('<?php echo $page_background_url; ?>')">
<?php endif ?>
	<div class="off-canvas-content" data-off-canvas-content>
	<?php get_template_part('template-parts/partials/header-desktop'); ?>
	<?php get_template_part('template-parts/partials/header-mobile'); ?>
<main id="main-content" class="main-content">
