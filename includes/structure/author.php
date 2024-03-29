<?php
/**
 * Author.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Author;

use function RosenfieldCollection\Theme\Helpers\svg;

use const RosenfieldCollection\Theme\Fields\ARTIST_PHOTO;
use const RosenfieldCollection\Theme\ImageSizes\IMAGE_THUMBNAIL;

/**
 * Setup
 */
function setup(): void {
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\do_the_artist_avatar', 8 );
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\do_the_artist_info', 12 );
}

/**
 * Display author avatar from user profile.
 */
function do_the_artist_avatar(): void {
	if ( ! is_author() ) {
		return;
	}

	$author_id = (int) get_the_author_meta( 'ID' );
	if ( empty( $author_id ) ) {
		return;
	}
	
	$attachment_id = get_field( ARTIST_PHOTO, 'user_' . $author_id );
	$attachment_id = $attachment_id ? (int) $attachment_id : 0; // @phpstan-ignore-line
	if ( empty( $attachment_id ) ) {
		return;
	}

	$avatar = wp_get_attachment_image_src( $attachment_id, IMAGE_THUMBNAIL );
	if ( empty( $avatar ) ) {
		return;
	}

	$first_name = get_the_author_meta( 'first_name', $author_id );
	$last_name  = get_the_author_meta( 'last_name', $author_id );
	$full_name  = $first_name . ' ' . $last_name;

	printf(
		'<img width="%s" height="%s" src="%s" class="img-fluid mb-3 border border-5 rounded-circle" alt="%s" />',
		esc_attr( (string) $avatar[1] ),
		esc_attr( (string) $avatar[2] ),
		esc_url( $avatar[0] ),
		esc_attr( $full_name )
	);
}

/**
 * Author info for author archive
 */
function do_the_artist_info(): void {
	if ( is_paged() ) {
		return;
	}
	
	if ( ! is_author() ) {
		return;
	}

	$author_id = (int) get_the_author_meta( 'ID' );
	if ( empty( $author_id ) ) {
		return;
	}

	$website   = get_the_author_meta( 'user_url', $author_id );
	$twitter   = get_the_author_meta( 'twitter', $author_id );
	$facebook  = get_the_author_meta( 'facebook', $author_id );
	$instagram = get_the_author_meta( 'instagram', $author_id );
	$pinterest = get_the_author_meta( 'pinterest', $author_id );
	$bio       = get_the_author_meta( 'description', $author_id );

	if ( ! empty( $website ) ) {
		printf(
			'<div class="fs-6 fs-md-4 mb-4"><a target="_blank" href="%s" class="link-dots" aria-label="Artist website">%s</a></div>',
			esc_url( $website ),
			esc_url( $website )
		);
	}

	if ( ! empty( $twitter ) ) {
		printf(
			'<div class="d-inline-block me-4"><a target="_blank" href="%s" aria-label="Twitter">%s</a></div>',
			esc_url( $twitter ),
			svg( 'twitter-square-brands' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}

	if ( ! empty( $facebook ) ) {
		printf(
			'<div class="d-inline-block me-4"><a target="_blank" href="%s" aria-label="Facebook">%s</a></div>',
			esc_url( $facebook ),
			svg( 'facebook-square-brands' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}

	if ( ! empty( $instagram ) ) {
		printf(
			'<div class="d-inline-block me-4"><a target="_blank" href="%s" aria-label="Instagram">%s</a></div>',
			esc_url( $instagram ),
			svg( 'instagram-square-brands' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}

	if ( ! empty( $pinterest ) ) {
		printf(
			'<div class="d-inline-block me-4"><a target="_blank" href="%s" aria-label="Pinterest">%s</a></div>',
			esc_url( $pinterest ),
			svg( 'pinterest-square-brands' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}

	if ( ! empty( $bio ) ) {
		printf(
			'<div class="font-alt fst-italic mt-4">%s</div>',
			wp_kses_post( wpautop( $bio ) )
		);
	}
}
