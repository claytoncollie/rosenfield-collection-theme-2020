<?php
/**
 * Thumbnail Gallery.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\ThumbnailGallery;

/**
 * Gallery Loop
 *
 * @return void
 */
function do_the_thumbnail_gallery(): void {
	$images = get_field( 'images' );

	if ( ! empty( $images ) ) {
		printf(
			'<section class="slider-thumbnails" aria-label="%s"><ul class="slider-thumbnails-images">',
			esc_html__( 'Thumbnail images', 'rosenfield-collection' )
		);
		foreach ( $images as $image ) {
			printf(
				'<li><img width="%s" height="%s" src="%s" alt="%s %s"></li>',
				esc_attr( $image['sizes']['thumbnail-width'] ),
				esc_attr( $image['sizes']['thumbnail-height'] ),
				esc_url( $image['sizes']['thumbnail'] ),
				esc_html__( 'Thumbnail of', 'rosenfield-collection' ),
				esc_html( $image['title'] )
			);
		}
		echo '</ul></section>';
	}
}
