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

use function SeoThemes\GenesisStarterTheme\Functions\get_theme_url;

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
			'handle' => \genesis_get_theme_handle() . '-ion-icons',
			'src'    => "//unpkg.com/ionicons@4.1.2/dist/css/ionicons.min.css",
			'editor' => false,
		],
	],
	'remove' => [],
];
