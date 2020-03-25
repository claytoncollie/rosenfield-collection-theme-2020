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

\add_filter( 'query_vars', __NAMESPACE__ . '\add_query_var' );
/**
 * Adds the query variable to the query object.
 *
 * @param array $query_vars Publicly availabe variables.
 * @return array
 * @since 1.0.0
 */
function add_query_var( array $query_vars ) : array {
	$query_vars[] = 'post_id';
	$query_vars[] = 'artist_filter';
	$query_vars[] = 'view';
	return $query_vars;
}
