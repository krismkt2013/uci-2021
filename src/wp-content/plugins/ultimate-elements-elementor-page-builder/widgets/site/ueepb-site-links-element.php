<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_Site_Links extends Widget_Base {

	public function get_name() {
		return 'ueepb-site-links';
	}

	public function get_title() {
		return __( 'Site Links', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-link ueepb-element-icon';
	}

	public function get_categories() {
		return [ 'ueepb-site-elements' ];
	}


	protected function _register_controls() {
		global $ueepb_woo_product,$wp_roles,$ueepb_business_params;
		
		$this->start_controls_section(
			'section_ueepb_site_links',
			[
				'label' => __( 'Site Links', 'ueepb' ),
			]
		);  

		$this->add_control(
            'ueepb_site_links_type',
            [
                'label'                => __( 'Link to', 'ueepb' ),
                'type'                 => Controls_Manager::SELECT,
                'default'              => '0',
                'options'              => [
                	'0'    		=> __( 'Select Link Type', 'ueepb' ),
                    'home'   	=> __( 'Home Page', 'ueepb' ),
                    'blog'      => __( 'Blog Page', 'ueepb' ),
                ],
            ]
        );

        $this->add_control(
			'ueepb_site_links_text',
			[
				'label' => __( 'Link Text', 'ueepb' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Link Text', 'ueepb' ),
				'default' => '',
				'label_block' => true
			]
		);

    	$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		$site_link = '';
		switch ($settings['ueepb_site_links_type']) {
			case 'home':
				$site_link = get_home_url();
				break;
			
			case 'blog':
				$site_link = get_home_url();
				if ( 'page' === get_option( 'show_on_front' ) ) {
					$site_link = get_permalink( get_option( 'page_for_posts' ) );
				}
				
				break;
		}

    	echo '<a class="ueepb-site-links" href="'.$site_link.'">'.$settings['ueepb_site_links_text'].'</a>';     
		
	} 
}

