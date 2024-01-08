<?php
/**
 * Theme Support.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\COnfig\ThemeSupport;

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
			'primary'   => __( 'Header Menu', 'rosenfield-collection' ),
			'secondary' => __( 'Footer Menu', 'rosenfield-collection' ),
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
	'remove' => [
		'genesis-seo-settings-menu',
		'genesis-readme-menu',
		'genesis-customizer-seo-settings',
		'genesis-auto-updates',
		'genesis-breadcrumbs',
	],
];
