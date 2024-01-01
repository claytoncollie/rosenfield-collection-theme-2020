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

return array(
	'add'    => array(
		'align-wide',
		'automatic-feed-links',
		'editor-styles',
		'front-page-widgets'       => 1,
		'genesis-accessibility'    => array(
			'404-page',
			'drop-down-menu',
			'headings',
			'rems',
			'search-form',
			'skip-links',
		),
		'genesis-menus'            => array(
			'primary'   => __( 'Header Menu', 'rosenfield-collection' ),
			'secondary' => __( 'Footer Menu', 'rosenfield-collection' ),
		),
		'genesis-structural-wraps' => array(
			'header',
			'menu-secondary',
			'hero-section',
			'footer-widgets',
			'front-page-widgets',
		),
		'gutenberg'                => array(
			'wide-images' => true,
		),
		'hero-section',
		'html5'                    => array(
			'caption',
			'comment-form',
			'comment-list',
			'gallery',
			'search-form',
		),
		'post-thumbnails',
		'responsive-embeds',
		'wp-block-styles',
	),
	'remove' => array(),
);
