<?php
/**
 * Single.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Single;

use function RosenfieldCollection\Theme\Helpers\get_object_prefix_and_id;

use const RosenfieldCollection\Theme\ImageSizes\IMAGE_OBJECT;

/**
 * Setup
 */
function setup(): void {
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\view_all_from_artist', 12 );
	add_action( 'genesis_before_content_sidebar_wrap', __NAMESPACE__ . '\the_post_meta', 8 );
	add_filter( 'body_class', __NAMESPACE__ . '\has_gallery' );
	add_action( 'genesis_entry_content', __NAMESPACE__ . '\the_gallery' );
	add_action( 'genesis_sidebar', __NAMESPACE__ . '\the_thumbnails' );
}

/**
 * View all objects by artist link
 */
function view_all_from_artist(): void {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	get_template_part( 'partials/view-all-from-artist' );
}

/**
 * View the objects post meta
 */
function the_post_meta(): void {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	get_template_part( 'partials/post-meta-single' );
	get_template_part( 'partials/post-meta-admin-single' );
}

/**
 * Add body class when image gallery is not populated.
 *
 * @param array $classes Body classes.
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

	$classes[] = ' has-gallery';
	return $classes;
}

/**
 * Display the image gallery
 */
function the_gallery(): void {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	$images = get_field( 'images' );

	// Substitute the featured image for an empty gallery.
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
					'object'        => $image[0],
					'object-width'  => $image[1],
					'object-height' => $image[2],
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

/**
 * Display the thumbnail images
 */
function the_thumbnails(): void {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	$images = get_field( 'images' );
	if ( empty( $images ) ) {
		return;
	}

	get_template_part(
		'partials/image-thumbnails',
		null,
		[ 
			'images' => $images,
		]  
	);
}
