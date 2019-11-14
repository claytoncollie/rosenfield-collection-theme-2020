<?php
/**
 * Genesis Starter Theme.
 *
 * @package   SeoThemes\GenesisStarterTheme
 * @link      https://genesisstartertheme.com
 * @author    SEO Themes
 * @copyright Copyright © 2019 SEO Themes
 * @license   GPL-2.0-or-later
 */

namespace SeoThemes\GenesisStarterTheme;

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
	[
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

		// Structure.
		'structure/archive',
		'structure/footer',
		'structure/header',
		'structure/hero',
		'structure/home',
		'structure/menus',
		'structure/pagination',
		'structure/single',
		'structure/wrap',

		// Plugins.
		'plugins/gravity-forms',
	]
);
