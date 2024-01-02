<?php
/**
 * Helpers.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Helpers;

/**
 * Load an inline SVG.
 *
 * @param string $filename The filename of the SVG you want to load.
 *
 * @return string The content of the SVG you want to load.
 */
function svg( string $filename ): string {
	$output = '';

	// Add the path to your SVG directory inside your theme.
	$svg_path = '/assets/svg/';

	// Check the SVG file exists.
	if ( file_exists( get_stylesheet_directory() . $svg_path . $filename . '.svg' ) ) {

		// Load and return the contents of the file.
		$output = file_get_contents( get_stylesheet_directory_uri() . $svg_path . $filename . '.svg' );
	}

	// Return a blank string if we can't find the file.
	return $output;
}

/**
 * Return first if conditions match up for column count.
 *
 * @param int $i Column count as of right now.
 * @param int $columns Number of columns we are starting with.
 *
 * @return string
 */
function column_class( int $i, int $columns ): string {
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
function get_object_prefix_and_id(): string {
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
function get_taxonomy_term_prefix(): string {
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
 * @return string
 */
function get_theme_dir(): string {
	static $dir = null;

	if ( \is_null( $dir ) ) {
		$dir = \trailingslashit( \get_stylesheet_directory() );
	}

	return $dir;
}

/**
 * Returns the child theme URL.
 *
 * @return string
 */
function get_theme_url(): string {
	static $url = null;

	if ( \is_null( $url ) ) {
		$url = \trailingslashit( \get_stylesheet_directory_uri() );
	}

	return $url;
}

/**
 * Check if were on any type of singular page.
 *
 * @return bool
 */
function is_type_single(): bool {
	return \is_front_page() || \is_single() || \is_page() || \is_404() || \is_attachment() || \is_singular();
}

/**
 * Check if were on any type of archive page.
 *
 * @return bool
 */
function is_type_archive(): bool {
	return is_type_archive_page() || \is_home() || \is_post_type_archive() || \is_category() || \is_tag() || \is_tax() || \is_author() || \is_date() || \is_year() || \is_month() || \is_day() || \is_time() || \is_archive();
}

/**
 * Check if we are nay of these pages.
 *
 * @return bool
 */
function is_type_archive_page(): bool {
	return \is_page( [ 'forms', 'firings', 'techniques', 'artists' ] );
}

/**
 * Checks if current page has the hero section enabled.
 *
 * @return bool
 */
function has_hero_section(): bool {
	return \in_array( 'has-hero-section', \get_body_class(), true );
}
