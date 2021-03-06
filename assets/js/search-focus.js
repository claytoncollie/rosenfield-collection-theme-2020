/**
 * Autofocus the search input on page load.
 *
 * @package RosenfieldCollection\Theme2020
 * @author CLayton Collie
 * @license GPL-2.0-or-later
 */
jQuery( function( $ ) {
	$( document ).on( 'load', function() {
		$( '.ais-SearchBox-input' ).trigger( 'focus' );
	});
});
