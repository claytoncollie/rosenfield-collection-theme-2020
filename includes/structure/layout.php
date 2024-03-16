<?php
/**
 * Layout.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Layout;

use function RosenfieldCollection\Theme\Helpers\is_list_view;

use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;

/**
 * Wrapper class
 * 
 * @var string
 */
const ROW = 'row';

/**
 * Sidebar slug
 * 
 * @var string
 */
const SIDEBAR = 'sidebar';

/**
 * Secondary sidebar slug
 * 
 * @var string
 */
const SIDEBAR_ALT = 'sidebar_alt';

/**
 * Full width slug
 * 
 * @var string
 */
const FULL_WIDTH_CONTENT = 'full-width-content';

/**
 * Content sidebar slug
 * 
 * @var string
 */
const CONTENT_SIDEBAR = 'content-sidebar';

/**
 * Sidebar content slug
 * 
 * @var string
 */
const SIDEBAR_CONTENT = 'sidebar-content';

/**
 * Content sidebar sidebar slug
 * 
 * @var string
 */
const CONTENT_SIDEBAR_SIDEBAR = 'content-sidebar-sidebar';

/**
 * Sidebar sidebar content slug
 * 
 * @var string
 */
const SIDEBAR_SIDEBAR_CONTENT = 'sidebar-sidebar-content';

/**
 * Sidebar content sidebar slug
 * 
 * @var string
 */
const SIDEBAR_CONTENT_SIDEBAR = 'sidebar-content-sidebar';

/**
 * Actions and Filters.
 */
function setup(): void {
	add_filter( 'genesis_site_layout', __NAMESPACE__ . '\set_layout' );
	add_action( 'after_setup_theme', __NAMESPACE__ . '\register_layout' );
	add_filter( 'genesis_attr_structural-wrap', __NAMESPACE__ . '\row' );
	add_filter( 'genesis_attr_content', __NAMESPACE__ . '\content' );
	add_filter( 'genesis_attr_sidebar-primary', __NAMESPACE__ . '\sidebar_primary' );
	// Remove content-sidebar-wrap.
	add_filter( 'genesis_markup_content-sidebar-wrap', '__return_empty_string' );
	// Remove sidebars.
	remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
	remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
}

/**
 * Set the layout for each page template.
 */
function set_layout(): string {
	if ( is_singular( POST_SLUG ) ) {
		return SIDEBAR_CONTENT;
	}

	return FULL_WIDTH_CONTENT;
}

/**
 * Register layouts
 */
function register_layout(): void {
	// Layouts.
	genesis_unregister_layout( CONTENT_SIDEBAR );
	genesis_unregister_layout( CONTENT_SIDEBAR_SIDEBAR );
	genesis_unregister_layout( SIDEBAR_SIDEBAR_CONTENT );
	genesis_unregister_layout( SIDEBAR_CONTENT_SIDEBAR );
	// Sidebars.
	unregister_sidebar( SIDEBAR );
	unregister_sidebar( SIDEBAR_ALT );
}

/**
 * Add support for Bootstrap's row class by replacing the default "wrap".
 * 
 * @param array $attributes Attributes.
 */
function row( array $attributes ): array {
	$attributes['class'] = ROW;
	return $attributes;
}

/**
 * Define layout for content area.
 * 
 * @param array $attributes Attributes.
 */
function content( array $attributes ): array {
	switch ( genesis_site_layout() ) {
		case FULL_WIDTH_CONTENT:
			$attributes['class'] = 'row gy-5 gx-3';
			break;

		case SIDEBAR_CONTENT:
			$attributes['class'] = 'col-12 col-md-10 order-0 order-md-1';
			break;
	}
	return $attributes;
}

/**
 * Define layout for primary sidebar.
 * 
 * @param array $attributes Attributes.
 */
function sidebar_primary( array $attributes ): array {
	if ( genesis_site_layout() === SIDEBAR_CONTENT ) {
		$attributes['class'] = 'col-12 col-md-2 order-1 order-md-0';
	}
	return $attributes;
}
