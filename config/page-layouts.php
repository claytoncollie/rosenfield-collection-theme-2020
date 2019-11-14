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
		[
			'id'    => 'narrow-content',
			'label' => __( 'Narrow Content', 'rosenfield-collection-2020' ),
			'img'   => get_theme_url() . 'assets/img/narrow-content.gif',
		],
	],
	'remove' => [
		'sidebar-content',
		'content-sidebar',
		'content-sidebar-sidebar',
		'sidebar-sidebar-content',
		'sidebar-content-sidebar',
	],
];
