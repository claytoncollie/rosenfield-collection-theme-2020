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

namespace RosenfieldCollection\Theme2020\Functions;

\add_action( 'genesis_entry_content', __NAMESPACE__ . '\by_line', 8 );
/**
 * Add artist name to below post title.
 *
 * @since 1.0.0
 */
function by_line() {
	if ( \is_author() || \is_singular() ) {
		return;
	}

	$first_name = get_the_author_meta( 'first_name' );
	$last_name  = get_the_author_meta( 'last_name' );

	if ( ! empty( $first_name ) && ! empty( $last_name ) ) {
		printf(
			'<p><a href="%s" class="entry-artist">%s %s</a></p><span class="entry-sep">&middot;</span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( $first_name ),
			esc_html( $last_name )
		);
	}
}
