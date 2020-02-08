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
 * Remove the big image threshold.
 *
 * @since 1.1.0
 */
\add_filter( 'big_image_size_threshold', '__return_false' );

\add_action( 'init', __NAMESPACE__ . '\remove_image_sizes', 99 );
/**
 * Remove all but needed image sizes.
 *
 * @return void
 * @since 1.1.0
 */
function remove_image_sizes() {
	foreach ( get_intermediate_image_sizes() as $size ) {
		if ( ! in_array( $size, array( 'thumbnail', 'medium', 'object', 'avatar', 'archive', 'full' ), true ) ) {
			remove_image_size( $size );
		}
	}
}

\add_filter( 'intermediate_image_sizes_advanced', __NAMESPACE__ . '\remove_default_image_sizes' );
/**
 * Remove WP Core image sizes.
 *
 * @param array $sizes Image sizes.
 * @return array
 * @since 1.1.0
 */
function remove_default_image_sizes( array $sizes ) : array {
	unset( $sizes['medium_large'] );
	unset( $sizes['large'] );
	unset( $sizes['1536x1536'] );
	unset( $sizes['2048x2048'] );
	return $sizes;
}
