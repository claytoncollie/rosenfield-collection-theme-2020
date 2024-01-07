<?php
/**
 * Rosenfield Collection Theme.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Config\PostTypeSupport;

return [
	'add'    => [
		'hero-section' => [ 'page', 'post' ],
		'excerpt'      => [ 'page', 'post' ],
	],
	'remove' => [
		'genesis-scripts' => [ 'post' ],
		'genesis-layouts' => [ 'post' ],
	],
];
