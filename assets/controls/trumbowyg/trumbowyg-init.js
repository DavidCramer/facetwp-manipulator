;(function ($) {
    jQuery(document).ready(function ($) {
        $(document).on('fwpmanip.init', function () {

            var editors = $("textarea.trumbowyg");
            editors.each(function () {
                $(this).trumbowyg({
                    resetCss: true,
                    removeformatPasted: true,
                    autogrow: true
                });
            });

        });
    });
})(jQuery);