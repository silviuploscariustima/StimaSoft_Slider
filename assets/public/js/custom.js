jQuery(function($) {
    if ($('.js-stimasoft-slider-content').length > 0) {
        $.each($('.js-stimasoft-slider-content'), function(index, value) {
            var sliderId = $(this).attr('data-slider');
            var sliderOptions = customOptions[sliderId];
            if (sliderOptions.status && sliderOptions.status != '0') {
                var sliderData = {};
                if (sliderOptions.margin != '') {
                    sliderData['spaceBetween'] = parseInt(sliderOptions.margin);
                }
                sliderData['slidesPerView'] = 1;
                if (sliderOptions.perview != '' && sliderOptions.perview != '0') {
                    sliderData['breakpoints'] = {
                        992: {
                            slidesPerView: parseInt(sliderOptions.perview),
                            spaceBetweenSlides: 0
                        },
                    }
                }
                if (sliderOptions.effect) {
                    sliderData['effect'] = sliderOptions.effect;
                }
                if (sliderOptions.loop && sliderOptions.loop != '0') {
                    sliderData['loop'] = true;
                }
                if (sliderOptions.autoplay && sliderOptions.autoplay != '0') {
                    if (sliderOptions.delay && sliderOptions.delay != '') {
                        sliderData['autoplay'] = {
                            delay: parseInt(sliderOptions.delay),
                            disableOnInteraction: false,
                        };
                    } else {
                        sliderData['autoplay'] = {
                            delay: 2500,
                            disableOnInteraction: false,
                        };

                    }
                }
                if (sliderOptions.arrows) {
                    sliderData['navigation'] = {
                        nextEl: '.js-stimasoft-slide-next[data-slider="' + sliderId + '"]',
                        prevEl: '.js-stimasoft-slide-prev[data-slider="' + sliderId + '"]',
                    };
                }
                if (sliderOptions.navigation != 'hidden') {
                    if (sliderOptions.navigation == 'dots') {
                        sliderData['pagination'] = {
                            el: '.js-stimasoft-slider-pagination[data-slider="' + sliderId + '"]',
                            clickable: true,
                        };
                    }
                }
                new Swiper('.js-stimasoft-slider-content[data-slider="' + sliderId + '"]', sliderData);
            }
        });
    }

});