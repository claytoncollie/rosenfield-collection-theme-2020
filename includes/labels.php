<?php
/**
 * Labels.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Labels;

/**
 * Get the URL to build a vertical label
 *
 * @return string
 */
function get_vertical_label_url(): string {
	return sprintf(
		'<a href="%s" rel="nofollow">%s</a>',
		esc_url( get_permalink() . 'vertical' ),
		esc_html__( 'Vertical Label', 'rosenfield-collection' )
	);
}

/**
 * Get the URL to build a horizontal label
 *
 * @return string
 */
function get_horizontal_label_url(): string {
	return sprintf(
		'<a href="%s" rel="nofollow">%s</a>',
		esc_url( get_permalink() . 'horizontal' ),
		esc_html__( 'Horizontal Label', 'rosenfield-collection' )
	);
}
