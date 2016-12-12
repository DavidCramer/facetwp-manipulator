var fwpmanip_related_post_handler,
    fwpmanip_related_post_before;
( function( $ ){
    jQuery( function( $ ){


        fwpmanip_related_post_before = function( el, ev ){
            var search = $( el ),
                items = [],
                page = 1,
                wrap = search.closest('.fwpmanip-control-input').find('.fwpmanip-post-relation');

            if( ev.type === 'paginate' ){
                page = search.data('paginate');
            }
            wrap.find('.fwpmanip-post-relation-id' ).each( function(){
                items.push( this.value );
            });

            search.data({ selected : items, page : page });
        }

        fwpmanip_related_post_handler = function( obj ){
            var wrapper = obj.params.trigger.parent().find('.fwpmanip-post-relation-results');
            wrapper.html( obj.data.html );
        };


        $( document ).on('click', '.fwpmanip-add-relation', function( e ) {
            var clicked = $(this),
                panel = clicked.closest('.fwpmanip-control-input').find('.fwpmanip-post-relation-panel'),
                input = panel.find('.fwpmanip-ajax');

            panel.toggle();
            if( panel.is(':visible') ) {
                input.val('').trigger('input').focus();
            }else{
                input.parent().find('.fwpmanip-post-relation-results').html('');
            }


        });
        $( document ).on('click', '.fwpmanip-post-relation-page', function( e ){
            var clicked = $( this ),
                search = clicked.closest('.fwpmanip-post-relation-panel').find('.fwpmanip-ajax');

            search.data('paginate', clicked.data('page') ).trigger('paginate');

        });

        $( document ).on('click', '.fwpmanip-post-relation-add', function(){

            var clicked = $( this ),
                oitem = clicked.parent(),
                wrap = clicked.closest('.fwpmanip-control-input').find('.fwpmanip-post-relation'),
                limit = parseFloat( wrap.data('limit') ),
                items,
                panel = wrap.parent().find('.fwpmanip-post-relation-footer, .fwpmanip-post-relation-panel'),
                item;


            clicked.removeClass('fwpmanip-post-relation-add dashicons-plus').addClass('fwpmanip-post-relation-remover dashicons-no-alt');
            item = oitem.clone();
            item.appendTo( wrap ).hide();
            item.find('.fwpmanip-post-relation-id').prop( 'disabled', false );
            item.show();
            oitem.remove();


            if( wrap.parent().find( '.fwpmanip-post-relation-results > .fwpmanip-post-relation-item' ).length <= 0 ){
                wrap.parent().find( '.fwpmanip-ajax' ).trigger('input');
            }

            items = wrap.children().length;

            if( items >= limit && limit > 0 ){
                panel.hide();
            }else{
                panel.show();
            }

        });

        $( document ).on('click', '.fwpmanip-post-relation-remover', function(){

            var clicked = $( this ),
                item = clicked.parent(),
                wrap = clicked.closest('.fwpmanip-control-input').find('.fwpmanip-post-relation'),
                limit = parseFloat( wrap.data('limit') ),
                items,
                panel = wrap.parent().find('.fwpmanip-post-relation-footer, .fwpmanip-post-relation-panel');

            item.remove();

            items = wrap.children().length;

            if( items >= limit && limit > 0 ){
                panel.hide();
            }else{
                if( !panel.is(':visible') ){
                    panel.show();
                    panel.find('.fwpmanip-ajax').val('').trigger('input').focus();
                }

            }
        });

        $( document ).on('fwpmanip.init', function(){
            var relations = $( '.fwpmanip-post-relation' );
            relations.each( function(){
                var input = $( this ),
                    limit = input.data('limit'),
                    panel = input.parent().find('.fwpmanip-post-relation-footer'),
                    items;

                if( limit ){
                    limit = parseFloat( limit );
                    items = input.find('.fwpmanip-post-relation-item');

                    if( items.length >= limit && limit > 0 ){
                        panel.hide();
                    }else{
                        panel.show();
                    }
                }
            });
        });

    });
})( jQuery )