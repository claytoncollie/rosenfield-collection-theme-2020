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

// Remove default loop.
\remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add new custom loop.
\add_action( 'genesis_loop', 'RosenfieldCollection\Theme2020\Functions\do_artists_loop' );

// Run the Genesis loop.
\genesis();
