<?php
/**
 * Pagination.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Pagination;

/**
 * Setup
 */
function setup(): void {
	add_filter( 'genesis_markup_open', __NAMESPACE__ . '\entry_pagination_wrap_open', 10, 2 );
	add_filter( 'genesis_markup_close', __NAMESPACE__ . '\entry_pagination_wrap_close', 10, 2 );
	add_filter( 'genesis_prev_link_text', __NAMESPACE__ . '\previous_page_link' );
	add_filter( 'genesis_next_link_text', __NAMESPACE__ . '\next_page_link' );
	add_filter( 'genesis_markup_pagination-previous_content', __NAMESPACE__ . '\previous_pagination_text' );
	add_filter( 'genesis_markup_pagination-next_content', __NAMESPACE__ . '\next_pagination_text' );
	// Reposition archive pagination.
	remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
	add_action( 'genesis_after_content_sidebar_wrap', 'genesis_posts_nav' );
	// Reposition single navigation.
	remove_action( 'genesis_after_entry', 'genesis_adjacent_entry_nav' );
	add_action( 'genesis_after_content_sidebar_wrap', 'genesis_adjacent_entry_nav' );
	// Removes alignment classes.
	remove_filter( 'genesis_attr_pagination-previous', 'genesis_adjacent_entry_attr_previous_post' );
	remove_filter( 'genesis_attr_pagination-next', 'genesis_adjacent_entry_attr_next_post' );
}
/**
 * Outputs the opening pagination wrap markup.
 *
 * @param string $open Opening markup.
 * @param array  $args Markup args.
 */
function entry_pagination_wrap_open( string $open, array $args ): string {
	if ( 'archive-pagination' === $args['context'] || 'adjacent-entry-pagination' === $args['context'] ) {
		$open .= '<div class="wrap">';
	}

	return $open;
}

/**
 * Outputs the closing pagination wrap markup.
 *
 * @param string $close Closing markup.
 * @param array  $args  Markup args.
 */
function entry_pagination_wrap_close( string $close, array $args ): string {
	if ( 'archive-pagination' === $args['context'] || 'adjacent-entry-pagination' === $args['context'] ) {
		$close .= '</div>';
	}

	return $close;
}

/**
 * Changes the previous page link text.
 */
function previous_page_link(): string {
	return \sprintf( '← Previous', 'rosenfield-collection' );
}

/**
 * Changes the next page link text.
 */
function next_page_link(): string {
	return \sprintf( 'Next →', 'rosenfield-collection' );
}

/**
 * Changes the previous link arrow icon.
 *
 * @param string $content Previous link text.
 */
function previous_pagination_text( string $content ): string {
	return \str_replace( '&#xAB;', '←', $content );
}

/**
 * Changes the next link arrow icon.
 *
 * @param string $content Next link text.
 */
function next_pagination_text( string $content ): string {
	return \str_replace( '&#xBB;', '→', $content );
}
