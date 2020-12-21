<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_Image_Viewer extends Widget_Base {

	public function get_name() {
		return 'ueepb-image-viewer';
	}

	public function get_title() {
		return __( 'Image Viewer', 'ueepb' );
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
			'section_ueepb_image_viewer',
			[
				'label' => __( 'Image Viewer', 'ueepb' ),
			]
		);

		$this->add_control(
			'ueepb_images_image_viewer_list',
			[
				'label' => __( 'Add Images', 'ueepb' ),
				'type' => Controls_Manager::GALLERY,
			]
		);

		$viewer_modes = array('modal' => __('Modal','ueepb'),'inline' => __('Inline','ueepb'));
		$this->add_control(
			'ueepb_image_viewer_mode',
			[
				'label' => __( 'Viewer Mode', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'modal',
				'options' => $viewer_modes,
			]
		);

		$viewer_title = array('enabled' => __('Enabled','ueepb'),'disabled' => __('Disabled','ueepb'));
		$this->add_control(
			'ueepb_image_viewer_title',
			[
				'label' => __( 'Viewer Title', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'enabled',
				'options' => $viewer_title,
			]
		);

		$viewer_navigation = array('enabled' => __('Enabled','ueepb'),'disabled' => __('Disabled','ueepb'));
		$this->add_control(
			'ueepb_image_viewer_navigation',
			[
				'label' => __( 'Viewer Navigation', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'enabled',
				'options' => $viewer_navigation,
			]
		);

		$viewer_toolbar = array('enabled' => __('Enabled','ueepb'),'disabled' => __('Disabled','ueepb'));
		$this->add_control(
			'ueepb_image_viewer_toolbar',
			[
				'label' => __( 'Viewer Toolbar', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'enabled',
				'options' => $viewer_toolbar,
			]
		);

		$viewer_tooltip = array('enabled' => __('Enabled','ueepb'),'disabled' => __('Disabled','ueepb'));
		$this->add_control(
			'ueepb_image_viewer_tooltip',
			[
				'label' => __( 'Viewer Tooltip', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'enabled',
				'options' => $viewer_tooltip,
			]
		);

		$viewer_moving = array('enabled' => __('Enabled','ueepb'),'disabled' => __('Disabled','ueepb'));
		$this->add_control(
			'ueepb_image_viewer_moving',
			[
				'label' => __( 'Viewer Moving', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'enabled',
				'options' => $viewer_moving,
			]
		);

		$viewer_zooming = array('enabled' => __('Enabled','ueepb'),'disabled' => __('Disabled','ueepb'));
		$this->add_control(
			'ueepb_image_viewer_zooming',
			[
				'label' => __( 'Viewer Zooming', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'enabled',
				'options' => $viewer_zooming,
			]
		);

		$viewer_rotating = array('enabled' => __('Enabled','ueepb'),'disabled' => __('Disabled','ueepb'));
		$this->add_control(
			'ueepb_image_viewer_rotating',
			[
				'label' => __( 'Viewer Rotating', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'enabled',
				'options' => $viewer_rotating,
			]
		);

		$viewer_scaling = array('enabled' => __('Enabled','ueepb'),'disabled' => __('Disabled','ueepb'));
		$this->add_control(
			'ueepb_image_viewer_scaling',
			[
				'label' => __( 'Viewer Scaling', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'enabled',
				'options' => $viewer_scaling,
			]
		);

		$viewer_transition = array('enabled' => __('Enabled','ueepb'),'disabled' => __('Disabled','ueepb'));
		$this->add_control(
			'ueepb_image_viewer_transition',
			[
				'label' => __( 'Viewer Transition', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'enabled',
				'options' => $viewer_transition,
			]
		);

		$viewer_fullscreen = array('enabled' => __('Enabled','ueepb'),'disabled' => __('Disabled','ueepb'));
		$this->add_control(
			'ueepb_image_viewer_fullscreen',
			[
				'label' => __( 'Viewer Fullscreen', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'enabled',
				'options' => $viewer_fullscreen,
			]
		);

		

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		wp_enqueue_style('ueepb-viewer-front');
		wp_enqueue_style('ueepb-image-viewer-style');		
		wp_enqueue_script('ueepb-image-viewer-script');
        
		if ( ! $settings['ueepb_images_image_viewer_list'] ) {
			return;
		}

		$id_int = substr( $this->get_id_int(), 0, 3 );
		$this->add_render_attribute( 'shortcode', 'id_int', $id_int );

		$ids = wp_list_pluck( $settings['ueepb_images_image_viewer_list'], 'id' );
		$this->add_render_attribute( 'shortcode', 'slider_images', implode( ',', $ids ) );

		$mode = ($settings['ueepb_image_viewer_mode'] == 'modal' ) ? 'false' : 'true';
        $navbar = ($settings['ueepb_image_viewer_navigation']  == 'enabled' ) ? 'true' : 'false';
        $title = ($settings['ueepb_image_viewer_title'] == 'enabled' ) ? 'true' : 'false';
        $toolbar = ($settings['ueepb_image_viewer_toolbar'] == 'enabled' ) ? 'true' : 'false';
        $tooltip = ($settings['ueepb_image_viewer_tooltip'] == 'enabled' ) ? 'true' : 'false';
        $movable = ($settings['ueepb_image_viewer_moving'] == 'enabled' ) ? 'true' : 'false';
        $zooming = ($settings['ueepb_image_viewer_zooming'] == 'enabled' ) ? 'true' : 'false';
        $rotating = ($settings['ueepb_image_viewer_rotating'] == 'enabled' ) ? 'true' : 'false';
        $scaling = ($settings['ueepb_image_viewer_scaling'] == 'enabled' ) ? 'true' : 'false';
        $transition = ($settings['ueepb_image_viewer_transition'] == 'enabled' ) ? 'true' : 'false';
        $fullscreen = ($settings['ueepb_image_viewer_fullscreen'] == 'enabled' ) ? 'true' : 'false';


        $display = "<div id='ueepb-front-viewer-".$id_int."' class='ueepb-front-viewer' >";

        $upload_dir = wp_upload_dir();
        $upload_dir_url = $upload_dir['baseurl']."/";
        $upload_sub_dir_url = $upload_dir['baseurl'].$upload_dir['subdir']."/";

        foreach($ids as $attach_id){
            if($attach_id != ''){
                
                $image_icons = "<img class='ueepb-viewer-edit' src='" . UEEPB_PLUGIN_URL ."images/viewer-edit.png' />
                                    <img class='ueepb-viewer-delete' src='" . UEEPB_PLUGIN_URL . "images/viewer-delete.png' />";

                $attachment = wp_get_attachment_metadata( $attach_id );

                $thumbnail = wp_get_attachment_thumb_url( $attach_id );
                 $display .= "<div class='ueepb-front-viewer-single'><img data-original='". $upload_dir_url.$attachment['file'] ."' src='" . $thumbnail . "' ></div>";
            }
        }
        
        $display .= "<div class='ueepb-clear'></div></div>";

        $display .= "<script type='text/javascript'>
                        jQuery(document).ready( function( $ ) {
                            var options_".$id_int." = {
                                url: 'data-original',
                                inline : ".$mode.",
                                navbar : ".$navbar.",
                                title : ".$title.",
                                toolbar : ".$toolbar.",
                                tooltip : ".$tooltip.",
                                movable : ".$movable.",
                                zoomable : ".$zooming.",
                                rotatable : ".$rotating.",
                                scalable : ".$scaling.",
                                transition:".$transition.",
                                fullscreen:".$fullscreen.",
                                
                              };

                            $('#ueepb-front-viewer-".$id_int."').viewer(options_".$id_int.");
                        });
                    </script>";
        echo $display;
	}
}

