<?php
/**
 * Single Template
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme;

// Force layout.
\add_filter( 'genesis_site_layout', '__genesis_return_sidebar_content' );

// Remove default loop.
\remove_action( 'genesis_loop', 'genesis_do_loop' );

// Display public post_meta.
\add_action( 'genesis_before_content_sidebar_wrap', __NAMESPACE__ . '\PostMeta\do_the_post_meta', 8 );

// Display admin-only post_meta.
\add_action( 'genesis_before_content_sidebar_wrap', __NAMESPACE__ . '\PostMetaAdmin\do_the_admin_bar', 9 );

// Run the Genesis loop.
\genesis();
