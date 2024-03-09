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
use function RosenfieldCollection\Theme\Helpers\is_type_archive_page;

use const RosenfieldCollection\Theme\Fields\OBJECT_ID;
use const RosenfieldCollection\Theme\QueryVars\VIEW_VAR;

/**
 * Setup
 */
function setup(): void {
	add_filter( 'genesis_attr_entry', __NAMESPACE__ . '\entry_attributes' );
	add_filter( 'get_the_content_more_link', __NAMESPACE__ . '\read_more_link' );
	add_filter( 'the_content_more_link', __NAMESPACE__ . '\read_more_link' );
	add_action( 'genesis_entry_header', __NAMESPACE__ . '\entry_wrap_open', 4 );
	add_action( 'genesis_entry_footer', __NAMESPACE__ . '\entry_wrap_close', 15 );
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
 * Grid layout for archives
 * 
 * @param array $attributes Attributes.
 */
function entry_attributes( array $attributes ): array {
	if ( ! is_type_archive() && ! is_type_archive_page() ) {
		return $attributes;
	}

	$attributes['class'] .= ' col col-12 col-md-6 col-lg-4 col-xl-3 text-center';
	return $attributes;
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
		'<a class="link-fancy" href="%s">%s</a>',
		esc_url( $permalink ),
		esc_html( ucwords( get_object_prefix_and_id() ) )
	);
}

/**
 * Outputs the opening entry wrap markup.
 */
function entry_wrap_open(): void {
	if ( is_type_archive() ) {
		echo wp_kses_post( '<div class="d-inline-block p-2 w-100">' );
	}
}

/**
 * Outputs the closing entry wrap markup.
 */
function entry_wrap_close(): void {
	if ( is_type_archive() ) {
		echo wp_kses_post( '</div>' );
	}
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
	if ( is_page_template( 'templates/pending.php' ) ) {
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

	$view = get_query_var( VIEW_VAR );
	$view = $view ? (string) $view : ''; // @phpstan-ignore-line
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
	$view = get_query_var( VIEW_VAR );
	$view = $view ? (string) $view : ''; // @phpstan-ignore-line
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
