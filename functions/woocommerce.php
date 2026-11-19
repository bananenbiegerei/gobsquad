<?php
/**
 * WooCommerce theme integration (WC 11.x, PHP 8.5+).
 *
 * @package GobSquad
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme support for WooCommerce gallery features.
 */
add_action(
	'after_setup_theme',
	static function (): void {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
);

// Drop default WooCommerce stylesheets; theme styles live in src/assets/css/woocommerce.css.
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// Content wrappers.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'gobsquad_woocommerce_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'gobsquad_woocommerce_wrapper_end', 10 );

/**
 * Open the theme WooCommerce content wrapper.
 */
function gobsquad_woocommerce_wrapper_start(): void {
	echo '<section id="wc-container" class="mx-auto max-w-320 px-3 sm:px-4">';
}

/**
 * Close the theme WooCommerce content wrapper.
 */
function gobsquad_woocommerce_wrapper_end(): void {
	echo '</section>';
}

// Archive chrome: theme owns header/title image; hide default shop loop header.
remove_action( 'woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// Loop product title markup.
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'gobsquad_woocommerce_template_loop_product_title', 10 );

/**
 * Output the product title in the shop loop.
 */
function gobsquad_woocommerce_template_loop_product_title(): void {
	echo '<h2 class="text-h3 mt-4">' . esc_html( get_the_title() ) . '</h2>';
}

// Single product: title/meta/excerpt are rendered from content-single-product.php.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
add_action( 'woocommerce_before_single_product', 'gobsquad_woocommerce_print_notices', 10 );

/**
 * Print WooCommerce notices in a theme wrapper.
 */
function gobsquad_woocommerce_print_notices(): void {
	echo '<div class="woocommerce-notices-wrapper">';
	woocommerce_output_all_notices();
	echo '</div>';
}

/**
 * Products per page on the shop archive.
 *
 * @param int $per_page Current per-page value.
 * @return int
 */
add_filter(
	'loop_shop_per_page',
	static function ( int $per_page ): int {
		return 80;
	},
	999
);

/**
 * Archive thumbnail size.
 *
 * @param string|int[] $size Image size.
 * @return string|int[]
 */
add_filter(
	'single_product_archive_thumbnail_size',
	static function ( $size ) {
		return 'three-columns';
	}
);

/**
 * Billing phone is optional.
 *
 * @param array<string, array<string, mixed>> $fields Billing fields.
 * @return array<string, array<string, mixed>>
 */
add_filter(
	'woocommerce_billing_fields',
	static function ( array $fields ): array {
		if ( isset( $fields['billing_phone'] ) ) {
			$fields['billing_phone']['required'] = false;
		}
		return $fields;
	},
	20
);

/**
 * Remove shipping phone field when present.
 *
 * @param array<string, array<string, mixed>> $fields Shipping fields.
 * @return array<string, array<string, mixed>>
 */
add_filter(
	'woocommerce_shipping_fields',
	static function ( array $fields ): array {
		unset( $fields['shipping_phone'] );
		return $fields;
	},
	20
);
