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

/**
 * Read more link to view author profile.
 *
 * @since  1.0.0
 */
function do_the_view_all_objects() {
	$avatar_id = get_field( 'artist_photo', 'user_' . get_the_author_meta( 'ID' ) );

	if ( ! empty( $avatar_id ) ) {
		$avatar = wp_get_attachment_image( $avatar_id, 'thumbnail', false, array( 'class' => 'author-avatar' ) );
	} else {
		$avatar = '';
	}

	printf(
		'<p class="author-view-more">%s<a class="more-link" rel="author" href="%s">%s %s %s</a></p>',
		wp_kses_post( $avatar ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html__( 'View more objects by', 'rosenfield-collection-2020' ),
		esc_html( get_the_author_meta( 'first_name' ) ),
		esc_html( get_the_author_meta( 'last_name' ) )
	);
}
