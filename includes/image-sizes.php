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
const IMAGE_THUMBNAIL = 'thumbnail';

/**
 * Medium
 * 
 * @var string
 */
const IMAGE_MEDIUM = 'medium';

/**
 * Large
 * 
 * @var string
 */
const IMAGE_LARGE = 'large';

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
 */
function remove_image_sizes(): void {
	foreach ( get_intermediate_image_sizes() as $size ) { // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.get_intermediate_image_sizes_get_intermediate_image_sizes
		if ( ! in_array( $size, [ IMAGE_THUMBNAIL, IMAGE_OBJECT, IMAGE_ARCHIVE, 'full' ], true ) ) {
			remove_image_size( $size );
		}
	}
}

/**
 * Remove WP Core image sizes.
 *
 * @param array $sizes Image sizes.
 */
function remove_default_image_sizes( array $sizes ): array {
	unset( $sizes['medium_large'] );
	unset( $sizes['1536x1536'] );
	unset( $sizes['2048x2048'] );
	return $sizes;
}

/**
 * Change Display Size of Featured Image Thumbnail in WordPress Admin Dashboard
 */
function admin_featured_image_size(): string {
	$sizes = get_intermediate_image_sizes(); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.get_intermediate_image_sizes_get_intermediate_image_sizes

	$result = array_search( IMAGE_ARCHIVE, $sizes, true );

	return is_numeric( $result ) ? $sizes[ $result ] : IMAGE_THUMBNAIL;
}
