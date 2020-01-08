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

use function RosenfieldCollection\Theme2020\Functions\get_theme_url;

$asset_url    = \trailingslashit( get_theme_url() . 'assets' );
$google_fonts = \implode( '|', \genesis_get_config( 'google-fonts' ) );

return [
	'add'    => [
		[
			'handle' => \genesis_get_theme_handle() . '-editor',
			'src'    => $asset_url . 'js/editor.js',
			'deps'   => [ 'wp-blocks' ],
			'editor' => true,
		],
		[
			'handle'    => \genesis_get_theme_handle() . '-main',
			'src'       => $asset_url . 'js/min/main.js',
			'condition' => function () {
				return ! \genesis_is_amp();
			},
		],
		[
			'handle' => \genesis_get_theme_handle() . '-main',
			'src'    => $asset_url . 'css/main.css',
		],
		[
			'handle' => \genesis_get_theme_handle() . '-google-fonts',
			'src'    => "//fonts.googleapis.com/css?family=$google_fonts&display=swap",
			'editor' => 'both',
		],
		[
			'handle'      => \genesis_get_theme_handle() . '-font-awesome',
			'src'         => '//kit.fontawesome.com/32f48c7bb2.js',
			'editor'      => 'both',
			'crossorigin' => 'anonymous',
		],
	],
	'remove' => [],
];
