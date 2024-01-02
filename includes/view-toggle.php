<?php
/**
 * View Toggle.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\ViewToggle;

use WP_Query;

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	add_action( 'pre_get_posts', __NAMESPACE__ . '\nopaging', 99 );
	add_filter( 'body_class', __NAMESPACE__ . '\body_class' );
	add_action( 'genesis_entry_footer', __NAMESPACE__ . '\do_the_view_toggle_post_meta' );
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

	if ( ! empty( $view ) ) {
		if ( 'list' === $view ) {
			$query->set( 'nopaging', true );
		}
	}
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

	if ( ! empty( $view ) ) {
		if ( 'list' === $view ) {
			$classes[] .= ' view-toggle-list';
		}
	}

	return $classes;
}

/**
 * Object meta data
 *
 * @return void
 */
function do_the_view_toggle_post_meta(): void {
	if ( ! is_tax() && ! is_tag() ) {
		return;
	}

	$forms      = get_the_term_list( get_the_ID(), 'rc_form', '', ', ', '' );
	$firings    = get_the_term_list( get_the_ID(), 'rc_firing', '', ', ' );
	$techniques = get_the_term_list( get_the_ID(), 'rc_technique', '', ', ' );
	$rows       = get_the_term_list( get_the_ID(), 'rc_row', '', ', ' );
	$columns    = get_the_term_list( get_the_ID(), 'rc_column', '', ', ' );
	$location   = get_the_term_list( get_the_ID(), 'rc_location', '', ', ' );
	$price      = get_field( 'rc_object_purchase_price', get_the_ID() );

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

	if ( is_user_logged_in() ) {
		echo '<div class="location">';

		if ( ! empty( $columns ) ) {
			printf(
				'%s %s',
				esc_html__( 'Column', 'rosenfield-collection' ),
				wp_kses_post( $columns )
			);
		}
		if ( ! empty( $rows ) ) {
			printf(
				'<span class="entry-sep">&middot;</span>%s %s',
				esc_html__( 'Row', 'rosenfield-collection' ),
				wp_kses_post( $rows )
			);
		}
		if ( ! empty( $location ) ) {
			printf(
				'<span class="entry-sep">&middot;</span>%s',
				wp_kses_post( $location )
			);
		}
		if ( ! empty( $price ) ) {
			printf(
				'<span class="entry-sep">&middot;</span>$ %s',
				wp_kses_post( $price )
			);
		}

		echo '</div>';
	}
}
