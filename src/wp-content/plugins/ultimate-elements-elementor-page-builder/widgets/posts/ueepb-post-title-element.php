<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_Post_Title extends Widget_Base {

	public function get_name() {
		return 'ueepb-post-title';
	}

	public function get_title() {
		return __( 'Post Title', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'ueepb-elements' ];
	}

	protected function _register_controls() {
		global $ueepb_woo_product,$wp_roles,$ueepb_business_params;
		
		$this->start_controls_section(
			'section_ueepb_post_title',
			[
				'label' => __( 'Post Title', 'ueepb' ),
			]
		);  

    $this->end_controls_section();
	}

	protected function render() {
    global $post;

		$settings = $this->get_settings();

    echo $post->post_title;     
		
	} 
}

