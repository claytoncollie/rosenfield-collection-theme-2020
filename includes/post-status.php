<?php
/**
 * Post Status.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\PostStatus;

use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;

/**
 * Post status slug
 * 
 * @var string
 */
const ARCHIVE_SLUG = 'archive';

/**
 * Setup
 */
function setup(): void {
	add_action( 'init', __NAMESPACE__ . '\register_archive_status' );
	add_action( 'admin_footer-post.php', __NAMESPACE__ . '\append_to_post_status_dropdown' );
	add_filter( 'display_post_states', __NAMESPACE__ . '\update_post_status' );
}

/**
 * Register the custom post status with WordPress.
 */
function register_archive_status(): void {
	register_post_status( 
		ARCHIVE_SLUG, 
		[
			'label'                     => _x( 'Archive', 'Status General Name', 'rosenfield-collection' ),
			'label_count'               => _n_noop( 'Archive (%s)', 'Archives (%s)', 'rosenfield-collection' ), // phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
			'public'                    => false,
			'protected'                 => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'exclude_from_search'       => true,
		] 
	);
}

/**
 * Append the custom post type to the post status dropdown on the edit pages of posts.
 */
function append_to_post_status_dropdown(): void {
	global $post;
	if ( POST_SLUG !== $post->post_type ) {
		return;
	}

	$selected = ARCHIVE_SLUG === $post->post_status ? ' selected="selected"' : '';
	$label    = ARCHIVE_SLUG === $post->post_status ? '<span id="post-status-display"> Archived</span>' : '';

	// phpcs:disable
	echo "
		<script>
		jQuery(document).ready(function ($){
			$('select#post_status').append('<option value=\"archive\"{$selected}>Archive</option>');
			$('.misc-pub-section label').append('{$label}');
		});
		</script>";
	// phpcs:enable
}

/**
 * Update the text on edit.php to be more descriptive of the type of post (text that labels each post)
 *
 * @param array $states Post status states.
 */
function update_post_status( array $states ): array {
	$screen = get_query_var( 'post_status' );
	if ( ARCHIVE_SLUG !== $screen ) {
		return $states;
	}

	$status = get_post_status();
	$status = $status ? (string) $status : '';
	if ( ARCHIVE_SLUG !== $status ) {
		return $states;
	}
	
	$states[] = esc_html__( 'Archived', 'rosenfield-collection' );
	return $states;
}
