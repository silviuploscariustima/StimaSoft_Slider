jQuery(function($) {

    function StimaSoft_Loader(show = true) {
        var loader = `<div class="ss-loader"><i class="fas fa-circle-notch fa-spin"></i></div>`;
        if (show) {
            $('.js-ss-slider').append(loader);
        } else {
            $('.js-ss-loader').remove();
        }
    }

    function StimaSoft_SlideTemplate(index) {
        var html = `
            <div class="ss-slide js-ss-slide">
                <div class="ss-image js-ss-upload-container">
                    <input type="hidden" class="js-ss-slide-data" name="image" value="">
                    <button type="button" class="js-ss-upload-image">
                        <img src="` + customData.placeholder + `" alt="">
                        <span>` + customData.trans.change + `</span>
                    </button>
                    <span>` + customData.trans.required + `</span>
                </div>
                <div class="ss-details">
                    <ul class="ss-nav">
                        <li><button class="js-nav-item active" data-option="general" type="button">` + customData.trans.general + `</button></li>
                        <li><button class="js-nav-item" data-option="options" type="button">` + customData.trans.options + `</button></li>
                        <li><button class="js-nav-item" data-option="aditional" type="button">` + customData.trans.aditional + `</button></li>
                        <li><button class="js-nav-item" data-option="seo" type="button">` + customData.trans.seo + `</button></li>
                        <li><button type="button" class="ss-button ss-danger js-ss-delete-slide"><i class="fas fa-trash-alt"></i> ` + customData.trans.delete + `</button></li>
                    </ul>
                    <ul class="ss-option">
                        <li class="js-option-item active" data-option="general" type="button">
                            <div class="ss-field">
                                <textarea class="wp-editor-area js-ss-slide-option" rows="5" name="content" id="content_new_` + index + `"></textarea>
                            </div>
                        </li>
                        <li class="js-option-item" data-option="options" type="button">
                            <div class="ss-field">
                                <label>` + customData.trans.overlay + `</label>
                                <input class="js-ss-colorpicker js-ss-slide-option" data-alpha-enabled="true" type="text" name="overlay" value="rgba(255,255,255,0.5)" />
                            </div>
                            <div class="ss-field">
                                <label>` + customData.trans.order + `</label>
                                <input type="text" class="js-ss-slide-data" name="order" value="0" />
                            </div>
                            <div class="ss-field">
                                <label>` + customData.trans.status + `</label>
                                <select class="js-ss-slide-data" name="status">
                                    <option value="1">` + customData.trans.show + `</option>
                                    <option value="0">` + customData.trans.hide + `</option>
                                </select>
                            </div>
                            <div class="ss-field ss-target">
                                <label>` + customData.trans.url + `</label>
                                <input type="text" class="js-ss-slide-option" name="url" value="" />
                                <label class="ss-target">
                                    <input type="checkbox" class="js-ss-slide-option" name="target" value="1" />
                                    ` + customData.trans.target + `
                                </label>
                            </div>
                        </li>
                        <li class="js-option-item" data-option="aditional" type="button">
                            <div class="ss-field">
                                <label>` + customData.trans.image + `</label>
                                <div class="ss-field-image js-ss-upload-container">
                                    <input type="hidden" class="js-ss-slide-option" name="image" value="">
                                    <button type="button" class="js-ss-upload-image">
                                        <img src="` + customData.placeholder + `" alt="">
                                        <span>` + customData.trans.change + `</span>
                                    </button>
                                </div>
                            </div>
                            <div class="ss-field">
                                <label>` + customData.trans.align + `</label>
                                <select class="js-ss-slide-option" name="image_align">
                                    <option value="1">` + customData.trans.left + `</option>
                                    <option value="0">` + customData.trans.right + `</option>
                                </select>
                            </div>
                            <div class="ss-field">
                                <label>` + customData.trans.border_width + `</label>
                                <input type="text" class="js-ss-slide-option" name="border" value="10" />
                            </div>
                            <div class="ss-field">
                                <label>` + customData.trans.border_color + `</label>
                                <input class="js-ss-colorpicker js-ss-slide-option" data-alpha-enabled="true" type="text" name="border_color" value="rgba(255,255,255,0.5)" />
                            </div>
                        </li>
                        <li class="js-option-item" data-option="seo" type="button">
                            <div class="ss-field">
                                <label>` + customData.trans.seo_title + `</label>
                                <input type="text" class="js-ss-slide-option" name="seo_title" value="" />
                            </div>
                            <div class="ss-field">
                                <label>` + customData.trans.seo_alt + `</label>
                                <input type="text" class="js-ss-slide-option" name="seo_alt" value="" />
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        `;
        return html;
    }

    function StimaSoft_Slide() {
        var index = 0;
        $(document).on('click', '.js-ss-add-slide', function(e) {
            e.preventDefault();
            var self = $(this);
            var tempalte = StimaSoft_SlideTemplate(index);
            $('.js-ss-slides-list').append(tempalte);
            $('.js-ss-colorpicker').wpColorPicker();
            wp.editor.initialize(
                'content_new_' + index, {
                    tinymce: {
                        wpautop: true,
                        media_buttons: false,
                        textarea_name: 'content',
                        editor_class: 'js-ss-slide-option',
                        teeny: true,
                        plugins: 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview',
                        toolbar1: 'formatselect fontselect fontsizeselect forecolor bold italic underline blockquote strikethrough bullist numlist alignleft aligncenter alignright undo redo link fullscreen'
                    },
                    quicktags: true
                }
            );
            index++;
            return false;
        });
        $(document).on('click', '.js-ss-delete-slide', function(e) {
            e.preventDefault();
            var self = $(this);
            var counter = self.closest('.js-ss-slides-list').find('.js-ss-slide').length;
            self.closest('.js-ss-slide').remove();
            if (counter == 1) {
                var tempalte = StimaSoft_SlideTemplate(index);
                $('.js-ss-slides-list').append(tempalte);
                $('.js-ss-colorpicker').ss_wpColorPicker();
                wp.editor.initialize(
                    'content_new_' + index, {
                        tinymce: {
                            wpautop: true,
                            media_buttons: false,
                            textarea_name: 'content',
                            editor_class: 'js-ss-slide-option',
                            teeny: true,
                            plugins: 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview',
                            toolbar1: 'formatselect fontselect fontsizeselect forecolor bold italic underline blockquote strikethrough bullist numlist alignleft aligncenter alignright undo redo link fullscreen'
                        },
                        quicktags: true
                    }
                );
                index++;
            }
            return false;
        });
    }

    function StimaSoft_Slider() {
        $(document).on('click', '.js-ss-save-slider', function(e) {
            e.preventDefault();
            var self = $(this);
            var slides = self.closest('.js-ss-slider').find('.js-ss-slide');
            var options = self.closest('.js-ss-slider').find('.js-ss-option');
            var optionsArray = {};
            $.each(options, function(index, element) {
                optionsArray[$(element).attr('name')] = $(element).val().trim();
            });
            var slidesArray = [];
            $.each(slides, function(index, element) {
                var slideOptions = $(element).find('.js-ss-slide-option');
                var slide = {
                    data: {
                        image: $(element).find('.js-ss-slide-data[name="image"]').val().trim(),
                        order: $(element).find('.js-ss-slide-data[name="order"]').val().trim() || 0,
                        status: $(element).find('.js-ss-slide-data[name="status"]').val().trim()
                    },
                    options: {}
                };
                $.each(slideOptions, function(index, elementOption) {
                    var optionKey = $(elementOption).attr('name');
                    var optionValue = $(elementOption).val().trim();
                    if (optionKey == 'content') {
                        if ($(element).find('.wp-editor-wrap').hasClass('tmce-active')) {
                            var contentId = $(elementOption).attr('id');
                            optionValue = tinyMCE.get(contentId).getContent({
                                format: 'row'
                            });
                        }
                        slide.options[optionKey] = btoa(unescape(encodeURIComponent(optionValue)));
                    } else if (optionKey == 'target') {
                        optionValue = $(elementOption).is(':checked') ? 1 : 0;
                        slide.options[optionKey] = optionValue;
                    } else {
                        slide.options[optionKey] = optionValue;
                    }
                });
                slidesArray.push(slide);
            });
            jQuery.ajax({
                type: 'post',
                dataType: 'json',
                url: stimasoftAjax.ajaxurl,
                data: {
                    action: 'saveSlider',
                    id: self.attr('data-id').trim(),
                    slides: slidesArray,
                    options: optionsArray
                },
                beforeSend: function() {
                    StimaSoft_Loader();
                },
                success: function(response) {
                    if (response.error) {
                        StimaSoft_Loader(false);
                    } else {
                        location.href = response.redirect
                    }
                }
            });
            return false;
        });
        $(document).on('click', '.js-ss-delete-slider', function(e) {
            e.preventDefault();
            var self = $(this);
            jQuery.ajax({
                type: 'post',
                dataType: 'json',
                url: stimasoftAjax.ajaxurl,
                data: {
                    action: 'deleteSlider',
                    id: self.attr('data-id').trim()
                },
                beforeSend: function() {
                    StimaSoft_Loader();
                },
                success: function(response) {
                    if (response.error) {
                        StimaSoft_Loader(false);
                    } else {
                        location.href = response.redirect
                    }
                }
            });
            return false;
        });
    }

    function StimaSoft_SlideNav() {
        $(document).on('click', '.js-nav-item', function(e) {
            e.preventDefault();
            var self = $(this);
            self.closest('.js-ss-slide').find('.js-nav-item').removeClass('active');
            self.closest('.js-ss-slide').find('.js-option-item').removeClass('active');
            self.closest('.js-ss-slide').find('.js-option-item[data-option="' + self.attr('data-option') + '"]').addClass('active');
            self.addClass('active');
            return false;
        });
    }

    function StimaSoft_BoxSettings() {
        $(document).on('click', '.js-box-toggle', function(e) {
            e.preventDefault();
            var self = $(this);
            if (self.closest('.js-ss-box').hasClass('active')) {
                self.closest('.js-ss-box').removeClass('active')
            } else {
                self.closest('.js-ss-box').addClass('active')
            }
            return false;
        });
    }

    function StimaSoft_UploadImage() {
        $(document).on('click', '.js-ss-upload-image', function(e) {
            e.preventDefault();
            var container = $(this).closest('.js-ss-upload-container');
            var image = wp.media({
                    multiple: false
                }).open()
                .on('select', function(e) {
                    var uploadedImage = image.state().get('selection').first();
                    var imageUrl = uploadedImage.toJSON().url;
                    var imageId = uploadedImage.toJSON().id;
                    container.find('input').val(imageId);
                    container.find('img').attr('src', imageUrl);
                });
        });
    }


    $(document).ready(function() {

        StimaSoft_Slide();
        StimaSoft_Slider();
        StimaSoft_SlideNav();
        StimaSoft_BoxSettings();
        StimaSoft_UploadImage();

    });
});