<?php
/**
 * WordPress Support.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\WordPress;

use const RosenfieldCollection\Theme\ImageSizes\IMAGE_ARCHIVE;
use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;

/**
 * Actions and filters
 */
function setup(): void {
	add_action( 'init', __NAMESPACE__ . '\register_support' );
	add_filter( 'use_block_editor_for_post_type', __NAMESPACE__ . '\disable_block_editor', 10, 2 );
	add_action( 'init', __NAMESPACE__ . '\clean_header' );
	add_filter( 'xmlrpc_methods', __NAMESPACE__ . '\remove_xmlrpc_pingback_ping' );
	add_action( 'load-edit.php', __NAMESPACE__ . '\no_category_dropdown' );
	add_filter( 'the_excerpt_rss', __NAMESPACE__ . '\add_image_to_rss' );
	add_filter( 'the_content_feed', __NAMESPACE__ . '\add_image_to_rss' );
	add_filter( 'post_row_actions', __NAMESPACE__ . '\remove_quick_edit', 10, 1 );
	add_action( 'admin_init', __NAMESPACE__ . '\remove_admin_color_scheme_picker' );
	add_filter( 'user_contactmethods', __NAMESPACE__ . '\modify_user_contact_methods', 99, 1 );
}

/**
 * Register support for WordPress functionality.
 */
function register_support(): void {
	// Disable plugin/theme editor.
	if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
		define( 'DISALLOW_FILE_EDIT', true );
	}
	// Disable Post By Email on options-writing.php.
	add_filter( 'enable_post_by_email_configuration', '__return_false' );
	// Disable Update Services on options-writing.php.
	add_filter( 'enable_update_services_configuration', '__return_false' );
	// Remove language dropdown on login screen.
	add_filter( 'login_display_language_dropdown', '__return_false' );
}

/**
 * Enabling the Gutenberg editor all post types except post.
 *
 * @param bool   $can_edit  Whether to use the Gutenberg editor.
 * @param string $post_type Name of WordPress post type.
 */
function disable_block_editor( bool $can_edit, string $post_type ): bool {
	if ( POST_SLUG === $post_type ) {
		return false;
	}

	return $can_edit;
}

/**
 * Cleans out unused HTML on wp_head
 */
function clean_header(): void {
	// Remove feed links.
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	// Remove Shortlink URL.
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
	// Remove rsd link.
	remove_action( 'wp_head', 'rsd_link' );
	// Remove Windows Live Writer.
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// Index link.
	remove_action( 'wp_head', 'index_rel_link' );
	// Previous link.
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// Start link.
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// Links for adjacent posts.
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// Remove WP version.
	remove_action( 'wp_head', 'wp_generator' );
	// Remove WP emoji.
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}

/**
 * Remove XMLRPC pingback
 *
 * @param array $methods XMLRPC methods.
 */
function remove_xmlrpc_pingback_ping( array $methods ): array {
	unset( $methods['pingback.ping'] );
	return $methods;
}

/**
 * Remove category drop down on edit.php
 */
function no_category_dropdown(): void {
	add_filter( 'wp_dropdown_cats', '__return_false' );
}

/**
 * Add featured image to RSS feed item.
 *
 * @param string $content RSS content.
 */
function add_image_to_rss( string $content ): string {
	$post_id = get_the_ID();
	$post_id = $post_id ? (int) $post_id : 0;
	if ( empty( $post_id ) ) {
		return $content;
	}

	if ( ! has_post_thumbnail( $post_id ) ) {
		return $content;
	}

	$permalink = get_permalink( $post_id );
	$permalink = $permalink ? (string) $permalink : '';
	if ( empty( $permalink ) ) {
		return $content;
	}

	return sprintf(
		'<a href="%s">%s</a>',
		$permalink,
		get_the_post_thumbnail(
			$post_id,
			IMAGE_ARCHIVE
		)
	);
}

/**
 * Remove the Quick Edit link from the post edit table.
 *
 * @param array $actions Row actions.
 */
function remove_quick_edit( array $actions ): array {
	unset( $actions['inline hide-if-no-js'] );
	return $actions;
}

/**
 * Remove the admin color picker
 */
function remove_admin_color_scheme_picker(): void {
	remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
}

/**
 * Custom contact methods for each user profile
 *
 * @param array $user_contact Contact methods.
 */
function modify_user_contact_methods( array $user_contact ): array {
	unset( $user_contact['aim'] );
	unset( $user_contact['jabber'] );
	unset( $user_contact['yim'] );
	unset( $user_contact['gplus'] );
	unset( $user_contact['myspace'] );
	unset( $user_contact['linkedin'] );
	unset( $user_contact['soundcloud'] );
	unset( $user_contact['tumblr'] );
	unset( $user_contact['youtube'] );
	unset( $user_contact['wikipedia'] );

	return $user_contact;
}
