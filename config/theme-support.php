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
			'primary'   => __( 'Header Menu', 'rosenfield-collection-2020' ),
			'secondary' => __( 'Footer Menu', 'rosenfield-collection-2020' ),
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
