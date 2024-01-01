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
		'hero-section' => array( 'page', 'post' ),
		'excerpt'      => array( 'page', 'post' ),
	),
	'remove' => array(
		'genesis-scripts' => array( 'post' ),
		'genesis-layouts' => array( 'post' ),
	),
);
