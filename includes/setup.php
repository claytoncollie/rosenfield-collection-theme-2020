<?php
/**
 * Setup.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Setup;

/**
 * Setup
 */
function setup(): void {
	add_action( 'after_setup_theme', __NAMESPACE__ . '\config', 5 );
}

/**
 * Theme setup.
 */
function config(): void {

	// Get setup configs.
	$responsive_menu   = genesis_get_config( 'responsive-menu' );
	$theme_support     = genesis_get_config( 'theme-support' );
	$post_type_support = genesis_get_config( 'post-type-support' );
	$image_sizes       = genesis_get_config( 'image-sizes' );
	$page_layouts      = genesis_get_config( 'page-layouts' );

	// Add responsive menus.
	genesis_register_responsive_menus( $responsive_menu );

	// Add theme supports.
	\array_walk(
		$theme_support['add'],
		function ( $value, $key ): void {
			is_int( $key ) ? add_theme_support( $value ) : add_theme_support( $key, $value );
		}
	);

	// Remove theme supports.
	\array_walk(
		$theme_support['remove'],
		function ( $name ): void {
			remove_theme_support( $name );
		}
	);

	// Add post type supports.
	\array_walk(
		$post_type_support['add'],
		function ( $post_types, $feature ): void {
			foreach ( $post_types as $post_type ) {
				add_post_type_support( $post_type, $feature );
			}
		}
	);

	// Remove post type supports.
	\array_walk(
		$post_type_support['remove'],
		function ( $post_types, $feature ): void {
			foreach ( $post_types as $post_type ) {
				remove_post_type_support( $post_type, $feature );
			}
		}
	);

	// Add image sizes.
	\array_walk(
		$image_sizes['add'],
		function ( $args, $name ): void {
			add_image_size( $name, $args[0], $args[1], $args[2] );
		}
	);

	// Remove image sizes.
	\array_walk(
		$image_sizes['remove'],
		function ( $name ): void {
			remove_image_size( $name );
		}
	);

	// Add page layouts.
	\array_walk(
		$page_layouts['add'],
		function ( array $args ): void {
			genesis_register_layout( $args['id'], $args );
		}
	);

	// Remove page layouts.
	\array_walk(
		$page_layouts['remove'],
		function ( $name ): void {
			genesis_unregister_layout( $name );
		}
	);
}
