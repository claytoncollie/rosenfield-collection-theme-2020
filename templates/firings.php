<?php
/**
 * Template Name:  Firings
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

// Add custom loop to show at sub categories of FORM.
add_action( 'genesis_loop', __NAMESPACE__ . '\Functions\do_taxonomy_loop__firing' );

// Run the Genesis loop.
genesis();

