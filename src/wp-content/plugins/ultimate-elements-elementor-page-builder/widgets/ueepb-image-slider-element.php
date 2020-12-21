<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_Image_Slider extends Widget_Base {

	public function get_name() {
		return 'ueepb-image-slider';
	}

	public function get_title() {
		return __( 'Image Slider', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid ueepb-element-icon';
	}

	public function get_style_depends() {
        return [
            'ueepb-front'
        ];
    }

	public function get_categories() {
		return [ 'ueepb-media-elements' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_ueepb_slider',
			[
				'label' => __( 'Image Slider', 'ueepb' ),
			]
		);

		$this->add_control(
			'ueepb_images_list',
			[
				'label' => __( 'Add Images', 'ueepb' ),
				'type' => Controls_Manager::GALLERY,
			]
		);

		$slider_type = array('image_slider' => __('Image Slider','ueepb'),
			'image_gallery' => __('Image Gallery','ueepb'));

		$this->add_control(
			'ueepb_slider_type',
			[
				'label' => __( 'Slide Type', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'image_slider',
				'options' => $slider_type,
			]
		);

		$this->add_control(
			'ueepb_slider_width',
			[
				'label' => __( 'Slider Width', 'ueepb' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Slider Width', 'ueepb' ),
				'default' => '',
				'label_block' => true
			]
		);

		$this->add_control(
			'ueepb_slider_height',
			[
				'label' => __( 'Slider Height', 'ueepb' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Slider Height', 'ueepb' ),
				'default' => '',
				'label_block' => true
			]
		);

		$autoplay = array('enabled' => __('Enabled','ueepb'),'disabled' => __('Disabled','ueepb'));
		$this->add_control(
			'ueepb_slider_autoplay',
			[
				'label' => __( 'Autoplay', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'enabled',
				'options' => $autoplay,
			]
		);

		$autoplay_transition = ueepb_transitions();
		$this->add_control(
			'ueepb_slider_autoplay_transition',
			[
				'label' => __( 'Autoplay Transition', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => $autoplay_transition,
			]
		);

		$navigation_arrows = array('enabled' => __('Enabled','ueepb'),'disabled' => __('Disabled','ueepb'));
		$this->add_control(
			'ueepb_slider_navigation_arrows',
			[
				'label' => __( 'Navigation Arrows', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'enabled',
				'options' => $navigation_arrows,
			]
		);

		$navigation_arrow_types = array('a01' => __('Design 1','ueepb'),
			'a02' => __('Design 2','ueepb'));
		$this->add_control(
			'ueepb_slider_navigation_arrow_type',
			[
				'label' => __( 'Arrow Type', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'a01',
				'options' => $navigation_arrow_types,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		if ( ! $settings['ueepb_images_list'] ) {
			return;
		}

		$id_int = substr( $this->get_id_int(), 0, 3 );
		$this->add_render_attribute( 'shortcode', 'id_int', $id_int );

		$ids = wp_list_pluck( $settings['ueepb_images_list'], 'id' );
		$this->add_render_attribute( 'shortcode', 'slider_images', implode( ',', $ids ) );

		if ( isset($settings['ueepb_slider_width']) &&  $settings['ueepb_slider_width'] != '' ) {
			$this->add_render_attribute( 'shortcode', 'slider_width', $settings['ueepb_slider_width'] );
		}
		if ( isset($settings['ueepb_slider_height'] ) && $settings['ueepb_slider_height'] != '') {
			$this->add_render_attribute( 'shortcode', 'slider_height', $settings['ueepb_slider_height'] );
		}
		if ( isset($settings['ueepb_slider_autoplay_transition'] ) ) {
			$this->add_render_attribute( 'shortcode', 'transition', $settings['ueepb_slider_autoplay_transition'] );
		}		
		
		if ( isset($settings['ueepb_slider_type'] ) ) {
			$this->add_render_attribute( 'shortcode', 'slider_type', $settings['ueepb_slider_type'] );
		}
		if ( isset($settings['ueepb_slider_navigation_arrows']  )) {
			$this->add_render_attribute( 'shortcode', 'show_arrows', $settings['ueepb_slider_navigation_arrows'] );
		}
		if ( isset($settings['ueepb_slider_navigation_arrow_type']  )) {
			$this->add_render_attribute( 'shortcode', 'arrow_type', $settings['ueepb_slider_navigation_arrow_type'] );
		}
		
		if ( isset($settings['ueepb_slider_autoplay'] ) ) {
			$this->add_render_attribute( 'shortcode', 'auto_play', $settings['ueepb_slider_autoplay'] );
		}
		if ( isset($settings['ueepb_autoplay_interval'] ) ) {
			$this->add_render_attribute( 'shortcode', 'autoplay_interval', $settings['ueepb_autoplay_interval'] );
		}
		if ( isset($settings['ueepb_autoplay_steps']  )) {
			$this->add_render_attribute( 'shortcode', 'autoplay_steps', $settings['ueepb_autoplay_steps'] );
		}
		if ( isset($settings['ueepb_thumbnail_visibility'] ) ) {
			$this->add_render_attribute( 'shortcode', 'thumbnail_visibility', $settings['ueepb_thumbnail_visibility'] );
		}
		if ( isset($settings['ueepb_thumbnail_gallery_design'] ) ) {
			$this->add_render_attribute( 'shortcode', 'thumbnail_gallery_design', $settings['ueepb_thumbnail_gallery_design'] );
		}
		if ( isset($settings['ueepb_thumbnail_back_color'] ) ) {
			$this->add_render_attribute( 'shortcode', 'thumbnail_back_color', $settings['ueepb_thumbnail_back_color'] );
		}
		
		?>
		<div class="ueepb-image-slider">
			<?php
			echo do_shortcode( '[ueepb_image_slider ' . $this->get_render_attribute_string( 'shortcode' ) . ']' );
			?>
		</div>
		<?php
	}
}

