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

return [
	'add'    => [
		'align-wide',
		'automatic-feed-links',
		'editor-styles',
		'front-page-widgets'       => 1,
		'genesis-accessibility'    => [
			'404-page',
			'drop-down-menu',
			'headings',
			'rems',
			'search-form',
			'skip-links',
		],
		'genesis-menus'            => [
			'primary'   => __( 'Header Menu', 'genesis-starter-theme' ),
			'secondary' => __( 'Footer Menu', 'genesis-starter-theme' ),
		],
		'genesis-structural-wraps' => [
			'header',
			'menu-secondary',
			'hero-section',
			'footer-widgets',
			'front-page-widgets',
		],
		'gutenberg'                => [
			'wide-images' => true,
		],
		'hero-section',
		'html5'                    => [
			'caption',
			'comment-form',
			'comment-list',
			'gallery',
			'search-form',
		],
		'post-thumbnails',
		'responsive-embeds',
		'wp-block-styles',
	],
	'remove' => [],
];
