<?php
/**
 * Pagination.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Pagination;

/**
 * Targets for the pagination context
 * 
 * @var array
 */
const CONTEXT = [ 
	'archive-pagination',
	'adjacent-entry-pagination',
];

/**
 * Setup
 */
function setup(): void {
	add_filter( 'genesis_attr_archive-pagination', __NAMESPACE__ . '\attributes', 10, 1 );
	add_filter( 'genesis_prev_link_text', __NAMESPACE__ . '\previous_page_link' );
	add_filter( 'genesis_next_link_text', __NAMESPACE__ . '\next_page_link' );
	add_filter( 'genesis_markup_pagination-previous_content', __NAMESPACE__ . '\previous_pagination_text' );
	add_filter( 'genesis_markup_pagination-next_content', __NAMESPACE__ . '\next_pagination_text' );
	// Reposition archive pagination.
	remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
	add_action( 'genesis_before_footer', __NAMESPACE__ . '\maybe_do_archive_pagination' );
	// Reposition single navigation.
	remove_action( 'genesis_after_entry', 'genesis_adjacent_entry_nav' );
	add_action( 'genesis_before_footer', 'genesis_adjacent_entry_nav' );
}

/**
 * Maybe display the search form on archive pages.
 * 
 * Do not display on search results
 *
 * @return void
 */
function maybe_do_archive_pagination(): void {
	if ( is_search() ) {
		return;
	}

	genesis_posts_nav();
}

/**
 * Genesis attributes
 * 
 * @param array $attributes Attributes.
 */
function attributes( array $attributes ): array {
	$attributes['class'] .= ' container-xxl px-3 py-5';
	return $attributes;
}

/**
 * Changes the previous page link text.
 */
function previous_page_link(): string {
	return __( '← Previous', 'rosenfield-collection' );
}

/**
 * Changes the next page link text.
 */
function next_page_link(): string {
	return __( 'Next →', 'rosenfield-collection' );
}

/**
 * Changes the previous link arrow icon.
 *
 * @param string $content Previous link text.
 */
function previous_pagination_text( string $content ): string {
	return str_replace( '&#xAB;', '←', $content );
}

/**
 * Changes the next link arrow icon.
 *
 * @param string $content Next link text.
 */
function next_pagination_text( string $content ): string {
	return str_replace( '&#xBB;', '→', $content );
}
