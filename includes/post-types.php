<?php
/**
 * Post types.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\PostTypes;

use const RosenfieldCollection\Theme\Fields\OBJECT_ID;
use const RosenfieldCollection\Theme\Fields\OBJECT_PREFIX;
use const RosenfieldCollection\Theme\Taxonomies\FORM;

/**
 * Page post type slug
 * 
 * @var string
 */
const PAGE_SLUG = 'page';

/**
 * Post post type slug
 * 
 * @var string
 */
const POST_SLUG = 'post';

/**
 * Setup
 */
function setup(): void {
	add_action( 'acf/save_post', __NAMESPACE__ . '\field_as_post_name', 20 );
}

/**
 * Write the post name to use custom field data and the taxonomy term meta.
 *
 * @param int|string $post_id Post ID.
 */
function field_as_post_name( int|string $post_id ): void {
	$object_id = get_field( OBJECT_ID, (int) $post_id );
	$object_id = $object_id ? (string) $object_id : ''; // @phpstan-ignore-line
	if ( empty( $object_id ) ) {
		return;
	}

	$prefix = get_taxonomy_term_prefix( (int) $post_id );
	if ( empty( $prefix ) ) {
		return;
	}

	wp_update_post(
		[
			'ID'        => (int) $post_id,
			'post_name' => $prefix . $object_id,
		]
	);
}

/**
 * Returns the prefix for a taxonomy term.
 *
 * @param int $post_id Post ID.
 */
function get_taxonomy_term_prefix( int $post_id ): string {
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
