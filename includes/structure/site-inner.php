<?php
/**
 * Site Inner.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\SiteInner;

/**
 * Setup actions and filters
 */
function setup(): void {
	add_filter( 'genesis_attr_site-inner', __NAMESPACE__ . '\container' );
	add_filter( 'genesis_structural_wrap-site-inner', __NAMESPACE__ . '\wrapper', 10, 2 );
}

/**
 * Container attributes
 * 
 * @param array $attributes Attributes.
 */
function container( array $attributes ): array {
	$attributes['class'] = 'flex-grow-1';
	return $attributes;
}

/**
 * Wrap the 'row' within a Bootstrap 'container' class
 * 
 * @param string $output Output.
 * @param string $original_output Original output.
 */
function wrapper( string $output, string $original_output ): string {
	$output = 'open' === $original_output ? '<div class="container-xxl gx-md-5 py-3 py-md-5">' : $output;
	return 'close' === $original_output ? '</div>' : $output;
}
