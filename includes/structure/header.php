<?php
/**
 * Header.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Header;

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	add_filter( 'genesis_markup_title-area_close', __NAMESPACE__ . '\title_area_hook', 10, 1 );
}

/**
 * Add custom hook after the title area.
 *
 * @param string $close_html Closing html markup.
 *
 * @return string
 */
function title_area_hook( string $close_html ): string {
	if ( $close_html ) {
		\ob_start();
		\do_action( 'genesis_after_title_area' );
		$close_html = $close_html . ob_get_clean();
	}

	return $close_html;
}
