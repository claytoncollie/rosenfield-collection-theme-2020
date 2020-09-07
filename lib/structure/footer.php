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
		array(
			'open'    => '<section class="footer-credits"><div class="wrap">',
			'context' => 'footer-credits',
		)
	);

	// Display the copyright info.
	printf(
		'<div id="rosenfield-collection-footer-credits" aria-label="Footer Credits"><span class="copyright">%s %s</span><span class="entry-sep">&middot;</span><span class="credits">%s</span><span class="entry-sep">&middot;</span><span class="login">%s</span></div>',
		do_shortcode( '[footer_copyright]' ),
		esc_html__( 'All Rights Reserved', 'rosenfield-collection-2020' ),
		esc_html( get_bloginfo( 'name' ) ),
		do_shortcode( '[footer_loginout]' )
	);

	// Display the secondary menu.
	\genesis_do_subnav();

	\genesis_markup(
		array(
			'close'   => '</div></section>',
			'context' => 'footer-credits',
		)
	);
}
