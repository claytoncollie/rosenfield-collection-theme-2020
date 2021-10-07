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
 * Display all posts labeled PENDING
 *
 * @return void
 * @since 1.3.0
 */
function do_the_pending_posts() {
	$query_var = get_query_var( 'rc_form' );

	if ( ! empty( $query_var ) ) {
		genesis_custom_loop(
			array(
				'post_type'   => 'post',
				'post_status' => 'pending',
				'paged'       => get_query_var( 'paged' )
				// 'nopaging'    => true,
				'orderby'     => 'author',
				'tax_query'   => array(
					array(
						'taxonomy' => 'rc_form',
						'field'    => 'slug',
						'terms'    => $query_var,
					),
				),
			)
		);
	} else {
		genesis_custom_loop(
			array(
				'post_type'   => 'post',
				'post_status' => 'pending',
				// 'nopaging'    => true,
				'orderby'     => 'author',
				'paged'       => get_query_var( 'paged' ),
			)
		);
	}
}

/**
 * Filter the permalink on the PENDING page to include a query argument with the post ID.
 *
 * @param string   $url Permalink.
 * @param \WP_Post $post Post Object.
 * @param boolean  $leavename Whether to keep the post name.
 * @return string
 * @since 1.3.0
 */
function get_the_permalink_with_post_id( string $url, \WP_Post $post, bool $leavename ) : string {
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
