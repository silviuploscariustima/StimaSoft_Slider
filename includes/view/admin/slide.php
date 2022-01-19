<?php
$admin = new StimaSoft_Admin();
$adminData = $admin->getData();
$sliderId = '';
$checkNew = true;
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $checkNew = false;
    $sliderId = (int) $_GET['id'];
}
?>
<div class="ss-slider js-ss-slider">
    <div class="ss-content">
        <div class="ss-headline">
            <?php $admin->translate('Slides'); ?>
        </div>
        <div class="ss-settings js-ss-slides-list">
            <?php if (isset($_GET['id']) && !empty($_GET['id'])) : ?>
                <?php $slides = $admin->getSliderSlides($sliderId); ?>
                <?php if ($slides && !empty($slides)) : ?>
                    <?php foreach ($slides as $index => $slide) : ?>
                        <div class="ss-slide js-ss-slide">
                            <div class="ss-image js-ss-upload-container">
                                <?php
                                $slideImage = $adminData['placeholder'];
                                if ($slide->image != '') {
                                    $imageData = wp_get_attachment_image_src($slide->image, 'full');
                                    if ($imageData && !empty($imageData)) {
                                        $slideImage = $imageData[0];
                                    }
                                }
                                ?>
                                <input type="hidden" class="js-ss-slide-data" name="image" value="<?php echo $slide->image; ?>">
                                <button type="button" class="js-ss-upload-image">
                                    <img src="<?php echo esc_url($slideImage); ?>" alt="">
                                    <span><?php $admin->translate('Change'); ?></span>
                                </button>
                                <span><?php $admin->translate('Required dimensions: <b>1064 x 370</b>'); ?></span>
                            </div>
                            <div class="ss-details">
                                <ul class="ss-nav">
                                    <li><button class="js-nav-item active" data-option="general" type="button"><?php $admin->translate('General'); ?></button></li>
                                    <li><button class="js-nav-item" data-option="options" type="button"><?php $admin->translate('Options'); ?></button></li>
                                    <li><button class="js-nav-item" data-option="aditional" type="button"><?php $admin->translate('Aditional image'); ?></button></li>
                                    <li><button class="js-nav-item" data-option="seo" type="button"><?php $admin->translate('SEO'); ?></button></li>
                                    <li><button type="button" class="ss-button ss-danger js-ss-delete-slide"><i class="fas fa-trash-alt"></i> <?php $admin->translate('Delete slide'); ?></button></li>
                                </ul>
                                <ul class="ss-option">
                                    <?php $slideOptions = $admin->getSlideOptions($sliderId, $slide->id); ?>
                                    <li class="js-option-item active" data-option="general" type="button">
                                        <div class="ss-field">
                                            <?php
                                            wp_editor($slideOptions['content'], 'content_' . $index, array(
                                                'wpautop' => true,
                                                'media_buttons' => false,
                                                'textarea_name' => 'content',
                                                'editor_class' => 'js-ss-slide-option',
                                                'teeny' => false,
                                                'tinymce' => array(
                                                    'toolbar1' => 'formatselect fontselect fontsizeselect forecolor bold italic underline blockquote strikethrough bullist numlist alignleft aligncenter alignright undo redo link fullscreen',
                                                )
                                            ));
                                            ?>
                                        </div>
                                    </li>
                                    <li class="js-option-item" data-option="options" type="button">
                                        <div class="ss-field">
                                            <label><?php $admin->translate('Color over image'); ?></label>
                                            <input class="js-ss-colorpicker js-ss-slide-option" data-alpha-enabled="true" type="text" name="overlay" value="<?php esc_attr_e($slideOptions['overlay']); ?>" />
                                        </div>
                                        <div class="ss-field">
                                            <label><?php $admin->translate('Slide order'); ?></label>
                                            <input type="text" class="js-ss-slide-data" name="order" value="<?php esc_attr_e($slide->order); ?>" />
                                        </div>
                                        <div class="ss-field">
                                            <label><?php $admin->translate('Slide status'); ?></label>
                                            <select class="js-ss-slide-data" name="status">
                                                <?php if ($slide->status) : ?>
                                                    <option selected value="1"><?php $admin->translate('Show'); ?></option>
                                                    <option value="0"><?php $admin->translate('Hide'); ?></option>
                                                <?php else : ?>
                                                    <option value="1"><?php $admin->translate('Show'); ?></option>
                                                    <option selected value="0"><?php $admin->translate('Hide'); ?></option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="ss-field ss-target">
                                            <label><?php $admin->translate('Url'); ?></label>
                                            <input type="text" class="js-ss-slide-option" name="url" value="<?php esc_attr_e($slideOptions['url']); ?>" />
                                            <label class="ss-target">
                                                <?php if ($slideOptions['target']) : ?>
                                                    <input type="checkbox" class="js-ss-slide-option" name="target" value="1" checked />
                                                <?php else : ?>
                                                    <input type="checkbox" class="js-ss-slide-option" name="target" value="1" />
                                                <?php endif; ?>
                                                <?php $admin->translate('Open link in new window'); ?>
                                            </label>
                                        </div>
                                    </li>
                                    <li class="js-option-item" data-option="aditional" type="button">
                                        <div class="ss-field">
                                            <label><?php $admin->translate('Image'); ?></label>
                                            <div class="ss-field-image js-ss-upload-container">
                                                <?php
                                                $aditionalImage = $adminData['placeholder'];
                                                if ($slideOptions['image'] != '') {
                                                    $aditionalImageData = wp_get_attachment_image_src($slideOptions['image'], 'full');
                                                    if ($aditionalImageData && !empty($aditionalImageData)) {
                                                        $aditionalImage = $aditionalImageData[0];
                                                    }
                                                }
                                                ?>
                                                <input type="hidden" class="js-ss-slide-option" name="image" value="<?php esc_attr_e($slideOptions['image']); ?>">
                                                <button type="button" class="js-ss-upload-image">
                                                    <img src="<?php echo esc_url($aditionalImage); ?>" alt="">
                                                    <span><?php $admin->translate('Change'); ?></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="ss-field">
                                            <label><?php $admin->translate('Align'); ?></label>
                                            <select class="js-ss-slide-option" name="image_align">
                                                <?php if ($slideOptions['image_align']) : ?>
                                                    <option selected value="1"><?php $admin->translate('Left'); ?></option>
                                                    <option value="0"><?php $admin->translate('Right'); ?></option>
                                                <?php else : ?>
                                                    <option value="1"><?php $admin->translate('Left'); ?></option>
                                                    <option selected value="0"><?php $admin->translate('Right'); ?></option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="ss-field">
                                            <label><?php $admin->translate('Border width'); ?></label>
                                            <input type="text" class="js-ss-slide-option" name="border" value="<?php esc_attr_e($slideOptions['border']); ?>" />
                                        </div>
                                        <div class="ss-field">
                                            <label><?php $admin->translate('Border color'); ?></label>
                                            <input class="js-ss-colorpicker js-ss-slide-option" data-alpha-enabled="true" type="text" name="border_color" value="<?php esc_attr_e($slideOptions['border_color']); ?>" />
                                        </div>
                                    </li>
                                    <li class="js-option-item" data-option="seo" type="button">
                                        <div class="ss-field">
                                            <label><?php $admin->translate('Image title text'); ?></label>
                                            <input type="text" class="js-ss-slide-option" name="seo_title" value="<?php esc_attr_e($slideOptions['seo_title']); ?>" />
                                        </div>
                                        <div class="ss-field">
                                            <label><?php $admin->translate('Image alt text'); ?></label>
                                            <input type="text" class="js-ss-slide-option" name="seo_alt" value="<?php esc_attr_e($slideOptions['seo_alt']); ?>" />
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php else : ?>
                <div class="ss-slide js-ss-slide">
                    <div class="ss-image js-ss-upload-container">
                        <input type="hidden" class="js-ss-slide-data" name="image" value="">
                        <button type="button" class="js-ss-upload-image">
                            <img src="<?php echo esc_url($adminData['placeholder']); ?>" alt="">
                            <span><?php $admin->translate('Change'); ?></span>
                        </button>
                        <span><?php $admin->translate('Required dimensions: <b>1064 x 370</b>'); ?></span>
                    </div>
                    <div class="ss-details">
                        <ul class="ss-nav">
                            <li><button class="js-nav-item active" data-option="general" type="button"><?php $admin->translate('General'); ?></button></li>
                            <li><button class="js-nav-item" data-option="options" type="button"><?php $admin->translate('Options'); ?></button></li>
                            <li><button class="js-nav-item" data-option="aditional" type="button"><?php $admin->translate('Aditional'); ?></button></li>
                            <li><button class="js-nav-item" data-option="seo" type="button"><?php $admin->translate('SEO'); ?></button></li>
                            <li><button type="button" class="ss-button ss-danger js-ss-delete-slide"><i class="fas fa-trash-alt"></i> <?php $admin->translate('Delete slide'); ?></button></li>
                        </ul>
                        <ul class="ss-option">
                            <li class="js-option-item active" data-option="general" type="button">
                                <div class="ss-field">
                                    <?php
                                    wp_editor('', 'content', array(
                                        'wpautop' => true,
                                        'media_buttons' => false,
                                        'textarea_name' => 'content',
                                        'editor_class' => 'js-ss-slide-option',
                                        'teeny' => false,
                                        'tinymce' => array(
                                            'toolbar1' => 'formatselect fontselect fontsizeselect forecolor bold italic underline blockquote strikethrough bullist numlist alignleft aligncenter alignright undo redo link fullscreen',
                                        )
                                    ));
                                    ?>
                                </div>
                            </li>
                            <li class="js-option-item" data-option="options" type="button">
                                <div class="ss-field">
                                    <label><?php $admin->translate('Color over image'); ?></label>
                                    <input class="js-ss-colorpicker js-ss-slide-option" data-alpha-enabled="true" type="text" name="overlay" value="rgba(255,255,255,0)" />
                                </div>
                                <div class="ss-field">
                                    <label><?php $admin->translate('Slide order'); ?></label>
                                    <input type="text" class="js-ss-slide-data" name="order" value="0" />
                                </div>
                                <div class="ss-field">
                                    <label><?php $admin->translate('Slide status'); ?></label>
                                    <select class="js-ss-slide-data" name="status">
                                        <option value="1"><?php $admin->translate('Show'); ?></option>
                                        <option value="0"><?php $admin->translate('Hide'); ?></option>
                                    </select>
                                </div>
                                <div class="ss-field ss-target">
                                    <label><?php $admin->translate('Url'); ?></label>
                                    <input type="text" class="js-ss-slide-option" name="url" value="" />
                                    <label class="ss-target">
                                        <input type="checkbox" class="js-ss-slide-option" name="target" value="1" />
                                        <?php $admin->translate('Open link in new window'); ?>
                                    </label>
                                </div>
                            </li>
                            <li class="js-option-item" data-option="aditional" type="button">
                                <div class="ss-field">
                                    <label><?php $admin->translate('Image'); ?></label>
                                    <div class="ss-field-image js-ss-upload-container">
                                        <input type="hidden" class="js-ss-slide-option" name="image" value="">
                                        <button type="button" class="js-ss-upload-image">
                                            <img src="<?php echo esc_url($adminData['placeholder']); ?>" alt="">
                                            <span><?php $admin->translate('Change'); ?></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="ss-field">
                                    <label><?php $admin->translate('Align'); ?></label>
                                    <select class="js-ss-slide-option" name="image_align">
                                        <option value="1"><?php $admin->translate('Left'); ?></option>
                                        <option value="0"><?php $admin->translate('Right'); ?></option>
                                    </select>
                                </div>
                                <div class="ss-field">
                                    <label><?php $admin->translate('Border width'); ?></label>
                                    <input type="text" class="js-ss-slide-option" name="border" value="10" />
                                </div>
                                <div class="ss-field">
                                    <label><?php $admin->translate('Border color'); ?></label>
                                    <input class="js-ss-colorpicker js-ss-slide-option" data-alpha-enabled="true" type="text" name="border_color" value="rgba(255,255,255,0.5)" />
                                </div>
                            </li>
                            <li class="js-option-item" data-option="seo" type="button">
                                <div class="ss-field">
                                    <label><?php $admin->translate('Image title text'); ?></label>
                                    <input type="text" class="js-ss-slide-option" name="seo_title" value="" />
                                </div>
                                <div class="ss-field">
                                    <label><?php $admin->translate('Image alt text'); ?></label>
                                    <input type="text" class="js-ss-slide-option" name="seo_alt" value="" />
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif ?>
        </div>
        <div class="ss-foot">
            <button type="button" class="ss-button ss-primary ss-right js-ss-add-slide"><i class="fas fa-plus-circle"></i> <?php $admin->translate('Add slide'); ?></button>
        </div>
    </div>
    <div class="ss-sidebar">
        <?php $options = $admin->getSliderOptions($sliderId); ?>
        <div class="ss-box active js-ss-box">
            <div class="ss-headline">
                <?php $admin->translate('Settings'); ?>
                <button type="button" class="js-box-toggle"><i class="fas fa-caret-up"></i></button>
            </div>
            <div class="ss-settings">
                <div class="ss-setting">
                    <label for="option-effect"><?php $admin->translate('Effect'); ?></label>
                    <select id="option-effect" class="js-ss-option" name="effect">
                        <?php if ($options['effect'] == 'fade') : ?>
                            <option value="slide"><?php $admin->translate('Slide'); ?></option>
                            <option selected value="fade"><?php $admin->translate('Fade'); ?></option>
                        <?php else : ?>
                            <option selected value="slide"><?php $admin->translate('Slide'); ?></option>
                            <option value="fade"><?php $admin->translate('Fade'); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="ss-setting">
                    <label for="option-navigation"><?php $admin->translate('Navigation'); ?></label>
                    <select id="option-navigation" class="js-ss-option" name="navigation">
                        <?php $navigations = array('Hidden', 'Dots'); ?>
                        <?php foreach ($navigations as $navigation) : ?>
                            <?php if ($options['navigation'] == strtolower($navigation)) : ?>
                                <option selected value="<?php echo strtolower(esc_attr($navigation)); ?>"><?php $admin->translate($navigation); ?></option>
                            <?php else : ?>
                                <option value="<?php echo strtolower(esc_attr($navigation)); ?>"><?php $admin->translate($navigation); ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="ss-setting">
                    <label for="option-arrows"><?php $admin->translate('Arrows'); ?></label>
                    <select id="option-arrows" class="js-ss-option" name="arrows">
                        <?php if ($options['arrows']) : ?>
                            <option selected value="1"><?php $admin->translate('Yes'); ?></option>
                            <option value="0"><?php $admin->translate('No'); ?></option>
                        <?php else : ?>
                            <option value="1"><?php $admin->translate('Yes'); ?></option>
                            <option selected value="0"><?php $admin->translate('No'); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="ss-setting">
                    <label for="option-loop"><?php $admin->translate('Loop'); ?></label>
                    <select id="option-loop" class="js-ss-option" name="loop">
                        <?php if ($options['loop']) : ?>
                            <option selected value="1"><?php $admin->translate('Yes'); ?></option>
                            <option value="0"><?php $admin->translate('No'); ?></option>
                        <?php else : ?>
                            <option value="1"><?php $admin->translate('Yes'); ?></option>
                            <option selected value="0"><?php $admin->translate('No'); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="ss-setting">
                    <label for="option-autoplay"><?php $admin->translate('Autoplay'); ?></label>
                    <select id="option-autoplay" class="js-ss-option" name="autoplay">
                        <?php if ($options['autoplay']) : ?>
                            <option selected value="1"><?php $admin->translate('Yes'); ?></option>
                            <option value="0"><?php $admin->translate('No'); ?></option>
                        <?php else : ?>
                            <option value="1"><?php $admin->translate('Yes'); ?></option>
                            <option selected value="0"><?php $admin->translate('No'); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="ss-setting">
                    <label for="option-margin"><?php $admin->translate('Autoplay delay'); ?></label>
                    <input id="option-margin" class="js-ss-option" type="text" name="delay" value="<?php esc_attr_e($options['delay']); ?>" />
                </div>
                <div class="ss-setting">
                    <label for="option-status"><?php $admin->translate('Slider status'); ?></label>
                    <select id="option-status" class="js-ss-option" name="status">
                        <?php if ($options['status']) : ?>
                            <option selected value="1"><?php $admin->translate('Show'); ?></option>
                            <option value="0"><?php $admin->translate('Hide'); ?></option>
                        <?php else : ?>
                            <option value="1"><?php $admin->translate('Show'); ?></option>
                            <option selected value="0"><?php $admin->translate('Hide'); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="ss-box js-ss-box">
            <div class="ss-headline">
                <?php $admin->translate('Advanced settings'); ?>
                <button type="button" class="js-box-toggle"><i class="fas fa-caret-up"></i></button>
            </div>
            <div class="ss-settings">
                <div class="ss-setting">
                    <label for="option-margin"><?php $admin->translate('Margin between slides'); ?></label>
                    <input id="option-margin" class="js-ss-option" type="text" name="margin" value="<?php esc_attr_e($options['margin']); ?>" />
                </div>
                <div class="ss-setting">
                    <label for="option-perview"><?php $admin->translate('Slides per view'); ?></label>
                    <input id="option-perview" class="js-ss-option" type="text" name="perview" value="<?php esc_attr_e($options['perview']); ?>" />
                </div>
            </div>
        </div>
        <?php if (!$checkNew) : ?>
            <div class="ss-box active js-ss-box">
                <div class="ss-headline">
                    <?php $admin->translate('Shortcode'); ?>
                    <button type="button" class="js-box-toggle"><i class="fas fa-caret-up"></i></button>
                </div>
                <div class="ss-settings">
                    <div class="ss-alert ss-warning">[stimasoft_slider id=<?php esc_attr_e($sliderId); ?>]</div>
                </div>
            </div>
        <?php endif; ?>
        <div class="ss-box active">
            <div class="ss-settings">
                <button type="button" data-id="<?php esc_attr_e($sliderId); ?>" class="ss-button ss-success js-ss-save-slider"><i class="fas fa-save"></i> <?php $admin->translate('Save'); ?></button>
                <button type="button" data-id="<?php esc_attr_e($sliderId); ?>" class="ss-button ss-warning ss-disabled js-ss-preview-slider"><i class="fas fa-eye"></i> <?php $admin->translate('Preview'); ?></button>
                <?php if (!$checkNew) : ?>
                    <button type="button" data-id="<?php esc_attr_e($sliderId); ?>" class="ss-button js-ss-delete-slider ss-danger"><i class="fas fa-trash-alt"></i> <?php $admin->translate('Delete'); ?></button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>