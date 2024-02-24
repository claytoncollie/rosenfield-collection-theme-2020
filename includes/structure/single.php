<?php
/**
 * Single.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Single;

use function RosenfieldCollection\Theme\Helpers\get_object_prefix_and_id;
use function RosenfieldCollection\Theme\Helpers\is_type_archive;
use function RosenfieldCollection\Theme\Helpers\is_type_archive_page;

use const RosenfieldCollection\Theme\Fields\OBJECT_IMAGES;
use const RosenfieldCollection\Theme\ImageSizes\IMAGE_OBJECT;
use const RosenfieldCollection\Theme\PostTypes\PAGE_SLUG;
use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;

/**
 * Setup
 */
function setup(): void {
	add_filter( 'genesis_attr_entry-content', __NAMESPACE__ . '\entry_content_attributes' );
	add_filter( 'genesis_attr_entry-image', __NAMESPACE__ . '\entry_image_attributes' );
	add_filter( 'genesis_attr_entry-title', __NAMESPACE__ . '\entry_title_attributes' );
	add_filter( 'genesis_attr_entry-title-link', __NAMESPACE__ . '\entry_title_link_attributes' );
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\view_all_from_artist', 12 );
	add_action( 'genesis_before_content_sidebar_wrap', __NAMESPACE__ . '\the_post_meta', 8 );
	add_filter( 'body_class', __NAMESPACE__ . '\has_gallery' );
	add_action( 'genesis_entry_content', __NAMESPACE__ . '\the_gallery' );
	add_action( 'genesis_sidebar', __NAMESPACE__ . '\the_thumbnails' );
}

/**
 * Entry content attributes
 * 
 * @param array $attributes Attributes.
 */
function entry_content_attributes( array $attributes ): array {
	if ( ! is_singular( PAGE_SLUG ) ) {
		return $attributes;
	}

	$attributes['class'] = 'is-layout-constrained has-global-padding';
	return $attributes;
}

/**
 * Entry image attributes
 * 
 * @param array $attributes Attributes.
 */
function entry_image_attributes( array $attributes ): array {
	$attributes['class'] .= ' img-fluid border shadow-sm';
	return $attributes;
}

/**
 * Entry title attributes
 * 
 * @param array $attributes Attributes.
 */
function entry_title_attributes( array $attributes ): array {
	if ( ! is_type_archive() && ! is_type_archive_page() ) {
		return $attributes;
	}

	$attributes['class'] .= ' h3';
	return $attributes;
}

/**
 * Entry title link attributes
 * 
 * @param array $attributes Attributes.
 */
function entry_title_link_attributes( array $attributes ): array {
	$attributes['class'] .= ' text-decoration-none';
	return $attributes;
}


/**
 * View all objects by artist link
 */
function view_all_from_artist(): void {
	if ( ! is_singular( POST_SLUG ) ) {
		return;
	}

	get_template_part( 'partials/view-all-from-artist' );
}

/**
 * View the objects post meta
 */
function the_post_meta(): void {
	if ( ! is_singular( POST_SLUG ) ) {
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
	if ( ! is_singular( POST_SLUG ) ) {
		return $classes;
	}

	$images = get_field( OBJECT_IMAGES );
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
	if ( ! is_singular( POST_SLUG ) ) {
		return;
	}

	$images = get_field( OBJECT_IMAGES );

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
	if ( ! is_singular( POST_SLUG ) ) {
		return;
	}

	$images = get_field( OBJECT_IMAGES );
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
