<?php
/**
 * Pending.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Pending;

use WP_Post;

/**
 * Display all posts labeled PENDING
 *
 * @return void
 */
function do_the_pending_posts(): void {
	$form = get_query_var( 'rc_form' );
	$user = get_query_var( 'artist' );

	$args = [
		'post_type'   => 'post',
		'post_status' => 'pending',
		'paged'       => get_query_var( 'paged' ),
		'order'       => 'ASC',
		'orderby'     => 'author',
	];

	if ( ! empty( $user ) ) {
		$args['author'] = absint( $user );
	}

	if ( ! empty( $form ) ) {
		$args['tax_query'] = [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			[
				'taxonomy' => 'rc_form',
				'field'    => 'slug',
				'terms'    => $form,
			],
		];
	}

	genesis_custom_loop( $args );
}

/**
 * Filter the permalink on the PENDING page to include a query argument with the post ID.
 *
 * @param string  $url Permalink.
 * @param WP_Post $post Post Object.
 * 
 * @return string
 */
function get_the_permalink_with_post_id( string $url, WP_Post $post ): string {
	if ( is_admin() ) {
		return $url;
	}

	if ( 'post' !== get_post_type( $post->ID ) ) {
		return $url;
	}

	if ( 'pending' !== get_post_status( $post->ID ) ) {
		return $url;
	}

	$url = add_query_arg( 'post_id', get_the_ID(), esc_url( get_bloginfo( 'url' ) . '/claim' ) );

	return $url;
}
