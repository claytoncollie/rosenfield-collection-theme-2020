<?php
/**
 * .
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\PostMetaAdmin;

/**
 * Display the purchase price.
 */
function the_purchase_price(): void {
	printf( '<hr><div>Price: <strong>%s</strong></div><hr>', esc_html( get_field( 'rc_object_purchase_price' ) ) );
}

/**
 * Display the purchase date.
 */
function the_purchase_date(): void {
	printf( '<div>Date: <strong>%s</strong></div><hr>', esc_html( get_field( 'rc_object_purchase_date' ) ) );
}

/**
 * Display the purchase location.
 */
function the_purchase_location(): void {
	$location = has_term( '', 'rc_location' ) ? get_the_term_list( get_the_ID(), 'rc_location', '', ', ', '' ) : '';
	printf( '<div>Location: <strong>%s</strong></div>', wp_kses_post( $location ) );
}
