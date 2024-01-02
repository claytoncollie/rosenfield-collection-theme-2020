<?php
/**
 * View All Objects.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\ViewAllObjects;

/**
 * Read more link to view author profile.
 *
 * @return void
 */
function do_the_view_all_objects(): void {
	$avatar_id = get_field( 'artist_photo', 'user_' . get_the_author_meta( 'ID' ) );

	if ( ! empty( $avatar_id ) ) {
		$avatar = wp_get_attachment_image(
			$avatar_id,
			'thumbnail',
			false,
			[
				'class' => 'author-avatar',
				'alt'   => esc_html( get_the_author_meta( 'first_name' ) ) . ' ' . esc_html( get_the_author_meta( 'last_name' ) ),
			]
		);
	} else {
		$avatar = '';
	}

	printf(
		'<p class="author-view-more">%s<a class="more-link" rel="author" href="%s">%s %s %s</a></p>',
		wp_kses_post( $avatar ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html__( 'View more objects by', 'rosenfield-collection' ),
		esc_html( get_the_author_meta( 'first_name' ) ),
		esc_html( get_the_author_meta( 'last_name' ) )
	);
}
