<?php
/**
 * Pending Filters.
 *
 * @package   RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\PendingFilter;

use const RosenfieldCollection\Theme\Fields\PENDING_SLUG;
use const RosenfieldCollection\Theme\PostTypes\PAGE_SLUG;
use const RosenfieldCollection\Theme\Taxonomies\FORM;

/**
 * Display select field to filter by form
 */
function do_pending_filter_by_form(): void {
	$terms = get_terms(
		[
			'taxonomy'   => FORM,
			'hide_empty' => false,
		]
	);

	if ( ! $terms ) {
		return;
	}

	if ( is_wp_error( $terms ) ) {
		return;
	}

	if ( ! is_array( $terms ) ) {
		return;
	}

	$post = get_page_by_path( PENDING_SLUG, OBJECT, PAGE_SLUG );

	printf(
		'<section id="rosenfield-collection-pending-filter-by-form" class="inline-filter" role="navigation" aria-label="%s"><ul>',
		esc_html__( 'Filter object by form', 'rosenfield-collection' )
	);

	printf(
		'<select onchange="document.location.href=this.value"><option value="%s">%s</option>',
		esc_url( (string) get_permalink( $post ) ), // @phpstan-ignore-line
		esc_html__( 'All Forms', 'rosenfield-collection' )
	);

	foreach ( $terms as $term ) {
		printf(
			'<option value="%s" %s>%s</option>',
			esc_url(
				add_query_arg(
					FORM,
					$term->slug,
					get_permalink()
				)
			),
			get_query_var( FORM ) === $term->slug ? 'selected' : '',
			esc_html( ucwords( $term->name ) )
		);
	}

	echo '</select></section>';
}

/**
 * Display select field to filter by artist
 */
function do_pending_filter_by_artist(): void {
	$users = get_users(
		[
			'order'   => 'ASC',
			'orderby' => 'display_name',
		]
	);

	if ( ! empty( $users ) ) {
		$post = get_page_by_path( PENDING_SLUG, OBJECT, PAGE_SLUG );

		printf(
			'<section id="rosenfield-collection-pending-filter-by-user" class="inline-filter" role="navigation" aria-label="%s"><ul>',
			esc_html__( 'Filter object by artist', 'rosenfield-collection' )
		);

		printf(
			'<select onchange="document.location.href=this.value"><option value="%s">%s</option>',
			esc_url( (string) get_permalink( $post ) ), // @phpstan-ignore-line
			esc_html__( 'All Artists', 'rosenfield-collection' )
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
				get_query_var( 'artist' ) === $user->ID ? 'selected' : '',
				esc_html( ucwords( (string) $user->display_name ) )
			);
		}

		echo '</select></section>';
	}
}
