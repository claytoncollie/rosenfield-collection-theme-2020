<?php
/**
 * Pending.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Pending;

use WP_Post;

use const RosenfieldCollection\Theme\Fields\CLAIM_SLUG;
use const RosenfieldCollection\Theme\Fields\PENDING_SLUG;
use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;
use const RosenfieldCollection\Theme\QueryVars\ARTIST_VAR;
use const RosenfieldCollection\Theme\QueryVars\POST_ID_VAR;
use const RosenfieldCollection\Theme\Taxonomies\FORM;

/**
 * Display all posts labeled PENDING
 */
function do_the_pending_posts(): void {
	$form = get_query_var( FORM );
	$user = get_query_var( ARTIST_VAR );

	$args = [
		'post_type'   => POST_SLUG,
		'post_status' => PENDING_SLUG,
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
				'taxonomy' => FORM,
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
 */
function get_the_permalink_with_post_id( string $url, WP_Post $post ): string {
	if ( is_admin() ) {
		return $url;
	}

	if ( POST_SLUG !== get_post_type( $post->ID ) ) {
		return $url;
	}

	if ( PENDING_SLUG !== get_post_status( $post->ID ) ) {
		return $url;
	}

	return add_query_arg( POST_ID_VAR, get_the_ID(), esc_url( get_bloginfo( 'url' ) . '/' . CLAIM_SLUG ) );
}
