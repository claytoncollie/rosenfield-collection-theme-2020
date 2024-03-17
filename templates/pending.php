<?php
/**
 * Template Name: Pending
 *
 * @package RosenfieldCollection\Theme
 */

// Remove the content.
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add post navigation.
add_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

// Run the Genesis loop.
genesis();
