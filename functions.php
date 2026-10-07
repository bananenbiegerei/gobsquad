<?php
// Register scripts and stylesheets
require_once(get_template_directory().'/functions/enqueue-scripts.php');

// custom image sizes
require_once(get_template_directory().'/functions/image-sizes.php');

// Register custom menus and menu walkers
require_once(get_template_directory().'/functions/menu.php');

// Custom Posts
require_once(get_template_directory().'/functions/custom-posts.php');

// Taxonomies
require_once(get_template_directory().'/functions/custom-taxonomies.php');

// Woocommerce
require_once(get_template_directory().'/functions/woocommerce.php');

// Gutenberg
//require_once(get_template_directory().'/functions/gutenberg-blocks.php');

// Register custom features
require_once(get_template_directory().'/functions/features.php');
