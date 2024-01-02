<?php
/**
 * Scripts and Styles.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Config\ScriptsAndStyles;

use function RosenfieldCollection\Theme\Helpers\get_theme_url;

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
			'ver'    => wp_get_theme()->get( 'Version' ),
		],
		[
			'handle' => \genesis_get_theme_handle() . '-google-fonts',
			'src'    => "//fonts.googleapis.com/css?family=$google_fonts&display=swap",
			'editor' => 'both',
		],
	],
	'remove' => [],
];
