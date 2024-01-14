<?php
/**
 * Query Vars.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\QueryVars;

/**
 * View query var
 * 
 * @var string
 */
const VIEW_VAR = 'view';

/**
 * Post ID query var
 * 
 * @var string
 */
const POST_ID_VAR = 'post_id';

/**
 * Artist query var
 * 
 * @var string
 */
const ARTIST_VAR = 'artist';

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
	$query_vars[] = POST_ID_VAR;
	$query_vars[] = VIEW_VAR;
	$query_vars[] = ARTIST_VAR;
	return $query_vars;
}
