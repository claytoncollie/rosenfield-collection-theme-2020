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

use RosenfieldCollection\Theme2020\Functions\svg as svg;

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
		echo '<section class="slider-gallery"><ul class="slider-gallery-images">';
		foreach ( $images as $image ) {
			printf(
				'<li><img src="%s" alt="%s %s %s"><a href="%s" class="button">%s <span class="label-download">%s</span></a></li>',
				esc_url( $image['sizes']['object'] ),
				esc_html__( 'Made by', 'rosenfield-collection-2020' ),
				esc_html( get_the_author_meta( 'first_name' ) ),
				esc_html( get_the_author_meta( 'last_name' ) ),
				esc_url( $image['url'] ),
				svg( 'cloud-download-alt-solid' ),
				esc_html__( 'Download', 'rosenfield-collection-2020' )
			);
		}
		echo '</ul></section>';
	} elseif ( has_post_thumbnail() ) {
		echo '<section class="slider-gallery"><ul class="slider-gallery-images">';
			printf(
				'<li>%s<a href="%s" class="button">%s <span class="label-download">%s</span></a></li>',
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
				svg( 'cloud-download-alt-solid' ),
				esc_html__( 'Download', 'rosenfield-collection-2020' )
			);
		echo '</ul></section>';
	}
}
