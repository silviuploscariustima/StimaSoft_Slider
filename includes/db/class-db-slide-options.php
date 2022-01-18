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

class StimaSoft_DB_Slide_Options
{
    const StimaSoft_TABLE_NAME = 'stimasoft_slider_slide_options';

    /** 
     * @var wpdb 
     */
    protected $DB;

    /** 
     * Function init.
     */
    public function __construct($Database)
    {
        $this->DB = $Database;
    }

    /** 
     * Function get table name.
     */
    protected function GetTableName()
    {
        return $this->DB->prefix . self::StimaSoft_TABLE_NAME;
    }

    /** 
     * Function is trigger when module is installed.
     */
    public function Install_DB()
    {
        $this->DB->query("CREATE TABLE IF NOT EXISTS {$this->GetTableName()} (
            `id` int(11) NOT NULL AUTO_INCREMENT,
			`slider_id` int(11) NOT NULL,
			`slide_id` int(11) NOT NULL,
			`option_key` TEXT NOT NULL,
			`option_value` TEXT NOT NULL,
			`option_value_type` TEXT NOT NULL,
			`created_at` datetime NOT NULL DEFAULT NOW(),
			`updated_at` datetime NOT NULL DEFAULT NOW(),
            PRIMARY KEY (`id`)
        )");
        if ($this->DB->last_error) {
            throw new Exception($this->DB->last_error);
        }
    }

    /** 
     * Function is trigger when module is uninstalled.
     */
    public function Uninstall_DB()
    {
        $this->DB->query("DROP TABLE IF EXISTS {$this->GetTableName()};");
    }

    /** 
     * Function update db.
     */
    public function Update_DB($version)
    {
        
    }
}
