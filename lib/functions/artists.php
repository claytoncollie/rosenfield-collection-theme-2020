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
 * Display the artists archive loop.
 *
 * @return void
 *
 * @since 1.4.0
 */
function do_artists_loop() {
	$i           = 0;
	$number      = 36;
	$paged       = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$offset      = ( $paged - 1 ) * $number;
	$total_users = (int) count( get_users() );
	$total_pages = intval( $total_users / $number ) + 1;

	$args = array(
		'order'               => 'ASC',
		'orderby'             => 'display_name',
		'exclude'             => get_field( 'rc_excluded_artists' ),
		'has_published_posts' => array( 'post' ),
		'number'              => $number,
		'offset'              => $offset,
	);

	$user_query = new \WP_User_Query( $args );

	if ( ! empty( $user_query->results ) ) {
		foreach ( $user_query->results as $user ) {
			$id         = $user->ID;
			$first_name = $user->first_name;
			$last_name  = $user->last_name;
			$link       = get_author_posts_url( $id );

			$attachment_id = get_field( 'artist_photo', 'user_' . $id );
			$avatar        = wp_get_attachment_image_src( $attachment_id, 'artist-image' );

			$fallback = '';

			// If the artist/user does not have a photo in the custom field.
			// then get_posts for that author an grab the featured image from the first post and use as fallback image.
			if ( ! $attachment_id ) {
				$posts = get_posts( 'author=' . $id . '&posts_per_page=1' );
				foreach ( $posts as $post ) {
					$fallback = get_the_post_thumbnail( $post->ID, 'artist-image' );
				}
			}

			if ( 0 === $i || 0 === $i % 6 ) {
				$column_class = 'first';
			} else {
				$column_class = '';
			}

			printf( '<article class="entry one-sixth %s">', esc_attr( $column_class ) );

			if ( $attachment_id ) {
				printf(
					'<a href="%s" class="post-image entry-image" rel="bookmark" itemprop="url"><img src="%s" alt="%s %s" itemprop="image" /></a>',
					esc_url( $link ),
					esc_url( $avatar[0] ),
					esc_html( $first_name ),
					esc_html( $last_name )
				);
			} else {
				printf(
					'<a href="%s" class="post-image entry-image" rel="bookmark" itemprop="url">%s</a>',
					esc_url( $link ),
					wp_kses_post( $fallback )
				);
			}
				echo '<header class="entry-header">';
					printf(
						'<h2 class="entry-title" itemprop="name"><a href="%s" rel="bookmark" itemprop="url">%s %s</a></h2>',
						esc_url( $link ),
						esc_html( $first_name ),
						esc_html( $last_name )
					);
					printf(
						'<a class="more-link" href="%s" rel="bookmark" itemprop="url">%s <i class="fa fa-long-arrow-right"></i></a>',
						esc_url( $link ),
						esc_html__( 'View Artist', 'rosenfield-collection-2020' )
					);
				echo '</header>';
			echo '</article>';

			$i++;
		}

		echo '</div>';

		/**
		 * Pagination for User Query
		 *
		 * @since 1.4.0
		 */
		if ( $total_users > $number ) {
			printf(
				'<section class="archive-pagination pagination"><div class="wrap">%s</div></section>',
				wp_kses_post(
					paginate_links(
						array(
							'base'      => get_pagenum_link( 1 ) . '%_%',
							'format'    => 'page/%#%/',
							'current'   => max( 1, get_query_var( 'paged' ) ),
							'total'     => $total_pages,
							'prev_next' => true,
							'type'      => 'list',
						)
					)
				)
			);
		}
	}
}
