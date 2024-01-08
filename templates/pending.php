<?php
/**
 * Template Name: Pending
 *
 * @package RosenfieldCollection\Theme
 */

// Remove the non-existent object ID.
remove_action( 'genesis_entry_content', 'RosenfieldCollection\Theme\PostTitle\object_id_by_line', 9 );

// Add meta data to each post.
add_action( 'genesis_entry_content', 'RosenfieldCollection\Theme\PostMetaAdmin\the_purchase_price' );
add_action( 'genesis_entry_content', 'RosenfieldCollection\Theme\PostMetaAdmin\the_purchase_date' );
add_action( 'genesis_entry_content', 'RosenfieldCollection\Theme\PostMetaAdmin\the_purchase_location' );

// Filter the permalink to include the post_id.
add_filter( 'post_link', 'RosenfieldCollection\Theme\Pending\get_the_permalink_with_post_id', 10, 2 );

// Add pending filter.
add_action( 'genesis_hero_section', 'RosenfieldCollection\Theme\PendingFilter\do_pending_filter_by_form', 25 );
add_action( 'genesis_hero_section', 'RosenfieldCollection\Theme\PendingFilter\do_pending_filter_by_artist', 25 );

// Add custom loop to only show pending posts.
add_action( 'genesis_loop', 'RosenfieldCollection\Theme\Pending\do_the_pending_posts', 12 );

// Add post navigation.
add_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

// Remove Post content.
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Run the Genesis loop.
genesis();
