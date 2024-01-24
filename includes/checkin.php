<?php
/**
 * Check In.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\CheckIn;

use WP_User_Query;

use const RosenfieldCollection\Theme\Taxonomies\LOCATION;

/**
 * Actions and Filters
 */
function setup(): void {
	add_filter( 'gform_pre_render_6', __NAMESPACE__ . '\populate_user_list' );
	add_action( 'gform_user_registered', __NAMESPACE__ . '\set_user_id', 10, 3 );
	add_action( 'gform_after_submission_6', __NAMESPACE__ . '\set_post_fields', 10 );
}

/**
 * Populates the field with a list of users.
 *
 * @param array $form Form data.
 */
function populate_user_list( array $form ): array {
	foreach ( $form['fields'] as &$field ) {
		// If the field is not a dropdown and not the specific class, move onto the next one.
		// This acts as a quick means to filter arguments until we find the one we want.
		if ( 'select' !== $field['type'] ) {
			continue;
		}
		if ( 2 !== $field['id'] ) {
			continue;
		}
		// The first, "select" option.
		$choices = [
			[
				'text'  => __( 'Select a User', 'rosenfield-collection' ),
				'value' => ' ',
			],
		];

		$wp_user_query = new WP_User_Query(
			[
				'orderby' => 'user_nicename',
			]
		);

		$users = $wp_user_query->get_results();

		if ( ! empty( $users ) ) {
			foreach ( $users as $user ) {
				// Make sure the user has an email address, safeguard against users can be imported without email addresses
				// Also, make sure the user is at least able to edit posts (i.e., not a subscriber). 
				// Look at: http://codex.wordpress.org/Roles_and_Capabilities for more ideas.
				if ( empty( $user->user_email ) ) {
					continue;
				}
				if ( ! user_can( $user->id, 'edit_posts' ) ) { // @phpstan-ignore-line
					continue;
				}
				// Add users to select.
				$choices[] = [
					'text'  => $user->display_name, // @phpstan-ignore-line
					'value' => $user->id, // @phpstan-ignore-line
				];
			}
		}
		$field['choices'] = $choices;
	}

	return $form;
}

/**
 * Sets the new user's user id
 *
 * @param int   $user_id User ID.
 * @param array $feed Feed data.
 * @param array $entry Entry data.
 */
function set_user_id( int $user_id, array $feed, array $entry ): void {
	$has_post_author = $entry[17] ?? 'No';
	if ( 'Yes' === $has_post_author ) {
		return;
	}

	set_transient( 'rosenfield_collection_user_id_for_form_6', $user_id );
}

/**
 * Attach images to post gallery meta & author.
 *
 * @param array $entry Entry data.
 */
function set_post_fields( array $entry ): void {
	$post_id = $entry['post_id'] ?? 0;
	if ( empty( $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );
	if ( is_null( $post ) ) {
		return;
	}

	$has_post_author = $entry[17] ?? 'No';
	$post_author_id  = $entry[2] ?? 0;
	$is_post_author  = get_user_by( 'id', $post_author_id );
	// Set Post Author, if existing author is chosen.
	// Set post author to author field and verify that the id is a valid author.
	if ( 'Yes' === $has_post_author && $is_post_author ) {
		wp_update_post( 
			[
				'post_author' => $post_author_id,
			]
		);
	}

	// Set post term.
	if ( ! empty( $entry[14] ) ) {
		$insert_term = wp_insert_term( $entry[14], LOCATION );
		$term_id     = is_wp_error( $insert_term ) ? $insert_term->error_data['term_exists'] : $insert_term['term_id'];

		if ( ! empty( $term_id ) && ! is_wp_error( $term_id ) ) {
			$term = get_term( $term_id, LOCATION, ARRAY_A );

			if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
				wp_set_post_terms( 
					$post->ID,
					$term['name'],
					LOCATION,
					false 
				);
			}
		}
	} elseif ( isset( $entry[20] ) && ! empty( $entry[20] ) ) {
		$term = get_term( $entry[20], LOCATION, ARRAY_A );

		if ( is_array( $term ) ) {
			wp_set_post_terms( 
				$post->ID,
				$term['name'],
				LOCATION,
				false 
			);
		}
	}
}
