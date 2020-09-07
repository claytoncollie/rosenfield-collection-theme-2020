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

use function RosenfieldCollection\Theme2020\Functions\svg as svg;

\add_action( 'genesis_after_title_area', __NAMESPACE__ . '\do_header_search_form', 12 );
/**
 * Outputs the header search form.
 *
 * @since 1.0.0
 */
function do_header_search_form() {
	$button = sprintf(
		'<a href="#" role="button" aria-expanded="false" aria-controls="header-search-wrap" class="toggle-header-search close"><span class="screen-reader-text">%s</span>%s</a>',
		__( 'Hide Search', 'rosenfield-collection-2020' ),
		svg( 'times-solid' )
	);

	printf(
		'<div id="header-search-wrap" class="header-search-wrap">%s %s</div>',
		get_search_form( false ),
		$button // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}

\add_filter( 'genesis_nav_items', __NAMESPACE__ . '\add_search_menu_item', 10, 2 );
\add_filter( 'wp_nav_menu_items', __NAMESPACE__ . '\add_search_menu_item', 10, 2 );
/**
 * Modifies the menu item output of the header menu.
 *
 * @since 1.0.0
 *
 * @param string $items The menu HTML.
 * @param object $args The menu options.
 * @return string Updated menu HTML.
 */
function add_search_menu_item( string $items, object $args ) : string {
	$search_toggle = sprintf( '<li class="menu-item search-lg">%s</li>', get_header_search_toggle() );
	$search_mobile = sprintf(
		'<li class="menu-item search-m"><a href="%s">%s</a></li>',
		esc_url( add_query_arg( 's', '', get_bloginfo( 'url' ) ) ),
		esc_html__( 'Search', 'rosenfield-collection-2020' )
	);

	if ( 'primary' === $args->theme_location ) {
		$items .= $search_toggle . $search_mobile;
	}

	return $items;
}

/**
 * Outputs the header search form toggle button.
 *
 * @return string HTML output of the Show Search button.
 *
 * @since 1.0.0
 */
function get_header_search_toggle() : string {
	return sprintf(
		'<a href="#header-search-wrap" aria-controls="header-search-wrap" aria-expanded="false" role="button" class="toggle-header-search"><span class="screen-reader-text">%s</span>%s</a>',
		__( 'Show Search', 'rosenfield-collection-2020' ),
		svg( 'search-solid' )
	);
}
