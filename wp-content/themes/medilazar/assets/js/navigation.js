'use strict';
(function ($) {
    var $trigger = $('.menu-toggle');
    var $mp_menu = $('#opal-canvas-menu');
    // Return early if menuToggle is missing.
    if (!$trigger.length) {
        return;
    }


    if ($mp_menu.length > 0) {
        $mp_menu.find('ul').wrap('<div class="mp-level"></div>');
        $mp_menu.find('li.menu-item-has-children > a').append('<i class="fa fa-chevron-right trigger"></i>');
        $('<a class="mp-back text-center" href="#"><i class="fa fa-arrow-left"></i></a>').insertBefore($mp_menu.find('ul.sub-menu'));
        $('<a class="mp-back mp-close text-right" href="#"><i class="fa fa-close"></i></a>').insertBefore($mp_menu.find('ul.menu-canvas-default'));
        $mp_menu.detach().insertBefore('#page');
        new mlPushMenu($mp_menu.get(0), $trigger.get(0), {
            type: 'cover'
        });

        let section_top = $('#wpadminbar').height();
        $mp_menu.css({
            top: section_top
        })
        $(window).resize(() => {
            let section_top = $('#wpadminbar').height();
            $mp_menu.css({
                top: section_top
            })
        })
    }


})(jQuery);