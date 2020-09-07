<?php
/**
 * Rosenfield Collection Theme.
 *
 * @package   RosenfieldCollection\Theme2020
 * @link      https://www.rosenfieldcollection.com
 * @author    Clayton Collie
 * @copyright Copyright © 2019 Clayton Collie
 * @license   GPL-2.0-or-later
 */

namespace RosenfieldCollection\Theme2020\Functions;

/**
* Load an inline SVG.
*
* @param string $filename The filename of the SVG you want to load.
*
* @return string The content of the SVG you want to load.
*
* @since 1.4.0
*/
function svg( string $filename ) : string {

	$output = '';
 
    // Add the path to your SVG directory inside your theme.
    $svg_path = '/assets/svg/';
 
    // Check the SVG file exists
    if ( file_exists( get_stylesheet_directory() . $svg_path . $filename . '.svg' ) ) {
 
        // Load and return the contents of the file
        $output = file_get_contents( get_stylesheet_directory_uri() . $svg_path . $filename . '.svg' );
    }

    // Return a blank string if we can't find the file.
    return $output;
}

/**
 * Returns the admin-pricing field with proper wrapping
 *
 * @param string $label Field Label.
 * @param string $content Content.
 *
 * @return string
 *
 * @since 1.0.0
 */
function admin_pricing( string $label, string $content ) : string {
	return sprintf(
		'<section class="admin-pricing"><h3 class="admin-pricing-content">%s</h3><span class="admin-pricing-label">%s</span></section>',
		wp_kses_post( $content ),
		esc_html( $label )
	);
}

/**
 * Return first if conditions match up for column count.
 *
 * @param integer $i Column count as of right now.
 * @param integer $columns Number of columns we are starting with.
 *
 * @return string
 */
function column_class( int $i, int $columns ) : string {
	if ( 0 === $i || 0 === $i % $columns ) {
		return 'first';
	} else {
		return '';
	}
}
/**
 * Get the object prefix and ID.
 *
 * @return string
 */
function get_object_prefix_and_id() : string {
	$output = '';
	$prefix = get_taxonomy_term_prefix();
	$id     = get_field( 'object_id' );

	if ( ! empty( $id ) && ! empty( $prefix ) ) {
		$output = $prefix . $id;
	}

	return $output;
}

/**
 * Get the taxonomy term prefix
 *
 * @return string
 */
function get_taxonomy_term_prefix() : string {
	$prefix = '';
	$terms  = get_the_terms( get_the_ID(), 'rc_form' );

	if ( ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			$term_id = $term->term_id;
		}
	}

	if ( ! empty( $term_id ) ) {
		$prefix = get_term_meta( $term_id, 'rc_form_object_prefix', true );
	}

	return $prefix;
}

/**
 * Returns the child theme directory.
 *
 * @since 1.0.0
 *
 * @return string
 */
function get_theme_dir() : string {
	static $dir = null;

	if ( \is_null( $dir ) ) {
		$dir = \trailingslashit( \get_stylesheet_directory() );
	}

	return $dir;
}

/**
 * Returns the child theme URL.
 *
 * @since 1.0.0
 *
 * @return string
 */
function get_theme_url() : string {
	static $url = null;

	if ( \is_null( $url ) ) {
		$url = \trailingslashit( \get_stylesheet_directory_uri() );
	}

	return $url;
}

/**
 * Check if were on any type of singular page.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function is_type_single() : bool {
	return \is_front_page() || \is_single() || \is_page() || \is_404() || \is_attachment() || \is_singular();
}

/**
 * Check if were on any type of archive page.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function is_type_archive() : bool {
	return is_type_archive_page() || \is_home() || \is_post_type_archive() || \is_category() || \is_tag() || \is_tax() || \is_author() || \is_date() || \is_year() || \is_month() || \is_day() || \is_time() || \is_archive();
}

/**
 * Check if we are nay of these pages.
 *
 * @since 1.4.0
 *
 * @return bool
 */
function is_type_archive_page() : bool {
	return \is_page( array( 'forms', 'firings', 'techniques', 'artists' ) );
}

/**
 * Checks if current page has the hero section enabled.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function has_hero_section() : bool {
	return \in_array( 'has-hero-section', \get_body_class(), true );
}
