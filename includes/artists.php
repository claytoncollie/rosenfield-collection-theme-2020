<?php
/**
 * Rosenfield Collection Theme.
 *
 * @package   RosenfieldCollection\Theme
 * @link      https://www.rosenfieldcollection.com
 * @author    Clayton Collie
 * @copyright Copyright © 2019 Clayton Collie
 * @license   GPL-2.0-or-later
 */

namespace RosenfieldCollection\Theme\Functions;

/**
 * Display the artists archive loop.
 *
 * @return void
 *
 * @since 1.4.0
 */
function do_artists_loop() {
	$i      = 0;
	$number = 36;
	$filter = get_query_var( 'artist_filter' );

	if ( ! empty( $filter ) ) {
		$artist_filter = array(
			'meta_key'     => 'artist_filter',
			'meta_value'   => $filter,
			'meta_compare' => '=',
		);
		// Set high value to disable pagination when using query var.
		$number = 999;
	} else {
		$artist_filter = array();
	}

	// Set up pagination.
	$paged  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$offset = ( $paged - 1 ) * $number;

	$arguments = array(
		'order'               => 'ASC',
		'orderby'             => 'display_name',
		'has_published_posts' => array( 'post' ),
		'number'              => $number,
		'offset'              => $offset,
	);

	$args = array_merge_recursive( $arguments, $artist_filter );

	$user_query = new \WP_User_Query( $args );

	if ( ! empty( $user_query->results ) ) {
		if ( ! empty( $filter ) ) {
			$total_users = (int) count( $user_query->results );
		} else {
			$total_users = (int) count( get_users( array( 'has_published_posts' => array( 'post' ) ) ) );
		}

		$total_pages = intval( $total_users / $number ) + 1;

		foreach ( $user_query->results as $user ) {
			$id         = $user->ID;
			$first_name = $user->first_name;
			$last_name  = $user->last_name;
			$link       = get_author_posts_url( $id );

			$attachment_id = get_field( 'artist_photo', 'user_' . $id );
			$avatar        = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );

			$fallback = '';

			/**
			 * If the artist/user does not have a photo in the custom field
			 * then get_posts for that author an grab the featured image from
			 * the first post and use as fallback image.
			 */
			if ( ! $attachment_id ) {
				$posts = get_posts( 'author=' . $id . '&posts_per_page=1' );
				foreach ( $posts as $post ) {
					$fallback = get_the_post_thumbnail(
						$post->ID,
						'thumbnail',
						array(
							'alt' => esc_html( $first_name ) . ' ' . esc_html( $last_name ),
						)
					);
				}
			}

			printf(
				'<article class="entry one-sixth %s" aria-label="%s: %s %s">',
				esc_attr( column_class( $i, 6 ) ),
				esc_html__( 'Artist', 'rosenfield-collection' ),
				esc_html( $first_name ),
				esc_html( $last_name )
			);

			if ( $attachment_id ) {
				printf(
					'<a href="%s" class="entry-image-link" rel="bookmark"><img width="%s" height="%s" src="%s" alt="%s %s" /></a>',
					esc_url( $link ),
					esc_attr( $avatar[1] ),
					esc_attr( $avatar[2] ),
					esc_url( $avatar[0] ),
					esc_html( $first_name ),
					esc_html( $last_name )
				);
			} else {
				printf(
					'<a href="%s" class="entry-image-link" rel="bookmark">%s</a>',
					esc_url( $link ),
					wp_kses_post( $fallback )
				);
			}
				echo '<div class="entry-wrap"><header class="entry-header">';
					printf(
						'<h2 class="entry-title" itemprop="name"><a href="%s" rel="bookmark">%s %s</a></h2>',
						esc_url( $link ),
						esc_html( $first_name ),
						esc_html( $last_name )
					);
					printf(
						'<a class="more-link" href="%s" rel="bookmark" aria-label="%s: %s %s">%s</a><span class="entry-sep">&middot;</span>%s',
						esc_url( $link ),
						esc_html__( 'View Artist', 'rosenfield-collection' ),
						esc_html( $first_name ),
						esc_html( $last_name ),
						esc_html__( 'View Artist', 'rosenfield-collection' ),
						esc_html( count_user_posts( $id ) ),
					);
				echo '</header></div>';
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
				'<section id="genesis-archive-pagination" class="archive-pagination pagination" role="navigation" aria-label="%s"><div class="wrap">%s</div></section>',
				esc_html__( 'Pagination', 'rosenfield-collection' ),
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
