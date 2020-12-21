<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_Site_Logo extends Widget_Base {

	public function get_name() {
		return 'ueepb-site-logo';
	}

	public function get_title() {
		return __( 'Site Logo', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-site-logo ueepb-element-icon';
	}

	public function get_categories() {
		return [ 'ueepb-site-elements' ];
	}

	public function get_style_depends() {
        return [
            'ueepb-site-style'
        ];
    }

	protected function _register_controls() {
		global $ueepb_woo_product,$wp_roles,$ueepb_business_params;
		
		$this->start_controls_section(
            'ueepb_site_logo_styles',
            [
                'label'             => __( 'Logo Styles', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'ueepb_site_border_display',
            [
                'label'          => __( 'Display Border?', 'ueepb' ),
                'type'           => Controls_Manager::SWITCHER,
                'default'        => 'no',
                'label_on'       => __( 'No', 'ueepb' ),
                'label_off'      => __( 'Yes', 'ueepb' ),
                'return_value'   => 'no', 

            ]
        ); 

        $this->add_control(
            'rows_margin',
            [
                'label'             => __( 'Border Size', 'powerpack' ),
                'type'              => Controls_Manager::SLIDER,
                'range'             => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 80,
                        'step'  => 1,
                    ],
                ],
                'size_units'        => [ 'px' ],
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-site-logo img' => 'border: {{SIZE}}{{UNIT}} solid;',
                ],
            ]
        );

        $this->add_control(
            'ueepb_site_logo_border_color',
            [
                'label'          => __( 'Border Color', 'ueepb' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'selectors'      => [
                    '{{WRAPPER}} .ueepb-site-logo img' => 'border-color: {{VALUE}}',
                ],
                'conditions'        => [
                    'terms' => [
                        [
                            'name' => 'ueepb_site_border_display',
                            'operator' => '!=',
                            'value' => 'no',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'ueepb_site_logo_outline_color',
            [
                'label'          => __( 'Outline Color', 'ueepb' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'selectors'      => [
                    '{{WRAPPER}} .ueepb-site-logo img' => 'outline:1px solid {{VALUE}}',
                    
                ],'conditions'        => [
                    'terms' => [
                        [
                            'name' => 'ueepb_site_border_display',
                            'operator' => '!=',
                            'value' => 'no',
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {

		wp_enqueue_style('ueepb-site-style');
	
		if (has_custom_logo()) {			
			echo '<div class="ueepb-site-logo">';
			the_custom_logo();
			echo '</div>';			
		}  		
	} 
}

