(function( $ ) {

    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $(document).on('fwpmanip.init', function () {

            $( '.codemirror-editor' ).each( function(){
                var input = $( this );
                if( input.data('cm') ){ return; }

                var editor = CodeMirror.fromTextArea( this, {
                    lineNumbers: true,
                    matchBrackets: true,
                    mode: "text/x-php",
                    indentUnit: 4,
                    indentWithTabs: true
                });
                input.data('cm', editor);
            });

        });
    });

})( jQuery );
