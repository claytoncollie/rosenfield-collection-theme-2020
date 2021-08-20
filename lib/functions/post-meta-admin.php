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

	$tag      = has_term( '', 'post_tag' ) ? get_the_term_list( get_the_ID(), 'post_tag', '', ', ', '<span class="entry-sep">&middot;</span>' ) : '';
	$location = has_term( '', 'rc_location' ) ? get_the_term_list( get_the_ID(), 'rc_location', '', ', ', '<span class="entry-sep">&middot;</span>' ) : '';
	$price    = get_field( 'rc_object_purchase_price', get_the_ID() ) ? sprintf( '$%s', get_field( 'rc_object_purchase_price', get_the_ID() ) ) : '';

	printf(
		'<section id="rosenfield-collection-admin-object-data" class="admin-only" role="contentinfo" aria-label="%s"><div class="wrap"><div class="admin-only-purchase">%s%s%s</div><div class="admin-only-labels">%s<span class="entry-sep">&middot;</span>%s</div></div></section>',
		esc_html__( 'Admin only object data', 'rosenfield-collection-2020' ),
		wp_kses_post( $tag ),
		wp_kses_post( $location ),
		wp_kses_post( $price ),
		wp_kses_post( get_vertical_label_url() ),
		wp_kses_post( get_horizontal_label_url() )
	);
}
