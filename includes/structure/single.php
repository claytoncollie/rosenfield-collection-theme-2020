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
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\view_all_from_artist', 12 );
	
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

/**
 * View all objects by artist link
 *
 * @return void
 */
function view_all_from_artist(): void {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	get_template_part( 'partials/view-all-from-artist' );
}
