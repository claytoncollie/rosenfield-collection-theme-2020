<?php
/**
 * Template Name: Artists
 *
 * @package      Rosenfield Collection
 * @since        1.0.0
 * @author       Clayton Collie <clayton.collie@gmail.com>
 * @copyright    Copyright (c) 2015, Rosenfield Collection
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Add grid body class.
add_filter( 'body_class', 'rc_body_class_artist_archive' );
add_filter( 'body_class', 'rc_body_class_title_description' );

// Remove default loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add page title above posts.
add_action( 'genesis_after_header', 'genesis_do_post_title' );

// Remove read more button from loop content section under header.
remove_action( 'genesis_entry_content', 'rc_read_more', 12 );

// Remove filter that adds artist name to end of post title.
remove_filter( 'genesis_post_title_text', 'rc_add_author_name' );

// Add new custom loop.
add_action( 'genesis_loop', 'rc_list_authors_loop' );

// Run the Genesis loop.
genesis();
