<?php
/**
 * Archive.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Archive;

use WP_Query;

use function RosenfieldCollection\Theme\Helpers\is_type_archive;
use function RosenfieldCollection\Theme\Helpers\get_object_prefix_and_id;

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	add_filter( 'post_class', __NAMESPACE__ . '\archive_post_class' );
	add_filter( 'get_the_content_more_link', __NAMESPACE__ . '\read_more_link' );
	add_filter( 'the_content_more_link', __NAMESPACE__ . '\read_more_link' );
	add_action( 'genesis_entry_header', __NAMESPACE__ . '\entry_wrap_open', 4 );
	add_action( 'genesis_entry_footer', __NAMESPACE__ . '\entry_wrap_close', 15 );
	add_filter( 'genesis_markup_entry-header_open', __NAMESPACE__ . '\widget_entry_wrap_open', 10, 2 );
	add_filter( 'pre_get_posts', __NAMESPACE__ . '\sort_by_object_id' );
	// Reposition entry image.
	remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
	add_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );
	// Remove entry-info.
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	// Remove entry-meta.
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
}

/**
 * Add column class to archive posts.
 *
 * @param array $classes Array of post classes.
 *
 * @return array
 */
function archive_post_class( array $classes ) : array {
	if ( ! is_type_archive() ) {
		return $classes;
	}

	if ( \class_exists( 'WooCommerce' ) && \is_woocommerce() ) {
		return $classes;
	}

	if ( \did_action( 'genesis_before_sidebar_widget_area' ) ) {
		return $classes;
	}

	if ( 'full-width-content' === \genesis_site_layout() ) {
		$classes[] = 'one-fourth';
		$count     = 4;
	} else {
		$classes[] = 'one-third';
		$count     = 3;
	}

	global $wp_query;

	if ( 0 === $wp_query->current_post || 0 === $wp_query->current_post % $count ) {
		$classes[] = 'first';
	}

	return $classes;
}

/**
 * Modify the content limit read more link
 *
 * @param string $more_link_text Default more link text.
 *
 * @return string
 */
function read_more_link( string $more_link_text ) : string {
	$more_link_text = sprintf(
		'<a class="more-link" href="%s">%s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		esc_html( ucwords( get_object_prefix_and_id() ) )
	);
	return $more_link_text;
}

/**
 * Outputs the opening entry wrap markup.
 *
 * @return void
 */
function entry_wrap_open(): void {
	if ( is_type_archive() ) {
		\genesis_markup(
			array(
				'open'    => '<div %s>',
				'context' => 'entry-wrap',
			)
		);
	}
}

/**
 * Outputs the closing entry wrap markup.
 *
 * @return void
 */
function entry_wrap_close(): void {
	if ( is_type_archive() ) {
		\genesis_markup(
			array(
				'close'   => '</div>',
				'context' => 'entry-wrap',
			)
		);
	}
}

/**
 * Outputs the opening entry wrap markup in widgets.
 *
 * @param string $open Opening markup.
 * @param array  $args Markup args.
 *
 * @return string
 */
function widget_entry_wrap_open( string $open, array $args ) : string {
	if ( isset( $args['params']['is_widget'] ) && $args['params']['is_widget'] ) {
		$markup = \genesis_markup(
			array(
				'open'    => '<div %s>',
				'context' => 'entry-wrap',
				'echo'    => false,
			)
		);

		$open = $markup . $open;
	}

	return $open;
}

/**
 * Sort the taxonomy archive pages by object ID
 *
 * @param WP_Query WP_Query.
 * 
 * @return void
 */
function sort_by_object_id( WP_Query $query ): void {
	if ( is_admin() ) {
		return;
	}

	if ( ! $query->is_main_query() ) {
		return;
	}

	if ( ! $query->is_tax() ) {
		return;
	}

	$query->set( 'meta_key', 'object_id' );
	$query->set( 'orderby', 'meta_value_num' );
	$query->set( 'order', 'DESC' );
}
