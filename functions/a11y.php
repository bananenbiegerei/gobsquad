<?php
/**
 * Accessibility helpers (WCAG 2.1 AA fixes tracked in Basecamp
 * "Gob Squad a11y 2026").
 *
 * @package gobsquad
 */

/**
 * Output a "title image" (an image that stands in for a heading, e.g. the
 * hand-drawn "ABOUT US" / "DATES" lettering).
 *
 * These are images of text, so WCAG 1.1.1 requires the alt text to carry the
 * same words. Editors can still set a specific alt in the media library; when
 * that is empty we fall back to the given heading text instead of emitting an
 * empty alt (which would hide the heading from screen readers).
 *
 * @param int|string $attachment_id Attachment ID.
 * @param string     $size          Image size name.
 * @param string     $fallback_alt  Text to use when the media library alt is empty.
 * @param array      $attr          Extra attributes passed to wp_get_attachment_image().
 * @return string HTML <img> or empty string.
 */
function gob_title_image( $attachment_id, $size = 'full', $fallback_alt = '', $attr = array() ) {
	$attachment_id = (int) $attachment_id;
	if ( ! $attachment_id ) {
		return '';
	}

	$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );
	if ( '' === $alt ) {
		$alt = wp_strip_all_tags( (string) $fallback_alt );
	}
	$attr['alt'] = $alt;

	return wp_get_attachment_image( $attachment_id, $size, false, $attr );
}

/**
 * Same as gob_title_image() but echoes.
 */
function gob_the_title_image( $attachment_id, $size = 'full', $fallback_alt = '', $attr = array() ) {
	echo gob_title_image( $attachment_id, $size, $fallback_alt, $attr ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image() escapes.
}

/**
 * Accessible name for a post's featured image when the media library alt is
 * empty: fall back to the post title so card images are never unlabeled.
 * Decorative duplicates (image + text link to the same target) are handled
 * in the templates with an empty alt instead.
 */
add_filter(
	'wp_get_attachment_image_attributes',
	function ( $attr, $attachment ) {
		if ( isset( $attr['alt'] ) && '' !== trim( (string) $attr['alt'] ) ) {
			return $attr;
		}
		// Explicitly decorative (templates pass aria-hidden with an empty alt).
		if ( isset( $attr['aria-hidden'] ) ) {
			return $attr;
		}
		// Only inside the loop / a known post, and only for featured images.
		$post_id = get_the_ID();
		if ( $post_id && (int) get_post_thumbnail_id( $post_id ) === (int) $attachment->ID ) {
			$attr['alt'] = wp_strip_all_tags( get_the_title( $post_id ) );
		}
		return $attr;
	},
	10,
	2
);

/**
 * Skip link (WCAG 2.4.1 Bypass Blocks). Printed as the first focusable
 * element in <body>, targets <main id="main-content">.
 */
function gob_skip_link() {
	echo '<a class="skip-link" href="#main-content">' . esc_html__( 'Skip to main content', 'gobsquad' ) . '</a>';
}

/**
 * Shared Tailwind class strings used across templates (utility-first).
 * Keep scheme / JS hooks (button, accordion-*, menu, …) as separate classes.
 */

/** Visually hidden heading kept for a11y when a title image is shown. */
function gob_text_hide_class() {
	return 'screen-reader-text';
}

/** Small copy (was Foundation `.small`). */
function gob_small_class() {
	return 'text-xs leading-small';
}

/** Lead paragraph on excerpts (was Foundation `.lead`). */
function gob_lead_class() {
	return 'text-base leading-copy sm:text-lead';
}

/** 16:9 video / iframe wrapper. */
function gob_embed_class() {
	return 'relative pb-[56.25%] overflow-hidden max-w-full h-auto [&_iframe]:absolute [&_iframe]:inset-0 [&_iframe]:size-full [&_object]:absolute [&_object]:inset-0 [&_object]:size-full [&_embed]:absolute [&_embed]:inset-0 [&_embed]:size-full';
}

/**
 * Primary button. Keeps the `button` class so colour schemes and WooCommerce
 * can still target it; the visual styles live as utilities.
 *
 * @param string $extra Extra classes (e.g. `clear`, `hollow`, size modifiers).
 */
function gob_button_class( $extra = '' ) {
	$base = 'button inline-block align-middle m-0 py-[0.85em] px-[1em] border border-transparent rounded-none bg-[var(--scheme-text,var(--color-primary))] text-white text-sm leading-none font-bold italic uppercase text-center cursor-pointer appearance-none transition-colors duration-250 ease-out font-[inherit] hover:text-white hover:bg-[color-mix(in_srgb,var(--scheme-text,var(--color-primary))_85%,black)] focus:text-white focus:bg-[color-mix(in_srgb,var(--scheme-text,var(--color-primary))_85%,black)]';
	$extra = trim( (string) $extra );
	return $extra ? $base . ' ' . $extra : $base;
}

/** Hollow / outline button. */
function gob_button_hollow_class() {
	return gob_button_class( 'hollow relative bg-white text-[var(--scheme-text,var(--color-primary))] border-2 border-[var(--scheme-accent,var(--color-primary))] hover:bg-white focus:bg-white after:content-[\'\'] after:block after:absolute after:top-[3px] after:-left-[8px] after:w-[calc(100%_+_16px)] after:h-[calc(100%_-_6px)] after:border-2 after:border-[var(--scheme-accent,var(--color-primary))]' );
}

/** Clear / ghost button (transparent). */
function gob_button_clear_class( $extra = '' ) {
	$extra = trim( 'clear border-transparent bg-transparent text-primary hover:border-transparent hover:bg-transparent hover:text-primary focus:border-transparent focus:bg-transparent focus:text-primary ' . $extra );
	return gob_button_class( $extra );
}

/** FAQ / press callout panel. Keeps `callout` for colour-scheme border. */
function gob_callout_class() {
	return 'callout relative m-0 mb-4 p-4 border-[3px] border-[var(--scheme-accent,var(--color-primary))] rounded-none bg-white text-black [&_:first-child]:mt-0 [&_:last-child]:mb-0';
}

/** Card shell used by project / date / video cards. */
function gob_card_class( $extra = '' ) {
	$base = 'card flex flex-col grow mb-4 border-0 border-light-gray rounded-none bg-transparent shadow-none overflow-hidden text-black [&_:last-child]:mb-0';
	$extra = trim( (string) $extra );
	return $extra ? $base . ' ' . $extra : $base;
}

function gob_card_section_class() {
	return 'card-section flex-[1_0_auto] py-4 px-0 [&_:last-child]:mb-0';
}

/**
 * WooCommerce sets autocomplete="email username" on billing_email, which is
 * not a valid token combination (axe: autocomplete-valid, WCAG 1.3.5).
 */
add_filter(
	'woocommerce_billing_fields',
	function ( $fields ) {
		if ( isset( $fields['billing_email'] ) ) {
			$fields['billing_email']['autocomplete'] = 'email';
		}
		return $fields;
	},
	30
);
add_filter(
	'woocommerce_checkout_fields',
	function ( $fields ) {
		if ( isset( $fields['billing']['billing_email'] ) ) {
			$fields['billing']['billing_email']['autocomplete'] = 'email';
		}
		return $fields;
	},
	30
);

/**
 * Give the WooCommerce cart thumbnail link an accessible name
 * (axe: link-name, WCAG 2.4.4). The product name link sits in the next
 * cell, so the image link is a duplicate: label it explicitly.
 */
add_filter(
	'woocommerce_cart_item_thumbnail',
	function ( $thumbnail, $cart_item ) {
		if ( empty( $cart_item['data'] ) || ! is_a( $cart_item['data'], 'WC_Product' ) ) {
			return $thumbnail;
		}
		$name = wp_strip_all_tags( $cart_item['data']->get_name() );
		if ( false !== strpos( $thumbnail, 'alt=""' ) || false === strpos( $thumbnail, 'alt=' ) ) {
			$thumbnail = preg_replace( '/\salt=""/', '', $thumbnail );
			$thumbnail = str_replace( '<img ', '<img alt="' . esc_attr( $name ) . '" ', $thumbnail );
		}
		return $thumbnail;
	},
	10,
	2
);

/**
 * Single product gallery: the zoom link wraps an image whose alt may be
 * empty, which leaves the link unnamed (axe: link-name). Fall back to the
 * product title.
 */
add_filter(
	'woocommerce_single_product_image_thumbnail_html',
	function ( $html, $post_thumbnail_id ) {
		global $product;
		if ( ! $product ) {
			return $html;
		}
		$alt = trim( (string) get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true ) );
		if ( '' === $alt ) {
			$alt = wp_strip_all_tags( $product->get_name() );
		}
		$html = preg_replace( '/\salt=""/', ' alt="' . esc_attr( $alt ) . '"', $html );
		if ( false === strpos( $html, 'aria-label=' ) ) {
			$html = preg_replace(
				'/<a([^>]*)href="/',
				'<a$1aria-label="' . esc_attr( sprintf( /* translators: %s: product name */ __( 'View larger image of %s', 'gobsquad' ), $alt ) ) . '" href="',
				$html,
				1
			);
		}
		return $html;
	},
	10,
	2
);
