<?php
/**
 * Wrapper.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Wrap;

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	add_filter( 'genesis_before', __NAMESPACE__ . '\structural_wrap_hooks' );
	add_filter( 'genesis_attr_content-sidebar-wrap', __NAMESPACE__ . '\content_sidebar_wrap' );
}

/**
 * Add hooks before and after structural wraps.
 *
 * @return void
 */
function structural_wrap_hooks(): void {
	$wraps = \get_theme_support( 'genesis-structural-wraps' );

	foreach ( $wraps[0] as $context ) {
		\add_filter(
			"genesis_structural_wrap-{$context}",
			function ( $output, $original ) use ( $context ) {
				$position = ( 'open' === $original ) ? 'before' : 'after';
				\ob_start();
				\do_action( "genesis_{$position}_{$context}_wrap" );
				if ( 'open' === $original ) {
					return \ob_get_clean() . $output;
				} else {
					return $output . \ob_get_clean();
				}
			},
			10,
			2
		);
	}
}

/**
 * Change content-sidebar-wrap class to wrap.
 *
 * @param array $atts Default element attributes.
 *
 * @return mixed
 */
function content_sidebar_wrap( array $atts ): array {
	$atts['class'] = 'wrap';
	return $atts;
}
