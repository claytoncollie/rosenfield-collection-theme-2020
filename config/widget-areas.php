<?php
/**
 * Widget Areas.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Config\WidgetAreas;

$front_page_widgets = [];
$theme_supports     = genesis_get_config( 'theme-support' )['add'];

for ( $i = 1; $i <= $theme_supports['front-page-widgets']; $i++ ) {
	$front_page_widgets[] = [
		'id'          => 'front-page-' . $i,
		'name'        => __( 'Front Page ', 'rosenfield-collection' ) . $i,
		/* translators: The front page widget area number. */
		'description' => \sprintf( __( 'The Front Page %s widget area.', 'rosenfield-collection' ), $i ),
	];
}

return [
	'add'    =>
		$front_page_widgets,
	'remove' => [
		'header-right',
		'sidebar',
		'sidebar-alt',
	],
];
