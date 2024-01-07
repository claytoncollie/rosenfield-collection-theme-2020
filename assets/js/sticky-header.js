let scrollPosition = window.scrollY;
const siteHeader = document.getElementsByClassName( 'site-header' )[ 0 ];
const postMeta = document.getElementsByClassName( 'post-meta' )[ 0 ];
const adminOnly = document.getElementsByClassName( 'admin-only' )[ 0 ];
const siteHeaderHeight = siteHeader.offsetHeight;

window.addEventListener( 'scroll', function () {
	scrollPosition = window.scrollY;

	if ( scrollPosition >= siteHeaderHeight ) {
		if ( 'undefined' !== typeof postMeta ) {
			postMeta.classList.add( 'sticky' );
		}
		if ( 'undefined' !== typeof adminOnly ) {
			adminOnly.classList.add( 'sticky' );
		}
	} else {
		if ( 'undefined' !== typeof postMeta ) {
			postMeta.classList.remove( 'sticky' );
		}
		if ( 'undefined' !== typeof adminOnly ) {
			adminOnly.classList.remove( 'sticky' );
		}
	}
} );
