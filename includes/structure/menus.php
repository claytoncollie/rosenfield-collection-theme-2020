<?php
/**
 * Menus.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Menus;

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	add_filter( 'wp_nav_menu_args', __NAMESPACE__ . '\limit_menu_depth' );
	// Reposition primary nav.
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_after_title_area', 'genesis_do_nav' );
	// Remove secondary nav.
	remove_action( 'genesis_after_header', 'genesis_do_subnav' );
}

/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @param array $args Original menu options.
 * 
 * @return array Menu options with depth set to 1.
 */
function limit_menu_depth( array $args ): array {
	$args['depth'] = 1;
	return $args;
}
