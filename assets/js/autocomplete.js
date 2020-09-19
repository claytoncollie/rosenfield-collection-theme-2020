jQuery( window ).load( function() {
    jQuery( '.aa-dropdown-menu' ).each( function() {
        jQuery( '.aa-dropdown-menu' ).attr(
            'aria-label',
            'Autocomplete search results'
        );
    });
});

jQuery( window ).load( function() {
    jQuery( 'input.aa-input' ).each( function() {
        var label = jQuery( this ).attr( 'aria-owns' );
        jQuery( this ).attr( 'aria-controls', label );
    });
});
