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

namespace RosenfieldCollection\Theme2020\Structure;

// Remove featured image.
\remove_action( 'genesis_entry_content', 'genesis_do_singular_image', 8 );

// Remove entry info.
\remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

\add_action( 'after_setup_theme', __NAMESPACE__ . '\disable_edit_post_link' );
/**
 * Disables the post edit link.
 *
 * @since 1.0.0
 *
 * @return void
 */
function disable_edit_post_link() {
	\add_filter( 'edit_post_link', '__return_empty_string' );
}

/**
 * Gallery Loop
 *
 * @since  1.0.0
 */
function rc_gallery_do_loop() {
	$images = get_field( 'images' );

	if ( $images ) {
		echo '<div id="slider" class="first three-fourths flexslider" itemscope="itemscope" itemtype="http://schema.org/VisualArtwork">';
			echo '<ul class="slides">';
		foreach ( $images as $image ) :
			printf(
				'<li data-thumb="%s"><img src="%s" alt="%s %s %s" itemprop="workExample"><a href="%s" class="button attachment"><i class="fa fa-cloud-download"></i> %s</a></li>',
				esc_html( $image['sizes']['thumbnail'] ),
				esc_url( $image['sizes']['large'] ),
				esc_html__( 'Made by', 'rosenfield-collection-2020' ),
				esc_html( get_the_author_meta( 'user_firstname' ) ),
				esc_html( get_the_author_meta( 'user_lastname' ) ),
				esc_url( $image['url'] ),
				esc_html__( 'Download', 'rosenfield-collection-2020' )
			);
				endforeach;
			echo '</ul>';
		echo '</div>';
	} elseif ( has_post_thumbnail() ) {
		echo '<div id="slider" class="first three-fourths flexslider" itemscope="itemscope" itemtype="http://schema.org/VisualArtwork">';
			echo '<ul class="slides">';
				printf(
					'<li itemprop="workExample">%s<a href="%s" class="button attachment"><i class="fa fa-cloud-download"></i> %s</a></li>',
					get_the_post_thumbnail(
						get_the_ID(),
						'large',
						array(
							'alt' => sprintf(
								'%s %s %s',
								esc_html__( 'Made by', 'rosenfield-collection-2020' ),
								esc_html( get_the_author_meta( 'user_firstname' ) ),
								esc_html( get_the_author_meta( 'user_lastname' ) )
							),
						)
					),
					esc_url( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) ),
					esc_html__( 'Download', 'rosenfield-collection-2020' )
				);
			echo '</ul>';
		echo '</div>';
	}
}


/**
 * Object meta just below post title
 *
 * @since  1.0.0
 */
function rc_sidebar_meta() {
	$forms      = get_the_term_list( get_the_ID(), 'rc_form', '<span itemprop="artForm">', '</span>, <span itemprop="artForm">', '</span>' );
	$firings    = get_the_term_list( get_the_ID(), 'rc_firing', '', ', ' );
	$techniques = get_the_term_list( get_the_ID(), 'rc_technique', '', ', ' );
	$rows       = get_the_term_list( get_the_ID(), 'rc_row', '', ', ' );
	$columns    = get_the_term_list( get_the_ID(), 'rc_column', '', ', ' );
	$length     = get_field( 'length' );
	$width      = get_field( 'width' );
	$height     = get_field( 'height' );

	// Load all 'rc_form' terms for the post.
	$terms     = get_the_terms( get_the_ID(), 'rc_form' );
	$object_id = get_field( 'object_id' );

	echo '<div class="one-fourth sidebar sidebar-primary" itemscope="itemscope" itemtype="http://schema.org/VisualArtwork">';

	if ( ! empty( $terms ) ) {
		$term   = array_pop( $terms );
		$prefix = get_field( 'rc_form_object_prefix', $term );

		printf(
			'<div class="meta id"><span class="object-meta-heading">%s</span><span class="object-id">%s%s</span></div>',
			esc_html__( 'ID', 'rosenfield-collection-2020' ),
			esc_html( $prefix ),
			intval( $object_id )
		);
	}
	if ( ! empty( $forms ) ) {
		printf(
			'<div class="meta form"><span class="object-meta-heading">%s</span>%s</div>',
			esc_html__( 'Form', 'rosenfield-collection-2020' ),
			wp_kses_post( $forms )
		);
	}
	if ( ! empty( $firings ) ) {
		printf(
			'<div class="meta firing"><span class="object-meta-heading">%s</span>%s</div>',
			esc_html__( 'Firing', 'rosenfield-collection-2020' ),
			wp_kses_post( $firings )
		);
	}
	if ( ! empty( $techniques ) ) {
		printf(
			'<div class="meta technique"><span class="object-meta-heading">%s</span>%s</div>',
			esc_html__( 'Technique', 'rosenfield-collection-2020' ),
			wp_kses_post( $techniques )
		);
	}
	if ( $length || $width || $height ) {
		printf(
			'<div class="meta dimensions"><span class="object-meta-heading">%s</span><span class="object-dimensions"><span itemprop="depth">%s</span>x<span itemprop="width">%s</span>x<span itemprop="height">%s</span> %s</span></div>',
			esc_html__( 'Dimensions', 'rosenfield-collection-2020' ),
			esc_html( $length ),
			esc_html( $width ),
			esc_html( $height ),
			esc_html__( 'inches', 'rosenfield-collection-2020' )
		);
	}
	if ( ! empty( $rows ) ) {
		printf(
			'<div class="meta row"><span class="object-meta-heading">%s</span>%s</div>',
			esc_html__( 'Row', 'rosenfield-collection-2020' ),
			wp_kses_post( $rows )
		);
	}
	if ( ! empty( $columns ) ) {
		printf(
			'<div class="meta column"><span class="object-meta-heading">%s</span>%s</div>',
			esc_html__( 'Column', 'rosenfield-collection-2020' ),
			wp_kses_post( $columns )
		);
	}
	echo '</div>';
}

