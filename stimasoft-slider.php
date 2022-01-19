<?php
/*
 * @since             1.0.0
 * @package           StimaSoft-Slider
 * 
 * Plugin Name:       StimaSoft Slider
 * Plugin URI:        http://www.stimasoft.com
 * Description:       A simple slider plugin
 * Version:           1.0.2
 * Author:            StimaSoft
 * Text Domain:       stimasoft-slider
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

define('STIMASOFT_SLIDER_PLUGIN_DIR', dirname(__FILE__) . '/');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-activator.php
 */
if (!function_exists('stimasoftSliderActivation')) {
	function stimasoftSliderActivation()
	{
		require_once plugin_dir_path(__FILE__) . 'includes/class-activator.php';
		require_once plugin_dir_path(__FILE__) . 'includes/db/class-db.php';
		StimaSoft_Activator::activate();
		StimaSoft_DB::Activation();
	}
	register_activation_hook(__FILE__, 'stimasoftSliderActivation');
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-deactivator.php
 */
if (!function_exists('stimasoftSliderDeactivation')) {
	function stimasoftSliderDeactivation()
	{
		require_once plugin_dir_path(__FILE__) . 'includes/class-deactivator.php';
		require_once plugin_dir_path(__FILE__) . 'includes/db/class-db.php';
		StimaSoft_Deactivator::deactivate();
		StimaSoft_DB::Deactivation();
	}
	register_deactivation_hook(__FILE__, 'stimasoftSliderDeactivation');
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-slider.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_stimasoft_slider()
{
	new StimaSoft_Slider();
}
run_stimasoft_slider();
