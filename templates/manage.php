<?php
/**
 * Template Name: Manage
 *
 * @package      Rosenfield Collection
 * @since        1.0.0
 * @author       Clayton Collie <clayton.collie@gmail.com>
 * @copyright    Copyright (c) 2015, Rosenfield Collection
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Add custom body class.
add_filter( 'body_class', 'rc_body_class_manage' );

// Add entry content.
add_action( 'genesis_entry_content', 'genesis_do_post_content' );

// Remove filter that adds artist name to end of post title.
remove_filter( 'genesis_post_title_text', 'rc_add_author_name' );

// Remove read more button from loop content section under header.
remove_action( 'genesis_entry_content', 'rc_read_more', 12 );

// Remove the footer widget.
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// Run the Genesis loop.
genesis();
