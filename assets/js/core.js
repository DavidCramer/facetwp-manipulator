var FWPMANIP = {};

(function() {

    jQuery( document ).ready( function( $ ){

       $( document ).on('fwpmanip.init', function() {
           $('[data-default]').each(function () {
                var field = $(this);
                field.val(field.data('default'));
            });
        });

       $( window ).load( function() {
            // main init
            $(document).trigger('fwpmanip.init');
        });
    });


})( window );