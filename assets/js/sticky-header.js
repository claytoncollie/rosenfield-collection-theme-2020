var scrollPosition = window.scrollY,
    siteHeader = document.getElementsByClassName('site-header')[0],
    postMeta = document.getElementsByClassName('post-meta')[0],
    adminOnly = document.getElementsByClassName('admin-only')[0],
    siteHeaderHeight = siteHeader.offsetHeight;

window.addEventListener('scroll', function () {

    scrollPosition = window.scrollY;

    if (scrollPosition >= siteHeaderHeight) {
        postMeta.classList.add('sticky');
        adminOnly.classList.add('sticky');
    } else {
        postMeta.classList.remove('sticky');
        adminOnly.classList.remove('sticky');
    }

});
