<?php
/**
 * Gravity Forms.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\GravityForms;

use WP_User_Query;

use const RosenfieldCollection\Theme\Fields\ARTIST_FILTER;
use const RosenfieldCollection\Theme\Taxonomies\LOCATION;

/**
 * Transient slug
 * 
 * @var string
 */
const USER_ID_TRANSIENT = 'rosenfield_collection_user_id';

/**
 * Actions and filters
 */
function setup(): void {
	// Show all artist in select field.
	add_filter( 'gform_pre_render_1', __NAMESPACE__ . '\filter_select_field_options' );
	add_filter( 'gform_pre_render_6', __NAMESPACE__ . '\filter_select_field_options' );
	// Save the user ID as a transient.
	add_action( 'gform_user_registered', __NAMESPACE__ . '\set_user_id' );
	// Add a new object to the collection.
	add_action( 'gform_after_submission_1', __NAMESPACE__ . '\set_post_author_id' );
	add_action( 'gform_after_submission_1', __NAMESPACE__ . '\set_post_author_letter' );
	add_action( 'gform_after_submission_1', __NAMESPACE__ . '\set_post_author_avatar' );
	add_action( 'gform_after_submission_1', __NAMESPACE__ . '\set_post_images' );
	// Claim an existing object in the collection.
	add_action( 'gform_after_submission_6', __NAMESPACE__ . '\set_post_author_id' );
	add_action( 'gform_after_submission_6', __NAMESPACE__ . '\set_post_author_letter' );
	add_action( 'gform_after_submission_6', __NAMESPACE__ . '\set_post_terms' );
}

/**
 * Populates the field with a list of users.
 *
 * @param array $form Form data.
 */
function filter_select_field_options( array $form ): array {
	$fields = $form['fields'] ?? [];
	if ( empty( $fields ) ) {
		return $form;
	}

	foreach ( $fields as $field ) {
		$field_type = $field['type'] ?? '';
		if ( 'select' !== $field_type ) {
			continue;
		}

		$field_id = $field['id'] ?? 0;
		if ( 23 !== $field_id ) {
			continue;
		}

		$query = new WP_User_Query(
			[
				'orderby' => 'user_nicename',
				'fields'  => [ 
					'id',
					'display_name',
					'user_email',
				],
			]
		);

		$users = $query->get_results();
		if ( empty( $users ) ) {
			continue;
		}

		$choices = [
			[
				'text'  => __( 'Select a User', 'rosenfield-collection' ),
				'value' => ' ',
			],
		];

		foreach ( $users as $user ) {
			if ( empty( $user->user_email ) ) {
				continue;
			}
			if ( ! user_can( $user->id, 'edit_posts' ) ) { // @phpstan-ignore-line
				continue;
			}

			$choices[] = [
				'text'  => $user->display_name, // @phpstan-ignore-line
				'value' => $user->id, // @phpstan-ignore-line
			];
		}

		$field['choices'] = $choices;
	}

	return $form;
}

/**
 * Set the User ID.
 *
 * @param string $user_id User ID.
 */
function set_user_id( string $user_id ): void {
	set_transient( USER_ID_TRANSIENT, $user_id );
}

/**
 * Set the post author.
 *
 * @param array $entry Entry data.
 */
function set_post_author_id( array $entry ): void {
	$post_id = $entry['post_id'] ?? 0;
	if ( empty( $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );
	if ( is_null( $post ) ) {
		return;
	}

	$post_author = $entry[23] ?? 0;
	if ( empty( $post_author ) ) {
		return;
	}

	$is_post_author = get_user_by( 'id', $post_author );
	if ( ! $is_post_author ) {
		return;
	}

	wp_update_post( 
		[
			'post_author' => $post_author,
		]
	);
}

/**
 * Set the post author letter field for easy filtering
 */
function set_post_author_letter(): void {
	$user_id = get_transient( USER_ID_TRANSIENT );
	if ( empty( $user_id ) ) {
		return;
	}

	$field = get_field( ARTIST_FILTER, $user_id );
	if ( ! empty( $field ) ) {
		return;
	}

	$user_id = str_replace( 'user_', '', (string) $user_id ); // @phpstan-ignore-line
	$name    = get_user_meta( (int) $user_id, 'last_name', true );
	if ( empty( $name ) ) {
		$name = get_user_meta( (int) $user_id, 'first_name', true );
	}

	$letter = mb_substr( (string) $name, 0, 1 ); // @phpstan-ignore-line
	$letter = strtolower( $letter );

	update_user_meta( (int) $user_id, ARTIST_FILTER, $letter );
}

/**
 * Set the post author avatar.
 *
 * @param array $entry Entry data.
 */
function set_post_author_avatar( array $entry ): void {
	$post_id = $entry['post_id'] ?? 0;
	if ( empty( $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );
	if ( is_null( $post ) ) {
		return;
	}

	$avatar = $entry[33] ?? 0;
	if ( empty( $avatar ) ) {
		return;
	}

	$image_id = get_image_id( $avatar );
	if ( empty( $image_id ) ) {
		return;
	}
		
	$user_id = get_transient( USER_ID_TRANSIENT );
	if ( empty( $user_id ) ) {
		return;
	}
			
	update_field( 'field_55b4095067ec4', $image_id, 'user_' . $user_id );
}

/**
 * Attach images to post gallery meta & author.
 *
 * @param array $entry Entry data.
 */
function set_post_images( array $entry ): void {
	$post_id = $entry['post_id'] ?? 0;
	if ( empty( $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );
	if ( is_null( $post ) ) {
		return;
	}

	$files = $entry[27] ?? '';
	if ( empty( $files ) ) {
		return;
	}

	$images = stripslashes( (string) $files );
	if ( empty( $images ) ) {
		return;
	}

	$images = json_decode( $images, true );
	if ( empty( $images ) ) {
		return;
	}
	if ( ! is_array( $images ) ) {
		return;
	}

	$gallery = [];
	foreach ( $images as $image ) {
		$image_id = get_image_id( $image, $post->ID );
		if ( 0 !== $image_id ) {
			$gallery[] = $image_id;
		}
	}

	if ( empty( $gallery ) ) {
		return;
	}
		
	update_field( 'field_546d0ad42e7f0', $gallery, $post->ID );
}

/**
 * Attach images to post gallery meta & author.
 *
 * @param array $entry Entry data.
 */
function set_post_terms( array $entry ): void {
	$post_id = $entry['post_id'] ?? 0;
	if ( empty( $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );
	if ( is_null( $post ) ) {
		return;
	}

	$existing_purchase_location = $entry[20] ?? '';
	$new_purchase_location      = $entry[14] ?? '';
	if ( ! empty( $new_purchase_location ) ) {
		$insert_term = wp_insert_term( $new_purchase_location, LOCATION );
		$term_id     = is_wp_error( $insert_term ) ? $insert_term->error_data['term_exists'] : $insert_term['term_id'];

		if ( ! empty( $term_id ) && ! is_wp_error( $term_id ) ) {
			$term = get_term( $term_id, LOCATION );

			if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
				wp_set_post_terms( 
					$post->ID,
					$term->name, // @phpstan-ignore-line
					LOCATION,
					false 
				);
			}
		}
	} elseif ( ! empty( $existing_purchase_location ) ) {
		$term = get_term( $existing_purchase_location, LOCATION );

		if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
			wp_set_post_terms( 
				$post->ID,
				$term->name, // @phpstan-ignore-line
				LOCATION,
				false 
			);
		}
	}
}

/**
 * Create the image and return the new media upload id.
 * 
 * @param string   $image_url Image URL.
 * @param int|null $parent_post_id Post ID of parent object.
 */
function get_image_id( string $image_url, ?int $parent_post_id = null ): int {
	// Cache info on the wp uploads dir.
	$wp_upload_dir = wp_upload_dir();
	
	// Get the file path.
	$path = wp_parse_url( $image_url );
	
	// File base name.
	$file_base_name = basename( $image_url );
	
	// Full path.
	$home_path = defined( 'GFUP_SUB_DIRECTORY' ) && \GFUP_SUB_DIRECTORY === true ? dirname( __DIR__, 4 ) : dirname( __DIR__, 3 );
	$home_path = untrailingslashit( $home_path );
	
	// Adjust the file path.
	$file_path          = $path['path'] ?? '';
	$uploaded_file_path = str_replace( '/wp-content', '', $home_path ) . $file_path;
	
	// Check the type of file. We'll use this as the 'post_mime_type'.
	$filetype = wp_check_filetype( $file_base_name );
	if ( empty( $filetype ) ) { // @phpstan-ignore-line
		return 0;
	}
	if ( ! is_array( $filetype ) ) {
		return 0;
	}

	// Prepare an array of post data for the attachment.
	$attachment = [
		'guid'           => $wp_upload_dir['url'] . '/' . basename( $uploaded_file_path ),
		'post_mime_type' => $filetype['type'],
		'post_title'     => preg_replace( '/\.[^.]+$/', '', $file_base_name ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	];

	// Set the post parent id if there is one.
	if ( ! is_null( $parent_post_id ) ) {
		$attachment['post_parent'] = $parent_post_id;
	}

	// Insert the attachment.
	$attachment_id = wp_insert_attachment( $attachment, $uploaded_file_path );
	if ( is_wp_error( $attachment_id ) ) { // @phpstan-ignore-line
		return 0;
	}

	if ( ! file_exists( ABSPATH . 'wp-admin/includes/image.php' ) ) {
		return 0;
	}   

	require_once ABSPATH . 'wp-admin/includes/image.php';

	if ( ! file_exists( ABSPATH . 'wp-admin/includes/media.php' ) ) {
		return 0;
	}
	
	require_once ABSPATH . 'wp-admin/includes/media.php';

	// Generate meta data.
	$attachment_data = wp_generate_attachment_metadata( $attachment_id, $uploaded_file_path );
	
	// Insert meta data.
	wp_update_attachment_metadata( $attachment_id, $attachment_data );

	return $attachment_id;
}
