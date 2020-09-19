<?php
/**
 * Rosenfield Collection Theme.
 *
 * @package   RosenfieldCollection\Theme2020
 * @link      https://www.rosenfieldcollection.com
 * @author    Clayton Collie
 * @copyright Copyright © 2019 Clayton Collie
 * @license   GPL-2.0-or-later
 */

namespace RosenfieldCollection\Theme2020\Structure;

// Remove sidebar.
\remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
\remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );

// Remove featured image.
\remove_action( 'genesis_entry_content', 'genesis_do_singular_image', 8 );

// Remove entry info.
\remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

\add_action( 'after_setup_theme', __NAMESPACE__ . '\disable_edit_post_link' );
/**
 * Disables the post edit link.
 *
 * @since 1.0.0
 *
 * @return void
 */
function disable_edit_post_link() {
	\add_filter( 'edit_post_link', '__return_empty_string' );
}
