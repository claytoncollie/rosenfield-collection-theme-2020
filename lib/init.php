<?php
/**
 * Rosenfield Collection Theme.
 *
 * @package   RosenfieldCollection\Theme2020
 * @link      https://www.rosenfieldcollection.com
 * @author    Clayton Collie
 * @copyright Copyright © 2019 Clayton Collie
 * @license   GPL-2.0-or-later
 */

namespace RosenfieldCollection\Theme2020;

/**
 * Autoload classes.
 *
 * @noinspection PhpUnhandledExceptionInspection
 */
\spl_autoload_register(
	function ( $class ) {
		if ( strpos( $class, __NAMESPACE__ ) === false ) {
			return;
		}

		$class_dir  = dirname( __DIR__ ) . '/lib/classes/';
		$class_name = strtolower( str_replace( __NAMESPACE__, '', $class ) );
		$class_file = str_replace( '\\', '-', $class_name );

		/* @noinspection PhpIncludeInspection */
		require_once "{$class_dir}class{$class_file}.php";
	}
);

/**
 * Autoload files.
 */
\array_map(
	function ( $file ) {
		$filename = __DIR__ . "/$file.php";

		if ( \is_readable( $filename ) ) {
			require_once $filename;
		}
	},
	array(
		// Composer.
		'../vendor/autoload',

		// Functions.
		'functions/helpers',
		'functions/setup',
		'functions/enqueue',
		'functions/markup',
		'functions/header',
		'functions/widgets',
		'functions/search',
		'functions/taxonomies',
		'functions/artists',
		'functions/statistics',
		'functions/post-title',
		'functions/post-meta-admin',
		'functions/view-all-objects',
		'functions/image-gallery',
		'functions/post-meta',
		'functions/thumbnail-gallery',
		'functions/view-toggle',
		'functions/artist-filter',
		'functions/image-sizes',
		'functions/pending',
		'functions/claim',
		'functions/query-vars',
		'functions/skip-links',
		'functions/a11y',
		'functions/labels',

		// Structure.
		'structure/archive',
		'structure/author',
		'structure/footer',
		'structure/header',
		'structure/hero',
		'structure/home',
		'structure/menus',
		'structure/pagination',
		'structure/single',
		'structure/wrap',

	)
);
