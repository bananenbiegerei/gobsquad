<?php
/**
 * SEO titles & meta descriptions (Basecamp "C — Content measures").
 *
 * No SEO plugin is installed, so the theme provides:
 *  - an ACF field group "SEO" (title + description) on every public post
 *    type and on the shop/options page, so editors can write per-page copy,
 *  - sensible automatic fallbacks (document title pattern, description from
 *    excerpt/content, trimmed to ~155 characters),
 *  - the matching Open Graph / Twitter tags.
 *
 * @package gobsquad
 */

/**
 * Register the SEO fields (title + description) for all public post types.
 */
add_action(
	'acf/init',
	function () {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$locations = array();
		foreach ( get_post_types( array( 'public' => true ), 'names' ) as $post_type ) {
			if ( 'attachment' === $post_type ) {
				continue;
			}
			$locations[] = array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => $post_type,
				),
			);
		}

		acf_add_local_field_group(
			array(
				'key'      => 'group_gob_seo',
				'title'    => 'SEO',
				'fields'   => array(
					array(
						'key'          => 'field_gob_seo_title',
						'label'        => 'SEO title',
						'name'         => 'seo_title',
						'type'         => 'text',
						'instructions' => 'Shown in the browser tab and search results. Aim for 50–60 characters, lead with the most important keyword. Leave empty to use "Page title – Gob Squad".',
						'maxlength'    => 70,
					),
					array(
						'key'          => 'field_gob_seo_description',
						'label'        => 'Meta description',
						'name'         => 'seo_description',
						'type'         => 'textarea',
						'rows'         => 3,
						'new_lines'    => '',
						'instructions' => 'Shown under the title in search results. 120–160 characters, one or two full sentences that say what the page offers. Leave empty to use the excerpt / first paragraph.',
						'maxlength'    => 160,
					),
				),
				'location' => $locations,
				'position' => 'side',
				'style'    => 'default',
			)
		);
	}
);

/**
 * Document title: "{Page} – Gob Squad" / front page: "Gob Squad – {tagline}".
 * An editor-provided SEO title replaces the page part.
 */
add_filter( 'document_title_separator', fn() => '–' );
add_filter(
	'document_title_parts',
	function ( $parts ) {
		$site = get_bloginfo( 'name', 'display' );

		if ( is_front_page() ) {
			$custom = get_field( 'seo_title', get_option( 'page_on_front' ) );
			return array(
				'title'   => $custom ? $custom : $site,
				'tagline' => $custom ? '' : get_bloginfo( 'description', 'display' ),
			);
		}

		if ( is_singular() ) {
			$custom = get_field( 'seo_title' );
			if ( $custom ) {
				$parts['title'] = $custom;
			}
		} elseif ( is_post_type_archive() || is_home() ) {
			$custom = get_field( 'seo_title', get_queried_object_id() );
			if ( $custom ) {
				$parts['title'] = $custom;
			}
		}

		$parts['site'] = $site;
		unset( $parts['tagline'] );

		return $parts;
	}
);

/**
 * Build the best available meta description for the current request.
 *
 * @return string Plain text, <= 160 chars, or empty string.
 */
function gob_meta_description() {
	$description = '';

	if ( is_front_page() ) {
		$description = get_field( 'seo_description', get_option( 'page_on_front' ) );
		if ( ! $description ) {
			$description = get_bloginfo( 'description', 'display' );
		}
	} elseif ( is_singular() ) {
		$description = get_field( 'seo_description' );
		if ( ! $description ) {
			$post = get_queried_object();
			if ( $post ) {
				$description = has_excerpt( $post ) ? get_the_excerpt( $post ) : $post->post_content;
			}
		}
	} elseif ( is_post_type_archive() || is_home() || is_tax() || is_category() ) {
		$description = get_field( 'seo_description', get_queried_object_id() );
		if ( ! $description ) {
			$description = get_the_archive_description();
		}
	}

	$description = wp_strip_all_tags( strip_shortcodes( (string) $description ), true );
	$description = str_replace( array( '&nbsp;', "\xC2\xA0" ), ' ', $description );
	$description = preg_replace( '/\s+/u', ' ', $description );
	$description = trim( $description );

	// Last resort so no page ships without a description (e.g. archives with
	// no term description, or pages whose content is only an embed).
	if ( '' === $description ) {
		$description = get_bloginfo( 'description', 'display' );
	}

	if ( mb_strlen( $description ) > 160 ) {
		$cut         = mb_substr( $description, 0, 157 );
		$description = mb_substr( $cut, 0, mb_strrpos( $cut, ' ' ) ) . '…';
	}

	return $description;
}

/**
 * Print <meta name="description">, canonical and basic Open Graph tags.
 */
add_action(
	'wp_head',
	function () {
		$description = gob_meta_description();
		$title       = wp_get_document_title();
		$url         = is_singular() ? get_permalink() : home_url( add_query_arg( array(), $GLOBALS['wp']->request ) );

		if ( $description ) {
			echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
			echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
		}
		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta property="og:type" content="' . ( is_singular() && ! is_front_page() ? 'article' : 'website' ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
		echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">' . "\n";
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";

		if ( is_singular() && has_post_thumbnail() ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'twelve-columns' );
			if ( $image ) {
				echo '<meta property="og:image" content="' . esc_url( $image[0] ) . '">' . "\n";
			}
		}
	},
	1
);
