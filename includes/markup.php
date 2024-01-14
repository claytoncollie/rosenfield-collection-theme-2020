<?php
/**
 * Markup.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Markup;

use function RosenfieldCollection\Theme\Helpers\is_type_archive;

/**
 * Setup
 */
function setup(): void {
	add_filter( 'body_class', __NAMESPACE__ . '\body_classes' );
	add_action( 'genesis_before', __NAMESPACE__ . '\narrow_content' );
}

/**
 * Add additional classes to the body element.
 *
 * @param array $classes Body classes.
 */
function body_classes( array $classes ): array {

	// Add archive type class.
	if ( is_type_archive() ) {
		$classes[] = 'is-archive';
	}

	if ( is_search() ) {
		unset( $classes['narrow-content'] );
		$classes[] = 'sidebar-content';
	}

	// Add no hero section class.
	$classes[] = 'no-hero-section';

	return $classes;
}

/**
 * Remove sidebars on narrow content layout.
 */
function narrow_content(): void {
	if ( 'narrow-content' === genesis_site_layout() ) {
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
	}
}
