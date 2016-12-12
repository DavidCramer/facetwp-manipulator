
var fwpmanip_edit_state = false;

(function($){

    $( document ).on( 'fwpmanip.init', init_fwpmanip_ajax );

    function init_fwpmanip_ajax(){
        var spinner;
        $('.fwpmanip-ajax').baldrick({
            'request': window.location.href,
            before : function( el, ev ){
                if( spinner ){
                    spinner.remove();
                }
                spinner = $( '<span class="fwpmanip-ajax spinner"></span>' );
                if( ev.originalEvent && ev.originalEvent.explicitOriginalTarget ){
                    //$( ev.originalEvent.explicitOriginalTarget ).prop('disabled', 'disabled' ).addClass('disabled');
                    spinner.addClass('inline');
                }
                $(el).find('.fwpmanip-title').append( spinner );
            },
            callback : function( obj, ev ){

                if( ev && ev.originalEvent && ev.originalEvent.explicitOriginalTarget ) {
                    spinner.removeClass( 'spinner' ).addClass('dashicons dashicons-yes');
                    setTimeout( function(){
                        spinner.fadeOut( 1000, function(){
                            spinner.remove();
                        });
                    }, 1000 );

                    $(ev.originalEvent.explicitOriginalTarget).prop('disabled', false).removeClass('disabled');
                }else{
                    spinner.remove();
                    obj.params.trigger.find('.ajax-triggered').removeClass('ajax-triggered');
                }
                fwpmanip_edit_state = false;
            }
        });
    };

    jQuery( document ).ready( function() {



        $('form.fwpmanip-ajax').each( function(){
            var form = $( this );
            if( form.data('autosave') ){
                $( document ).on('fwpmanip.save', function(){
                    form.trigger( 'submit' );
                })
                form.on('change', '[name]', function( e ){
                    $(this).addClass('ajax-triggered');
                    $( document ).trigger('fwpmanip.save');
                })
            }else{
                form.on( 'change', '[name]', function(){
                    fwpmanip_edit_state = true;
                });
            }

        });
    })

    // check for a button




    window.onbeforeunload = function(e) {

        if( false === fwpmanip_edit_state ){ return; }

        var dialogText = 'confirm';
        e.returnValue = dialogText;
        return dialogText;
    };

})(jQuery);
