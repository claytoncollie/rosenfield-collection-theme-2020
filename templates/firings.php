<?php
/**
 * Template Name: Firings
 *
 * @package   RosenfieldCollection\Theme
 * @link      https://www.rosenfieldcollection.com
 * @author    Clayton Collie
 * @copyright Copyright © 2019 Clayton Collie
 * @license   GPL-2.0-or-later
 */

namespace RosenfieldCollection\Theme\Templates;

// Force full-width-content layout setting.
\add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove default loop.
\remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add custom loop to show at sub categories of FORM.
\add_action( 'genesis_loop', 'RosenfieldCollection\Theme\Functions\do_taxonomy_loop__firing' );

// Run the Genesis loop.
\genesis();

