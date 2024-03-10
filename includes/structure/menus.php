<?php
/**
 * Menus.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Menus;

/**
 * Setup
 */
function setup(): void {
	add_filter( 'wp_nav_menu_args', __NAMESPACE__ . '\limit_menu_depth' );
	add_filter( 'wp_nav_menu_args', __NAMESPACE__ . '\navigation' );
	add_filter( 'genesis_attr_nav-primary', __NAMESPACE__ . '\nav_primary_attributes' );
	add_filter( 'genesis_attr_nav-secondary', __NAMESPACE__ . '\nav_secondary_attributes' );
	// Reposition primary nav.
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_after_title_area', 'genesis_do_nav' );
	// Remove secondary nav.
	remove_action( 'genesis_after_header', 'genesis_do_subnav' );
}

/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @param array $args Original menu options.
 */
function limit_menu_depth( array $args ): array {
	$args['depth'] = 1;
	return $args;
}

/**
 * Primary and secondary navigation
 * 
 * @param array $args Arguments.
 */
function navigation( array $args ): array {
	$theme_location = $args['theme_location'] ?? '';
	
	if ( empty( $theme_location ) ) {
		remove_filter( 'genesis_attr_nav-link', __NAMESPACE__ . '\primary_nav_link', 15, 1 );
		remove_filter( 'genesis_attr_nav-link', __NAMESPACE__ . '\secondary_nav_link', 15, 1 );
	} elseif ( 'primary' === $theme_location ) {
		$args['menu_class'] .= ' navbar-nav';

		add_filter( 'genesis_attr_nav-link', __NAMESPACE__ . '\primary_nav_link', 15, 1 );
		remove_filter( 'genesis_attr_nav-link', __NAMESPACE__ . '\secondary_nav_link', 15, 1 );
	} elseif ( 'secondary' === $theme_location ) {
		remove_filter( 'genesis_attr_nav-link', __NAMESPACE__ . '\primary_nav_link', 15, 1 );
		add_filter( 'genesis_attr_nav-link', __NAMESPACE__ . '\secondary_nav_link', 15, 1 );
	}

	return $args;
}

/**
 * Nav primary attributes
 * 
 * @param array $attributes Attributes.
 */
function nav_primary_attributes( array $attributes ): array {
	$attributes['class'] .= ' py-4 py-md-0 px-3 px-md-0';
	return $attributes;
}

/**
 * Nav secondary attributes
 * 
 * @param array $attributes Attributes.
 */
function nav_secondary_attributes( array $attributes ): array {
	$attributes['class'] = 'navbar navbar-expand-md py-0';
	return $attributes;
}

/**
 * Add nav-link classes
 * 
 * @param array $attributes Attributes.
 */
function primary_nav_link( array $attributes ): array {
	$is_active           = $attributes['aria-current'] ? ' active' : '';
	$attributes['class'] = 'nav-link link-light py-1 fs-3 fs-md-6 text-decoration-none' . esc_attr( $is_active );
	return $attributes;
}

/**
 * Add nav-link classes
 * 
 * @param array $attributes Attributes.
 */
function secondary_nav_link( array $attributes ): array {
	$is_active           = $attributes['aria-current'] ? ' active' : '';
	$attributes['class'] = 'nav-link text-decoration-underline' . esc_attr( $is_active );
	return $attributes;
}
