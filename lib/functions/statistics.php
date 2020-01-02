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

\add_action( 'genesis_after_front-page-1_widget_area', __NAMESPACE__ . '\front_page_1_stats' );
function front_page_1_stats() {
	printf(
		'<section class="statistics">%s%s</section>',
		wp_kses_post( get_user_count( 'one-half' ) ),
		wp_kses_post( get_post_count_published( 'one-half' ) )
	);
}

/**
 * High level stats for entire site.
 *
 * @since 1.0.0
 */
function do_the_statistics() {
	printf(
		'<div class="wrap">%s%s%s</div>',
		wp_kses_post( get_user_count( 'one-third' ) ),
		wp_kses_post( get_post_count_published( 'one-third' ) ),
		wp_kses_post( get_post_count_draft( 'one-third' ) )
	);
}

/**
 * High level stats for certain taxonomy.
 *
 * @since 1.0.0
 */
function do_the_taxonomy_totals() {
	printf(
		'<div class="wrap">%s</div>',
		wp_kses_post( get_taxonomy_totals( 'rc_form' ) )
	);
}

/**
 * Return the totla number of users for homepage stats.
 *
 * @param string $column_width Set column width.
 *
 * @return string
 *
 * @since 1.0.0
 */
function get_user_count( string $column_width ) : string {
	$output = '';

	$users = count_users();

	if ( ! empty( $users ) ) {
		$output .= sprintf(
			'<section class="%s first"><h2>%s</h2>%s</section>',
			esc_attr( $column_width ),
			intval( $users['total_users'] ),
			esc_html__( 'Artists', 'rosenfield-collection-2020' )
		);
	}

	return $output;
}

/**
 * Return totle number of published posts.
 *
 * @param string $column_width Set column width.
 *
 * @return string
 *
 * @since 1.0.0
 */
function get_post_count_published( string $column_width ) : string {
	return sprintf(
		'<section class="%s"><h2>%s</h2>%s</section>',
		esc_attr( $column_width ),
		intval( wp_count_posts()->publish ),
		esc_html__( 'Published Objects', 'rosenfield-collection-2020' )
	);
}

/**
 * Return totle number of draft posts.
 *
 * @param string $column_width Set column width.
 *
 * @return string
 *
 * @since 1.0.0
 */
function get_post_count_draft( string $column_width ) : string {
	return sprintf(
		'<section class="%s"><h2>%s</h2>%s</section>',
		esc_attr( $column_width ),
		intval( wp_count_posts()->draft ),
		esc_html__( 'Draft Objects', 'rosenfield-collection-2020' )
	);
}

/**
 * Sow stats for taxonomy terms in grdi format.
 *
 * @param string $taxonomy Taxonomy slug.
 *
 * @return string
 *
 * @since 1.0.0
 */
function get_taxonomy_totals( string $taxonomy ) : string {
	$i      = 0;
	$output = '';
	$forms  = get_terms( $taxonomy );

	if ( ! empty( $forms ) && ! is_wp_error( $forms ) ) {
		foreach ( $forms as $form ) {
			$output .= sprintf(
				'<section class="one-sixth %s"><h2>%s</h2><p>%s</p></section>',
				esc_attr( column_class( $i, 6 ) ),
				esc_html( $form->count ),
				esc_html( $form->name )
			);
			$i++;
		}
	}

	return $output;
}
