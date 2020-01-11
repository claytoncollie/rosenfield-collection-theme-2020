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

\add_action( 'genesis_hero_section', __NAMESPACE__ . '\do_taxonomy_purchase_price', 30 );
/**
 * Display the total cost of each taxonomy term.
 *
 * @return void
 *
 * @since 1.0.0
 */
function do_taxonomy_purchase_price() {
	global $wp_query;

	if ( ! is_user_logged_in() ) {
		return;
	}

	if ( ! current_user_can( 'edit_others_pages' ) ) {
		return;
	}

	if ( ! is_tax() && ! is_tag() ) {
		return;
	}

	$taxonomy = $wp_query->get_queried_object();

	if ( ! empty( $taxonomy ) ) {
		$total = get_taxonomy_purchase_price( absint( $taxonomy->term_id ), $taxonomy->taxonomy );

		if ( ! empty( $total ) ) {
			echo wp_kses_post(
				admin_pricing(
					__( 'Total Cost', 'rosenfield-collection-2020' ),
					'$ ' . $total
				)
			);
		}
	}
}

/**
 * Get the total purchase price for a single taxonomy term.
 *
 * Returns as a float in money format for the USD.
 *
 * @param integer $term_id Term ID.
 * @param string  $taxonomy Taxonomy slug.
 *
 * @return float
 *
 * @since 1.1.0
 */
function get_taxonomy_purchase_price( int $term_id, string $taxonomy ) : float {
	$output = '';
	$total  = array();

	if ( ! empty( $taxonomy ) ) {
		$query = new \WP_Query(
			array(
				'post_type' => 'post',
				'nopaging'  => true,
				'tax_query' => array(
					array(
						'taxonomy' => esc_html( $taxonomy ),
						'field'    => 'term_id',
						'terms'    => absint( $term_id ),
					),
				),
			)
		);

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();

				$price = get_field( 'rc_object_purchace_price' );

				if ( ! empty( $price ) ) {
					$total[] .= $price;
				}
			}
			wp_reset_postdata();

			$output = array_sum( $total );
		}
	}

	return money_format( '%i', floatval( $output ) );
}

/**
 * Get the total collection purchase price from all taxonomies.
 *
 * @return float
 * @since 1.0.0
 */
function get_total_purchase_price() : float {
	$output = array();
	$forms  = get_terms( 'rc_form' );

	if ( ! empty( $forms ) && ! is_wp_error( $forms ) ) {
		foreach ( $forms as $form ) {
			$output[] .= get_taxonomy_purchase_price( absint( $form->term_id ), $form->taxonomy );
		}

		$output = array_sum( $output );
	}

	return money_format( '%i', floatval( $output ) );
}
