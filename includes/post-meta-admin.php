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
	$price = get_field( 'rc_object_purchase_price' );
	$price = $price ? (string) $price : '';
	if ( empty( $price ) ) {
		return;
	}

	printf( 
		'<hr><div>%s: <strong>%s</strong></div><hr>',
		esc_html__( 'Price', 'rosenfield-collection' ),
		esc_html( $price ) 
	);
}

/**
 * Display the purchase date.
 */
function the_purchase_date(): void {
	$date = get_field( 'rc_object_purchase_date' );
	$date = $date ? (string) $date : '';
	if ( empty( $date ) ) {
		return;
	}

	printf( 
		'<div>%s: <strong>%s</strong></div><hr>',
		esc_html__( 'Date', 'rosenfield-collection' ),
		esc_html( $date ) 
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
		'<div>%s: <strong>%s</strong></div>', 
		esc_html__( 'Location', 'rosenfield-collection' ),
		wp_kses_post( $location ) 
	);
}
