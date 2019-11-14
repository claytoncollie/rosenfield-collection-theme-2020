<?php
/**
 * Template Name: Report
 *
 * @package      Rosenfield Collection
 * @since        1.0.0
 * @author       Clayton Collie <clayton.collie@gmail.com>
 * @copyright    Copyright (c) 2015, Rosenfield Collection
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Add custom body class.
add_filter( 'body_class', 'rc_body_class_report' );

// Force full-width-content layout setting.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Dispaly totals.
add_action( 'genesis_after_header', 'rc_totals' );

// Remove the post content (requires HTML5 theme support).
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Shoow all posts.
add_action( 'genesis_loop', 'rc_list_all_posts' );

// Run the Genesis loop.
genesis();
