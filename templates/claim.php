<?php
/**
 * Template Name: Claim
 *
 * @package RosenfieldCollection\Theme
 */

// Add special scripts to wp_head.
add_action( 'wp_head', 'acf_form_head', 0 );

// Display author.
add_action( 'genesis_entry_content', 'RosenfieldCollection\Theme\ObjectClaim\do_claim_meta', 8 );

// Display ACF form to edit pending post.
add_action( 'genesis_entry_content', 'RosenfieldCollection\Theme\ObjectClaim\acf_form_claim', 12 );

// Run the Genesis loop.
genesis();
