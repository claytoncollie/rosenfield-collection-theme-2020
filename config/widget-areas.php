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

$front_page_widgets = array(); // phpcs:ignore
$theme_supports     = genesis_get_config( 'theme-support' )['add']; // phpcs:ignore

for ( $i = 1; $i <= $theme_supports['front-page-widgets']; $i++ ) { // phpcs:ignore
	$front_page_widgets[] = array( // phpcs:ignore
		'id'          => 'front-page-' . $i,
		'name'        => __( 'Front Page ', 'rosenfield-collection' ) . $i,
		/* translators: The front page widget area number. */
		'description' => \sprintf( __( 'The Front Page %s widget area.', 'rosenfield-collection' ), $i ),
	);
}

return array(
	'add'    =>
		$front_page_widgets,
	'remove' => array(
		'header-right',
		'sidebar',
		'sidebar-alt',
	),
);
