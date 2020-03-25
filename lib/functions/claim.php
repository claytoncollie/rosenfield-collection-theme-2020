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
 * Frontend editing form for POSTs.
 *
 * @return void
 * @since 1.3.0
 */
function acf_form_claim() {
	$post_id = get_query_var( 'post_id' );

	if ( ! empty( $post_id ) ) {
		acf_form(
			array(
				'post_id'           => absint( $post_id ),
				'post_title'        => true,
				'post_content'      => false,
				'field_groups'      => array( 6277, 22858, 26396 ),
				'html_after_fields' => '<input type="hidden" name="acf[claim]" value="true"/>',
				'return'            => get_permalink( get_page_by_path( 'pending', OBJECT, 'page' ) ),
				'submit_value'      => esc_html__( 'Save Draft', 'rosenfield-collection-2020' ),
			)
		);
	}
}

\add_filter( 'acf/update_value/name=rc_featured_image', __NAMESPACE__ . '\claim_set_featured_image', 99, 3 );
/**
 * Set the featured image on form submission.
 *
 * @param integer $value Field value.
 * @param int     $post_id Post ID.
 * @param array   $field Field settings.
 * @return integer
 * @since 1.3.0
 */
function claim_set_featured_image( $value, $post_id, $field ) {
	if ( empty( $_POST['acf']['claim'] ) ) {
		return $post_id;
	}

	if ( is_admin() ) {
		return $value;
	}

	if ( 'post' !== get_post_type( $post_id ) ) {
		return $value;
	}

	if ( 'pending' !== get_post_status( $post_id ) ) {
		return $value;
	}

	if ( ! empty( $value ) ) {
		set_post_thumbnail( $post_id, $value );
	}

	return $value;
}

\add_filter( 'acf/save_post', __NAMESPACE__ . '\claim_post_status_transition', 30, 1 );
/**
 * Convert post status from PENDING to  DRAFT on form submission.
 *
 * Sendings email on form submission to admin_email(s).
 *
 * @param integer $post_id Post ID.
 * @return int
 * @since 1.3.0
 */
function claim_post_status_transition( $post_id ) {
	if ( empty( $_POST['acf']['claim'] ) ) {
		return $post_id;
	}

	if ( is_admin() ) {
		return $post_id;
	}

	if ( 'post' !== get_post_type( $post_id ) ) {
		return $post_id;
	}

	if ( 'pending' !== get_post_status( $post_id ) ) {
		return $post_id;
	}

	if ( ! empty( $_POST['acf']['claim'] ) ) {
		if ( 'true' !== $_POST['acf']['claim'] ) {
			return $post_id;
		}
	}

	$post_id = wp_update_post(
		array(
			'ID'          => $post_id,
			'post_status' => 'draft',
		)
	);

	if ( ! empty( $post_id ) ) {
		wp_mail(
			get_bloginfo( 'admin_email' ),
			esc_html__( 'Rosenfield Collection: Awaiting Approval', 'rosenfield-collection-2020' ),
			sprintf(
				'%s: %s',
				esc_html__( 'Object is awating approval', 'rosenfield-collection-2020' ),
				esc_url( get_edit_post_link( $post_id ) )
			)
		);
	}

	return $post_id;
}

\add_filter( 'acf/save_post', __NAMESPACE__ . '\claim_delete_attachment', 5, 1 );
/**
 * Delete the pending posts featured image from database and filesystem.
 *
 * @param integer $post_id Post ID.
 * @return int
 * @since 1.3.0
 */
function claim_delete_attachment( $post_id ) {
	if ( empty( $_POST['acf']['claim'] ) ) {
		return $post_id;
	}

	if ( is_admin() ) {
		return $post_id;
	}

	if ( 'post' !== get_post_type( $post_id ) ) {
		return $post_id;
	}

	if ( 'pending' !== get_post_status( $post_id ) ) {
		return $post_id;
	}

	if ( has_post_thumbnail( $post_id ) ) {
		$attachment_id = get_post_thumbnail_id( $post_id );
		wp_delete_attachment( $attachment_id, true );
	}

	return $post_id;
}
