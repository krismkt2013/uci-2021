<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_Site_Title extends Widget_Base {

	public function get_name() {
		return 'ueepb-site-title';
	}

	public function get_title() {
		return __( 'Site Title', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-site-title ueepb-element-icon';
	}


	public function get_categories() {
		return [ 'ueepb-site-elements' ];
	}

	protected function _register_controls() {
		global $ueepb_woo_product,$wp_roles,$ueepb_business_params;
		
		$this->start_controls_section(
			'section_ueepb_site_title',
			[
				'label' => __( 'Site Title', 'ueepb' ),
			]
		); 

		$this->add_control(
            'ueepb_site_title_link',
            [
                'label'          => __( 'Link to Home?', 'ueepb' ),
                'type'           => Controls_Manager::SWITCHER,
                'default'        => 'no',
                'label_on'       => __( 'No', 'ueepb' ),
                'label_off'      => __( 'Yes', 'ueepb' ),
                'return_value'   => 'no',                
            ]
        ); 

    	$this->end_controls_section();

    	$this->start_controls_section(
            'ueepb_site_title_styles',
            [
                'label'             => __( 'Title Styles', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'ueepb_site_title_color',
            [
                'label'          => __( 'Color', 'ueepb' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'selectors'      => [
                    '{{WRAPPER}} .ueepb-site-title' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .ueepb-site-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_site_title_bg_color',
            [
                'label'          => __( 'Background Color', 'ueepb' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'selectors'      => [
                    '{{WRAPPER}} .ueepb-site-title' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'ueepb_site_title_typography',
                'label'             => __( 'Typography', 'ueepb' ),
                'scheme'            => Scheme_Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .ueepb-site-title',
            ]
        );

        $this->add_responsive_control(
			'ueepb_site_title_padding',
			[
				'label'             => __( 'Padding', 'ueepb' ),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => [ 'px', '%' ],
				'default'           => [
                    'top'       => '5',
                    'right'     => '5',
                    'bottom'    => '5',
                    'left'      => '5',
                    'unit'      => 'px',
                    'isLinked'  => true,
                ],
				'selectors'         => [
					'{{WRAPPER}} .ueepb-site-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator'         => 'before',
			]
		);

		$this->add_responsive_control(
			'ueepb_site_title_margin',
			[
				'label'             => __( 'Padding', 'ueepb' ),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => [ 'px', '%' ],
				'default'           => [
                    'top'       => '5',
                    'right'     => '5',
                    'bottom'    => '5',
                    'left'      => '5',
                    'unit'      => 'px',
                    'isLinked'  => true,
                ],
				'selectors'         => [
					'{{WRAPPER}} .ueepb-site-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator'         => 'before',
			]
		);

		$this->add_responsive_control(
            'ueepb_site_title__alignment',
            [
                'label'                 => __( 'Alignment', 'ueepb' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => __( 'Left', 'ueepb' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'    => [
						'title' => __( 'Center', 'ueepb' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'     => [
						'title' => __( 'Right', 'ueepb' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'               => 'left',
				'selectors'             => [
					'{{WRAPPER}} .ueepb-site-title' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

    	$site_title = get_bloginfo( 'name' );     
		
		if($settings['ueepb_site_title_link'] == 'no'){
			echo '<div class="ueepb-site-title">'.$site_title.'</div>';
		}else{
			echo '<div class="ueepb-site-title"><a href="'.site_url().'">'.$site_title.'</a></div>';
		}
		
	} 
}

