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
		echo '<section class="slider-thumbnails"><ul class="slider-thumbnails-images">';
		foreach ( $images as $image ) {
			printf( '<li><img src="%s"></li>', esc_url( $image['sizes']['thumbnail'] ) );
		}
		echo '</ul></section>';
	}
}
