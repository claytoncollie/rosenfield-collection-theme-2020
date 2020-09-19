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

use function RosenfieldCollection\Theme2020\Functions\svg as svg;

/**
 * Add body class when image gallery is not populated.
 *
 * @param array $classes Body classes.
 *
 * @return array
 *
 * @since 1.0.0
 */
function is_gallery( $classes ) : array {
	$classes[] .= empty( get_field( 'images' ) ) ? 'no-gallery' : '';
	return $classes;
}

/**
 * Gallery Loop
 *
 * @since  1.0.0
 */
function do_the_object_gallery() {
	$images = get_field( 'images' );

	if ( ! empty( $images ) ) {
		printf(
			'<section class="slider-gallery" role="navigation" aria-label="%s"><ul class="slider-gallery-images">',
			esc_html__( 'All images', 'rosenfield-collection-2020' )
		);
		foreach ( $images as $image ) {
			printf(
				'<li><img src="%s" alt="%s %s %s"><a href="%s" class="button" aria-label="%s %s">%s <span class="label-download">%s</span></a></li>',
				esc_url( $image['sizes']['object'] ),
				esc_html__( 'Made by', 'rosenfield-collection-2020' ),
				esc_html( get_the_author_meta( 'first_name' ) ),
				esc_html( get_the_author_meta( 'last_name' ) ),
				esc_url( $image['url'] ),
				esc_html__( 'Download full size image', 'rosenfield-collection-2020' ),
				esc_html( $image['title'] ),
				svg( 'cloud-download-alt-solid' ), // phpcs:ignore
				esc_html__( 'Download', 'rosenfield-collection-2020' )
			);
		}
		echo '</ul></section>';
	} elseif ( has_post_thumbnail() ) {
		printf(
			'<section class="slider-gallery" aria-label="%s"><ul class="slider-gallery-images">',
			esc_html__( 'Large single image', 'rosenfield-collection-2020' )
		);
			printf(
				'<li>%s<a href="%s" class="button" aria-label="%s %s">%s <span class="label-download">%s</span></a></li>',
				get_the_post_thumbnail(
					get_the_ID(),
					'object',
					array(
						'alt' => sprintf(
							'%s %s %s',
							esc_html__( 'Made by', 'rosenfield-collection-2020' ),
							esc_html( get_the_author_meta( 'first_name' ) ),
							esc_html( get_the_author_meta( 'last_name' ) )
						),
					)
				),
				esc_url( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) ),
				esc_html__( 'Download full size image for object', 'rosenfield-collection-2020' ),
				esc_html( get_object_prefix_and_id() ),
				svg( 'cloud-download-alt-solid' ), // phpcs:ignore
				esc_html__( 'Download', 'rosenfield-collection-2020' )
			);
		echo '</ul></section>';
	}
}
