(function($){

    jQuery( document ).ready( function(){

        function reseset_attributes(el, name, index, id_parts, type) {
            $(el).find("[" + name + "]").each(function () {
                $(this)[type]( name, function (idx, attr) {
                    var parts = attr.split('-'),
                        old_attr = parts.join('-');
                    parts[ id_parts.length - 1 ] = index;
                    attr = parts.join('-');
                    if( name == 'id') {
                        var classnames = $('.' + old_attr );
                        classnames.removeClass( old_attr ).addClass( attr.replace( /\d+/g, 0 ) );
                    }
                    return attr;
                });
            });
        }

        function reset_repeatable_index( id ){
            var wrapper = $('[data-fwpmanip-template="'+ id + '"'),
                id_parts = id.split('-');

            wrapper.children().each( function( index, el ){
                id_parts[id_parts.length - 1 ] = index;
                var new_id = id_parts.join('-');
                reseset_attributes(el, 'name', index, id_parts, 'attr');
                reseset_attributes(el, 'data-fwpmanip-template', index, id_parts, 'attr');
                reseset_attributes(el, 'id', index, id_parts, 'prop');
                reseset_attributes(el, 'for', index, id_parts, 'attr');
                //reseset_attributes(el, 'data-for', index, id_parts, 'attr');
            })
        }

        $( document ).on('click', '[data-fwpmanip-repeat]', function( e ){
            var clicked = $( this ),
                id = clicked.data('fwpmanipRepeat'),
                template = '';
            template = $( '#' + id + '-tmpl' ).html();
            template = $( template.replace(/{{_inst_}}/g, 0 ) ).hide();
            clicked.parent().prev().append( template );
            template.slideDown(100);
            //reset_repeatable_index( id );


            $( document ).trigger('fwpmanip.init');
        });

        $( document ).on('click', '.fwpmanip-remover', function( e ){
            var clicked = $( this ),
                template = clicked.closest('[data-fwpmanip-template]'),
                id = template.data('fwpmanipTemplate');
                $( this ).parent().slideUp( 100, function(){
                    $(this).remove();
                });

            $( document ).trigger('fwpmanip.init');
            //reset_repeatable_index( id );

        })

        $( document ).on('fwpmanip.init', function(){
            var wrappers = $( '[data-fwpmanip-template]');
            wrappers.each( function(){
                var id = $( this ).attr('data-fwpmanip-template');
                reset_repeatable_index( id );

            })
        });

        $('[data-fwpmanip-repeat]').each( function(){
            var id  = $( this ).attr( 'data-fwpmanip-repeat' ),
                elesclass = $('.' + id );

            elesclass.removeClass( id );

            id = id.replace( /\d+/g, 0 );
            elesclass.addClass( id );
            $( this ).attr( 'data-fwpmanip-repeat', id );

        });

        $( document ).trigger('fwpmanip.init');

    })


})(jQuery);
