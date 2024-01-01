<?php
/**
 * Rosenfield Collection Theme.
 *
 * @package   RosenfieldCollection\Theme
 * @link      https://www.rosenfieldcollection.com
 * @author    Clayton Collie
 * @copyright Copyright © 2019 Clayton Collie
 * @license   GPL-2.0-or-later
 */

namespace RosenfieldCollection\Theme;

use function RosenfieldCollection\Theme\Helpers\get_theme_url;

$asset_url    = \trailingslashit( get_theme_url() . 'assets' ); // phpcs:ignore
$google_fonts = \implode( '|', \genesis_get_config( 'google-fonts' ) ); // phpcs:ignore

return array(
	'add'    => array(
		array(
			'handle' => \genesis_get_theme_handle() . '-editor',
			'src'    => $asset_url . 'js/editor.js',
			'deps'   => array( 'wp-blocks' ),
			'editor' => true,
		),
		array(
			'handle'    => \genesis_get_theme_handle() . '-main',
			'src'       => $asset_url . 'js/min/main.js',
			'condition' => function () {
				return ! \genesis_is_amp();
			},
		),
		array(
			'handle' => \genesis_get_theme_handle() . '-main',
			'src'    => $asset_url . 'css/main.css',
			'ver'    => wp_get_theme()->get( 'Version' ),
		),
		array(
			'handle' => \genesis_get_theme_handle() . '-google-fonts',
			'src'    => "//fonts.googleapis.com/css?family=$google_fonts&display=swap",
			'editor' => 'both',
		),
	),
	'remove' => array(),
);
