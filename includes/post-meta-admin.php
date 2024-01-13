<?php
/**
 * .
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\PostMetaAdmin;

use const RosenfieldCollection\Theme\Taxonomies\LOCATION;

/**
 * Display the purchase price.
 */
function the_purchase_price(): void {
	printf( 
		'<hr><div>Price: <strong>%s</strong></div><hr>',
		esc_html( get_field( 'rc_object_purchase_price' ) ) 
	);
}

/**
 * Display the purchase date.
 */
function the_purchase_date(): void {
	printf( 
		'<div>Date: <strong>%s</strong></div><hr>',
		esc_html( get_field( 'rc_object_purchase_date' ) ) 
	);
}

/**
 * Display the purchase location.
 */
function the_purchase_location(): void {
	$post_id = get_the_ID();
	$post_id = $post_id ? (int) $post_id : 0;
	if ( empty( $post_id ) ) {
		return;
	}

	$location = get_the_term_list( $post_id, LOCATION, '', ', ', '' );
	$location = $location && ! is_wp_error( $location ) ? $location : '';
	if ( empty( $location ) ) {
		return;
	}

	printf( 
		'<div>Location: <strong>%s</strong></div>', 
		wp_kses_post( $location ) 
	);
}
