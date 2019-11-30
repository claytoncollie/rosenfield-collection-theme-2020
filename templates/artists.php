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

namespace RosenfieldCollection\Theme2020;

// Remove default loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add new custom loop.
add_action( 'genesis_loop', __NAMESPACE__ . '\Functions\do_artists_loop' );

// Run the Genesis loop.
genesis();
