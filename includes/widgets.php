<?php
/**
 * Widgets.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Widgets;

/**
 * Setup
 */
function setup(): void {
	add_filter( 'genesis_register_widget_area_defaults', __NAMESPACE__ . '\front_page_1_heading', 10, 2 );
	add_filter( 'genesis_widget_area_defaults', __NAMESPACE__ . '\widget_area_defaults', 10, 2 );
}

/**
 * Change Front Page 1 title to H1.
 *
 * @param array $defaults Default settings.
 * @param array $args     Other args.
 */
function front_page_1_heading( array $defaults, array $args ): array {
	if ( 'front-page-1' === $args['id'] ) {
		$defaults['before_title'] = '<h2 class="hero-title" itemprop="headline">';
		$defaults['after_title']  = "</h2>\n";
	}

	return $defaults;
}

/**
 * Set default values for widget area output.
 *
 * @param array  $defaults Widget area defaults.
 * @param string $id       Widget area ID.
 */
function widget_area_defaults( array $defaults, string $id ): array {
	$hero = 'front-page-1' === $id ? ' hero-section" role="banner' : '';

	if ( str_contains( $id, 'front-page-' ) ) {
		$defaults['before'] = genesis_markup(
			[
				'open'    => '<div class="' . $id . $hero . '"><div class="wrap">',
				'context' => 'widget-area-wrap',
				'echo'    => false,
				'params'  => [
					'id' => $id,
				],
			]
		);
		$defaults['after']  = genesis_markup(
			[
				'close'   => '</div></div>',
				'context' => 'widget-area-wrap',
				'echo'    => false,
			]
		);
	}

	return $defaults;
}
