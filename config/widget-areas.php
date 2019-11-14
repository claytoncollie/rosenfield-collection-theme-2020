<?php
/**
 * Genesis Starter Theme.
 *
 * @package   SeoThemes\GenesisStarterTheme
 * @link      https://genesisstartertheme.com
 * @author    SEO Themes
 * @copyright Copyright © 2019 SEO Themes
 * @license   GPL-2.0-or-later
 */

namespace SeoThemes\GenesisStarterTheme;

$front_page_widgets = [];
$theme_supports     = genesis_get_config( 'theme-support' )['add'];

for ( $i = 1; $i <= $theme_supports['front-page-widgets']; $i++ ) {
	$front_page_widgets[] = [
		'id'          => 'front-page-' . $i,
		'name'        => __( 'Front Page ', 'genesis-starter-theme' ) . $i,
		/* translators: The front page widget area number. */
		'description' => \sprintf( __( 'The Front Page %s widget area.', 'genesis-starter-theme' ), $i ),
	];
}

return [
	'add'    => 
		$front_page_widgets
	,
	'remove' => [
		'header-right',
		'sidebar',
		'sidebar-alt',
	],
];
