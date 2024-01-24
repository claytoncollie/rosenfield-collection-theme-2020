<?php
/**
 * User Populate.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\UserPopulate;

use WP_User_Query;

/**
 * Actions and filters
 */
function setup(): void {
	add_filter( 'gform_pre_render_1', __NAMESPACE__ . '\populate_user_email_list' );
	add_action( 'gform_user_registered', __NAMESPACE__ . '\add_custom_user_meta', 10, 3 );
	add_filter( 'gform_after_submission_1', __NAMESPACE__ . '\set_post_fields', 10, 2 );
}

/**
 * Set the User ID.
 *
 * @param string $user_id User ID.
 * @param array  $config Configuration options.
 * @param array  $entry Entry data.
 */
function add_custom_user_meta( string $user_id, array $config, array $entry ): void {
	if ( ! isset( $entry[19] ) ) {
		return;
	}
	if ( 'Yes' === $entry[19] ) {
		return;
	}
	if ( ! isset( $entry[22] ) ) {
		return;
	}
	if ( empty( $entry[22] ) ) {
		return;
	}
	set_transient( 'rosenfield_collection_user_id', $user_id );
}

/**
 * Populates the field with a list of users.
 *
 * @param array $form Form data.
 */
function populate_user_email_list( array $form ): array {
	foreach ( $form['fields'] as &$field ) {
		// If the field is not a dropdown and not the specific class, move onto the next one.
		// This acts as a quick means to filter arguments until we find the one we want.
		if ( 'select' !== $field['type'] ) {
			continue;
		}
		if ( 23 !== $field['id'] ) {
			continue;
		}
		$choices = [
			[
				'text'  => __( 'Select a User', 'rosenfield-collection' ),
				'value' => ' ',
			],
		];

		$wp_user_query = new WP_User_Query(
			[
				'orderby' => 'user_nicename',
				'fields'  => [ 
					'id',
					'display_name',
					'user_email',
				],
			]
		);

		$users = $wp_user_query->get_results();

		if ( ! empty( $users ) ) {
			foreach ( $users as $user ) {
				// Make sure the user has an email address, safeguard against users can be imported without email addresses.
				// Also, make sure the user is at least able to edit posts (i.e., not a subscriber). Look at: http://codex.wordpress.org/Roles_and_Capabilities for more ideas.
				if ( empty( $user->user_email ) ) {
					continue;
				}
				if ( ! user_can( $user->id, 'edit_posts' ) ) {
					continue;
				}
				$choices[] = [
					'text'  => $user->display_name,
					'value' => $user->id,
				];
			}
		}
		$field['choices'] = $choices;
	}

	return $form;
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

	// Set Post Author, if existing author is chosen.
	if ( isset( $entry[19] ) && 'Yes' === $entry[19] && isset( $entry[23] ) && ! empty( $entry[23] ) ) {

		// Set post author to author field.
		// Verify that the id is a valid author.
		if ( get_user_by( 'id', $entry[23] ) ) {
			$post->post_author = $entry[23];
		}

		// If it's an existing author, make sure the avatar image is added to the media library.
	} elseif ( isset( $entry[19] ) && 'Yes' !== $entry[19] && isset( $entry[22] ) && ! empty( $entry[22] ) ) {

		// Add new post author image to media library and set simple local avatar.
		$author_image = get_image_id( $entry[22], null );
		$user_id      = get_transient( 'rosenfield_collection_user_id' );
		if ( $author_image && $user_id ) {
			update_field( 'field_55b4095067ec4', $author_image, 'user_' . $user_id );
		}
	}

	// Clean up images upload and create array for gallery field.
	if ( isset( $entry[27] ) ) {
		$images = stripslashes( (string) $entry[27] );
		$images = json_decode( $images, true );
		if ( ! empty( $images ) && is_array( $images ) ) {
			$gallery = [];
			foreach ( $images as $image ) {
				$image_id = get_image_id( $image, $post->ID );
				if ( 0 !== $image_id ) {
					$gallery[] = $image_id;
				}
			}
		}
	}

	// Update gallery field with array.
	if ( ! empty( $gallery ) ) {
		update_field( 'field_546d0ad42e7f0', $gallery, $post->ID );
	}

	// Updating post.
	wp_update_post( $post );
}

/**
 * Create the image and return the new media upload id.
 *
 * @see http://codex.wordpress.org/Function_Reference/wp_insert_attachment#Example
 * 
 * @param string $image_url Image URL.
 * @param string $parent_post_id Post ID of parent object.
 */
function get_image_id( string $image_url, string $parent_post_id = null ): int {
	if ( ! isset( $image_url ) ) {
		return 0;
	}

	// Cache info on the wp uploads dir.
	$wp_upload_dir = wp_upload_dir();

	// Get the file path.
	$path = wp_parse_url( $image_url );

	// File base name.
	$file_base_name = basename( $image_url );

	// Full path.
	$home_path = defined( 'GFUP_SUB_DIRECTORY' ) && GFUP_SUB_DIRECTORY === true ? dirname( __DIR__, 4 ) : dirname( __DIR__, 3 );
	$home_path = untrailingslashit( $home_path );

	$uploaded_file_path = str_replace( '/wp-content', '', $home_path ) . $path['path'];

	// Check the type of file. We'll use this as the 'post_mime_type'.
	$filetype = wp_check_filetype( $file_base_name, null );

	if ( ! empty( $filetype ) && is_array( $filetype ) ) {

		// Create attachment title.
		$post_title = preg_replace( '/\.[^.]+$/', '', $file_base_name );

		// Prepare an array of post data for the attachment.
		$attachment = [
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $uploaded_file_path ),
			'post_mime_type' => $filetype['type'],
			'post_title'     => esc_attr( $post_title ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		];

		// Set the post parent id if there is one.
		if ( ! is_null( $parent_post_id ) ) {
			$attachment['post_parent'] = $parent_post_id;
		}

		// Insert the attachment.
		$attach_id = wp_insert_attachment( $attachment, $uploaded_file_path );

		if ( ! is_wp_error( $attach_id ) ) {
			// Generate wp attachment meta data.
			if ( file_exists( ABSPATH . 'wp-admin/includes/image.php' ) && file_exists( ABSPATH . 'wp-admin/includes/media.php' ) ) {
				require_once ABSPATH . 'wp-admin/includes/image.php';
				require_once ABSPATH . 'wp-admin/includes/media.php';

				$attach_data = wp_generate_attachment_metadata( $attach_id, $uploaded_file_path );
				wp_update_attachment_metadata( $attach_id, $attach_data );
			} // end if file exists check
		}

		return $attach_id;

	}
	return 0;
}
