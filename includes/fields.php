<?php
/**
 * Fields.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Fields;

use const RosenfieldCollection\Theme\Taxonomies\FORM;

/**
 * Object ID
 * 
 * @var string
 */
const OBJECT_ID = 'object_id';

/**
 * Object prefix
 * 
 * @var string
 */
const OBJECT_PREFIX = 'rc_form_object_prefix';

/**
 * Object Price
 * 
 * @var string
 */
const OBJECT_PRICE = 'rc_object_purchase_price';

/**
 * Object Date
 * 
 * @var string
 */
const OBJECT_DATE = 'rc_object_purchase_date';

/**
 * Object images
 * 
 * @var string
 */
const OBJECT_IMAGES = 'images';

/**
 * Object length
 * 
 * @var string
 */
const OBJECT_LENGTH = 'length';

/**
 * Object width
 * 
 * @var string
 */
const OBJECT_WIDTH = 'width';

/**
 * Object height
 * 
 * @var string
 */
const OBJECT_HEIGHT = 'height';

/**
 * Artist photo meta key
 * 
 * @var string
 */
const ARTIST_PHOTO = 'artist_photo';

/**
 * Artist filter meta key
 * 
 * @var string
 */
const ARTIST_FILTER = 'artist_filter';

/**
 * Pending page slug
 * 
 * @var string
 */
const PENDING_SLUG = 'pending';

/**
 * Artist slug
 * 
 * @var string
 */
const ARTIST_SLUG = 'artists';

/**
 * Claim slug
 * 
 * @var string
 */
const CLAIM_SLUG = 'claim';

/**
 * Contact page slug
 * 
 * @var string
 */
const CONTACT_SLUG = 'contact';

/**
 * Setup
 */
function setup(): void {
	add_filter( 'acf/settings/save_json', __NAMESPACE__ . '\acf_local_json_save_location' );
	add_filter( 'acf/settings/load_json', __NAMESPACE__ . '\acf_local_json_load_location' );
	add_action( 'acf/save_post', __NAMESPACE__ . '\field_as_post_name', 20 );
}

/**
 * Change save path for Advanced Custom Fields local json files
 */
function acf_local_json_save_location(): string {
	return ROSENFIELD_COLLECTION_THEME_STYLESHEET_PATH . '/acf-json';
}

/**
 * Change load path for Advanced Custom Fields local json files.
 *
 * @param array $paths Default directories.
 */
function acf_local_json_load_location( array $paths ): array {
	unset( $paths[0] );
	$paths[] = ROSENFIELD_COLLECTION_THEME_STYLESHEET_PATH . '/acf-json';
	return $paths;
}

/**
 * Write the post name to use custom field data and the taxonomy term meta.
 *
 * @param int $post_id Post ID.
 */
function field_as_post_name( int $post_id ): void {
	$object_id = get_field( OBJECT_ID, $post_id );
	$object_id = $object_id ? (string) $object_id : ''; // @phpstan-ignore-line
	if ( empty( $object_id ) ) {
		return;
	}

	$prefix = get_taxonomy_term_prefix( $post_id );
	if ( empty( $prefix ) ) {
		return;
	}

	wp_update_post(
		[
			'ID'        => $post_id,
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
