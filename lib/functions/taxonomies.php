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
 * Taxonomy archive with featured images.
 *
 * @param string $taxonomy Taxonomy term.
 *
 * @return string
 *
 * @since 1.0.0
 */
function get_the_taxonomy_archive( string $taxonomy ) : string {
	$output       = '';
	$column_class = '';
	$i            = 0;

	$args = array(
		'taxonomy'   => esc_attr( $taxonomy ),
		'post_type'  => 'post',
		'title_li'   => '',
		'depth'      => 1,
		'hide_empty' => 1,
		'images'     => 1,
	);

	$query_args = array(
		'post_type'   => esc_attr( $args['post_type'] ),
		'numberposts' => 1,
		'meta_query'  => array(
			array(
				'key'     => '_thumbnail_id',
				'compare' => 'EXISTS',
			),
		),
	);

	if ( ! empty( $args['images'] ) ) {
		$cats = get_categories( $args );

		if ( ! empty( $cats ) ) {
			foreach ( $cats as $cat ) {
				$img                             = '';
				$query_args[ $args['taxonomy'] ] = $cat->slug;
				$posts                           = get_posts( $query_args );

				if ( ! empty( $posts ) ) {
					$img = get_the_post_thumbnail( $posts[0]->ID, 'archive-image' );
				}

				if ( 0 === $i || 0 === $i % 4 ) {
					$column_class = 'first';
				} else {
					$column_class = '';
				}

				$output     .= sprintf( '<article class="entry one-fourth %s">', esc_attr( $column_class ) );
				$output     .= sprintf(
					'<a href="%s" rel="bookmark" itemprop="url" class="entry-image-link">%s</a>',
					esc_url( get_term_link( $cat ) ),
					$img
				);
				$output     .= '<div class="entry-wrap"><header class="entry-header">';
				$output     .= sprintf(
					'<h2 class="entry-title" itemprop="headline"><a href="%s">%s</a></h2>',
					esc_url( get_term_link( $cat ) ),
					esc_html( $cat->name )
				);
					$output .= sprintf(
						'<a class="more-link" href="%s">%s <i class="fa fa-long-arrow-right"></i></a>',
						esc_url( get_term_link( $cat ) ),
						esc_html__( 'View All', 'rosenfield-collection-2020' )
					);
				$output     .= '</header></div></article>';

				$i++;
			}
		}
	}

	return $output;
}

/**
 * Taxonomy archive for Firing
 *
 * @since  1.4.0
 */
function do_taxonomy_loop__firing() {
	echo wp_kses_post( get_the_taxonomy_archive( 'rc_firing' ) );
}

/**
 * Taxonomy archive for Forms
 *
 * @since  1.4.0
 */
function do_taxonomy_loop__form() {
	echo wp_kses_post( get_the_taxonomy_archive( 'rc_form' ) );
}

/**
 * Taxonomy archive for Technique
 *
 * @since  1.4.0
 */
function do_taxonomy_loop__technique() {
	echo wp_kses_post( get_the_taxonomy_archive( 'rc_technique' ) );
}
