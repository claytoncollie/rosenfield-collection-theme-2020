<?php
/**
 * Responsive Menu.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Config\ResponsiveMenu;

return [
	'script' => [
		'mainMenu'         => sprintf( '<span class="hamburger"></span><span class="screen-reader-text">%s</span>', __( 'Menu', 'rosenfield-collection' ) ),
		'menuIconClass'    => null,
		'subMenuIconClass' => null,
		'menuClasses'      => [
			'combine' => [
				'.nav-primary',
			],
		],
		'menuAnimation'    => [
			'effect'   => 'fadeToggle',
			'duration' => 'fast',
			'easing'   => 'swing',
		],
		'subMenuAnimation' => [
			'effect'   => 'slideToggle',
			'duration' => 'fast',
			'easing'   => 'swing',
		],
	],
	'extras' => [
		'media_query_width' => '896px',
	],
];
