<?php
/**
 * Post Title.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\PostTitle;

use function RosenfieldCollection\Theme\Helpers\get_object_prefix_and_id;

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	add_action( 'genesis_entry_content', __NAMESPACE__ . '\author_by_line', 8 );
	add_action( 'genesis_entry_content', __NAMESPACE__ . '\object_id_by_line', 9 );
}

/**
 * Add artist name to below post title.
 *
 * @return void
 */
function author_by_line(): void {
	if ( \is_author() || \is_singular() ) {
		return;
	}

	printf(
		'<p><span class="entry-sep">&middot;</span><a href="%s" class="entry-artist">%s %s</a></p>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author_meta( 'first_name' ) ),
		esc_html( get_the_author_meta( 'last_name' ) )
	);
}

/**
 * Add artist name to below post title.
 *
 * @return void
 */
function object_id_by_line(): void {
	if ( \is_author() || \is_singular() ) {
		return;
	}

	$id = get_object_prefix_and_id();

	if ( ! empty( $id ) ) {
		printf(
			'<span class="entry-sep">&middot;</span>%s',
			esc_html( $id )
		);
	}
}
