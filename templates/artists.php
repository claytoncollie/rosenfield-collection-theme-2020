<?php
/**
 * Template Name: Artists
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

// Remove default sidebars.
\remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
\remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );

// Remove default loop.
\remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add artist filter.
\add_action( 'genesis_hero_section', 'RosenfieldCollection\Theme2020\Functions\do_artist_filter', 25 );

// Add new custom loop.
\add_action( 'genesis_loop', 'RosenfieldCollection\Theme2020\Functions\do_artists_loop' );

// Run the Genesis loop.
\genesis();
