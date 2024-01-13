<?php
/**
 * Footer.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Footer;

/**
 * Setup
 */
function setup(): void {
	add_action( 'genesis_footer', __NAMESPACE__ . '\do_footer_credits' );
	// Remove default footer.
	remove_action( 'genesis_footer', 'genesis_do_footer' ); 
}

/**
 * Output custom footer credits.
 */
function do_footer_credits(): void {
	\genesis_markup(
		[
			'open'    => '<div class="wrap">',
			'context' => 'footer-credits',
		]
	);

	// Display the copyright info.
	printf(
		'<div id="rosenfield-collection-footer-credits" aria-label="Footer Credits"><span class="copyright">%s %s</span><span class="entry-sep">&middot;</span><span class="credits">%s</span><span class="entry-sep">&middot;</span><span class="login">%s</span></div>',
		do_shortcode( '[footer_copyright]' ),
		esc_html__( 'All Rights Reserved', 'rosenfield-collection' ),
		esc_html( get_bloginfo( 'name' ) ),
		do_shortcode( '[footer_loginout]' )
	);

	// Display the secondary menu.
	\genesis_do_subnav();

	\genesis_markup(
		[
			'close'   => '</div>',
			'context' => 'footer-credits',
		]
	);
}
