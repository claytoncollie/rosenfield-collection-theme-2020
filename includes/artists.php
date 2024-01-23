<?php
/**
 * Artists.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Artists;

use const RosenfieldCollection\Theme\Fields\ARTIST_FILTER;

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
 */
function setup(): void {
	add_filter( 'query_vars', __NAMESPACE__ . '\add_query_var' );
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\the_filter', 12 );
	add_action( 'genesis_loop', __NAMESPACE__ . '\the_loop', 12 );
	add_action( 'acf/save_post', __NAMESPACE__ . '\set_artist_filter_value', 20 );
	add_action( 'user_register', __NAMESPACE__ . '\set_artist_filter_value', 10, 1 );
}

/**
 * Adds the query variable to the query object.
 *
 * @param array $query_vars Publicly available variables.
 */
function add_query_var( array $query_vars ): array {
	$query_vars[] = QUERY_VAR;
	return $query_vars;
}

/**
 * Display the alphabetical filter
 */
function the_filter(): void {
	if ( ! is_page_template( 'templates/artists.php' ) ) {
		return;
	}

	get_template_part( 'partials/artist-filter' );
}

/**
 * Display the main loop
 */
function the_loop(): void {
	if ( ! is_page_template( 'templates/artists.php' ) ) {
		return;
	}

	get_template_part( 'partials/artist-loop' );
}

/**
 * Update user meta when user edit page is saved.
 *
 * @param int|string $user_id User ID.
 */
function set_artist_filter_value( int|string $user_id ): void {
	if ( ! current_user_can( 'edit_users', $user_id ) ) {
		return;
	}

	$field = get_field( ARTIST_FILTER, $user_id );
	if ( ! empty( $field ) ) {
		return;
	}

	$user_id = str_replace( 'user_', '', (string) $user_id );
	$name    = get_user_meta( (int) $user_id, 'last_name', true );
	if ( empty( $name ) ) {
		$name = get_user_meta( (int) $user_id, 'first_name', true );
	}

	$letter = mb_substr( (string) $name, 0, 1 ); // @phpstan-ignore-line
	$letter = strtolower( $letter );

	update_user_meta( (int) $user_id, ARTIST_FILTER, $letter );
}
