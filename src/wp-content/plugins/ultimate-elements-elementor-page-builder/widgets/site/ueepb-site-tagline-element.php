<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_Site_Tagline extends Widget_Base {

	public function get_name() {
		return 'ueepb-site-tagline';
	}

	public function get_title() {
		return __( 'Site Tagline', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-tags ueepb-element-icon';
	}

	public function get_categories() {
		return [ 'ueepb-site-elements' ];
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
            'ueepb_site_tagline_styles',
            [
                'label'             => __( 'Title Styles', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'ueepb_site_tagline_color',
            [
                'label'          => __( 'Color', 'ueepb' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'selectors'      => [
                    '{{WRAPPER}} .ueepb-site-tagline' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .ueepb-site-tagline a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_site_tagline_bg_color',
            [
                'label'          => __( 'Background Color', 'ueepb' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'selectors'      => [
                    '{{WRAPPER}} .ueepb-site-tagline' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'ueepb_site_tagline_typography',
                'label'             => __( 'Typography', 'ueepb' ),
                'scheme'            => Scheme_Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .ueepb-site-tagline',
            ]
        );

        $this->add_responsive_control(
			'ueepb_site_tagline_padding',
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
					'{{WRAPPER}} .ueepb-site-tagline' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator'         => 'before',
			]
		);

		$this->add_responsive_control(
			'ueepb_site_tagline_margin',
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
					'{{WRAPPER}} .ueepb-site-tagline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator'         => 'before',
			]
		);

		$this->add_responsive_control(
            'ueepb_site_tagline_alignment',
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
					'{{WRAPPER}} .ueepb-site-tagline' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();
	}

	protected function render() {
	    $site_desc = get_bloginfo( 'description' );     
		
		echo '<div class="ueepb-site-tagline">'.$site_desc.'</div>';
	
	} 
}

