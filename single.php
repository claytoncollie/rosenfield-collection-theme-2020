<?php
/**
 * Single Template
 *
 * @package   RosenfieldCollection\Theme
 * @link      https://www.rosenfieldcollection.com
 * @author    Clayton Collie
 * @copyright Copyright © 2019 Clayton Collie
 * @license   GPL-2.0-or-later
 */

namespace RosenfieldCollection\Theme;

// Force full-width-content layout setting.
\add_filter( 'genesis_site_layout', '__genesis_return_sidebar_content' );

// Remove default loop.
\remove_action( 'genesis_loop', 'genesis_do_loop' );

// Display public post_meta.
\add_filter( 'body_class', __NAMESPACE__ . '\Functions\is_gallery' );

// Display public post_meta.
\add_action( 'genesis_before_content_sidebar_wrap', __NAMESPACE__ . '\Functions\do_the_post_meta', 8 );

// Display admin-only post_meta.
\add_action( 'genesis_before_content_sidebar_wrap', __NAMESPACE__ . '\Functions\do_the_admin_bar', 9 );

// Display view all link.
\add_action( 'genesis_hero_section', __NAMESPACE__ . '\Functions\do_the_view_all_objects', 12 );

// Display image gallery.
\add_action( 'genesis_loop', __NAMESPACE__ . '\Functions\do_the_object_gallery' );

// Display thumbnail gallery.
\add_action( 'genesis_sidebar', __NAMESPACE__ . '\Functions\do_the_thumbnail_gallery' );

// Run the Genesis loop.
\genesis();
