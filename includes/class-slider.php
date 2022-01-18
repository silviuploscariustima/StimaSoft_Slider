<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    StimaSoft-Slider
 * @subpackage StimaSoft-Slider/admin
 */

class StimaSoft_Slider
{
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_url     The string used to access settings plugin easy.
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_url;
	protected $plugin_name;
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var     StimaSoft_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;
	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		$this->plugin_url = 'admin.php?page=stimasoft-slider';
		$this->plugin_name = 'stimasoft-slider';
		add_action('plugins_loaded', array($this, 'LoadDependencies'));
		add_action('admin_notices', array($this, 'ActivateNotice'));
		add_action('admin_bar_menu', array($this, 'NavMenu'), 100);
	}

	public function ActivateNotice()
	{
		if (get_transient('stimasoft-slider-activated')) {

			echo '
				<div class="updated notice is-dismissible">
					<p>Thank you for using StimaSoft Slider! Add your <a href="' . admin_url($this->plugin_url) . '">slider\'s</a>.</p>
				</div>
			';
			delete_transient('stimasoft-slider-activated');
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * -StimaSoft_Loader. Orchestrates the hooks of the plugin.
	 * -StimaSoft_i18n. Defines internationalization functionality.
	 * -StimaSoft_Admin. Defines all hooks for the admin shipping area.
	 * -StimaSoft_Public. Defines all hooks for the admin payment area.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function LoadDependencies()
	{
		/** 
		 * ========= ADMIN ACTIONS / FUNCTIONS CORE ========= 
		 */

		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-loader.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-i18n.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-admin.php';
		
		/** 
		 * ========= PUBLIC ACTIONS / FUNCTIONS ========= 
		 */
		
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-public.php';

		$this->loader = new StimaSoft_Loader();
		$this->SetLocale();
		$this->DefineHooks();
		$this->loader->run();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses theStimaSoft_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function SetLocale()
	{
		$plugin_i18n = new StimaSoft_i18n();
		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'LoadPluginTextdomain');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function DefineHooks()
	{
		// Admin
		$plugin_admin = new StimaSoft_Admin($this->GetPluginName());
		$this->loader->add_action('init', $plugin_admin, 'init');

		// Public
		$plugin_public = new StimaSoft_Public($this->GetPluginName());
		$this->loader->add_action('init', $plugin_public, 'init');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function GetPluginName()
	{
		return $this->plugin_name;
	}

	/**
	 * Link to settings from wordpress admin menu
	 */
	public function NavMenu()
	{
		global $wp_admin_bar;
		$menu_id = 'stimasoft-slider';
		$wp_admin_bar->add_menu(
			array(
				'id' => $menu_id,
				'title' => __('StimaSoft Slider','stimasoft-slider'),
				'href' => admin_url($this->plugin_url)
			)
		);
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return   StimaSoft_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}

}
