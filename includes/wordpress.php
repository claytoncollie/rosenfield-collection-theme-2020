<?php
/**
 * WordPress Support.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\WordPress;

/**
 * Actions and filters
 */
function setup(): void {
	add_action( 'init', __NAMESPACE__ . '\register_support' );
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
