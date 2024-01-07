<?php
/**
 * Page Layouts.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Config\PageLayouts;

use function RosenfieldCollection\Theme\Helpers\get_theme_url;

return [
	'add'    => [
		[
			'id'    => 'narrow-content',
			'label' => __( 'Narrow Content', 'rosenfield-collection' ),
			'img'   => get_theme_url() . 'assets/img/narrow-content.gif',
		],
	],
	'remove' => [
		'content-sidebar',
		'content-sidebar-sidebar',
		'sidebar-sidebar-content',
		'sidebar-content-sidebar',
	],
];
