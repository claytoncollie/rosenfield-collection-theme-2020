<?php
/**
 * Template Name: Pending
 *
 * @package RosenfieldCollection\Theme
 */

// Add post navigation.
add_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

// Run the Genesis loop.
genesis();
