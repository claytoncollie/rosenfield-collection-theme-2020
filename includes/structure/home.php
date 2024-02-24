<?php
/**
 * Home.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Home;

/**
 * Setup
 */
function setup(): void {
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\introduction' );
}

/**
 * Display the introduction and stats on the homepage.
 */
function introduction(): void {
	if ( ! is_front_page() ) {
		return;
	}

	if ( is_paged() ) {
		return;
	}
	
	get_template_part( 'partials/introduction' );
	get_template_part( 'partials/subscribe' );
	get_template_part( 'partials/statistics' );
}
