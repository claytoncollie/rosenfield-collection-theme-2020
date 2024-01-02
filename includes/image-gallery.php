<?php
/**
 * Image Gallery.
 *
 * @package   RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\ImageGallery;

use function RosenfieldCollection\Theme\Helpers\svg;
use function RosenfieldCollection\Theme\Helpers\get_object_prefix_and_id;

/**
 * Add body class when image gallery is not populated.
 *
 * @param array $classes Body classes.
 *
 * @return array
 */
function is_gallery( array $classes ): array {
	$classes[] .= empty( get_field( 'images' ) ) ? 'no-gallery' : '';
	return $classes;
}

/**
 * Gallery Loop
 *
 * @return void
 */
function do_the_object_gallery(): void {
	$images = get_field( 'images' );

	if ( ! empty( $images ) ) {
		printf(
			'<section class="slider-gallery" role="navigation" aria-label="%s"><ul class="slider-gallery-images">',
			esc_html__( 'All images', 'rosenfield-collection' )
		);
		foreach ( $images as $image ) {
			printf(
				'<li><img width="%s" height="%s" src="%s" alt="%s %s %s"><a href="%s" class="button" aria-label="%s %s">%s <span class="label-download">%s</span></a></li>',
				esc_attr( $image['sizes']['object-width'] ?? '' ),
				esc_attr( $image['sizes']['object-height'] ?? '' ),
				esc_url( $image['sizes']['object'] ?? '' ),
				esc_html__( 'Made by', 'rosenfield-collection' ),
				esc_html( get_the_author_meta( 'first_name' ) ),
				esc_html( get_the_author_meta( 'last_name' ) ),
				esc_url( $image['url'] ),
				esc_html__( 'Download full size image', 'rosenfield-collection' ),
				esc_html( $image['title'] ),
				svg( 'cloud-download-alt-solid' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				esc_html__( 'Download', 'rosenfield-collection' )
			);
		}
		echo '</ul></section>';
	} elseif ( has_post_thumbnail() ) {
		printf(
			'<section class="slider-gallery" aria-label="%s"><ul class="slider-gallery-images">',
			esc_html__( 'Large single image', 'rosenfield-collection' )
		);
			printf(
				'<li>%s<a href="%s" class="button" aria-label="%s %s">%s <span class="label-download">%s</span></a></li>',
				get_the_post_thumbnail(
					get_the_ID(),
					'object',
					[
						'alt' => sprintf(
							'%s %s %s',
							esc_html__( 'Made by', 'rosenfield-collection' ),
							esc_html( get_the_author_meta( 'first_name' ) ),
							esc_html( get_the_author_meta( 'last_name' ) )
						),
					]
				),
				esc_url( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) ),
				esc_html__( 'Download full size image for object', 'rosenfield-collection' ),
				esc_html( get_object_prefix_and_id() ),
				svg( 'cloud-download-alt-solid' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				esc_html__( 'Download', 'rosenfield-collection' )
			);
		echo '</ul></section>';
	}
}
