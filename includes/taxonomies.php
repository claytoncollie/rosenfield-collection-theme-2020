<?php
/**
 * Taxonomies.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Taxonomies;

use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;

/**
 * Post tag
 * 
 * @var string
 */
const POST_TAG = 'post_tag';

/**
 * Firing
 * 
 * @var string
 */
const FIRING = 'rc_firing';

/**
 * Form
 * 
 * @var string
 */
const FORM = 'rc_form';

/**
 * Technique
 * 
 * @var string
 */
const TECHNIQUE = 'rc_technique';

/**
 * Row
 * 
 * @var string
 */
const ROW = 'rc_row';

/**
 * Column
 * 
 * @var string
 */
const COLUMN = 'rc_column';

/**
 * Location
 * 
 * @var string
 */
const LOCATION = 'rc_location';

/**
 * Results
 * 
 * @var string
 */
const RESULT = 'rc_result';

/**
 * WordPress actions and filters
 */
function setup(): void {
	add_action( 'genesis_loop', __NAMESPACE__ . '\the_taxonomy_loop__firing' );
	add_action( 'genesis_loop', __NAMESPACE__ . '\the_taxonomy_loop__form' );
	add_action( 'genesis_loop', __NAMESPACE__ . '\the_taxonomy_loop__technique' );
	add_action( 'restrict_manage_posts', __NAMESPACE__ . '\admin_filter' );
}

/**
 * Taxonomy archive for Firing
 */
function the_taxonomy_loop__firing(): void {
	if ( ! is_page_template( 'templates/firings.php' ) ) {
		return;
	}

	get_template_part( 
		'partials/taxonomy-loop',
		null,
		[
			'taxonomy' => FIRING,
		] 
	);
}

/**
 * Taxonomy archive for Forms
 */
function the_taxonomy_loop__form(): void {
	if ( ! is_page_template( 'templates/forms.php' ) ) {
		return;
	}

	get_template_part( 
		'partials/taxonomy-loop',
		null,
		[
			'taxonomy' => FORM,
		] 
	);
}

/**
 * Taxonomy archive for Technique
 */
function the_taxonomy_loop__technique(): void {
	if ( ! is_page_template( 'templates/techniques.php' ) ) {
		return;
	}

	get_template_part( 
		'partials/taxonomy-loop',
		null,
		[
			'taxonomy' => TECHNIQUE,
		] 
	);
}


/**
 * Add drop down for custom taxonomies
 */
function admin_filter(): void {
	global $typenow;

	$taxonomies = [
		FORM,
		FIRING,
		TECHNIQUE,
		COLUMN,
		ROW,
		LOCATION,
		RESULT,
	];

	if ( POST_SLUG !== $typenow ) {
		return;
	}

	foreach ( $taxonomies as $taxonomy ) {
		$tax_obj = get_taxonomy( $taxonomy );
		if ( empty( $tax_obj ) ) {
			continue;
		}

		$tax_name = $tax_obj->labels->name ?? '';
		if ( empty( $tax_name ) ) {
			continue;
		}

		$terms = get_terms( $taxonomy );
		if ( empty( $terms ) ) {
			continue;
		}

		$_GET[ $taxonomy ] = false;

		if ( count( $terms ) > 0 ) {
			printf(
				'<select name=%s id=%s class="postform">',
				esc_attr( $taxonomy ),
				esc_attr( $taxonomy )
			);

			printf(
				'<option value="">%s %s</option>',
				esc_html__( 'Show All', 'rosenfield-collection' ),
				esc_html( $tax_name )
			);

			foreach ( $terms as $term ) {
				printf(
					'<option value=%s %s>%s (%s)</option>',
					esc_attr( $term->slug ),
					$_GET[ $taxonomy ] === $term->slug ? ' selected="selected"' : '', // phpcs:ignore
					esc_html( $term->name ),
					(int) $term->count
				);
			}

			echo '</select>';
		}
	}
}
