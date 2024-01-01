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

use function RosenfieldCollection\Theme\Helpers\get_theme_url;

return array(
	'add'    => array(
		array(
			'id'    => 'narrow-content',
			'label' => __( 'Narrow Content', 'rosenfield-collection' ),
			'img'   => get_theme_url() . 'assets/img/narrow-content.gif',
		),
	),
	'remove' => array(
		'content-sidebar',
		'content-sidebar-sidebar',
		'sidebar-sidebar-content',
		'sidebar-content-sidebar',
	),
);
