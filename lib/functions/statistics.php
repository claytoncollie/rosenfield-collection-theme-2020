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
 * High level stats for entire site
 *
 * @since 1.0.0
 */
function do_the_statistics() {
	printf(
		'<section class="widget"><div class="widget-wrap">%s%s</div></section>',
		wp_kses_post( get_user_count() ),
		wp_kses_post( get_post_count() )
	);
}

/**
 * Return the totla number of users for homepage stats.
 *
 * @return string
 *
 * @since 1.0.0
 */
function get_user_count() : string {
	$output = '';

	$users = count_users();

	if ( ! empty( $users ) ) {
		$output .= sprintf(
			'<section class="one-half first"><h2>%s</h2><p>%s</p></section>',
			intval( $users['total_users'] ),
			esc_html__( 'Artists', 'rosenfield-collection-2020' )
		);
	}

	return $output;
}

/**
 * Return totle number of published posts.
 *
 * @return string
 *
 * @since 1.0.0
 */
function get_post_count() : string {
	return sprintf(
		'<section class="one-half"><h2>%s</h2><p>%s</p></section>',
		intval( wp_count_posts()->publish ),
		esc_html__( 'Objects', 'rosenfield-collection-2020' )
	);
}
