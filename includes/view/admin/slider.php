<?php
$admin = new StimaSoft_Admin();
$sliders = $admin->getSliders();
?>
<div class="ss-slider js-ss-slider">
    <div class="ss-header">
        <?php $admin->translate('Slider List'); ?>
    </div>
    <div class="ss-body">
        <div class="ss-list">
            <table>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"><?php $admin->translate('Shortcode'); ?></th>
                        <th scope="col"><?php $admin->translate('Slides'); ?></th>
                        <th scope="col"><?php $admin->translate('Date'); ?></th>
                        <th scope="col"><?php $admin->translate('Status'); ?></th>
                        <th scope="col"><?php $admin->translate('Action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($sliders && !empty($sliders)) : ?>
                        <?php foreach ($sliders as $slider) : ?>
                            <tr>
                                <th scope="row"><?php esc_html_e($slider['id']); ?></th>
                                <td>
                                    <div class="ss-alert ss-warning">[stimasoft_slider id=<?php esc_attr_e($slider['id']); ?>]</div>
                                </td>
                                <td>
                                    <?php if ($slider['slides'] && !empty($slider['slides'])) : ?>
                                        <ul>
                                            <?php foreach ($slider['slides'] as $slide) : ?>
                                                <li>
                                                    <img src="<?php echo esc_url($slide['image']); ?>" alt="" />
                                                    <span><?php esc_html_e($slide['order']); ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else : ?>
                                        <div class="ss-alert ss-danger"><?php $admin->translate('No images'); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="ss-alert"><?php esc_html_e($slider['date']); ?></div>
                                </td>
                                <td>
                                    <?php if ($slider['status']) : ?>
                                        <div class="ss-alert ss-success"><?php $admin->translate('Enabled');?></div>
                                    <?php else : ?>
                                        <div class="ss-alert ss-danger"><?php $admin->translate('Disabled');?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=stimasoft-slider&edit=slide&id=' . $slider['id'])); ?>" class="ss-button ss-primary"><i class="fas fa-pencil-alt"></i> <?php $admin->translate('Edit');?></a>
                                    <button type="button" data-id="<?php esc_attr_e($slider['id']); ?>" class="ss-button ss-danger js-ss-delete-slider"><i class="fas fa-trash-alt"></i> <?php $admin->translate('Delete');?></button>
                                    <button type="button" data-id="<?php esc_attr_e($slider['id']); ?>" class="ss-button ss-warning ss-disabled js-ss-preview-slider"><i class="fas fa-eye"></i> <?php $admin->translate('Preview');?></button>
                                    <button type="button" data-id="<?php esc_attr_e($slider['id']); ?>" class="ss-button ss-info ss-disabled js-ss-export-slider"><i class="fas fa-file-export"></i> <?php $admin->translate('Export');?></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6">
                                <p class="ss-empty"><?php $admin->translate('No sliders found!');?></p>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="6">
                            <a href="<?php echo esc_url(admin_url('admin.php?page=stimasoft-slider&edit=slide')); ?>" class="ss-button ss-primary"><i class="fas fa-plus-circle"></i> <?php $admin->translate('Add slider');?></a>
                            <a href="<?php echo esc_url(admin_url('admin.php?page=stimasoft-templates')); ?>" class="ss-button ss-info"><i class="fas fa-images"></i> <?php $admin->translate('View templates');?></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>