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

\add_filter( 'query_vars', __NAMESPACE__ . '\add_query_var_artist_filter' );
/**
 * Adds the query variable to the query object.
 *
 * @param array $public_query_vars Publicly availabe variables.
 * @return array
 * @since 1.0.0
 */
function add_query_var_artist_filter( array $public_query_vars ) : array {
	$public_query_vars[] = 'artist_filter';
	return $public_query_vars;
}

/**
 * Display alphebtical filter for artist
 *
 * @since  1.0.0
 */
function do_artist_filter() {
	$field = get_field_object( 'field_5e17ad49aa83c' );

	if ( ! empty( $field ) ) {
		$letters = $field['choices'];

		if ( ! empty( $letters ) ) {
			echo '<section class="author-filter"><ul>';

			foreach ( $letters as $letter ) {
				printf(
					'<li><a href="%s">%s</a></li>',
					esc_url(
						add_query_arg(
							'artist_filter',
							$letter,
							get_permalink()
						)
					),
					esc_html( ucwords( $letter ) )
				);
			}

			echo '</ul></section>';
		}
	}
}

