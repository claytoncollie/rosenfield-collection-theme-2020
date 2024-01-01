<?php
/**
 * Single.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Single;

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	// Remove sidebar.
	remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
	remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
	// Remove featured image.
	remove_action( 'genesis_entry_content', 'genesis_do_singular_image', 8 );
	// Remove entry info.
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	// Disable post edit link.
	add_filter( 'edit_post_link', '__return_empty_string' );
}
