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
 * Returns the child theme directory.
 *
 * @since 1.0.0
 *
 * @return string
 */
function get_theme_dir() {
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
function get_theme_url() {
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
	return \is_page( array( 'forms', 'firings', 'techniques', 'artists', 'report' ) );
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
