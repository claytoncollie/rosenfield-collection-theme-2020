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

use const RosenfieldCollection\Theme\Fields\OBJECT_ID;

/**
 * Setup
 */
function setup(): void {
	add_filter( 'post_class', __NAMESPACE__ . '\archive_post_class' );
	add_filter( 'get_the_content_more_link', __NAMESPACE__ . '\read_more_link' );
	add_filter( 'the_content_more_link', __NAMESPACE__ . '\read_more_link' );
	add_action( 'genesis_entry_header', __NAMESPACE__ . '\entry_wrap_open', 4 );
	add_action( 'genesis_entry_footer', __NAMESPACE__ . '\entry_wrap_close', 15 );
	add_filter( 'genesis_markup_entry-header_open', __NAMESPACE__ . '\widget_entry_wrap_open', 10, 2 );
	add_action( 'pre_get_posts', __NAMESPACE__ . '\sort_by_object_id' );
	add_action( 'genesis_entry_content', __NAMESPACE__ . '\object_by_line', 8 );
	add_action( 'pre_get_posts', __NAMESPACE__ . '\nopaging', 99 );
	add_filter( 'body_class', __NAMESPACE__ . '\body_class' );
	add_action( 'genesis_entry_footer', __NAMESPACE__ . '\the_post_meta' );
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
 */
function archive_post_class( array $classes ): array {
	if ( ! is_type_archive() ) {
		return $classes;
	}

	if ( \did_action( 'genesis_before_sidebar_widget_area' ) !== 0 ) {
		return $classes;
	}

	if ( 'full-width-content' === genesis_site_layout() ) {
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
 */
function read_more_link(): string {
	$post_id = get_the_ID();
	$post_id = $post_id ? (int) $post_id : 0;
	if ( empty( $post_id ) ) {
		return '';
	}

	$permalink = get_permalink( $post_id );
	$permalink = $permalink ? (string) $permalink : '';
	if ( empty( $permalink ) ) {
		return '';
	}

	return sprintf(
		'<a class="more-link" href="%s">%s</a>',
		esc_url( $permalink ),
		esc_html( ucwords( get_object_prefix_and_id() ) )
	);
}

/**
 * Outputs the opening entry wrap markup.
 */
function entry_wrap_open(): void {
	if ( is_type_archive() ) {
		genesis_markup(
			[
				'open'    => '<div %s>',
				'context' => 'entry-wrap',
			]
		);
	}
}

/**
 * Outputs the closing entry wrap markup.
 */
function entry_wrap_close(): void {
	if ( is_type_archive() ) {
		genesis_markup(
			[
				'close'   => '</div>',
				'context' => 'entry-wrap',
			]
		);
	}
}

/**
 * Outputs the opening entry wrap markup in widgets.
 *
 * @param string $open Opening markup.
 * @param array  $args Markup args.
 */
function widget_entry_wrap_open( string $open, array $args ): string {
	if ( isset( $args['params']['is_widget'] ) && $args['params']['is_widget'] ) {
		$markup = genesis_markup(
			[
				'open'    => '<div %s>',
				'context' => 'entry-wrap',
				'echo'    => false,
			]
		);

		$open = $markup . $open;
	}

	return $open;
}

/**
 * Sort the taxonomy archive pages by object ID
 *
 * @param WP_Query $query Main Query.
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

	$query->set( 'meta_key', OBJECT_ID );
	$query->set( 'orderby', 'meta_value_num' );
	$query->set( 'order', 'DESC' );
}

/**
 * Display the object author name and object ID below the post title
 */
function object_by_line(): void {
	if ( is_singular() ) {
		return;
	}
	if ( is_author() ) {
		return;
	}

	get_template_part( 'partials/object-by-line' );
}

/**
 * Filter the posts per page on taxonomy archives.
 *
 * @param WP_Query $query Main Query.
 */
function nopaging( WP_Query $query ): void {
	if ( is_admin() ) {
		return;
	}

	if ( ! $query->is_main_query() ) {
		return;
	}

	$view = get_query_var( 'view' );
	$view = $view ? (string) $view : '';
	if ( 'list' !== $view ) {
		return;
	}
		
	$query->set( 'nopaging', true );
}

/**
 * Add body class for taxonomy archive.
 *
 * @param array $classes Body classes.
 */
function body_class( array $classes ): array {
	$view = get_query_var( 'view' );
	$view = $view ? (string) $view : '';
	if ( 'list' !== $view ) {
		return $classes;
	}

	$classes[] = ' view-toggle-list';
	return $classes;
}

/**
 * Display the post meta next to each object
 *
 * Includes data only for logged in users.
 */
function the_post_meta(): void {
	if ( ! is_tax() && ! is_tag() ) {
		return;
	}

	get_template_part( 'partials/post-meta-list-view' );  
}
