<?php
/**
 * Home.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Home;

/**
 * Setup
 *
 * @return void
 */
function setup(): void {
	add_action( 'genesis_meta', __NAMESPACE__ . '\front_page_loop', 5 );
}

/**
 * Only add hooks if were on the front page.
 *
 * @since 1.0.0
 *
 * @return void
 */
function front_page_loop() {
	if ( \is_front_page() && \is_active_sidebar( 'front-page-1' ) ) {
		\add_action( 'genesis_before_content_sidebar_wrap', __NAMESPACE__ . '\front_page_widget_areas' );
		\add_filter( 'body_class', __NAMESPACE__ . '\front_page_body_class' );
		\add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
		\remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
		\remove_theme_support( 'hero-section' );
	}
}

/**
 * Add additional classes to the body element.
 *
 * @since 1.0.0
 *
 * @param  array $classes Body classes.
 *
 * @return array
 */
function front_page_body_class( array $classes ) : array {
	$classes   = \array_diff( $classes, array( 'no-hero-section' ) );
	$classes[] = 'front-page';

	return $classes;
}

/**
 * Display the front page widget areas.
 *
 * @since 1.0.0
 *
 * @return void
 */
function front_page_widget_areas() {
	$widget_areas = \get_theme_support( 'front-page-widgets' )[0];

	for ( $i = 1; $i <= $widget_areas; $i++ ) {
		\genesis_widget_area( 'front-page-' . $i );
	}
}
