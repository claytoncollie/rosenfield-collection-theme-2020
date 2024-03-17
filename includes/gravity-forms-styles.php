<?php
/**
 * Gravity Forms Styles.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\GravityFormsStyles;

/**
 * Setup actions and filters
 */
function setup(): void {
	add_filter( 'pre_option_rg_gforms_disable_css', '__return_false' );
	add_filter( 'pre_option_rg_gforms_enable_html5', '__return_true' );
	add_filter( 'gform_submit_button', __NAMESPACE__ . '\submit_button' );
}

/**
 * Add classes to the submit button.
 * 
 * @param string $button Button markup.
 */
function submit_button( string $button ): string {
	return str_replace( "class='gform_button", "class='gform_button btn btn-primary", $button );
}
