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
 * Gallery Loop
 *
 * @since  1.0.0
 */
function do_the_thumbnail_gallery() {
	$images = get_field( 'images' );

	if ( ! empty( $images ) ) {
		printf(
			'<section class="slider-thumbnails" aria-label="%s"><ul class="slider-thumbnails-images">',
			esc_html__( 'Thumbnail images', 'rosenfield-collection-2020' )
		);
		foreach ( $images as $image ) {
			printf(
				'<li><img width="%s" height="%s" src="%s" alt="%s %s"></li>',
				esc_attr( $image['sizes']['thumbnail-width'] ),
				esc_attr( $image['sizes']['thumbnail-height'] ),
				esc_url( $image['sizes']['thumbnail'] ),
				esc_html__( 'Thumbnail of', 'rosenfield-collection-2020' ),
				esc_html( $image['title'] )
			);
		}
		echo '</ul></section>';
	}
}
