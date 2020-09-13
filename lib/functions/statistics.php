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

\add_action( 'genesis_after_front-page-1_widget_area', __NAMESPACE__ . '\front_page_1_stats' );
/**
 * Display the high level stats on the homepage.
 *
 * @return void
 *
 * @since 1.0.0
 */
function front_page_1_stats() {
	printf(
		'<section class="statistics">%s%s</section>',
		wp_kses_post( get_post_count_published( 'one-half first' ) ),
		wp_kses_post( get_user_count( 'one-half' ) )
	);
}

/**
 * Return the totla number of users for homepage stats.
 *
 * @param string $classes Set column width.
 *
 * @return string
 *
 * @since 1.0.0
 */
function get_user_count( string $classes ) : string {
	$output = '';

	$users = count_users();

	if ( ! empty( $users ) ) {
		$output .= sprintf(
			'<section class="%s"><h3>%s</h3><p>%s</p></section>',
			esc_attr( $classes ),
			intval( $users['total_users'] ),
			esc_html__( 'Artists', 'rosenfield-collection-2020' )
		);
	}

	return $output;
}

/**
 * Return totle number of published posts.
 *
 * @param string $classes Set column width.
 *
 * @return string
 *
 * @since 1.0.0
 */
function get_post_count_published( string $classes ) : string {
	$output = '';

	$post_count = wp_count_posts();

	if ( ! empty( $post_count ) ) {
		$output .= sprintf(
			'<section class="%s"><h3>%s</h3><p>%s</p></section>',
			esc_attr( $classes ),
			intval( $post_count->publish ),
			esc_html__( 'Published Objects', 'rosenfield-collection-2020' )
		);
	}

	return $output;
}


