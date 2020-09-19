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

/**
 * Display alphebtical filter for artist
 *
 * @since  1.0.0
 */
function do_pending_filter() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'rc_form',
			'hide_empty' => false,
		)
	);

	if ( ! empty( $terms ) ) {
		printf(
			'<section id="rosenfield-collection-pending-filter" class="inline-filter" role="navigation" aria-label="%s"><ul>',
			esc_html__( 'Filter object by form', 'rosenfield-collection-2020' )
		);

		printf(
			'<li %s><a href="%s"><span class="screen-reader-text">%s</span> %s</a></li>',
			get_query_var( 'rc_form' ) === '' ? 'class="current"' : '',
			esc_url( get_permalink( get_page_by_path( 'pending', OBJECT, 'page' ) ) ),
			esc_html__( 'Go to page', 'rosenfield-collection-2020' ),
			esc_html__( 'All Forms', 'rosenfield-collection-2020' )
		);

		foreach ( $terms as $term ) {
			printf(
				'<li %s><a href="%s"><span class="screen-reader-text">%s</span> %s</a></li>',
				get_query_var( 'rc_form' ) === $term->slug ? 'class="current"' : '',
				esc_url(
					add_query_arg(
						'rc_form',
						$term->slug,
						get_permalink()
					)
				),
				esc_html__( 'Filter object by form', 'rosenfield-collection-2020' ),
				esc_html( ucwords( $term->name ) )
			);
		}

		echo '</ul></section>';
	}
}

