<?php
/**
 * Author.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Author;

use function RosenfieldCollection\Theme\Helpers\svg;

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\do_the_artist_avatar', 8 );
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\do_the_artist_info', 12 );
}

/**
 * Display author avatar from user profile.
 *
 * @return void
 */
function do_the_artist_avatar(): void {
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

/**
 * Author info for author archive
 *
 * @return void
 */
function do_the_artist_info(): void {
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
			svg( 'twitter-square-brands' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}
	if ( ! empty( $facebook ) ) {
		printf(
			'<div class="author-social"><a target="_blank" href="%s">%s</a></div>',
			esc_url( $facebook ),
			svg( 'facebook-square-brands' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}
	if ( ! empty( $instagram ) ) {
		printf(
			'<div class="author-social"><a target="_blank" href="%s">%s</a></div>',
			esc_url( $instagram ),
			svg( 'instagram-square-brands' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}
	if ( ! empty( $pinterest ) ) {
		printf(
			'<div class="author-social"><a target="_blank" href="%s">%s</a></div>',
			esc_url( $pinterest ),
			svg( 'pinterest-square-brands' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}
	if ( ! empty( $bio ) ) {
		printf(
			'<p class="hero-subtitle" itemprop="description">%s</p>',
			wp_kses_post( $bio )
		);
	}
}
