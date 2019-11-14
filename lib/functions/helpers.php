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
function is_type_single() {
	return \is_front_page() || \is_single() || \is_page() || \is_404() || \is_attachment() || \is_singular();
}

/**
 * Check if were on any type of archive page.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function is_type_archive() {
	return \is_home() || \is_post_type_archive() || \is_category() || \is_tag() || \is_tax() || \is_author() || \is_date() || \is_year() || \is_month() || \is_day() || \is_time() || \is_archive() || \is_search();
}

/**
 * Checks if current page has the hero section enabled.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function has_hero_section() {
	return \in_array( 'has-hero-section', \get_body_class(), true );
}
