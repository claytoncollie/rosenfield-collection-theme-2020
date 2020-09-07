<?php
/**
 * Rosenfield Collection Theme.
 *
 * @package   RosenfieldCollection\Theme2020
 * @link      https://www.rosenfieldcollection.com
 * @author    Clayton Collie
 * @copyright Copyright © 2019 Clayton Collie
 * @license   GPL-2.0-or-later
 */

namespace RosenfieldCollection\Theme2020\Functions;

/**
 * Display the adin only information on single post template
 *
 * @return void
 *
 * @since 1.0.0
 */
function do_the_admin_bar() {
	if ( ! is_user_logged_in() ) {
		return;
	}

	if ( ! current_user_can( 'edit_others_pages' ) ) {
		return;
	}

	$tag      = has_term( '', 'post_tag' ) ? get_the_term_list( get_the_ID(), 'post_tag', '', ', ', '<span class="entry-sep">&middot;</span>' ) : '';
	$location = has_term( '', 'rc_location' ) ? get_the_term_list( get_the_ID(), 'rc_location', '', ', ', '<span class="entry-sep">&middot;</span>' ) : '';
	$price    = get_field( 'rc_object_purchace_price' ) ? sprintf( '$%s', get_field( 'rc_object_purchace_price' ) ) : '';

	printf(
		'<section class="admin-only"><div class="wrap"><div class="admin-only-purchase">%s%s%s</div><div class="admin-only-labels">%s<span class="entry-sep">&middot;</span>%s</div></div></section>',
		wp_kses_post( $tag ),
		wp_kses_post( $location ),
		wp_kses_post( $price ),
		wp_kses_post( get_vertical_label_url() ),
		wp_kses_post( get_horizontal_label_url() )
	);
}

/**
 * Get the URL to build a verttical label
 *
 * @return string
 *
 * @since 1.0.0
 */
function get_vertical_label_url() : string {
	return sprintf(
		'<a href="%s" rel="nofollow">%s</a>',
		esc_url( get_permalink() . 'vertical' ),
		esc_html__( 'Vertical Label', 'rosenfield-collection-2020' )
	);
}

/**
 * Get the URL to build a horizontal label
 *
 * @return string
 *
 * @since 1.0.0
 */
function get_horizontal_label_url() : string {
	return sprintf(
		'<a href="%s" rel="nofollow">%s</a>',
		esc_url( get_permalink() . 'horizontal' ),
		esc_html__( 'Horizontal Label', 'rosenfield-collection-2020' )
	);
}
