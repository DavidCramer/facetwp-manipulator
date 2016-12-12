;(function ($) {

    $(document).on('change', '.hook-selector', function () {
        var input = $(this),
            hook = input.val(),
            example = $('[data-hook="' + hook + '"]').text().trim(),
            editor = $('.codemirror-editor').data('cm'),
            button_link = $('.fwpmanip-control-select .fwpmanip-control-description');
            code_loader = $('.facetwp-sample-code');

        if( hook.length ){
            button_link.show();
        }else{
            button_link.hide();
        }
        if (!example.length) {
            code_loader.hide();
        } else {
            code_loader.show();
        }

    });
    $(document).on('click', '.facetwp-sample-code', function () {
        var editor = $('.codemirror-editor').data('cm'),
            hook = $('.hook-selector'),
            current = editor.getValue().trim(),
            sample = $('[data-hook="' + hook.val() + '"]').text().trim();

        if( !current.length || confirm( hook.data('confirm') ) ) {
            editor.setValue(sample);
        }

    });
    $(document).on('fwpmanip.init', function () {
        var hook = $('.hook-selector'),
            code_loader = $('.facetwp-sample-code'),
            button_link = $('.fwpmanip-control-select .fwpmanip-control-description');
        if ( hook.length ) {
            if ( !hook.val().length) {
                button_link.hide();
                code_loader.hide();
            } else {
                button_link.show();
                code_loader.show();
            }
        }
    });
    $(document).on('click', '.fwpmanip-control-select .fwpmanip-control-description', function(){
        var hook = $('.hook-selector').val();

        window.open('https://facetwp.com/documentation/' + hook + '/', '_blank');

    });


})(jQuery);
