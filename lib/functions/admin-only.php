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

add_action( 'genesis_hero_section', __NAMESPACE__ . '\do_taxonomy_purchase_price', 12 );
/**
 * Display the total cost of each taxonomy term.
 *
 * @return void
 *
 * @since 1.0.0
 */
function do_taxonomy_purchase_price() {

	global $wp_query;

	if ( ! current_user_can( 'edit_others_pages' ) ) {
		return;
	}

	if ( ! is_tax() ) {
		return;
	}

	$taxonomy = $wp_query->get_queried_object();

	$total = array();

	if ( ! empty( $taxonomy ) ) {
		$query = new \WP_Query(
			array(
				'post_type' => 'post',
				'nopaging'  => true,
				'tax_query' => array(
					array(
						'taxonomy' => esc_html( $taxonomy->taxonomy ),
						'field'    => 'term_id',
						'terms'    => esc_html( $taxonomy->term_id ),
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

			$total = array_sum( $total );

			echo wp_kses_post(
				admin_only(
					__( 'Total Cost', 'rosenfield-collection-2020' ),
					'$ ' . money_format( '%i', $total )
				)
			);
		}
	}
}
