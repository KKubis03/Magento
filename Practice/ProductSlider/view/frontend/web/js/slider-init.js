define(['jquery', '_ProductSlider/js/slick.min'], function ($) {
    'use strict';

    return function (config, element) {
        var $el = $(element);
        if (!$el || !$el.length || typeof $el.slick !== 'function') {
            return;
        }

        $el.slick({
            slidesToShow: config && config.slidesToShow ? config.slidesToShow : 3,
            slidesToScroll: 1,
            autoplay: true,
            arrows: true
        });
    };
});
