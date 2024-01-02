<?php
/**
 * Taxonomies.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Taxonomies;

use function RosenfieldCollection\Theme\Helpers\column_class;

/**
 * Taxonomy archive for Firing
 *
 * @return void
 */
function do_taxonomy_loop__firing(): void {
	echo wp_kses_post( get_the_taxonomy_archive( 'rc_firing' ) );
}

/**
 * Taxonomy archive for Forms
 *
 * @return void
 */
function do_taxonomy_loop__form(): void {
	echo wp_kses_post( get_the_taxonomy_archive( 'rc_form' ) );
}

/**
 * Taxonomy archive for Technique
 *
 * @return void
 */
function do_taxonomy_loop__technique(): void {
	echo wp_kses_post( get_the_taxonomy_archive( 'rc_technique' ) );
}

/**
 * Taxonomy archive with featured images.
 *
 * @param string $taxonomy Taxonomy term.
 *
 * @return string
 */
function get_the_taxonomy_archive( string $taxonomy ): string {
	$output       = '';
	$column_class = '';
	$i            = 0;

	$args = [
		'taxonomy'   => esc_attr( $taxonomy ),
		'post_type'  => 'post',
		'title_li'   => '',
		'depth'      => 1,
		'hide_empty' => 1,
		'images'     => 1,
	];

	$query_args = [
		'post_type'   => esc_attr( $args['post_type'] ),
		'numberposts' => 1,
		'meta_query'  => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			[
				'key'     => '_thumbnail_id',
				'compare' => 'EXISTS',
			],
		],
	];

	if ( ! empty( $args['images'] ) ) {
		$cats = get_categories( $args );

		if ( ! empty( $cats ) ) {
			foreach ( $cats as $cat ) {
				$img                             = '';
				$query_args[ $args['taxonomy'] ] = $cat->slug;
				$posts                           = get_posts( $query_args );
				$term_link                       = get_term_link( $cat );
				$term_link                       = ! empty( $term_link ) && ! is_wp_error( $term_link ) ? (string) $term_link : '';

				if ( ! empty( $posts ) ) {
					$img = get_the_post_thumbnail(
						$posts[0]->ID,
						'archive',
						[
							'alt' => sprintf(
								'%s %s',
								esc_html__( 'Newest object from category:', 'rosenfield-collection' ),
								esc_html( $cat->name )
							),
						]
					);
				}

				$output     .= sprintf(
					'<article class="entry one-fourth %s" aria-label="%s: %s">',
					esc_attr( column_class( $i, 4 ) ),
					esc_html__( 'Category', 'rosenfield-collection' ),
					esc_html( $cat->name )
				);
				$output     .= sprintf(
					'<a href="%s" rel="bookmark" itemprop="url" class="entry-image-link">%s</a>',
					esc_url( $term_link ),
					$img
				);
				$output     .= '<div class="entry-wrap"><header class="entry-header">';
				$output     .= sprintf(
					'<h2 class="entry-title" itemprop="headline"><a href="%s">%s</a></h2>',
					esc_url( $term_link ),
					esc_html( $cat->name )
				);
					$output .= sprintf(
						'<a class="more-link" href="%s" aria-label="%s: %s">%s</a><span class="entry-sep">&middot;</span>%s',
						esc_url( $term_link ),
						esc_html__( 'View Category', 'rosenfield-collection' ),
						esc_html( $cat->name ),
						esc_html__( 'View All', 'rosenfield-collection' ),
						esc_html( $cat->count )
					);
				$output     .= '</header></div></article>';

				++$i;
			}
		}
	}

	return $output;
}
