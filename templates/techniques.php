<?php
/**
 * Template Name: Techniques
 *
 * @package RosenfieldCollection\Theme
 */

// Reposition the entry content.
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_hero_section', 'the_content', 12 );

genesis();
