<?php
/**
 * Helpers.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Helpers;

use const RosenfieldCollection\Theme\Fields\OBJECT_ID;
use const RosenfieldCollection\Theme\Fields\OBJECT_PREFIX;
use const RosenfieldCollection\Theme\QueryVars\VIEW_VAR;
use const RosenfieldCollection\Theme\Taxonomies\FORM;

/**
 * Get the terms from taxonomy and add the light link utility classes
 *
 * @param int    $post_id Post ID.
 * @param string $taxonomy Taxonomy.
 */
function get_the_terms_light_links( int $post_id, string $taxonomy ): string {
	$terms = get_the_terms( $post_id, $taxonomy );
	if ( is_wp_error( $terms ) ) {
		return '';
	}
	if ( empty( $terms ) ) {
		return '';
	}

	$links = [];

	foreach ( $terms as $term ) {
		$link = get_term_link( $term, $taxonomy );
		if ( is_wp_error( $link ) ) {
			continue;
		}
		$links[] = sprintf(
			'<a href="%s" class="link-light link-hidden-dots-light">%s</a>',
			esc_url( $link ),
			esc_html( $term->name )
		);
	}

	return wp_kses_post( implode( ', ', $links ) );
}

/**
 * Load an inline SVG.
 *
 * @param string $filename The filename of the SVG you want to load.
 */
function svg( string $filename ): string {
	if ( file_exists( ROSENFIELD_COLLECTION_THEME_STYLESHEET_PATH . '/assets/svg/' . $filename . '.svg' ) ) {
		return (string) file_get_contents( ROSENFIELD_COLLECTION_THEME_STYLESHEET_URL . '/assets/svg/' . $filename . '.svg' );
	}

	return '';
}

/**
 * Get the object prefix and ID.
 */
function get_object_prefix_and_id(): string {
	$output = '';
	$prefix = get_taxonomy_term_prefix();
	$id     = get_field( OBJECT_ID );

	if ( ! empty( $id ) && ! empty( $prefix ) ) {
		return $prefix . $id;
	}

	return $output;
}

/**
 * Get the taxonomy term prefix
 */
function get_taxonomy_term_prefix(): string {
	$post_id = get_the_ID();
	$post_id = $post_id ? (int) $post_id : 0;
	if ( empty( $post_id ) ) {
		return '';
	}

	$terms = get_the_terms( $post_id, FORM );
	if ( ! $terms ) {
		return '';
	}
	if ( is_wp_error( $terms ) ) {
		return '';
	}

	foreach ( $terms as $term ) {
		$term_id = $term->term_id;
	}

	if ( empty( $term_id ) ) {
		return '';
	}

	$prefix = get_term_meta( $term_id, OBJECT_PREFIX, true );

	return $prefix ? (string) $prefix : ''; // @phpstan-ignore-line
}

/**
 * Check if we ar eon the lis view
 */
function is_list_view(): bool {
	$view = get_query_var( VIEW_VAR );
	return 'list' === $view;
}

/**
 * Check if were on any type of archive page.
 */
function is_type_archive(): bool {
	return is_type_archive_page() || is_home() || is_post_type_archive() || is_category() || is_tag() || is_tax() || is_author() || is_date() || is_year() || is_month() || is_day() || is_time() || is_archive();
}

/**
 * Check if we are nay of these pages.
 */
function is_type_archive_page(): bool {
	return is_page( [ 'forms', 'firings', 'techniques', 'artists' ] );
}
