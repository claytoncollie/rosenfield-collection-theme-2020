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
 * Display select field to filter by form
 *
 * @since  1.0.0
 */
function do_pending_filter_by_form() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'rc_form',
			'hide_empty' => false,
		)
	);

	if ( ! empty( $terms ) ) {
		printf(
			'<section id="rosenfield-collection-pending-filter-by-form" class="inline-filter" role="navigation" aria-label="%s"><ul>',
			esc_html__( 'Filter object by form', 'rosenfield-collection-2020' )
		);

		printf(
			'<select onchange="document.location.href=this.value"><option value="%s">%s</option>',
			esc_url( get_permalink( get_page_by_path( 'pending', OBJECT, 'page' ) ) ),
			esc_html__( 'All Forms', 'rosenfield-collection-2020' )
		);

		foreach ( $terms as $term ) {
			printf(
				'<option value="%s" %s>%s</option>',
				esc_url(
					add_query_arg(
						'rc_form',
						$term->slug,
						get_permalink()
					)
				),
				$term->slug === get_query_var( 'rc_form' ) ? 'selected' : '',
				esc_html( ucwords( $term->name ) )
			);
		}

		echo '</select></section>';
	}
}

/**
 * Display select field to filter by artist
 *
 * @since  1.0.0
 */
function do_pending_filter_by_artist() {
	$users = get_users(
		array(
			'order'   => 'ASC',
			'orderby' => 'display_name',
		)
	);

	if ( ! empty( $users ) ) {
		printf(
			'<section id="rosenfield-collection-pending-filter-by-user" class="inline-filter" role="navigation" aria-label="%s"><ul>',
			esc_html__( 'Filter object by artist', 'rosenfield-collection-2020' )
		);

		printf(
			'<select onchange="document.location.href=this.value"><option value="%s">%s</option>',
			esc_url( get_permalink( get_page_by_path( 'pending', OBJECT, 'page' ) ) ),
			esc_html__( 'All Artists', 'rosenfield-collection-2020' )
		);

		foreach ( $users as $user ) {
			printf(
				'<option value="%s" %s>%s</option>',
				esc_url(
					add_query_arg(
						'artist',
						$user->ID,
						get_permalink()
					)
				),
				$user->ID == get_query_var( 'artist' ) ? 'selected' : '',
				esc_html( ucwords( $user->display_name ) )
			);
		}

		echo '</select></section>';
	}
}
