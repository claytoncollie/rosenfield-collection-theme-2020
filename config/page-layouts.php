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

use function SeoThemes\GenesisStarterTheme\Functions\get_theme_url;

return [
	'add'    => [
		[
			'id'    => 'narrow-content',
			'label' => __( 'Narrow Content', 'genesis-starter-theme' ),
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
