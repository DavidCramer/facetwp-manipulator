(function($){
    
    var fwpmanipBackdrop = null,
        fwpmanipModals   = {},
        activeModals    = [],
        activeSticky    = [],
        pageHTML,
        pageBody,
        mainWindow;

    var positionModals = function(){

        if( !activeModals.length && !activeSticky.length ){
            return;
        }


        var modalId  = ( activeModals.length ? activeModals[ ( activeModals.length - 1 ) ] : activeSticky[ ( activeSticky.length - 1 ) ] ),
            windowWidth  = mainWindow.width(),
            windowHeight = mainWindow.height(),
            //modalHeight  = fwpmanipModals[ modalId ].body.outerHeight(),
            modalHeight  = fwpmanipModals[ modalId ].config.height,
            modalOuterHeight  = modalHeight,
            modalWidth  = fwpmanipModals[ modalId ].config.width,
            top          = 0,
            flickerBD    = false,
            modalReduced = false;

        fwpmanipModals[ modalId ].body.css( {
            height      : ''
        } );


        if( fwpmanipBackdrop ){ pageHTML.addClass('has-fwpmanip-modal'); }




        // check modals for %
        if( typeof modalWidth === 'string' ){
            modalWidth = parseInt( modalWidth );
            modalWidth = windowWidth / 100 * parseInt( modalWidth );
        }
        if( typeof modalHeight === 'string' ){
            modalHeight = parseInt( modalHeight );
            modalHeight = windowHeight / 100 * parseInt( modalHeight );
        }       
        // top
        top = (windowHeight - modalHeight ) / 2.2;

        if( top < 0 ){
            top = 0;
        }

        if( modalHeight + ( fwpmanipModals[ modalId ].config.padding * 2 ) > windowHeight && fwpmanipBackdrop ){
            modalHeight = windowHeight;// - ( fwpmanipModals[ modalId ].config.padding * 2 );
            modalOuterHeight = '100%';
            if( fwpmanipBackdrop ){
                fwpmanipBackdrop.css( {
                    //paddingTop: fwpmanipModals[ modalId ].config.padding,
                    //paddingBottom: fwpmanipModals[ modalId ].config.padding,
                });
            }
            modalReduced = true;
        }
        if( modalWidth + ( fwpmanipModals[ modalId ].config.padding * 2 ) >= windowWidth ){
            modalWidth = '100%';
            if( fwpmanipBackdrop ){
                fwpmanipBackdrop.css( {
                    //paddingLeft: fwpmanipModals[ modalId ].config.padding,
                    //paddingRight: fwpmanipModals[ modalId ].config.padding,
                });
            }
            modalReduced = true;
        }

        if( true === modalReduced ){
            if( windowWidth <= 700 && windowWidth > 600 ){
                if( fwpmanipBackdrop ){
                    modalHeight = windowHeight - ( fwpmanipModals[ modalId ].config.padding * 2 );
                }
                modalWidth = windowWidth;
                modalOuterHeight = modalHeight - ( fwpmanipModals[ modalId ].config.padding * 2 );
                modalWidth = '100%';
                top = 0;
                if( fwpmanipBackdrop ){ fwpmanipBackdrop.css( { padding : fwpmanipModals[ modalId ].config.padding } ); }
            }else if( windowWidth <= 600 ){
                if( fwpmanipBackdrop ){ modalHeight = windowHeight; }
                modalWidth = windowWidth;
                modalOuterHeight = '100%';
                top = 0;
                if( fwpmanipBackdrop ){ fwpmanipBackdrop.css( { padding : 0 } ); }
            }
        }
        // set backdrop
        if( fwpmanipBackdrop && fwpmanipBackdrop.is(':hidden') ){
            flickerBD = true;
            fwpmanipBackdrop.show();
        }

        // title?
        if( fwpmanipModals[ modalId ].header ){
            if( fwpmanipBackdrop ){ fwpmanipBackdrop.show(); }
            modalHeight -= fwpmanipModals[ modalId ].header.outerHeight();
            fwpmanipModals[ modalId ].closer.css( {
                padding     : ( fwpmanipModals[ modalId ].header.outerHeight() / 2 ) - 3.8
            } );
            fwpmanipModals[ modalId ].title.css({ paddingRight: fwpmanipModals[ modalId ].closer.outerWidth() } );
        }
        // footer?
        if( fwpmanipModals[ modalId ].footer ){
            if( fwpmanipBackdrop ){ fwpmanipBackdrop.show(); }
            modalHeight -= fwpmanipModals[ modalId ].footer.outerHeight();
        }

        if( fwpmanipBackdrop && flickerBD === true ){
            fwpmanipBackdrop.hide();
            flickerBD = false;
        }

        // set final height
        if( modalHeight != modalOuterHeight ){
            fwpmanipModals[ modalId ].body.css( {
                height      : modalHeight
            } );
        }
        fwpmanipModals[ modalId ].modal.css( {
            width       : modalWidth    
        } );
        if( fwpmanipModals[ modalId ].config.sticky && fwpmanipModals[ modalId ].config.minimized ){
            var toggle = {},
                minimizedPosition = fwpmanipModals[ modalId ].title.outerHeight() - fwpmanipModals[ modalId ].modal.outerHeight();
            if( fwpmanipModals[ modalId ].config.sticky.indexOf( 'bottom' ) > -1 ){
                toggle['margin-bottom'] = minimizedPosition;
            }else if( fwpmanipModals[ modalId ].config.sticky.indexOf( 'top' ) > -1 ){
                toggle['margin-top'] = minimizedPosition;
            }
            fwpmanipModals[ modalId ].modal.css( toggle );
            if( fwpmanipModals[ modalId ].config.sticky.length >= 3 ){
                pageBody.css( "margin-" + fwpmanipModals[ modalId ].config.sticky[0] , fwpmanipModals[ modalId ].title.outerHeight() );
                if( modalReduced ){
                    fwpmanipModals[ modalId ].modal.css( fwpmanipModals[ modalId ].config.sticky[1] , 0 );
                }else{
                    fwpmanipModals[ modalId ].modal.css( fwpmanipModals[ modalId ].config.sticky[1] , parseFloat( fwpmanipModals[ modalId ].config.sticky[2] ) );
                }
            }
        }
        if( fwpmanipBackdrop ){
            fwpmanipBackdrop.fadeIn( fwpmanipModals[ modalId ].config.speed );

            fwpmanipModals[ modalId ].modal.css( {
                top   : 'calc( 50% - ' + ( fwpmanipModals[ modalId ].modal.outerHeight() / 2 ) + 'px)',
                left   : 'calc( 50% - ' + ( fwpmanipModals[ modalId ].modal.outerWidth() / 2 ) + 'px)',
            } );
            setTimeout( function(){
                fwpmanipModals[ modalId ].modal.addClass( 'fwpmanip-animate' );
            }, 10);

        }

        return fwpmanipModals;
    }

    var closeModal = function( lastModal ){


        if( activeModals.length ){
            if( !lastModal ) {
                lastModal = activeModals.pop();
            }else{
                activeModals.splice( lastModal.indexOf( activeModals ), 1 );
            }

            if( fwpmanipModals[ lastModal ].modal.hasClass( 'fwpmanip-animate' ) && !activeModals.length ){
                fwpmanipModals[ lastModal ].modal.removeClass( 'fwpmanip-animate' );
                setTimeout( function(){
                    var current_modal = fwpmanipModals[ lastModal ];
                    current_modal.modal.fadeOut( 200, function(){
                        current_modal.modal.remove();
                    } )

                    if( fwpmanipModals[ lastModal ].flush ){
                        delete fwpmanipModals[ lastModal ];
                    }
                }, 500 );
            }else{
                if( fwpmanipBackdrop ){
                    var current_modal = fwpmanipModals[ lastModal ];
                    current_modal.modal.fadeOut( 200, function(){
                        current_modal.modal.remove();
                    } )

                    if( fwpmanipModals[ lastModal ].flush ){
                        delete fwpmanipModals[ lastModal ];
                    }

                }
            }

        }

        if( !activeModals.length ){
            if( fwpmanipBackdrop ){
                fwpmanipBackdrop.fadeOut( 250 , function(){
                    $( this ).remove();
                    fwpmanipBackdrop = null;
                });
            }
            pageHTML.removeClass('has-fwpmanip-modal');
            $(window).trigger( 'modals.closed' );
        }else{
            fwpmanipModals[ activeModals[ ( activeModals.length - 1 ) ] ].modal.find('.fwpmanip-modal-blocker').remove();
            fwpmanipModals[ activeModals[ ( activeModals.length - 1 ) ] ].modal.animate( {opacity : 1 }, 100 );
        }
        $(window).trigger( 'modal.close' );
    }
    $.fwpmanipModal = function(opts,trigger){

        pageHTML        = $('html');
        pageBody        = $('body');
        mainWindow      = $(window);

        var defaults    = $.extend(true, {
            element             :   'form',
            height              :   550,
            width               :   620,
            padding             :   12,
            speed               :   250,
            content             :   ''
        }, opts );
        defaults.trigger = trigger;
        if( !fwpmanipBackdrop && ! defaults.sticky ){
            fwpmanipBackdrop = $('<div>', {"class" : "fwpmanip-backdrop"});

            pageBody.append( fwpmanipBackdrop );
            fwpmanipBackdrop.hide();
        }

        // create modal element
        var modalElement = defaults.element,
            modalId = defaults.modal;


        if( typeof fwpmanipModals[ modalId ] === 'undefined' ){
            if( defaults.sticky ){
                defaults.sticky = defaults.sticky.split(' ');
                if( defaults.sticky.length < 2 ){
                    defaults.sticky = null;
                }
                activeSticky.push( modalId );
            }
            fwpmanipModals[ modalId ] = {
                config  :   defaults
            };

            fwpmanipModals[ modalId ].body = $('<div>', {"class" : "fwpmanip-modal-body",id: modalId + '_fwpmanipModalBody'});
            fwpmanipModals[modalId].content = $('<div>', {"class": "fwpmanip-modal-content", id: modalId + '_fwpmanipModalContent'});


        }else{
            fwpmanipModals[ modalId ].config = defaults;
        }



        var options = {
            id                  : modalId + '_fwpmanipModal',
            tabIndex            : -1,
            "ariaLabelled-by"   : modalId + '_fwpmanipModalLable',
            "method"            : 'post',
            "enctype"           : 'multipart/form-data',
            "class"             : "fwpmanip-modal-wrap " + ( defaults.sticky ? ' fwpmanip-sticky-modal ' + defaults.sticky[0] + '-' + defaults.sticky[1] : '' )
        };

        if( opts.config ){
            $.extend( options, opts.config );
        }
        //add in wrapper
        fwpmanipModals[ modalId ].modal = $('<' + modalElement + '>', options );


        // push active
        if( !defaults.sticky ){ activeModals.push( modalId ); }

        // add animate      
        if( defaults.animate && fwpmanipBackdrop ){
            var animate         = defaults.animate.split( ' ' ),
                animateSpeed    = defaults.speed + 'ms',
                animateEase     = ( defaults.animateEase ? defaults.animateEase : 'ease' );

            if( animate.length === 1){
                animate[1] = 0;
            }

            fwpmanipModals[ modalId ].modal.css( {
                transform               : 'translate(' + animate[0] + ', ' + animate[1] + ')',
                '-web-kit-transition'   : 'transform ' + animateSpeed + ' ' + animateEase,
                '-moz-transition'       : 'transform ' + animateSpeed + ' ' + animateEase,
                transition              : 'transform ' + animateSpeed + ' ' + animateEase
            } );

        }




        // padd content
        fwpmanipModals[ modalId ].content.css( {
            //padding : defaults.padding
        } );
        fwpmanipModals[ modalId ].body.append( fwpmanipModals[ modalId ].content ).appendTo( fwpmanipModals[ modalId ].modal );
        if( fwpmanipBackdrop ){ fwpmanipBackdrop.append( fwpmanipModals[ modalId ].modal ); }else{
            fwpmanipModals[ modalId ].modal . appendTo( $( 'body' ) );
        }


        if( defaults.footer ){
            if( !fwpmanipModals[ modalId ].footer ) {
                fwpmanipModals[modalId].footer = $('<div>', {"class": "fwpmanip-modal-footer", id: modalId + '_fwpmanipModalFooter'});
                fwpmanipModals[ modalId ].footer.css({ padding: defaults.padding });

                // function?
                if( typeof window[defaults.footer] === 'function' ){
                    fwpmanipModals[ modalId ].footer.append( window[defaults.footer]( defaults, fwpmanipModals[ modalId ] ) );
                }else if( typeof defaults.footer === 'string' ){
                    // is jquery selector?
                    try {
                        var footerElement = $( defaults.footer );
                        fwpmanipModals[ modalId ].footer.html( footerElement.html() );
                    } catch (err) {
                        fwpmanipModals[ modalId ].footer.html( defaults.footer );
                    }
                }
            }

            fwpmanipModals[ modalId ].footer.appendTo( fwpmanipModals[ modalId ].modal );
        }

        if( defaults.title ){
            var headerAppend = 'prependTo';
            fwpmanipModals[ modalId ].header = $('<div>', {"class" : "fwpmanip-modal-title", id : modalId + '_fwpmanipModalTitle'});
            fwpmanipModals[ modalId ].closer = $('<a>', { "href" : "#close", "class":"fwpmanip-modal-closer", "data-dismiss":"modal", "aria-hidden":"true",id: modalId + '_fwpmanipModalCloser'}).html('&times;');
            fwpmanipModals[ modalId ].title = $('<h3>', {"class" : "modal-label", id : modalId + '_fwpmanipModalLable'});

            fwpmanipModals[ modalId ].title.html( defaults.title ).appendTo( fwpmanipModals[ modalId ].header );
            fwpmanipModals[ modalId ].title.css({ padding: defaults.padding });
            fwpmanipModals[ modalId ].title.append( fwpmanipModals[ modalId ].closer );
            if( fwpmanipModals[ modalId ].config.sticky ){
                if( fwpmanipModals[ modalId ].config.minimized && true !== fwpmanipModals[ modalId ].config.minimized ){
                    setTimeout( function(){
                        fwpmanipModals[ modalId ].title.trigger('click');
                    }, parseInt( fwpmanipModals[ modalId ].config.minimized ) );
                    fwpmanipModals[ modalId ].config.minimized = false;
                }
                fwpmanipModals[ modalId ].closer.hide();
                fwpmanipModals[ modalId ].title.addClass( 'fwpmanip-modal-closer' ).data('modal', modalId).appendTo( fwpmanipModals[ modalId ].header );
                if( fwpmanipModals[ modalId ].config.sticky.indexOf( 'top' ) > -1 ){
                    headerAppend = 'appendTo';
                }
            }else{
                fwpmanipModals[ modalId ].closer.data('modal', modalId).appendTo( fwpmanipModals[ modalId ].header );
            }
            fwpmanipModals[ modalId ].header[headerAppend]( fwpmanipModals[ modalId ].modal );
        }
        // hide modal
        //fwpmanipModals[ modalId ].modal.outerHeight( defaults.height );
        fwpmanipModals[ modalId ].modal.outerWidth( defaults.width );

        if( defaults.content && !fwpmanipModals[ modalId ].content.children().length ){
            // function?
            if( typeof defaults.content === 'function' ){
                fwpmanipModals[ modalId ].content.append( defaults.content( defaults, fwpmanipModals[ modalId ] ) );
            }else if( typeof defaults.content === 'string' ){

                if( typeof window[ defaults.content ] === 'function' ){
                    fwpmanipModals[modalId].content.html( window[ defaults.content ]( defaults ) );
                }else {

                    // is jquery selector?
                    try {
                        var contentElement = $(defaults.content);
                        if (contentElement.length) {
                            fwpmanipModals[modalId].content.append(contentElement.html());
                            contentElement.show();
                        } else {
                            throw new Error;
                        }
                        fwpmanipModals[modalId].modal.removeClass('processing');
                    } catch (err) {
                        fwpmanipModals[modalId].footer.hide();
                        setTimeout(function () {
                            fwpmanipModals[modalId].modal.addClass('processing');
                            $.post(defaults.content, trigger.data(), function (res) {
                                fwpmanipModals[modalId].content.html(res);
                                fwpmanipModals[modalId].modal.removeClass('processing');
                                fwpmanipModals[modalId].footer.show();
                            });
                        }, 250);
                    }
                }
            }
        }else{
            fwpmanipModals[ modalId ].modal.removeClass('processing');
        }

        // others in place?
        if( activeModals.length > 1 ){
            if( activeModals[ ( activeModals.length - 2 ) ] !== modalId ){
                fwpmanipModals[ activeModals[ ( activeModals.length - 2 ) ] ].modal.prepend( '<div class="fwpmanip-modal-blocker"></div>' ).animate( {opacity : 1 }, 100 );
                fwpmanipModals[ modalId ].modal.hide().fadeIn( 200 );
                //fwpmanipModals[ activeModals[ ( activeModals.length - 2 ) ] ].modal.fadeOut( 200, function(){
                  //  fwpmanipModals[ modalId ].modal.fadeIn( 2200 );
                //} );
            }
        }

        // set position;
        positionModals();
        // return main object
        $( window ).trigger('modal.open');

        if( opts.master && activeModals ){
            delete fwpmanipModals[ activeModals.shift() ];
        }


        fwpmanipModals[ modalId ].positionModals = positionModals;
        fwpmanipModals[ modalId ].closeModal = function(){
            closeModal( modalId );
        }
        var submit = fwpmanipModals[ modalId ].modal.find('button[type="submit"]');

        if( !submit.length ){
            fwpmanipModals[ modalId ].modal.find('input').on('change', function(){
                fwpmanipModals[ modalId ].modal.submit();
            })
        }else{
            fwpmanipModals[ modalId ].flush = true;
        }

        var notice = $('<div class="notice error"></div>'),
            message = $('<p></p>'),
            dismiss = $( '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>' );

        message.appendTo( notice );
        dismiss.appendTo( notice );

        dismiss.on('click', function(){
            notice.animate( { height: 0 }, 100, function(){
                notice.css('height', '');
                message.html();
                notice.detach();
            });
        });

        fwpmanipModals[ modalId ].modal.attr('data-load-element', '_parent' ).baldrick({
            request : window.location.href,
            before : function( el, e ){
                $(document).trigger('fwpmanip.itemsubmit');
                submit = fwpmanipModals[ modalId ].modal.find('button[type="submit"]');
                if( submit.length ){
                    submit.prop( 'disabled', true );
                    fwpmanipModals[ modalId ].modal.addClass('processing');
                }
                notice.detach();
            },
            callback : function( obj ){

                obj.params.trigger.find( '[type="submit"],button' ).prop( 'disabled', false );
                fwpmanipModals[ modalId ].modal.removeClass('processing');
                fwpmanipModals[ modalId ].data = obj.rawData.data;
                if ( typeof obj.rawData === 'object' ) {
                    if( obj.rawData.success ) {
                        if( typeof obj.rawData.data === 'string' ){
                            obj.rawData = obj.rawData.data;
                        }else if( typeof obj.rawData.data === 'object' ){
                            if( obj.rawData.data.redirect ){
                                window.location = obj.rawData.data.redirect;
                            }
                            fwpmanipModals[ modalId ].modal.trigger('modal.complete');
                        }else if( typeof obj.rawData.data === 'boolean' && obj.rawData.data === true ){

                            if( submit.length ) {
                                fwpmanipModals[ modalId ].flush = false;
                            }
                        }
                        closeModal();
                    }else{
                        obj.params.target = false;
                        if( typeof obj.rawData.data === 'string' ){
                            message.html( obj.rawData.data );
                            notice.appendTo( fwpmanipModals[ modalId ].body );
                            var height = notice.height();
                            notice.height(0).animate( { height: height }, 100 );
                        }else{
                            closeModal();
                        }
                    }
                }else{
                    closeModal();
                }
            },
            complete : function () {
                $(document).trigger('fwpmanip.init');
            }
        });
        return fwpmanipModals[ modalId ];
    }

    $.fn.fwpmanipModal = function( opts ){

        if( !opts ){ opts = {}; }
        opts = $.extend( {}, this.data(), opts );
        return $.fwpmanipModal( opts, this );
    }

    // setup resize positioning and keypresses
    if ( window.addEventListener ) {
        window.addEventListener( "resize", positionModals, false );
        window.addEventListener( "keypress", function(e){
            if( e.keyCode === 27 && fwpmanipBackdrop !== null ){
                fwpmanipBackdrop.trigger('click');
            }
        }, false );

    } else if ( window.attachEvent ) {
        window.attachEvent( "onresize", positionModals );
    } else {
        window["onresize"] = positionModals;
    }

    $(document).on('click', '[data-modal]:not(.fwpmanip-modal-closer)', function( e ){
        e.preventDefault();
        return $(this).fwpmanipModal();
    });

    $(document).on( 'click', '.fwpmanip-modal-closer', function( e ) {
        e.preventDefault();
        $(window).trigger('close.modal');
    })

    $(window).on( 'close.modal', function( e ) {
        closeModal();
    })
    $(window).on( 'modal.init', function( e ) {
        $('[data-modal][data-autoload]').each( function(){
            $( this ).fwpmanipModal();
        });
    })
    $(window).on( 'modal.open', function( e ) {
        $(document).trigger('fwpmanip.init');
    });
    $(window).load( function(){
        $(window).trigger('modal.init');
    });



})(jQuery);
