<?php
/**
 * Site Footer.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\SiteFooter;

/**
 * Setup
 */
function setup(): void {
	add_filter( 'genesis_attr_site-footer', __NAMESPACE__ . '\container' );
	add_filter( 'genesis_structural_wrap-footer', __NAMESPACE__ . '\wrapper', 10, 2 );
	add_filter( 'genesis_footer_output', __NAMESPACE__ . '\copyright_and_menu' );
}

/**
 * Site footer container
 * 
 * @param array $attributes Attributes.
 */
function container( array $attributes ): array {
	$attributes['class'] = 'mt-auto pt-5 pb-3';
	return $attributes;
}

/**
 * Wrap the 'row' within a Bootstrap 'container' class
 * 
 * @param string $output Output.
 * @param string $original_output Original output.
 */
function wrapper( string $output, string $original_output ): string {
	$output = 'open' === $original_output ? '<div class="container-xxl"><div class="row align-items-center">' : $output;
	return 'close' === $original_output ? '</div></div>' : $output;
}

/**
 * Display the custom credits text wrapped in Bootstrap markup.
 */
function copyright_and_menu(): string {
	ob_start();
	get_template_part( 'partials/copyright' );
	$output = ob_get_contents();
	$output = $output ? $output : '';
	ob_end_clean();
	return $output;
}
