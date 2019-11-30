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

$front_page_widgets = [];
$theme_supports     = genesis_get_config( 'theme-support' )['add'];

for ( $i = 1; $i <= $theme_supports['front-page-widgets']; $i++ ) {
	$front_page_widgets[] = [
		'id'          => 'front-page-' . $i,
		'name'        => __( 'Front Page ', 'rosenfield-collection-2020' ) . $i,
		/* translators: The front page widget area number. */
		'description' => \sprintf( __( 'The Front Page %s widget area.', 'rosenfield-collection-2020' ), $i ),
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
