<?php
/**
 * Rosenfield Collection Theme.
 *
 * @package   RosenfieldCollection\Theme
 * @link      https://www.rosenfieldcollection.com
 * @author    Clayton Collie
 * @copyright Copyright © 2019 Clayton Collie
 * @license   GPL-2.0-or-later
 */

namespace RosenfieldCollection\Theme\Functions;

\add_filter( 'genesis_skip_links_output', __NAMESPACE__ . '\skip_links', 10, 2 );
/**
 * Change Front Page 1 title to H1.
 *
 * @since 1.5.0
 *
 * @param array $links {
 *     Default skiplinks.
 *
 *     @type string HTML ID attribute value to link to.
 *     @type string Anchor text.
 * }
 *
 * @return array
 */
function skip_links( array $links ) : array {
	if ( is_page( 'artists' ) ) {
		$links['rosenfield-collection-artist-filter'] = esc_html__( 'Skip to artist filter by last name', 'rosenfield-collection' );
	}

	if ( is_single() ) {
		$links['rosenfield-collection-object-data'] = esc_html__( 'Skip to object data', 'rosenfield-collection' );
	}

	if ( is_single() && is_user_logged_in() ) {
		$links['rosenfield-collection-admin-object-data'] = esc_html__( 'Skip to admin object data', 'rosenfield-collection' );
	}

	if ( is_search() ) {
		$links['rosenfield-collection-current-refinements'] = esc_html__( 'Skip to current refinements', 'rosenfield-collection' );
	}

	if ( is_archive() || is_home() || is_page( 'artists' ) ) {
		$links['genesis-archive-pagination'] = esc_html__( 'Skip to pagination', 'rosenfield-collection' );
	}

	$links['rosenfield-collection-footer-credits'] = esc_html__( 'Skip to footer credits', 'rosenfield-collection' );

	if ( genesis_nav_menu_supported( 'secondary' ) && has_nav_menu( 'secondary' ) ) {
		$links['genesis-nav-secondary'] = esc_html__( 'Skip to secondary navigation', 'rosenfield-collection' );
	}

	return $links;
}
