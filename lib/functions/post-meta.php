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
 * Object meta data
 *
 * @since  1.0.0
 */
function do_the_post_meta() {
	$forms      = get_the_term_list( get_the_ID(), 'rc_form', '', ', ', '' );
	$firings    = get_the_term_list( get_the_ID(), 'rc_firing', '', ', ' );
	$techniques = get_the_term_list( get_the_ID(), 'rc_technique', '', ', ' );
	$rows       = get_the_term_list( get_the_ID(), 'rc_row', '', ', ' );
	$columns    = get_the_term_list( get_the_ID(), 'rc_column', '', ', ' );
	$length     = get_field( 'length' );
	$width      = get_field( 'width' );
	$height     = get_field( 'height' );
	$first_name = get_the_author_meta( 'first_name' ) ? get_the_author_meta( 'first_name' ) : '';
	$last_name  = get_the_author_meta( 'last_name' ) ? get_the_author_meta( 'last_name' ) : '';

	// Load all 'rc_form' terms for the post.
	$terms     = get_the_terms( get_the_ID(), 'rc_form' );
	$object_id = get_field( 'object_id' );

	printf(
		'<section id="rosenfield-collection-object-data" class="post-meta" role="contentinfo" aria-label="%s"><div class="wrap"><div class="data">',
		esc_html__( 'Object data', 'rosenfield-collection-2020' )
	);

	if ( ! empty( $terms ) ) {
		$term   = array_pop( $terms );
		$prefix = get_field( 'rc_form_object_prefix', $term );

		printf(
			'<span>%s%s</span>',
			esc_html( $prefix ),
			esc_html( $object_id )
		);
	}
	printf(
		'<span class="entry-sep">&middot;</span><span><a href="%s" rel="author">%s %s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( $first_name ),
		esc_html( $last_name )
	);
	if ( ! empty( $forms ) ) {
		printf(
			'<span class="entry-sep">&middot;</span>%s',
			wp_kses_post( $forms )
		);
	}
	if ( ! empty( $firings ) ) {
		printf(
			'<span class="entry-sep">&middot;</span>%s',
			wp_kses_post( $firings )
		);
	}
	if ( ! empty( $techniques ) ) {
		printf(
			'<span class="entry-sep">&middot;</span>%s',
			wp_kses_post( $techniques )
		);
	}
	if ( $length || $width || $height ) {
		printf(
			'<span class="entry-sep">&middot;</span>%s x %s x %s %s',
			esc_html( $length ),
			esc_html( $width ),
			esc_html( $height ),
			esc_html__( 'inches', 'rosenfield-collection-2020' )
		);
	}

	echo '</div><div class="location">';

	if ( ! empty( $columns ) ) {
		printf(
			'%s %s',
			esc_html__( 'Column', 'rosenfield-collection-2020' ),
			wp_kses_post( $columns )
		);
	}
	if ( ! empty( $rows ) ) {
		printf(
			'<span class="entry-sep">&middot;</span>%s %s',
			esc_html__( 'Row', 'rosenfield-collection-2020' ),
			wp_kses_post( $rows )
		);
	}

	echo '</div></div></section>';
}

