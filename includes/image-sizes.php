<?php
/**
 * Image Sizes.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\ImageSizes;

/**
 * Thumbnail
 * 
 * @var string
 */
const THUMBNAIL = 'thumbnail';

/**
 * Object
 * 
 * @var string
 */
const IMAGE_OBJECT = 'object';

/**
 * Archive
 *
 * @var string
 */
const IMAGE_ARCHIVE = 'archive';

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	add_action( 'init', __NAMESPACE__ . '\remove_image_sizes', 99 );
	add_filter( 'intermediate_image_sizes_advanced', __NAMESPACE__ . '\remove_default_image_sizes' );
	add_filter( 'admin_post_thumbnail_size', __NAMESPACE__ . '\admin_featured_image_size', 10, 1 );
	// Remove the big image threshold.
	add_filter( 'big_image_size_threshold', '__return_false' ); 
}

/**
 * Remove all but needed image sizes.
 *
 * @return void
 */
function remove_image_sizes(): void {
	foreach ( get_intermediate_image_sizes() as $size ) { // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.get_intermediate_image_sizes_get_intermediate_image_sizes
		if ( ! in_array( $size, [ 'thumbnail', 'object', 'archive', 'full' ], true ) ) {
			remove_image_size( $size );
		}
	}
}

/**
 * Remove WP Core image sizes.
 *
 * @param array $sizes Image sizes.
 * 
 * @return array
 */
function remove_default_image_sizes( array $sizes ): array {
	unset( $sizes['medium_large'] );
	unset( $sizes['large'] );
	unset( $sizes['1536x1536'] );
	unset( $sizes['2048x2048'] );
	return $sizes;
}

/**
 * Change Display Size of Featured Image Thumbnail in WordPress Admin Dashboard
 *
 * @param string|array $size Image size.
 * 
 * @return string|array
 */
function admin_featured_image_size( $size ) {
	$sizes = get_intermediate_image_sizes(); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.get_intermediate_image_sizes_get_intermediate_image_sizes

	$result = array_search( 'archive', $sizes, true );

	$size = is_numeric( $result ) ? $sizes[ $result ] : 'thumbnail';

	return $size;
}
