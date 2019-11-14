<?php
/**
 * Genesis Starter Theme.
 *
 * @package   SeoThemes\GenesisStarterTheme
 * @link      https://genesisstartertheme.com
 * @author    SEO Themes
 * @copyright Copyright © 2019 SEO Themes
 * @license   GPL-2.0-or-later
 */

namespace SeoThemes\GenesisStarterTheme\Structure;

// Reposition primary nav.
\remove_action( 'genesis_after_header', 'genesis_do_nav' );
\add_action( 'genesis_after_title_area', 'genesis_do_nav' );

// Reposition secondary nav.
\remove_action( 'genesis_after_header', 'genesis_do_subnav' );

\add_filter( 'wp_nav_menu_args', __NAMESPACE__ . '\limit_menu_depth' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 1.0.0
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function limit_menu_depth( array $args ) : array {
	$args['depth'] = 1;
	return $args;
}
