<?php
/**
 * Accessibility.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Accessibility;

use function RosenfieldCollection\Theme\Helpers\get_object_prefix_and_id;

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	add_filter( 'genesis_attr_entry', __NAMESPACE__ . '\entry' );
	add_filter( 'genesis_attr_entry-title-link', __NAMESPACE__ . '\entry_title_link' );
	add_filter( 'wp_get_attachment_image_attributes', __NAMESPACE__ . '\entry_image', 99 );
	add_filter( 'genesis_attr_nav-secondary', __NAMESPACE__ . '\nav_secondary' );
	add_filter( 'genesis_attr_archive-pagination', __NAMESPACE__ . '\pagination' );
	add_filter( 'genesis_skip_links_output', __NAMESPACE__ . '\skip_links', 10, 2 );
}

/**
 * Add ID markup to secondary navigation.
 *
 * @param array $attributes Existing attributes for primary navigation element.
 * 
 * @return array
 */
function entry( array $attributes ): array {
	if ( is_archive() || is_home() ) {
		$attributes['aria-label'] = sprintf(
			'%s: %s %s %s %s',
			esc_html( get_object_prefix_and_id() ),
			esc_html( get_the_title() ),
			esc_html__( 'made by', 'rosenfield-collection' ),
			esc_html( get_the_author_meta( 'first_name' ) ),
			esc_html( get_the_author_meta( 'last_name' ) )
		);
	}

	return $attributes;
}

/**
 * Add ID markup to secondary navigation.
 *
 * @param array $attributes Existing attributes for primary navigation element.
 * 
 * @return array
 */
function entry_title_link( array $attributes ): array {
	if ( is_archive() || is_home() ) {
		$attributes['aria-label'] = sprintf(
			'%s: %s %s %s %s %s',
			wp_kses_post( get_object_prefix_and_id() ),
			esc_html__( 'Learn more about', 'rosenfield-collection' ),
			esc_html( get_the_title() ),
			esc_html__( 'made by', 'rosenfield-collection' ),
			esc_html( get_the_author_meta( 'first_name' ) ),
			esc_html( get_the_author_meta( 'last_name' ) )
		);
	}

	return $attributes;
}

/**
 * Define the alt text if it is not present.
 * 
 * @param array $attributes Image attributes.
 *
 * @return array
 */
function entry_image( array $attributes ): array {
	if ( is_archive() || is_home() ) {
		if ( isset( $attributes['alt'] ) ) {
			if ( empty( $attributes['alt'] ) ) {
				$attributes['alt'] = sprintf(
					'%s: %s %s %s %s %s',
					esc_html( get_object_prefix_and_id() ),
					esc_html__( 'Main image for', 'rosenfield-collection' ),
					esc_html( get_the_title() ),
					esc_html__( 'made by', 'rosenfield-collection' ),
					esc_html( get_the_author_meta( 'first_name' ) ),
					esc_html( get_the_author_meta( 'last_name' ) )
				);
			}
		}
	}

	return $attributes;
}

/**
 * Add ID markup to secondary navigation.
 *
 * @param array $attributes Existing attributes for primary navigation element.
 * 
 * @return array
 */
function nav_secondary( array $attributes ): array {
	$attributes['id'] = 'genesis-nav-secondary';
	return $attributes;
}

/**
 * Add attributes for pagination element.
 *
 * @param array $attributes Existing attributes for pagination element.
 * 
 * @return array
 */
function pagination( array $attributes ): array {
	$attributes['id'] = 'genesis-archive-pagination';
	return $attributes;
}

/**
 * Filter the available skip links
 *
 * @param array $links {
 *     Default skiplinks.
 *
 *     @type string HTML ID attribute value to link to.
 *     @type string Anchor text.
 * }
 *
 * @return array
 */
function skip_links( array $links ): array {
	if ( is_page( 'artists' ) ) {
		$links['rosenfield-collection-artist-filter'] = esc_html__( 'Skip to artist filter by last name', 'rosenfield-collection' );
	}

	if ( is_single() ) {
		$links['rosenfield-collection-object-data'] = esc_html__( 'Skip to object data', 'rosenfield-collection' );
	}

	if ( is_single() && is_user_logged_in() ) {
		$links['rosenfield-collection-admin-object-data'] = esc_html__( 'Skip to admin object data', 'rosenfield-collection' );
	}

	if ( is_search() ) {
		$links['rosenfield-collection-current-refinements'] = esc_html__( 'Skip to current refinements', 'rosenfield-collection' );
	}

	if ( is_archive() || is_home() || is_page( 'artists' ) ) {
		$links['genesis-archive-pagination'] = esc_html__( 'Skip to pagination', 'rosenfield-collection' );
	}

	$links['rosenfield-collection-footer-credits'] = esc_html__( 'Skip to footer credits', 'rosenfield-collection' );

	if ( genesis_nav_menu_supported( 'secondary' ) && has_nav_menu( 'secondary' ) ) {
		$links['genesis-nav-secondary'] = esc_html__( 'Skip to secondary navigation', 'rosenfield-collection' );
	}

	return $links;
}
