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
	'script' => array(
		'mainMenu'         => sprintf( '<span class="hamburger"></span><span class="screen-reader-text">%s</span>', __( 'Menu', 'rosenfield-collection' ) ),
		'menuIconClass'    => null,
		'subMenuIconClass' => null,
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
			),
		),
		'menuAnimation'    => array(
			'effect'   => 'fadeToggle',
			'duration' => 'fast',
			'easing'   => 'swing',
		),
		'subMenuAnimation' => array(
			'effect'   => 'slideToggle',
			'duration' => 'fast',
			'easing'   => 'swing',
		),
	),
	'extras' => array(
		'media_query_width' => '896px',
	),
);
