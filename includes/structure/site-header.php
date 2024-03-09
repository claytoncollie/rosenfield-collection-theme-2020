<?php
/**
 * Site Header.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\SiteHeader;

/**
 * Setup
 */
function setup(): void {
	add_filter( 'genesis_attr_site-header', __NAMESPACE__ . '\container' );
	add_filter( 'genesis_structural_wrap-header', __NAMESPACE__ . '\wrapper', 10, 2 );
	add_filter( 'genesis_attr_title-area', __NAMESPACE__ . '\title_area_attributes' );
	add_filter( 'genesis_attr_site-title', __NAMESPACE__ . '\site_title_attributes' );
	add_filter( 'genesis_attr_site-description', __NAMESPACE__ . '\site_description_attributes' );
	add_filter( 'genesis_markup_title-area_close', __NAMESPACE__ . '\title_area_hook', 10, 1 );
}

/**
 * Site header container
 * 
 * @param array $attributes Attributes.
 */
function container( array $attributes ): array {
	$attributes['class'] .= ' navbar navbar-expand-lg navbar-dark bg-dark py-3 w-100 z-99';
	return $attributes;
}

/**
 * Wrap the 'row' within a Bootstrap 'container' class
 * 
 * @param string $output Output.
 * @param string $original_output Original output.
 */
function wrapper( string $output, string $original_output ): string {
	$output = 'open' === $original_output ? '<div class="container-xxl">' : $output;
	return 'close' === $original_output ? '</div>' : $output;
}

/**
 * Title area attributes
 * 
 * @param array $attributes Attributes.
 */
function title_area_attributes( array $attributes ): array {
	$attributes['class'] = 'lh-sm';
	return $attributes;
}

/**
 * Site Title attributes
 * 
 * @param array $attributes Attributes.
 */
function site_title_attributes( array $attributes ): array {
	$attributes['class'] .= ' mb-0 h2 fs-md-h2 fw-normal text-light';
	return $attributes;
}

/**
 * Site Description attributes
 * 
 * @param array $attributes Attributes.
 */
function site_description_attributes( array $attributes ): array {
	$attributes['class'] = 'mb-0 fst-italic fw-normal text-light font-alt';
	return $attributes;
}

/**
 * Add custom hook after the title area.
 *
 * @param string $close_html Closing html markup.
 */
function title_area_hook( string $close_html ): string {
	if ( '' !== $close_html && '0' !== $close_html ) {
		\ob_start();
		\do_action( 'genesis_after_title_area' );
		$close_html .= ob_get_clean();
	}

	return $close_html;
}
