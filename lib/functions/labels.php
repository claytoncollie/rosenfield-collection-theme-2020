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
 * Get the URL to build a verttical label
 *
 * @return string
 *
 * @since 1.0.0
 */
function get_vertical_label_url() : string {
	return sprintf(
		'<a href="%s" rel="nofollow">%s</a>',
		esc_url( get_permalink() . 'vertical' ),
		esc_html__( 'Vertical Label', 'rosenfield-collection-2020' )
	);
}

/**
 * Get the URL to build a horizontal label
 *
 * @return string
 *
 * @since 1.0.0
 */
function get_horizontal_label_url() : string {
	return sprintf(
		'<a href="%s" rel="nofollow">%s</a>',
		esc_url( get_permalink() . 'horizontal' ),
		esc_html__( 'Horizontal Label', 'rosenfield-collection-2020' )
	);
}
