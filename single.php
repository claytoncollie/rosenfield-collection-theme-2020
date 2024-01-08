<?php
/**
 * Single Template
 *
 * @package RosenfieldCollection\Theme
 */

add_filter( 'genesis_site_layout', '__genesis_return_sidebar_content' );

genesis();
