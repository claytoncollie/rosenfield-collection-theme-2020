<?php
/**
 * Template Name: Pending
 *
 * @package   RosenfieldCollection\Theme2020
 * @link      https://www.rosenfieldcollection.com
 * @author    Clayton Collie
 * @copyright Copyright © 2019 Clayton Collie
 * @license   GPL-2.0-or-later
 */

namespace RosenfieldCollection\Theme2020\Templates;

// Force full-width-content layout setting.
\add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove the non-existent object ID.
\remove_action( 'genesis_entry_content', 'RosenfieldCollection\Theme2020\Functions\object_id_by_line', 9 );

// Add meta data to each post.
\add_action( 'genesis_entry_content', 'RosenfieldCollection\Theme2020\Functions\the_purchase_price' );
\add_action( 'genesis_entry_content', 'RosenfieldCollection\Theme2020\Functions\the_purchase_date' );
\add_action( 'genesis_entry_content', 'RosenfieldCollection\Theme2020\Functions\the_purchase_location' );

// Filter the permalink to include the post_id.
\add_filter( 'post_link', 'RosenfieldCollection\Theme2020\Functions\get_the_permalink_with_post_id', 10, 3 );

// Add pending filter.
\add_action( 'genesis_hero_section', 'RosenfieldCollection\Theme2020\Functions\do_pending_filter', 25 );

// Add custom loop to only show pending posts.
\add_action( 'genesis_loop', 'RosenfieldCollection\Theme2020\Functions\do_the_pending_posts', 12 );

// Add post navigation.
\add_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

// Remove Post content.
\remove_action( 'genesis_loop', 'genesis_do_loop' );

// Run the Genesis loop.
\genesis();
