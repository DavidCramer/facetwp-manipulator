(function( $ ) {

    $( document ).on( 'click', '.fwpmanip-tab-trigger', function( e ){
        e.preventDefault();
        var clicked  = $( this ),
            target   = $( clicked.attr('href') ),
            wrapper  = clicked.closest('.fwpmanip-panel-inside'),
            tabs     = wrapper.find('> .fwpmanip-panel-tabs').children(),
            sections = wrapper.find('> .fwpmanip-sections').children();

        tabs.attr('aria-selected', false );
        clicked.parent().attr('aria-selected', true );

        sections.attr('aria-hidden', true );
        target.attr('aria-hidden', false );

    });

})( jQuery );