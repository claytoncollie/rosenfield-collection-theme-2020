<?php
/**
 * Template Name: Claim
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

// Add special scripts to wp_head.
\add_action( 'wp_head', 'acf_form_head', 0 );

// Display author.
\add_action( 'genesis_entry_content', 'RosenfieldCollection\Theme\Functions\do_claim_meta', 8 );

// Display ACF form to edit pending post.
\add_action( 'genesis_entry_content', 'RosenfieldCollection\Theme\Functions\acf_form_claim', 12 );

// Run the Genesis loop.
\genesis();
