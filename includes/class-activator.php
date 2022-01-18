<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    StimaSoft-Slider
 * @subpackage StimaSoft-Slider/admin
 */

class StimaSoft_Activator
{
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	public static function activate()
	{
		set_transient('stimasoft-slider-activated', true, 30);
	}
}
