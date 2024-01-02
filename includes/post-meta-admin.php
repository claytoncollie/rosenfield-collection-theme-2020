<?php
/**
 * .
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\PostMetaAdmin;

use function RosenfieldCollection\Theme\Labels\get_vertical_label_url;
use function RosenfieldCollection\Theme\Labels\get_horizontal_label_url;

/**
 * Display the admin only information on single post template
 *
 * @return void
 */
function do_the_admin_bar(): void {
	if ( ! is_user_logged_in() ) {
		return;
	}

	$tag      = has_term( '', 'post_tag' ) ? get_the_term_list( get_the_ID(), 'post_tag', '', ', ', '<span class="entry-sep">&middot;</span>' ) : '';
	$location = has_term( '', 'rc_location' ) ? get_the_term_list( get_the_ID(), 'rc_location', '', ', ', '<span class="entry-sep">&middot;</span>' ) : '';
	$price    = get_field( 'rc_object_purchase_price', get_the_ID() ) ? sprintf( '$%s', get_field( 'rc_object_purchase_price', get_the_ID() ) ) : '';

	printf(
		'<section id="rosenfield-collection-admin-object-data" class="admin-only" role="contentinfo" aria-label="%s"><div class="wrap"><div class="admin-only-purchase">%s%s%s</div><div class="admin-only-labels">%s<span class="entry-sep">&middot;</span>%s</div></div></section>',
		esc_html__( 'Admin only object data', 'rosenfield-collection' ),
		wp_kses_post( $tag ),
		wp_kses_post( $location ),
		wp_kses_post( $price ),
		wp_kses_post( get_vertical_label_url() ),
		wp_kses_post( get_horizontal_label_url() )
	);
}

/**
 * Display the purchase price.
 *
 * @return void
 */
function the_purchase_price(): void {
	printf( '<hr><div>Price: <strong>%s</strong></div><hr>', esc_html( get_field( 'rc_object_purchase_price' ) ) );
}

/**
 * Display the purchase date.
 *
 * @return void
 */
function the_purchase_date(): void {
	printf( '<div>Date: <strong>%s</strong></div><hr>', esc_html( get_field( 'rc_object_purchase_date' ) ) );
}

/**
 * Display the purchase location.
 *
 * @return void
 */
function the_purchase_location(): void {
	$location = has_term( '', 'rc_location' ) ? get_the_term_list( get_the_ID(), 'rc_location', '', ', ', '' ) : '';
	printf( '<div>Location: <strong>%s</strong></div>', wp_kses_post( $location ) );
}
