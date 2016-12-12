(function() {

    jQuery( document ).ready( function( $ ) {
        $(document).on('fwpmanip.init', function( e ) {
            var simplemde = new SimpleMDE({ element: $(".markdown")[0] });
        });
    });
});