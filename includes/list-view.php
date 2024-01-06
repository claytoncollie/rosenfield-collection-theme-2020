<?php
/**
 * List View.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\ListView;

use WP_Query;

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	add_action( 'pre_get_posts', __NAMESPACE__ . '\nopaging', 99 );
	add_filter( 'body_class', __NAMESPACE__ . '\body_class' );
	add_action( 'genesis_entry_footer', __NAMESPACE__ . '\the_post_meta' );
}

/**
 * Filter the posts per page on taxonomy archives.
 *
 * @param WP_Query $query Main Query.
 *
 * @return void
 */
function nopaging( WP_Query $query ): void {
	if ( is_admin() ) {
		return;
	}

	if ( ! $query->is_main_query() ) {
		return;
	}

	$view = get_query_var( 'view' );
	$view = $view ? (string) $view : '';
	if ( 'list' !== $view ) {
		return;
	}
		
	$query->set( 'nopaging', true );
}

/**
 * Add body class for taxonomy archive.
 *
 * @param array $classes Body classes.
 * 
 * @return array
 */
function body_class( array $classes ): array {
	$view = get_query_var( 'view' );
	$view = $view ? (string) $view : '';
	if ( 'list' !== $view ) {
		return $classes;
	}

	$classes[] = ' view-toggle-list';
	return $classes;
}

/**
 * Display the post meta next to each object
 * 
 * Includes data only for logged in users.
 *
 * @return void
 */
function the_post_meta(): void {
	if ( ! is_tax() && ! is_tag() ) {
		return;
	}

	get_template_part( 'partials/list-view' );  
}
