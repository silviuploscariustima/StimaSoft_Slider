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

class StimaSoft_Admin
{
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private $version;

	/**
	 * Constructor for the gateway.
	 */
	public function __construct()
	{
		$this->init();
	}

	/**
	 * Init your settings.
	 */
	function init()
	{
		// Scripts.
		add_action('admin_menu', array($this, 'addAdminManu'));
		add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
		add_action('wp_ajax_authTemplates', array($this, 'authTemplates'));
		add_action('wp_ajax_nopriv_authTemplates', array($this, 'authTemplates'));
		add_action('wp_ajax_saveSlider', array($this, 'saveSlider'));
		add_action('wp_ajax_nopriv_saveSlider', array($this, 'saveSlider'));
		add_action('wp_ajax_deleteSlider', array($this, 'deleteSlider'));
		add_action('wp_ajax_nopriv_deleteSlider', array($this, 'deleteSlider'));
	}

	/**
	 * Admin page settings.
	 */
	public function addAdminManu()
	{
		add_menu_page(__('StimaSoft Slider', 'stimasoft-slider'), __('StimaSoft Slider', 'stimasoft-slider'), 'manage_options', 'stimasoft-slider', array($this, 'renderAdminPage'), 'dashicons-format-gallery', 35);
	}

	/**
	 * Render admin page settings.
	 */
	public function renderAdminPage()
	{
		if (isset($_GET['edit'])) {
			include_once(STIMASOFT_SLIDER_PLUGIN_DIR . 'includes/view/admin/slide.php');
		} else {
			include_once(STIMASOFT_SLIDER_PLUGIN_DIR . 'includes/view/admin/slider.php');
		}
	}

	/**
	 * Register the JavaScript for the admin-facing side of the site.
	 */
	public function enqueueScripts()
	{
		if (is_admin()) {
			$screen = get_current_screen();
			if (isset($screen->base) && ($screen->base === 'toplevel_page_stimasoft-slider' || $screen->base === 'stimasoft-slider_page_stimasoft-templates')) {

				// Library
				wp_enqueue_media();
				wp_enqueue_editor();
				wp_enqueue_style('wp-color-picker');
				wp_enqueue_style('stimasoft-fontawesome-style', plugin_dir_url(__FILE__) . '../assets/libraries/fontawesome/css/all.css', array(), $this->version, 'all');
				wp_enqueue_style('stimasoft-swiper-style', plugin_dir_url(__FILE__) . '../assets/libraries/swiper/swiper-bundle.min.css', array(), $this->version, 'all');
				wp_enqueue_script('jquery');
				wp_enqueue_style('wp-color-picker');
				wp_register_script('wp-color-picker-alpha', plugin_dir_url(__FILE__) . '../assets/libraries/colorpicker/wp-color-picker-alpha.js', array('wp-color-picker'), $this->version, true);
				wp_add_inline_script(
					'wp-color-picker-alpha',
					'jQuery( function() { jQuery( ".js-ss-colorpicker" ).wpColorPicker(); } );'
				);
				wp_enqueue_script('wp-color-picker-alpha');
				wp_enqueue_script('stimasoft-swiper-script', plugin_dir_url(__FILE__) . '../assets/libraries/swiper/swiper-bundle.min.js', array(), $this->version, true);

				// Custom
				wp_enqueue_style('stimasoft-slider-style', plugin_dir_url(__FILE__) . '../assets/admin/css/style.css', array(), $this->version, 'all');
				wp_enqueue_script('stimasoft-slider-script', plugin_dir_url(__FILE__) . '../assets/admin/js/custom.js', array('jquery'), $this->version, true);

				$customData = array(
					'placeholder' => esc_url(plugins_url('../assets/img/placeholder.png', __FILE__)),
					'trans' => array(
						'change' => __('Change', 'stimasoft-slider'),
						'general' => __('General', 'stimasoft-slider'),
						'options' => __('Options', 'stimasoft-slider'),
						'aditional' => __('Aditional image', 'stimasoft-slider'),
						'seo' => __('SEO', 'stimasoft-slider'),
						'delete' => __('Delete slide', 'stimasoft-slider'),
						'overlay' => __('Color over image', 'stimasoft-slider'),
						'order' => __('Slide order', 'stimasoft-slider'),
						'status' => __('Slide status', 'stimasoft-slider'),
						'show' => __('Show', 'stimasoft-slider'),
						'hide' => __('Hide', 'stimasoft-slider'),
						'image' => __('Image', 'stimasoft-slider'),
						'left' => __('Left', 'stimasoft-slider'),
						'right' => __('Right', 'stimasoft-slider'),
						'align' => __('Align', 'stimasoft-slider'),
						'border_width' => __('Border width', 'stimasoft-slider'),
						'border_color' => __('Border color', 'stimasoft-slider'),
						'url' => __('Url', 'stimasoft-slider'),
						'target' => __('Open link in new window', 'stimasoft-slider'),
						'seo_title' => __('Image title text', 'stimasoft-slider'),
						'seo_alt' => __('Image alt text', 'stimasoft-slider'),
						'required' => __('Required dimensions: <b>1064 x 370</b>', 'stimasoft-slider'),
					),
				);

				wp_localize_script('stimasoft-slider-script', 'stimasoftAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
				wp_localize_script('stimasoft-slider-script', 'customData', $customData);
			}
		}
	}
	/**
	 * Register the JavaScript for the admin-facing side of the site.
	 */
	public function translate($word)
	{
		_e($word, 'stimasoft-slider');
	}

	/**
	 * Admin data.
	 */
	public function getData()
	{
		$response = [
			'placeholder' => esc_url(plugins_url('../assets/img/placeholder.png', __FILE__))
		];
		return $response;
	}

	public function getSliders()
	{
		global $wpdb;
		$response = [];
		$query = $wpdb->get_results(
			$wpdb->prepare(
				"
				SELECT *
				FROM `{$wpdb->prefix}stimasoft_slider`
            ",
				array()
			)
		);
		if ($query && !empty($query)) {
			foreach ($query as $item) {
				$slides = $this->getSliderSlides($item->id);
				$itemOptions = $this->getSliderOptions($item->id);
				$slidesImages = [];
				foreach ($slides as $slide) {
					$imageData = wp_get_attachment_image_src($slide->image, 'full');
					if ($imageData && !empty($imageData)) {
						$slidesImages[] = [
							'image' => $imageData[0],
							'order' => $slide->order
						];
					}
				}
				$response[] = [
					'id' => $item->id,
					'status' => $itemOptions['status'],
					'date' => $item->created_at,
					'slides' => array_slice($slidesImages, 0, 4)
				];
			}
		}
		return $response;
	}

	public function getSliderOptions($id)
	{
		global $wpdb;
		$response = [
			'effect' => 'slide',
			'navigation' => 'hidden',
			'arrows' => 0,
			'loop' => 0,
			'autoplay' => 0,
			'delay' => 2500,
			'status' => 1,
			'margin' => 0,
			'perview' => 1,
		];
		$query = $wpdb->get_results(
			$wpdb->prepare(
				"
				SELECT *
				FROM `{$wpdb->prefix}stimasoft_slider_options`
				WHERE 
                	slider_id = {$id}
            ",
				array()
			)
		);
		if ($query && !empty($query)) {
			$response = [];
			foreach ($query as $item) {
				$response[$item->option_key] = $item->option_value;
			}
		}
		return $response;
	}
	public function getSliderSlides($id)
	{
		global $wpdb;
		$response = $wpdb->get_results(
			$wpdb->prepare(
				"
				SELECT *
				FROM `{$wpdb->prefix}stimasoft_slider_slide`
				WHERE 
                	slider_id = {$id}
            ",
				array()
			)
		);
		return $response;
	}
	public function getSlideOptions($sliderId, $id)
	{
		global $wpdb;
		$response = [];
		$query = $wpdb->get_results(
			$wpdb->prepare(
				"
				SELECT *
				FROM `{$wpdb->prefix}stimasoft_slider_slide_options`
				WHERE 
                	slider_id = {$sliderId} AND
                	slide_id = {$id}
            ",
				array()
			)
		);
		if ($query && !empty($query)) {
			foreach ($query as $item) {
				$response[$item->option_key] = $item->option_value;
			}
		}
		return $response;
	}

	public function saveSlider()
	{
		$json = [
			'error' => true
		];
		if (isset($_POST['action'])) {
			$slides = [];
			$slidesArray = isset($_POST['slides']) ? (array) $_POST['slides'] : array();
			foreach ($slidesArray as $slideData) {
				$slideDataSanitize = sanitize_post($slideData, 'raw');
				$slides[] = $slideDataSanitize;
			}
			$options = isset($_POST['options']) ? (array) $_POST['options'] : array();
			$options = sanitize_post($options, 'raw');
			if (isset($_POST['id']) && !empty($_POST['id'])) {
				$sliderId = intval($_POST['id']);
				if ($sliderId) {
					$this->deleteDBSliderData($sliderId);
				}
			} else {
				$sliderId = $this->addSlider($options);
			}
			if ($options && !empty($options)) {
				foreach ($options as $key => $value) {
					$this->addSliderOptions($sliderId, $key, $value);
				}
			}
			if ($slides && !empty($slides)) {
				foreach ($slides as $slide) {
					$slideId = $this->addSliderSlide($sliderId, $slide['data']);
					if ($slideId) {
						if (isset($slide['options']) && !empty($slide['options'])) {
							foreach ($slide['options'] as $key => $value) {
								if ($key == 'content') {
									$this->addSliderSlideOption($sliderId, $slideId, $key, base64_decode($value));
								} else {
									$this->addSliderSlideOption($sliderId, $slideId, $key, $value);
								}
							}
						}
					}
				}
			}
			$json['error'] = false;
			$json['redirect'] = admin_url('admin.php?page=stimasoft-slider');
		}
		echo wp_send_json($json);
		wp_die();
	}
	public function deleteSlider()
	{
		$json = [
			'error' => true
		];
		if (isset($_POST['action'])) {
			$sliderId = intval($_POST['id']);
			if ($sliderId) {
				$this->deleteDBSlider($sliderId);
				$json['error'] = false;
				$json['redirect'] = admin_url('admin.php?page=stimasoft-slider');
			}
		}
		echo wp_send_json($json);
		wp_die();
	}
	public function addSlider($data)
	{
		global $wpdb;
		$wpdb->insert(
			$wpdb->prefix . 'stimasoft_slider',
			array(
				'status' => intval($data['status'])
			),
			array('%d')
		);
		return $wpdb->insert_id;
	}
	public function addSliderOptions($id, $key, $value)
	{
		global $wpdb;
		$wpdb->insert(
			$wpdb->prefix . 'stimasoft_slider_options',
			array(
				'slider_id'         => intval($id),
				'option_key'        => sanitize_text_field($key),
				'option_value'      => sanitize_text_field($value),
				'option_value_type' => 'text'
			),
			array('%d', '%s', '%s', '%s')
		);
	}
	public function addSliderSlide($id, $data)
	{
		global $wpdb;
		$wpdb->insert(
			$wpdb->prefix . 'stimasoft_slider_slide',
			array(
				'slider_id' => intval($id),
				'image'     => sanitize_text_field($data['image']),
				'order'     => intval($data['order']),
				'status'    => intval($data['status'])
			),
			array('%d', '%s', '%d', '%d')
		);
		return $wpdb->insert_id;
	}
	public function addSliderSlideOption($sliderId, $id, $key, $value)
	{
		global $wpdb;
		$wpdb->insert(
			$wpdb->prefix . 'stimasoft_slider_slide_options',
			array(
				'slider_id'         => intval($sliderId),
				'slide_id'          => intval($id),
				'option_key'        => sanitize_text_field($key),
				'option_value'      => sanitize_text_field($value),
				'option_value_type' => 'text'
			),
			array('%d', '%d', '%s', '%s', '%s')
		);
	}
	public function deleteDBSlider($id)
	{
		global $wpdb;
		$wpdb->query($wpdb->prepare("DELETE FROM `{$wpdb->prefix}stimasoft_slider` WHERE id = {$id}", array()));
		$wpdb->query($wpdb->prepare("DELETE FROM `{$wpdb->prefix}stimasoft_slider_options` WHERE slider_id = {$id}", array()));
		$wpdb->query($wpdb->prepare("DELETE FROM `{$wpdb->prefix}stimasoft_slider_slide` WHERE slider_id = {$id}", array()));
		$wpdb->query($wpdb->prepare("DELETE FROM `{$wpdb->prefix}stimasoft_slider_slide_options` WHERE slider_id = {$id}", array()));
	}
	public function deleteDBSliderData($id)
	{
		global $wpdb;
		$wpdb->query($wpdb->prepare("DELETE FROM `{$wpdb->prefix}stimasoft_slider_options` WHERE slider_id = {$id}", array()));
		$wpdb->query($wpdb->prepare("DELETE FROM `{$wpdb->prefix}stimasoft_slider_slide` WHERE slider_id = {$id}", array()));
		$wpdb->query($wpdb->prepare("DELETE FROM `{$wpdb->prefix}stimasoft_slider_slide_options` WHERE slider_id = {$id}", array()));
	}
}
