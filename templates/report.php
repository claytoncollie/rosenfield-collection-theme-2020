<?php
/**
 * Template Name: Report
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

// Dispaly totals.
\add_action( 'genesis_after_hero_section', 'RosenfieldCollection\Theme2020\Functions\do_the_statistics', 25 );

// Dispaly totals.
\add_action( 'genesis_after_hero_section', 'RosenfieldCollection\Theme2020\Functions\do_the_taxonomy_totals', 30 );

// Shoow all posts.
\add_action( 'genesis_loop', 'RosenfieldCollection\Theme2020\Functions\do_the_report', 12 );

// Run the Genesis loop.
\genesis();
