<?php
/**
 * Site Container.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\SiteContainer;

/**
 * Setup actions and filters
 */
function setup(): void {
	add_filter( 'genesis_attr_site-container', __NAMESPACE__ . '\container' );
}

/**
 * Container attributes
 * 
 * @param array $attributes Attributes.
 */
function container( array $attributes ): array {
	$attributes['class'] = 'position-relative d-flex flex-nowrap flex-column min-vh-100';
	return $attributes;
}
