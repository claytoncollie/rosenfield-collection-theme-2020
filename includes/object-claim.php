<?php
/**
 * Object Claim.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\ObjectClaim;

use const RosenfieldCollection\Theme\Fields\PENDING_SLUG;
use const RosenfieldCollection\Theme\PostTypes\PAGE_SLUG;
use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;
use const RosenfieldCollection\Theme\QueryVars\POST_ID_VAR;

/**
 * Setup
 */
function setup(): void {
	add_action( 'parse_request', __NAMESPACE__ . '\redirect_after_trash' );
	add_filter( 'acf/update_value/name=rc_featured_image', __NAMESPACE__ . '\set_featured_image', 99, 2 );
	add_action( 'acf/save_post', __NAMESPACE__ . '\transition_to_draft', 30, 1 );
	add_action( 'acf/save_post', __NAMESPACE__ . '\delete_attachment', 5, 1 );
}

/**
 * Redirect user to pending page after a post has been deleted.
 */
function redirect_after_trash(): void {
	if ( is_admin() ) {
		return;
	}

	$is_trashed = filter_input( INPUT_GET, 'trashed', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
	if ( '1' !== $is_trashed ) {
		return;
	}

	$post = get_page_by_path( PENDING_SLUG, OBJECT, PAGE_SLUG );
	if ( empty( $post ) ) {
		return;
	}

	wp_safe_redirect( get_permalink( $post ) );
	exit;
}

/**
 * Display post author.
 */
function do_claim_meta(): void {
	$post_id = get_query_var( POST_ID_VAR );
	$post_id = $post_id ? (int) $post_id : 0; // @phpstan-ignore-line
	if ( empty( $post_id ) ) {
		return;
	}

	$author_id = get_post_field( 'post_author', $post_id );
	$author_id = empty( $author_id ) ? 0 : (int) $author_id;
	if ( empty( $author_id ) ) {
		return;
	}

	$permalink = add_query_arg(
		[
			'post'   => $post_id,
			'action' => 'trash',
		],
		get_admin_url() . 'post.php'
	);
	$permalink = wp_nonce_url( $permalink, 'trash-post_' . $post_id );
	if ( empty( $permalink ) ) {
		return;
	}   

	$first_name = get_the_author_meta( 'first_name', $author_id );
	$last_name  = get_the_author_meta( 'last_name', $author_id );
	$full_name  = $first_name . ' ' . $last_name;

	printf(
		'<section class="claim-header"><div class="wrap"><h2>%s</h2><a href="%s" class="button warning">%s</a></div></section>',
		esc_html( $full_name ),
		esc_url( $permalink ),
		esc_html__( 'Delete', 'rosenfield-collection' )
	);
}

/**
 * Frontend editing form for POSTs.
 */
function acf_form_claim(): void {
	$post_id = get_query_var( POST_ID_VAR );
	$post_id = $post_id ? (int) $post_id : 0; // @phpstan-ignore-line
	if ( empty( $post_id ) ) {
		return;
	}

	$post = get_page_by_path( PENDING_SLUG, OBJECT, PAGE_SLUG );
	if ( empty( $post ) ) {
		return;
	}

	acf_form(
		[
			'post_id'           => $post_id,
			'post_title'        => true,
			'post_content'      => false,
			'field_groups'      => [ 'group_54563456rjr67jr6708ddf', 'group_5e75dg6699894fb9dc81c' ],
			'html_after_fields' => '<input type="hidden" name="acf[claim]" value="true"/>',
			'return'            => get_permalink( $post ), // @phpstan-ignore-line
			'submit_value'      => esc_html__( 'Save as a Draft', 'rosenfield-collection' ),
		]
	);
}

/**
 * Set the featured image on form submission.
 *
 * @param int $value Field value.
 * @param int $post_id Post ID.
 */
function set_featured_image( int $value, int $post_id ): int {
	if ( is_admin() ) {
		return $value;
	}

	$is_claim = isset( $_POST['acf']['claim'] ) ? sanitize_text_field( $_POST['acf']['claim'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
	if ( 'true' !== $is_claim ) { 
		return $value;
	}

	$post_type = get_post_type( $post_id );
	$post_type = $post_type ? (string) $post_type : '';
	if ( POST_SLUG !== $post_type ) {
		return $value;
	}

	$post_status = get_post_status( $post_id );
	$post_status = $post_status ? (string) $post_status : '';
	if ( PENDING_SLUG !== $post_status ) {
		return $value;
	}

	// Set the featured image ID.
	set_post_thumbnail( $post_id, $value );

	return $value;
}

/**
 * Convert post status from PENDING to  DRAFT on form submission.
 *
 * Sends email on form submission to admin_email(s).
 *
 * @param int|string $post_id Post ID.
 */
function transition_to_draft( int|string $post_id ): void {
	if ( is_admin() ) {
		return;
	}

	$is_claim = isset( $_POST['acf']['claim'] ) ? sanitize_text_field( $_POST['acf']['claim'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
	if ( 'true' !== $is_claim ) { 
		return;
	}

	$post_type = get_post_type( (int) $post_id );
	$post_type = $post_type ? (string) $post_type : '';
	if ( POST_SLUG !== $post_type ) {
		return;
	}

	$post_status = get_post_status( (int) $post_id );
	$post_status = $post_status ? (string) $post_status : '';
	if ( PENDING_SLUG !== $post_status ) {
		return;
	}

	$post_id = wp_update_post(
		[
			'ID'          => (int) $post_id,
			'post_status' => 'draft',
		]
	);

	if ( empty( $post_id ) ) {
		return;
	}

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

/**
 * Delete the pending posts featured image from database and filesystem.
 *
 * @param int|string $post_id Post ID.
 */
function delete_attachment( int|string $post_id ): void {
	if ( is_admin() ) {
		return;
	}

	$is_claim = isset( $_POST['acf']['claim'] ) ? sanitize_text_field( $_POST['acf']['claim'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
	if ( 'true' !== $is_claim ) { 
		return;
	}

	$post_type = get_post_type( (int) $post_id );
	$post_type = $post_type ? (string) $post_type : '';
	if ( POST_SLUG !== $post_type ) {
		return;
	}

	$post_status = get_post_status( (int) $post_id );
	$post_status = $post_status ? (string) $post_status : '';
	if ( PENDING_SLUG !== $post_status ) {
		return;
	}

	if ( ! has_post_thumbnail( (int) $post_id ) ) {
		return;
	}
	
	$attachment_id = get_post_thumbnail_id( (int) $post_id );
	$attachment_id = $attachment_id ? (int) $attachment_id : 0;
	if ( empty( $attachment_id ) ) {
		return;
	}
		
	wp_delete_attachment( $attachment_id, true );
}
