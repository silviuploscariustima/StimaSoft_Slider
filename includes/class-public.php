<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    StimaSoft-Slider
 * @subpackage StimaSoft-Slider/public
 */

if (!defined('ABSPATH')) {
	exit;
}

class StimaSoft_Public
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
		add_shortcode('stimasoft_slider', array($this, 'shortcode'));
		add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
	}

	public function shortcode($attr, $content)
	{
		extract(shortcode_atts(array(
			'id' => ''
		), $attr));
		if ($id) {
			if (is_front_page()) {
    			$admin = new StimaSoft_Admin();
    			$sliderOptions = $admin->getSliderOptions($id);
    			if ($sliderOptions['status']) {
    				$slides = $admin->getSliderSlides($id);
					usort($slides, function($a, $b) {
						return $a->order <=> $b->order;
					});
    				if ($slides && !empty($slides)) {
    					$html = '<div class="stimasoft-slider">';
    					$html .= '<div data-slider="' . $id . '" class="swiper-container js-stimasoft-slider-content">';
    					$html .= '<div class="swiper-wrapper">';
    					foreach ($slides as $slide) {
    						if ($slide->status) {
    							$slideOptions = $admin->getSlideOptions($id, $slide->id);
    							$html .= '<div class="swiper-slide">';
    							if ($slideOptions['url'] != '') {
    								if ($slideOptions['target'] && $slideOptions['target'] != '0') {
    									$html .= '<a href="' . $slideOptions['url'] . '" target="_black" title="' . $slideOptions['seo_title'] . '">';
    								} else {
    									$html .= '<a href="' . $slideOptions['url'] . '">';
    								}
    							}
    							// =============================================
    							// Slide Background
    							$slideBackground = '';
    							$slideBackgroundImage = wp_get_attachment_image_src($slide->image, 'full');
    							if ($slideBackgroundImage && !empty($slideBackgroundImage)) {
    								$slideBackground = 'background-image: url(' . $slideBackgroundImage[0] . ');';
    							} else {
    								$slideBackground = 'background-color: #ffffff;';
    							}
    							// =============================================
    							// Slide content
    							if (intval($sliderOptions['perview']) > 1) {
    								$html .= '<div class="stimasoft-slider-slide style-column" style="' . $slideBackground . '">';
    							} else {
    								$html .= '<div class="stimasoft-slider-slide" style="' . $slideBackground . '">';
    							}
    							if ($slideOptions['overlay'] != '') {
    								$html .= '<span class="stimasoft-slider-slide-overlay" style="background-color: ' . $slideOptions['overlay'] . ';"></span>';
    							}
    							if ($slideOptions['image'] != '') {
    								$aditionalImage = wp_get_attachment_image_src($slideOptions['image'], 'full');
    								if ($aditionalImage && !empty($aditionalImage)) {
    									$aditionalStyle = '';
    									if ($slideOptions['border'] != '') {
    										if ($slideOptions['border_color'] != '') {
    											$aditionalStyle = 'border: ' . $slideOptions['border'] . 'px solid ' . $slideOptions['border_color'] . ';';
    										} else {
    											$aditionalStyle = 'border: ' . $slideOptions['border'] . 'px solid rgba(255, 255, 255, 0.6);';
    										}
    									}
    									if ($slideOptions['image_align']) {
    										$html .= '
    										<div class="stimasoft-slide-image ss-align-left" style="' . $aditionalStyle . '">
    											<div class="stimasoft-slide-img">
    												<img src="' . esc_url($aditionalImage[0]) . '" alt="' . $slideOptions['seo_alt'] . '" />
    											</div>
    										</div>
    									';
    									} else {
    										$html .= '
    										<div class="stimasoft-slide-image ss-align-right" style="' . $aditionalStyle . '">
    											<div class="stimasoft-slide-img">
    												<img src="' . esc_url($aditionalImage[0]) . '" alt="' . $slideOptions['seo_alt'] . '" />
    											</div>
    										</div>
    									';
    									}
    								}
    							}
    							$html .= '<div class="stimasoft-slide-content">' . $slideOptions['content'] . '</div>';
    							$html .= '</div>';
    							// =============================================
    							if ($slideOptions['url'] != '') {
    								$html .= '</a>';
    							}
    							$html .= '</div>';
    						}
    					}
    					$html .= '</div>';
    					$sliderOptions = $admin->getSliderOptions($id);
    					// Navigation
    					if ($sliderOptions['arrows']) {
    						$html .= '
    						<div data-slider="' . $id . '" class="stimasoft-slide-nav stimasoft-slide-prev js-stimasoft-slide-prev"><i class="fa fa-angle-left"></i></span></div>
    						<div data-slider="' . $id . '" class="stimasoft-slide-nav stimasoft-slide-next js-stimasoft-slide-next"><i class="fa fa-angle-right"></i></div>
    					';
    					}
    					// Pagination
    					if ($sliderOptions['navigation'] != 'hidden') {
    						if ($sliderOptions['navigation'] == 'dots') {
    							$html .= '<div data-slider="' . $id . '" class="stimasoft-slider-pagination js-stimasoft-slider-pagination"></div>';
    						} else {
    						}
    					}
    					$html .= '</div>';
    					$html .= '</div>';
    					return $html;
    				}
    			}
		    }
		}
	}

	/**
	 * Register the JavaScript for the admin-facing side of the site.
	 */
	public function enqueueScripts()
	{
		wp_enqueue_style('stimasoft-swiper-style', plugin_dir_url(__FILE__) . '../assets/libraries/swiper/swiper-bundle.min.css', array(), $this->version, 'all');
		wp_enqueue_script('jquery');
		wp_enqueue_script('stimasoft-swiper-script', plugin_dir_url(__FILE__) . '../assets/libraries/swiper/swiper-bundle.min.js', array(), $this->version, true);

		// Custom
		wp_enqueue_style('stimasoft-slider-style', plugin_dir_url(__FILE__) . '../assets/public/css/style.css', array(), $this->version, 'all');
		wp_enqueue_script('stimasoft-slider-script', plugin_dir_url(__FILE__) . '../assets/public/js/custom.js', array('jquery'), $this->version, true);

		// JS
		$admin = new StimaSoft_Admin();
		$sliders = $admin->getSliders();
		$slidersOptions = array();
		if ($sliders && !empty($sliders)) {
			foreach ($sliders as $slider) {
				$slidersOptions[$slider['id']] = $admin->getSliderOptions($slider['id']);
			}
		}
		wp_localize_script('stimasoft-slider-script', 'customOptions', $slidersOptions);
	}
}
