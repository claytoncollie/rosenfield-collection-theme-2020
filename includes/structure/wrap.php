<?php
/**
 * Wrapper.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Wrap;

/**
 * Setup
 */
function setup(): void {
	add_action( 'genesis_before', __NAMESPACE__ . '\structural_wrap_hooks' );
	add_filter( 'genesis_attr_content-sidebar-wrap', __NAMESPACE__ . '\content_sidebar_wrap' );
}

/**
 * Add hooks before and after structural wraps.
 */
function structural_wrap_hooks(): void {
	$wraps = get_theme_support( 'genesis-structural-wraps' );
	$wraps = is_array( $wraps ) ? $wraps : [];
	if ( empty( $wraps ) ) {
		return;
	}

	foreach ( $wraps[0] ?? [] as $context ) {
		add_filter(
			'genesis_structural_wrap-' . $context,
			function ( string $output, $original ) use ( $context ): string {
				$position = ( 'open' === $original ) ? 'before' : 'after';
				ob_start();
				do_action( sprintf( 'genesis_%s_%s_wrap', $position, (string) $context ) ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound
				if ( 'open' === $original ) {
					return ob_get_clean() . $output;
				}
				return $output . ob_get_clean();
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
 */
function content_sidebar_wrap( array $atts ): array {
	$atts['class'] = 'wrap';
	return $atts;
}
