/**
 * This script adds the Slick Slider effects to the theme.
 *
 * @package RosenfieldCollection\Theme
 * @author CLayton Collie
 * @license GPL-2.0-or-later
 */
( function( $ ) {

    $( '.slider-gallery-images' ).slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        dots: false,
        asNavFor: '.slider-thumbnails-images'
    });

    $( '.slider-thumbnails-images' ).slick({
        slidesToShow: 100,
        slidesToScroll: 1,
        dots: false,
        arrows: false,
        focusOnSelect: true,
        asNavFor: '.slider-gallery-images'
    });

    // Remove active class from all thumbnail slides
    $( '.slider-thumbnails-images .slick-slide' ).removeClass( 'slick-active' );

    // Set active class to first thumbnail slides
    $( '.slider-thumbnails-images .slick-slide' ).eq( 0 ).addClass( 'slick-active' );

    // On before slide change match active thumbnail to current slide
    $( '.slider-gallery-images' ).on( 'beforeChange', function( event, slick, currentSlide, nextSlide ) {
        var mySlideNumber = nextSlide;
        $( '.slider-thumbnails-images .slick-slide' ).removeClass( 'slick-active' );
        $( '.slider-thumbnails-images .slick-slide' ).eq( mySlideNumber ).addClass( 'slick-active' );
   });

}( jQuery ) );
