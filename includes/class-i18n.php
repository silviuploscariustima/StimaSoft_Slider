<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    StimaSoft-Slider
 * @subpackage StimaSoft-Slider/admin
 */

class StimaSoft_i18n
{
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function LoadPluginTextdomain()
	{
		load_plugin_textdomain('stimasoft-slider', false, dirname(dirname(plugin_basename(__FILE__))) . '/languages/');
	}
}
