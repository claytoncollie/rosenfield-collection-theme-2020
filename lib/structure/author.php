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

namespace RosenfieldCollection\Theme2020\Structure;

use function RosenfieldCollection\Theme2020\Functions\svg as svg;

\add_action( 'genesis_hero_section', __NAMESPACE__ . '\do_the_artist_avatar', 8 );
/**
 * Display author avatar from user profile.
 *
 * @return void
 *
 * @since 1.0.0
 */
function do_the_artist_avatar() {
	if ( ! is_author() ) {
		return;
	}

	$author = get_queried_object();

	if ( empty( $author ) ) {
		return;
	}

	$attachment_id = get_field( 'artist_photo', 'user_' . $author->ID );

	$avatar = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );

	if ( ! empty( $avatar ) ) {
		printf(
			'<img width="%s" height="%s" src="%s" class="author-avatar" alt="%s %s" />',
			esc_attr( $avatar[1] ),
			esc_attr( $avatar[2] ),
			esc_url( $avatar[0] ),
			esc_html( $author->first_name ),
			esc_html( $author->last_name )
		);
	}
}

\add_action( 'genesis_hero_section', __NAMESPACE__ . '\do_the_artist_info', 12 );
/**
 * Author info for author archive
 *
 * @return void
 *
 * @since 1.0.0
 */
function do_the_artist_info() {
	if ( ! is_author() || is_paged() ) {
		return;
	}

	$author = get_queried_object();

	if ( empty( $author ) ) {
		return;
	}

	$website   = $author->user_url;
	$twitter   = $author->twitter;
	$facebook  = $author->facebook;
	$instagram = $author->instagram;
	$pinterest = $author->pinterest;
	$bio       = $author->description;

	if ( ! empty( $website ) ) {
		printf(
			'<div class="author-website"><a target="_blank" href="%s">%s</a></div>',
			esc_url( $website ),
			esc_url( $website )
		);
	}
	if ( ! empty( $twitter ) ) {
		printf(
			'<div class="author-social"><a target="_blank" href="%s">%s</a></div>',
			esc_url( $twitter ),
			svg( 'twitter-square-brands' ) // phpcs:ignore
		);
	}
	if ( ! empty( $facebook ) ) {
		printf(
			'<div class="author-social"><a target="_blank" href="%s">%s</a></div>',
			esc_url( $facebook ),
			svg( 'facebook-square-brands' ) // phpcs:ignore
		);
	}
	if ( ! empty( $instagram ) ) {
		printf(
			'<div class="author-social"><a target="_blank" href="%s">%s</a></div>',
			esc_url( $instagram ),
			svg( 'instagram-square-brands' ) // phpcs:ignore
		);
	}
	if ( ! empty( $pinterest ) ) {
		printf(
			'<div class="author-social"><a target="_blank" href="%s">%s</a></div>',
			esc_url( $pinterest ),
			svg( 'pinterest-square-brands' ) // phpcs:ignore
		);
	}
	if ( ! empty( $bio ) ) {
		printf(
			'<p class="hero-subtitle" itemprop="description">%s</p>',
			wp_kses_post( $bio )
		);
	}
}

