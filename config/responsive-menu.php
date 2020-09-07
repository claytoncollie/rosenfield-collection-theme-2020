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

return [
	'script' => [
		'mainMenu'         => sprintf( '<span class="hamburger"></span><span class="screen-reader-text">%s</span>', __( 'Menu', 'rosenfield-collection-2020' ) ),
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
