<?php
/**
 * Genesis.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Genesis;

/**
 * Setup
 */
function setup(): void {
	// Remove featured image.
	remove_action( 'genesis_entry_content', 'genesis_do_singular_image', 8 );
	// Remove entry info.
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	// Disable post edit link.
	add_filter( 'edit_post_link', '__return_empty_string' );
	// Remove block editor controls.
	add_filter( 'genesis_title_toggle_enabled', '__return_false' );
	add_filter( 'genesis_footer_widgets_toggle_enabled', '__return_false' );
	add_filter( 'genesis_breadcrumbs_toggle_enabled', '__return_false' );
	// User profile options.
	remove_action( 'show_user_profile', 'genesis_user_options_fields' );
	remove_action( 'edit_user_profile', 'genesis_user_options_fields' );
	// User archive settings.
	remove_action( 'show_user_profile', 'genesis_user_archive_fields' );
	remove_action( 'edit_user_profile', 'genesis_user_archive_fields' );
	// SEO options.
	remove_action( 'show_user_profile', 'genesis_user_seo_fields' );
	remove_action( 'edit_user_profile', 'genesis_user_seo_fields' );
	// Layout options.
	remove_action( 'show_user_profile', 'genesis_user_layout_fields' );
	remove_action( 'edit_user_profile', 'genesis_user_layout_fields' );
}
