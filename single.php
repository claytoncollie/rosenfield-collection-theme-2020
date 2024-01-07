<?php
/**
 * Single Template
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme;

// Force layout.
\add_filter( 'genesis_site_layout', '__genesis_return_sidebar_content' );

// Run the Genesis loop.
\genesis();
