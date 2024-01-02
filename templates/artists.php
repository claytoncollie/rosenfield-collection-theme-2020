<?php
/**
 * Template Name: Artists
 *
 * @package RosenfieldCollection\Theme
 */

// Force full-width-content layout setting.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove default loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Run the Genesis loop.
genesis();
