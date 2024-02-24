<?php
/**
 * Layout.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Layout;

use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;

const ROW                     = 'row';
const SIDEBAR                 = 'sidebar';
const SIDEBAR_ALT             = 'sidebar_alt';
const FULL_WIDTH_CONTENT      = 'full-width-content';
const CONTENT_SIDEBAR         = 'content-sidebar';
const SIDEBAR_CONTENT         = 'sidebar-content';
const CONTENT_SIDEBAR_SIDEBAR = 'content-sidebar-sidebar';
const SIDEBAR_SIDEBAR_CONTENT = 'sidebar-sidebar-content';
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
	add_filter( 'genesis_attr_sidebar-secondary', __NAMESPACE__ . '\sidebar_secondary' );
	// Remove content-sidebar-wrap.
	add_filter( 'genesis_markup_content-sidebar-wrap', '__return_empty_string' );
	// Remove sidebars.
	remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
	remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
}

/**
 * Set the layout for each page template.
 */
function set_layout(): ?string {
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

		case SIDEBAR_SIDEBAR_CONTENT:
			$attributes['class'] .= ' col-12 col-md-6 order-2';
			break;

		case SIDEBAR_CONTENT_SIDEBAR:
			$attributes['class'] .= ' col-12 col-md-6 order-1';
			break;

		case CONTENT_SIDEBAR_SIDEBAR:
			$attributes['class'] .= ' col-12 col-md-6 order-0';
			break;

		case CONTENT_SIDEBAR:
			$attributes['class'] .= ' col-12 col-md-8 order-0';
			break;

		case SIDEBAR_CONTENT:
			$attributes['class'] .= ' col-12 col-md-8 order-1';
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
	switch ( genesis_site_layout() ) {
		case SIDEBAR_SIDEBAR_CONTENT:
			$attributes['class'] .= ' col-12 col-md-3 order-0';
			break;

		case SIDEBAR_CONTENT_SIDEBAR:
			$attributes['class'] .= ' col-12 col-md-3 order-0';
			break;

		case CONTENT_SIDEBAR_SIDEBAR:
			$attributes['class'] .= ' col-12 col-md-3 order-1';
			break;

		case CONTENT_SIDEBAR:
			$attributes['class'] .= ' col-12 col-md-4 order-1';
			break;

		case SIDEBAR_CONTENT:
			$attributes['class'] .= ' col-12 col-md-4 order-0';
			break;
	}
	return $attributes;
}

/**
 * Define layout for secondary sidebar.
 * 
 * @param array $attributes Attributes.
 */
function sidebar_secondary( array $attributes ): array {
	switch ( genesis_site_layout() ) {
		case SIDEBAR_SIDEBAR_CONTENT:
			$attributes['class'] .= ' col-12 col-md-3 order-1';
			break;

		case SIDEBAR_CONTENT_SIDEBAR:
			$attributes['class'] .= ' col-12 col-md-3 order-2';
			break;

		case CONTENT_SIDEBAR_SIDEBAR:
			$attributes['class'] .= ' col-12 col-md-3 order-2';
			break;
	}
	return $attributes;
}
