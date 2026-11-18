<?php
// Register scripts and stylesheets (Vite dev-server / manifest build)
require_once(get_template_directory().'/functions/vite.php');

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

// Accessibility helpers (skip link, alt fallbacks, WooCommerce a11y filters)
require_once(get_template_directory().'/functions/a11y.php');

// SEO titles, meta descriptions, Open Graph
require_once(get_template_directory().'/functions/seo.php');
