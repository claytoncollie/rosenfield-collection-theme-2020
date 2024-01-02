<?php
/**
 * Statistics.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Statistics;

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	add_action( 'genesis_after_front-page-1_widget_area', __NAMESPACE__ . '\front_page_1_stats' );
}

/**
 * Display the high level stats on the homepage.
 *
 * @return void
 */
function front_page_1_stats(): void {
	printf(
		'<section class="statistics">%s%s</section>',
		wp_kses_post( get_post_count_published( 'one-half first' ) ),
		wp_kses_post( get_user_count( 'one-half' ) )
	);
}

/**
 * Return the total number of users for homepage stats.
 *
 * @param string $classes Set column width.
 *
 * @return string
 */
function get_user_count( string $classes ): string {
	$output = '';

	$users = count_users();

	if ( ! empty( $users ) ) {
		$output .= sprintf(
			'<section class="%s"><h3>%s</h3><p>%s</p></section>',
			esc_attr( $classes ),
			intval( $users['total_users'] ),
			esc_html__( 'Artists', 'rosenfield-collection' )
		);
	}

	return $output;
}

/**
 * Return total number of published posts.
 *
 * @param string $classes Set column width.
 *
 * @return string
 */
function get_post_count_published( string $classes ): string {
	$output = '';

	$post_count = wp_count_posts();

	if ( ! empty( $post_count ) ) {
		$output .= sprintf(
			'<section class="%s"><h3>%s</h3><p>%s</p></section>',
			esc_attr( $classes ),
			intval( $post_count->publish ),
			esc_html__( 'Published Objects', 'rosenfield-collection' )
		);
	}

	return $output;
}
