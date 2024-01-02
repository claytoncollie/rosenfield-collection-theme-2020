<?php
/**
 * Template Name: Forms
 *
 * @package RosenfieldCollection\Theme
 */

// Force full-width-content layout setting.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove default loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add custom loop to show at sub categories of FORM.
add_action( 'genesis_loop', 'RosenfieldCollection\Theme\Taxonomies\do_taxonomy_loop__form' );

// Run the Genesis loop.
genesis();
