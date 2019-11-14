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

namespace SeoThemes\GenesisStarterTheme\Structure;

\add_filter( 'genesis_markup_title-area_close', __NAMESPACE__ . '\title_area_hook', 10, 1 );
/**
 * Add custom hook after the title area.
 *
 * @since 1.0.0
 *
 * @param string $close_html Closing html markup.
 *
 * @return string
 */
function title_area_hook( $close_html ) {
	if ( $close_html ) {
		\ob_start();
		\do_action( 'genesis_after_title_area' );
		$close_html = $close_html . ob_get_clean();
	}

	return $close_html;
}

\add_filter( 'get_custom_logo', __NAMESPACE__ . '\custom_logo_size' );
/**
 * Add max-width style to custom logo.
 *
 * @since 1.0.0
 *
 * @param string $html Custom logo HTML output.
 *
 * @return string
 */
function custom_logo_size( $html ) {
	$width  = \get_theme_support( 'custom-logo' )[0]['width'];
	$height = \get_theme_support( 'custom-logo' )[0]['height'];

	return \str_replace( '<img ', '<img style="max-width:' . $width . 'px;max-height:' . $height . 'px"', $html );
}

