var scrollPosition = window.scrollY,
    siteHeader = document.getElementsByClassName('site-header')[0],
    postMeta = document.getElementsByClassName('post-meta')[0],
    adminOnly = document.getElementsByClassName('admin-only')[0],
    siteHeaderHeight = siteHeader.offsetHeight;

window.addEventListener('scroll', function () {

    scrollPosition = window.scrollY;

    if (scrollPosition >= siteHeaderHeight) {
        if ( typeof postMeta !== 'undefined') {
            postMeta.classList.add('sticky');
        }
        if ( typeof adminOnly !== 'undefined') {
            adminOnly.classList.add('sticky');
        }
    } else {
        if ( typeof postMeta !== 'undefined') {
            postMeta.classList.remove('sticky');
        }
        if ( typeof adminOnly !== 'undefined') {
            adminOnly.classList.remove('sticky');
        }
    }

});
