<?php
/**
 * Image Gallery.
 *
 * @package   RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\ImageGallery;

use function RosenfieldCollection\Theme\Helpers\get_object_prefix_and_id;

use const RosenfieldCollection\Theme\ImageSizes\IMAGE_OBJECT;

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	add_filter( 'body_class', __NAMESPACE__ . '\has_gallery' );
	add_action( 'genesis_loop', __NAMESPACE__ . '\the_gallery' );
}

/**
 * Add body class when image gallery is not populated.
 *
 * @param array $classes Body classes.
 *
 * @return array
 */
function has_gallery( array $classes ): array {
	if ( ! is_singular( 'post' ) ) {
		return $classes;
	}

	$images = get_field( 'images' );
	if ( empty( $images ) ) {
		$classes[] = ' no-gallery';
		return $classes;
	}

	$classes[] = ' gallery';
	return $classes;
}

/**
 * Display the image gallery
 * 
 * @return void
 */
function the_gallery(): void {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	$images = get_field( 'images' );

	// Substitute the featured image for an empty gallery
	if ( empty( $images ) ) {
		$image_id = get_post_thumbnail_id();
		$image_id = $image_id ? (int) $image_id : 0;
		if ( empty( $image_id ) ) {
			return;
		}
		$image = wp_get_attachment_image_src( $image_id, IMAGE_OBJECT );
		$image = is_array( $image ) ? $image : [];
		if ( empty( $image ) ) {
			return;
		}

		$image_url = wp_get_attachment_url( $image_id );
		$image_url = $image_url ? (string) $image_url : '';
		if ( empty( $image_url ) ) {
			return;
		}

		$prefix_id = get_object_prefix_and_id();
		if ( empty( $prefix_id ) ) {
			return;
		}

		$images = [
			[
				'sizes' => [
					'object'        => $image[0] ?? '',
					'object-width'  => $image[1] ?? '',
					'object-height' => $image[2] ?? '',
				],
				'url'   => $image_url,
				'title' => $prefix_id,
			],
		];
	}

	get_template_part( 
		'partials/image-gallery',
		null,
		[ 
			'images' => $images,
		] 
	);
}
