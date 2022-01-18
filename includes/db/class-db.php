<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    StimaSoft-Slider
 * @subpackage StimaSoft-Slider/admin
 */

if (!defined('ABSPATH')) {
    exit;
}

class StimaSoft_DB
{
    /**
     * Function is trigger when module is activated.
     */
    public static function Activation()
    {
        global $wpdb;

        /**
         * The class responsible for DB requests
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'db/class-db-slider.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'db/class-db-slider-options.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'db/class-db-slide.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'db/class-db-slide-options.php';

        // Add table stimasoft_slider
        $STIMASOFT_DB_Slider = new StimaSoft_DB_Slider($wpdb);
        $STIMASOFT_DB_Slider->Install_DB();
        
        // Add table stimasoft_slider_options
        $STIMASOFT_DB_Slider = new StimaSoft_DB_Slider_Options($wpdb);
        $STIMASOFT_DB_Slider->Install_DB();
        
        // Add table stimasoft_slider_slide
        $STIMASOFT_DB_Slider = new StimaSoft_DB_Slide($wpdb);
        $STIMASOFT_DB_Slider->Install_DB();
        
        // Add table stimasoft_slider_slide_options
        $STIMASOFT_DB_Slider = new StimaSoft_DB_Slide_Options($wpdb);
        $STIMASOFT_DB_Slider->Install_DB();

    }

    /**
     * Function is trigger when module is deactivated.
     */
    public static function Deactivation()
    {
        global $wpdb;

        /**
         * The class responsible for DB requests
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'db/class-db-slider.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'db/class-db-slider-options.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'db/class-db-slide.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'db/class-db-slide-options.php';

        // Alter table stimasoft_slider
        $STIMASOFT_DB_Slider = new StimaSoft_DB_Slider($wpdb);
        $STIMASOFT_DB_Slider->Uninstall_DB();
        
        // Alter table stimasoft_slider_options
        $STIMASOFT_DB_Slider = new StimaSoft_DB_Slider_Options($wpdb);
        $STIMASOFT_DB_Slider->Uninstall_DB();
        
        // Alter table stimasoft_slider_slide
        $STIMASOFT_DB_Slider = new StimaSoft_DB_Slide($wpdb);
        $STIMASOFT_DB_Slider->Uninstall_DB();
        
        // Alter table stimasoft_slider_slide_options
        $STIMASOFT_DB_Slider = new StimaSoft_DB_Slide_Options($wpdb);
        $STIMASOFT_DB_Slider->Uninstall_DB();
    }
}
