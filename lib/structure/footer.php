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

namespace RosenfieldCollection\Theme2020\Structure;

// Remove default footer.
\remove_action( 'genesis_footer', 'genesis_do_footer' );

\add_action( 'genesis_footer', __NAMESPACE__ . '\do_footer_credits' );
/**
 * Output custom footer credits.
 *
 * @since 1.0.0
 *
 * @return void
 */
function do_footer_credits() {
	\genesis_markup(
		[
			'open'    => '<section class="footer-credits"><div class="wrap">',
			'context' => 'footer-credits',
		]
	);

	// Display the copyright info.
	printf(
		'<div><span class="copyright">%s %s</span> &middot; <span class="credits-title">%s</span> &middot; <span class="login-link">%s</span></div>',
		do_shortcode( '[footer_copyright]' ),
		esc_html__( 'All Rights Reserved', 'rc' ),
		esc_html( get_bloginfo( 'name' ) ),
		do_shortcode( '[footer_loginout]' )
	);

	// Display the secondary menu.
	\genesis_do_subnav();

	\genesis_markup(
		[
			'close'   => '</div></section>',
			'context' => 'footer-credits',
		]
	);
}
