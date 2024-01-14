<?php
/**
 * Claim Object.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\ClaimObject;

use const RosenfieldCollection\Theme\Fields\PENDING_SLUG;
use const RosenfieldCollection\Theme\PostTypes\PAGE_SLUG;
use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;

/**
 * Setup
 */
function setup(): void {
	add_action( 'parse_request', __NAMESPACE__ . '\redirect_after_trash' );
	add_filter( 'acf/update_value/name=rc_featured_image', __NAMESPACE__ . '\claim_set_featured_image', 99, 2 );
	add_filter( 'acf/save_post', __NAMESPACE__ . '\claim_post_status_transition', 30, 1 );
	add_filter( 'acf/save_post', __NAMESPACE__ . '\claim_delete_attachment', 5, 1 );
}

/**
 * Redirect user to pending page after a post has been deleted.
 */
function redirect_after_trash(): void {
	if ( is_admin() ) {
		return;
	}

	if ( array_key_exists( 'trashed', $_GET ) && '1' === $_GET['trashed'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		wp_safe_redirect( get_bloginfo( 'url' ) . '/pending' );
		exit;
	}
}

/**
 * Display post author.
 */
function do_claim_meta(): void {
	$post_id = get_query_var( 'post_id' );
	$post_id = $post_id ? (int) $post_id : 0; // @phpstan-ignore-line
	if ( empty( $post_id ) ) {
		return;
	}

	$author_id = get_post_field( 'post_author', $post_id );
	$author_id = empty( $author_id ) ? 0 : (int) $author_id;
	if ( empty( $author_id ) ) {
		return;
	}

	printf(
		'<section class="claim-header"><div class="wrap"><h2>%s %s</h2><a href="%s" class="button warning">Delete</a></div></section>',
		esc_html( get_the_author_meta( 'first_name', $author_id ) ),
		esc_html( get_the_author_meta( 'last_name', $author_id ) ),
		esc_url( wp_nonce_url( get_admin_url() . 'post.php?post=' . $post_id . '&action=trash', 'trash-post_' . $post_id ) )
	);
}

/**
 * Frontend editing form for POSTs.
 */
function acf_form_claim(): void {
	$post_id = get_query_var( 'post_id' );
	$post_id = $post_id ? (int) $post_id : 0; // @phpstan-ignore-line
	if ( empty( $post_id ) ) {
		return;
	}

	$post = get_page_by_path( PENDING_SLUG, OBJECT, PAGE_SLUG );

	acf_form(
		[
			'post_id'           => $post_id,
			'post_title'        => true,
			'post_content'      => false,
			'field_groups'      => [ 6277, 22858, 26396 ],
			'html_after_fields' => '<input type="hidden" name="acf[claim]" value="true"/>',
			'return'            => (string) get_permalink( $post ), // @phpstan-ignore-line
			'submit_value'      => esc_html__( 'Save Draft', 'rosenfield-collection' ),
		]
	);
}

/**
 * Set the featured image on form submission.
 *
 * @param int $value Field value.
 * @param int $post_id Post ID.
 */
function claim_set_featured_image( int $value, int $post_id ): int {
	if ( empty( $_POST['acf']['claim'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		return $post_id;
	}

	if ( is_admin() ) {
		return $value;
	}

	if ( POST_SLUG !== get_post_type( $post_id ) ) {
		return $value;
	}

	if ( PENDING_SLUG !== get_post_status( $post_id ) ) {
		return $value;
	}

	if ( ! empty( $value ) ) {
		set_post_thumbnail( $post_id, $value );
	}

	return $value;
}

/**
 * Convert post status from PENDING to  DRAFT on form submission.
 *
 * Sends email on form submission to admin_email(s).
 *
 * @param int $post_id Post ID.
 */
function claim_post_status_transition( int $post_id ): int {
	if ( empty( $_POST['acf']['claim'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		return $post_id;
	}

	if ( is_admin() ) {
		return $post_id;
	}

	if ( POST_SLUG !== get_post_type( $post_id ) ) {
		return $post_id;
	}

	if ( PENDING_SLUG !== get_post_status( $post_id ) ) {
		return $post_id;
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	if ( ! empty( $_POST['acf']['claim'] ) && 'true' !== $_POST['acf']['claim'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		return $post_id;
	}

	$post_id = wp_update_post(
		[
			'ID'          => $post_id,
			'post_status' => 'draft',
		]
	);

	if ( ! empty( $post_id ) ) {
		wp_mail(
			get_bloginfo( 'admin_email' ),
			esc_html__( 'Rosenfield Collection: Awaiting Approval', 'rosenfield-collection' ),
			sprintf(
				'%s: %s',
				esc_html__( 'Object is awaiting approval', 'rosenfield-collection' ),
				esc_url( (string) get_edit_post_link( $post_id ) )
			)
		);
	}

	return $post_id;
}

/**
 * Delete the pending posts featured image from database and filesystem.
 *
 * @param int $post_id Post ID.
 */
function claim_delete_attachment( int $post_id ): int {
	if ( empty( $_POST['acf']['claim'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		return $post_id;
	}

	if ( is_admin() ) {
		return $post_id;
	}

	if ( POST_SLUG !== get_post_type( $post_id ) ) {
		return $post_id;
	}

	if ( PENDING_SLUG !== get_post_status( $post_id ) ) {
		return $post_id;
	}

	if ( has_post_thumbnail( $post_id ) ) {
		$attachment_id = get_post_thumbnail_id( $post_id );
		$attachment_id = $attachment_id ? (int) $attachment_id : 0;
		if ( ! empty( $attachment_id ) ) {
			wp_delete_attachment( $attachment_id, true );
		}
	}

	return $post_id;
}
