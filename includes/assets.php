<?php
/**
 * Assets.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Assets;

/**
 * Actions and Filters
 */
function setup(): void {
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\scripts' );
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\styles' );
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\editor_styles' );
}

/**
 * Enqueue scripts.
 */
function scripts(): void {
	wp_enqueue_script(
		'rosenfield-collection-frontend',
		ROSENFIELD_COLLECTION_THEME_DIST_URL . 'frontend.js',
		[ 'jquery' ],
		(string) filemtime( ROSENFIELD_COLLECTION_THEME_DIST_PATH . 'frontend.js' ),
		true
	);
}

/**
 * Enqueue styles.
 */
function styles(): void {
	wp_enqueue_style(
		'rosenfield-collection-main',
		ROSENFIELD_COLLECTION_THEME_DIST_URL . 'main.css',
		[],
		(string) filemtime( ROSENFIELD_COLLECTION_THEME_DIST_PATH . 'main.css' ),
	);
}

/**
 * Enqueue editor styles.
 */
function editor_styles(): void {
	wp_enqueue_style(
		'rosenfield-collection-editor',
		ROSENFIELD_COLLECTION_THEME_DIST_URL . 'editor.css',
		[],
		(string) filemtime( ROSENFIELD_COLLECTION_THEME_DIST_PATH . 'editor.css' ),
	);
}
