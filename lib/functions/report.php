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
 * Lists all posts for the REPORT page template
 *
 * @since 1.0.0
 */
function do_the_report() {
	$user_args = array(
		'orderby' => 'display_name',
		'order'   => 'ASC',
	);

	$artists = get_users( $user_args );

	foreach ( $artists as $artist ) {
		$i = 0;

		echo '<section class="entry-user report">';

			printf(
				'<h2 class="entry-title"><a href="%s">%s %s</a><span class="entry-sep">&middot;</span>%s</h2>',
				esc_url( get_author_posts_url( $artist->ID ) ),
				esc_html( $artist->first_name ),
				esc_html( $artist->last_name ),
				intval( count_user_posts( $artist->ID ) )
			);

			$post_args = array(
				'order'          => 'DESC',
				'orderby'        => 'date',
				'author'         => intval( $artist->ID ),
				'posts_per_page' => 100,
				'post_status'    => 'any',
			);

			$objects = new \WP_Query( $post_args );

			if ( $objects->have_posts() ) {
				while ( $objects->have_posts() ) {
					$objects->the_post();

					$terms = get_the_terms( get_the_ID(), 'rc_form' );
					$term  = array_pop( $terms );

					$notice      = '';
					$post_status = get_post_status();

					if ( 'publish' === $post_status ) {
						$notice = 'notice-success';
					}

					if ( 'draft' === $post_status ) {
						$notice = 'notice-info';
					}

					if ( 'pending' === $post_status ) {
						$notice = 'notice-warning';
					}

					if ( 'archive' === $post_status ) {
						$notice = 'notice-error';
					}

					printf( '<article class="entry one-half %s %s">', esc_attr( column_class( $i, 2 ) ), esc_attr( $notice ) );
						printf(
							'<div class="one-third first"><a href="%s">%s</a></div>',
							esc_url( get_permalink() ),
							get_the_post_thumbnail( get_the_ID(), 'archive' )
						);
						echo '<div class="two-thirds">';
							echo '<table>';
							echo '<tr>';
								printf(
									'<td><span class="object-id"><a href="%s">%s%s</a></span></td>',
									esc_url( get_permalink() ),
									esc_html( get_field( 'rc_form_object_prefix', $term ) ),
									esc_html( get_field( 'object_id' ) )
								);
								printf( '<td>%s</td>', esc_html( get_the_title() ) );
							echo '</tr>';
								printf(
									'<tr><td>%s</td><td>%s</td></tr>',
									get_the_term_list( get_the_ID(), 'rc_form', '', '', '' ),
									get_the_term_list( get_the_ID(), 'rc_firing', '', ', ' )
								);
								printf(
									'<tr><td>%s</td><td>%sx%sx%s</td></tr>',
									get_the_term_list( get_the_ID(), 'rc_technique', '', ', ' ),
									esc_html( get_field( 'length' ) ),
									esc_html( get_field( 'width' ) ),
									esc_html( get_field( 'height' ) )
								);
								printf(
									'<tr><td><span class="entry-user-heading">%s</span>%s</td><td>%s</td></tr>',
									esc_html__( 'Column', 'rosenfield-collection-2020' ),
									get_the_term_list( get_the_ID(), 'rc_column', '', ', ' ),
									get_the_term_list( get_the_ID(), 'rc_location', '', ', ' )
								);
								printf(
									'<tr><td><span class="entry-user-heading">%s</span>%s</td>',
									esc_html__( 'Row', 'rosenfield-collection-2020' ),
									get_the_term_list( get_the_ID(), 'rc_row', '', ', ' )
								);
								printf(
									'<td><span class="entry-user-heading">%s</span>%s</td>',
									esc_html__( '$', 'rosenfield-collection-2020' ),
									esc_html( get_field( 'rc_object_purchace_price' ) )
								);
							echo '</tr>';
						echo '</table>';
						echo '</div>';
					echo '</article>';
					$i++;
				}
				wp_reset_postdata();
			}
			echo '</section>';
	}
}
