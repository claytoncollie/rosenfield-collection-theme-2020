<?php
/**
 * Home.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Home;

/**
 * Setup
 */
function setup(): void {
	add_action( 'genesis_meta', __NAMESPACE__ . '\setup', 5 );
	add_filter( 'body_class', __NAMESPACE__ . '\body_class' );
	add_action( 'genesis_before_content_sidebar_wrap', __NAMESPACE__ . '\hero' );
	
	if ( is_front_page() ) {
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
		remove_theme_support( 'hero-section' );
	}
}

/**
 * Add additional classes to the body element.
 *
 * @param array $classes Body classes.
 */
function body_class( array $classes ): array {
	if ( ! is_front_page() ) {
		return $classes;
	}

	$classes   = array_diff( $classes, [ 'no-hero-section' ] );
	$classes[] = 'front-page';

	return $classes;
}

/**
 * Display the introduction and stats on the homepage.
 */
function hero(): void {
	if ( ! is_front_page() ) {
		return;
	}
	
	echo wp_kses_post( '<section class="front-page-1 hero-section"><div class="wrap">' );

	get_template_part( 'partials/introduction' );
	get_template_part( 'partials/subscribe' );
	get_template_part( 'partials/statistics' );

	echo wp_kses_post( '</div></section>' );
}
