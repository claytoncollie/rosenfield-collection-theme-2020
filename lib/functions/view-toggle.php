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

add_filter( 'query_vars', __NAMESPACE__ . '\add_query_var' );
/**
 * Adds the query variable to the query object.
 *
 * @param array $public_query_vars Publicly availabe variables.
 * @return array
 * @since 1.0.0
 */
function add_query_var( $public_query_vars ) {
    $public_query_vars[] = 'view';
    return $public_query_vars;
}

\add_action( 'pre_get_posts', __NAMESPACE__ . '\nopaging', 99 );
function nopaging( $query ) {

	if ( is_admin() ) {
		return $query;
	}
	
	if ( ! $query->is_main_query() ) {
		return $query;
	}
	
	$view = get_query_var( 'view' );

	if ( ! empty( $view ) ) {
		if ( 'list' === $view ) {
			$query->set( 'nopaging', true );
		}
	}
}

\add_filter( 'body_class', __NAMESPACE__ . '\body_class' );
function body_class( $classes ) {
	
	$view = get_query_var( 'view' );

	if ( ! empty( $view ) ) {
		if ( 'list' === $view ) {
			$classes[] .= ' view-toggle-list';
		}
	}

	return $classes;
	
}

\add_action( 'genesis_entry_footer', __NAMESPACE__ . '\do_the_view_toggle_post_meta' );
/**
 * Object meta data
 *
 * @since  1.0.0
 */
function do_the_view_toggle_post_meta() {

	if ( ! is_tax() && ! is_tag() ) {
		return;
	}  

	$forms      = get_the_term_list( get_the_ID(), 'rc_form', '', ', ', '' );
	$firings    = get_the_term_list( get_the_ID(), 'rc_firing', '', ', ' );
	$techniques = get_the_term_list( get_the_ID(), 'rc_technique', '', ', ' );
	$rows       = get_the_term_list( get_the_ID(), 'rc_row', '', ', ' );
	$columns    = get_the_term_list( get_the_ID(), 'rc_column', '', ', ' );

	echo '<div class="taxonomies">';

	if ( ! empty( $forms ) ) {
		printf(
			'<span class="entry-sep">&middot;</span>%s',
			wp_kses_post( $forms )
		);
	}
	if ( ! empty( $firings ) ) {
		printf(
			'<span class="entry-sep">&middot;</span>%s',
			wp_kses_post( $firings )
		);
	}
	if ( ! empty( $techniques ) ) {
		printf(
			'<span class="entry-sep">&middot;</span>%s',
			wp_kses_post( $techniques )
		);
	}

	echo '</div>';

	echo '<div class="location">';

	if ( ! empty( $columns ) ) {
		printf(
			'%s %s',
			esc_html__( 'Column', 'rosenfield-collection-2020' ),
			wp_kses_post( $columns )
		);
	}
	if ( ! empty( $rows ) ) {
		printf(
			'<span class="entry-sep">&middot;</span>%s %s',
			esc_html__( 'Row', 'rosenfield-collection-2020' ),
			wp_kses_post( $rows )
		);
	}

	echo '</div>';

}

