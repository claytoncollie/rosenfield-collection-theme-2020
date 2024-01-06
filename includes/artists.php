<?php
/**
 * Artists.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Artists;

/**
 * Page slug set in the WordPress admin
 * 
 * @var string
 */
const SLUG = 'artists';

/**
 * Artist filter query var
 * 
 * @var string
 */
const QUERY_VAR = 'artist_filter';

/**
 * Posts per page
 * 
 * @var int
 */
const POSTS_PER_PAGE = 36;

/**
 * Number of posts to show when using filter variable
 * 
 * @var int
 */
const MAX_PER_PAGE = 999;

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	add_filter( 'query_vars', __NAMESPACE__ . '\add_query_var' );
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\the_filter', 12 );
	add_action( 'genesis_loop', __NAMESPACE__ . '\the_loop' );
}

/**
 * Adds the query variable to the query object.
 *
 * @param array $query_vars Publicly available variables.
 * 
 * @return array
 */
function add_query_var( array $query_vars ): array {
	$query_vars[] = QUERY_VAR;
	return $query_vars;
}

/**
 * Display the alphabetical filter
 * 
 * @return void
 */
function the_filter(): void {
	if ( ! is_page_template( 'templates/artists.php' ) ) {
		return;
	}

	get_template_part( 'partials/artist-filter' );
}

/**
 * Display the main loop
 * 
 * @return void
 */
function the_loop(): void {
	if ( ! is_page_template( 'templates/artists.php' ) ) {
		return;
	}

	get_template_part( 'partials/artist-loop' );
}
