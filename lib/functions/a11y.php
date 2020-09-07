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

\add_filter( 'genesis_attr_entry', __NAMESPACE__ . '\attr_entry' );
/**
 * Add ID markup to secondary navigation.
 *
 * @since 1.6.0
 *
 * @param array $attributes Existing attributes for primary navigation element.
 * @return array Amended attributes for primary navigation element.
 */
function attr_entry( array $attributes ) : array {
	if ( is_archive() || is_home() ) {
		$attributes['aria-label'] = sprintf(
			'%s %s %s %s',
			esc_html( get_the_title() ),
			wp_kses_post( get_field( 'object_id' ) ),
			esc_html__( 'by', 'rosenfield-collection-2020' ),
			esc_html( get_the_author() )
		);
	}

	return $attributes;
}

\add_filter( 'genesis_attr_entry-title-link', __NAMESPACE__ . '\attr_entry_title_link' );
/**
 * Add ID markup to secondary navigation.
 *
 * @since 1.6.0
 *
 * @param array $attributes Existing attributes for primary navigation element.
 * @return array Amended attributes for primary navigation element.
 */
function attr_entry_title_link( array $attributes ) : array {
	if ( is_archive() || is_home() ) {
		$attributes['aria-label'] = sprintf(
			'%s %s',
			esc_html__( 'Learn more about object', 'rosenfield-collection-2020' ),
			wp_kses_post( get_object_prefix_and_id() )
		);
	}

	return $attributes;
}

\add_filter( 'wp_get_attachment_image_attributes', __NAMESPACE__ . '\attr_entry_image', 99, 3 );
/**
 * Define the alt text if it is not present.
 *
 * @param array    $attr Image attributes.
 * @param \WP_Post $attachment Attached post.
 * @param mixed    $size Image size.
 *
 * @return array
 *
 * @since 1.6.0
 */
function attr_entry_image( array $attr, \WP_Post $attachment, $size ) : array {
	if ( is_archive() || is_home() ) {
		if ( isset( $attr['alt'] ) ) {
			if ( empty( $attr['alt'] ) ) {
				$attr['alt'] = sprintf(
					'%s %s',
					esc_html__( 'Front view of', 'rosenfield-collection-2020' ),
					esc_html( get_object_prefix_and_id() )
				);
			}
		}
	}

	return $attr;
}

add_filter( 'genesis_attr_nav-secondary', __NAMESPACE__ . '\attr_nav_secondary' );
/**
 * Add ID markup to secondary navigation.
 *
 * @since 1.5.0
 *
 * @param array $attributes Existing attributes for primary navigation element.
 * @return array Amended attributes for primary navigation element.
 */
function attr_nav_secondary( array $attributes ) : array {
	$attributes['id'] = 'genesis-nav-secondary';
	return $attributes;
}

add_filter( 'genesis_attr_archive-pagination', __NAMESPACE__ . '\attr_pagination' );
/**
 * Add attributes for pagination element.
 *
 * @since 1.5.0
 *
 * @param array $attributes Existing attributes for pagination element.
 * @return array Amended attributes for pagination element.
 */
function attr_pagination( array $attributes ) : array {
	$attributes['id'] = 'genesis-archive-pagination';
	return $attributes;
}
