<?php
/**
 * Query Vars.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\QueryVars;

/**
 * Setup
 */
function setup(): void {
	add_filter( 'query_vars', __NAMESPACE__ . '\add_query_var' );
}

/**
 * Adds the query variable to the query object.
 *
 * @param array $query_vars Publicly available variables.
 */
function add_query_var( array $query_vars ): array {
	$query_vars[] = 'post_id';
	$query_vars[] = 'view';
	$query_vars[] = 'artist';
	return $query_vars;
}
