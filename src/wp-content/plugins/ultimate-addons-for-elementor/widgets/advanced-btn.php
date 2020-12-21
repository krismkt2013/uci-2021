<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

use Elementor\Utils;

class Elementor_uae_advanced_btn extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'advanced-btn';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Advanced Button', 'uae' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-hand-o-up';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'ultimate-addons' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		// wp_enqueue_style( 'advanced-buttons-css', plugins_url( '../css/advanced-buttons.css' , __FILE__ ));
		
		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'Icon Setting', 'uae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Choose Effects', 'uae' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'description'	=>	'Click here to <a href="https://elementor.topdigitaltrends.net/advanced-button/" target="_blank">See Demo</a>',
				'options' 		=> [
		     		'hvr-fade' 			=> esc_html__('Fade', 'uae'),
		     		'button--winona' 	=> esc_html__('Winona', 'uae'),
		     		'button--ujarak' 	=> esc_html__('Ujarak', 'uae'),
		     		'button--wayra' 	=> esc_html__('Wayra', 'uae'),
		     		'button--rayen' 	=> esc_html__('Rayen', 'uae'),
		     		'button--pipaluk' 	=> esc_html__('Pipaluk', 'uae'),
		     		'button--moema' 	=> esc_html__('Moema', 'uae'),
		     		'button--isi' 		=> esc_html__('Isi', 'uae'),
		     		'button--aylen' 	=> esc_html__('Aylen', 'uae'),
		     		'button--wapasha' 	=> esc_html__('Wapasha', 'uae'),
		     		'button--nuka' 		=> esc_html__('Nuka', 'uae'),
		     		'button--antiman' 	=> esc_html__('Antiman', 'uae'),
		     		'button--itzel' 	=> esc_html__('Itzel', 'uae'),
		     		'button--naira' 	=> esc_html__('Naira', 'uae'),
		     		'button--quidel' 	=> esc_html__('Quidel', 'uae'),
		     		'button--shikoba' 	=> esc_html__('Shikoba', 'uae'),
		     		'button--dualshade' => esc_html__('Dual Shade', 'uae'),
				],
				'default' 		=> 'button--winona',
			]
		);

		$this->add_control(
			'btn_icon',
			[
				'label' => __( 'Button Icon', 'uae' ),
				'type' => \Elementor\Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label' => __( 'Icon Position', 'uae' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' 		=> [
		     		'left' 			=> esc_html__('Left', 'uae'),
		     		'right' 	=> esc_html__('Right', 'uae'),
				],
				'default' 		=> 'left',
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label' => __( 'Button Text', 'uae' ),
				'default' => 'Elementor Go!',
				'type' => \Elementor\Controls_Manager::TEXT,
				// 'selectors' => [
				// 	'{{WRAPPER}} .button--tamaya::after, .button--tamaya::before' => 'content: "{{VALUE}}" !important;',
				// ],
			]
		);

		$this->add_control(
			'btn_text2',
			[
				'label' => __( 'Button Secondary Text', 'uae' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Go!',
				'condition' => [
					'style' => ['button--winona', 'button--rayen', 'button--saqui', 'button--tamaya']
				]
			]
		);

		$this->add_control(
			'btn_link',
			[
				'label' => __('Link To', 'uae'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('https://your-link.com', 'uae'),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				]
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => __( 'Button Alignment', 'uae' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'uae' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'uae' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'uae' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label' => __( 'Button Padding', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'	=>	[
					'top' 		=> '9',
					'right' 	=> '40',
					'bottom' 	=> '9',
					'left' 		=> '40',
				],
				'selectors' => [
					'{{WRAPPER}} .mega-uae-btn-section .mega-uae-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--saqui::after' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--sacnite' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--winona::after' => 'padding: {{TOP}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--naira i' => 'padding: {{TOP}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--shikoba i' => 'padding-top: {{TOP}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				'label' => __('Typography', 'uae'),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .mega-uae-btn-section .mega-uae-btn',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'uae_section_pro',
			[
				'label' => __( '<span style="color: #f54;">Go Premium for More Features</span>', 'uae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'asdasdsadasasdsaf',
            [
                'label' => __( 'Unlock more possibilities', 'uae' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( '', 'uae' ),
						'icon' => 'fa fa-unlock-alt',
					],
				],
				'default' => '1',
                'description' => 'Get the <a style="color: #f54; text-decoration: underline;" href="https://genialsouls.com/mega-addons-for-elementor-pro/" target="_blank">Pro version</a> for more stunning elements and customization options.'
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'divider_section',
			[
				'label' => __( 'Color Options', 'uae' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'btnclr',
			[
				'label'      => esc_html__('Button Color', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
			]
		);

		$this->add_control(
			'btnbg',
			[
				'label'      => esc_html__('Button Background', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => 'rgb(242, 41, 91)',
				'selectors' => [
					// '{{WRAPPER}} .mega-uae-btn-section .mega-uae-btn' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .hvr-fade' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--antiman::after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--shikoba' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--nuka::before, .mega-uae-btn-section .button--nuka::after' => 'background: {{VALUE}};',
					'{{WRAPPER}} .button--wapasha' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--aylen' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--isi' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--pipaluk::after' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--moema' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--wayra' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--ujarak' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--winona' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--rayen' => 'background: {{VALUE}};',
					// '{{WRAPPER}} .mega-uae-btn-section .button--saqui' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--naira' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--quidel::after' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--saqui' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--sacnite' => 'background: none;',
					'{{WRAPPER}} .mega-uae-btn-section .button--sacnite::before' => 'box-shadow: inset 0 0 0 35px {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--sacnite:hover::before' => 'box-shadow: inset 0 0 0 2px {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hvrclr',
			[
				'label'      => esc_html__('Hover Text Color', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => 'rgb(242, 41, 91)',
				'selectors' => [
					'{{WRAPPER}} .mega-uae-btn-section .button--saqui::after' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--sacnite:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'bghover',
			[
				'label'      => esc_html__('Background Color on Hover', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .mega-uae-btn-section .hvr-fade:hover' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--antiman::before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--shikoba:hover' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--nuka:hover::after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .button--wapasha:hover' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--aylen::after' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--aylen::before' => 'background: {{VALUE}} !important; opacity: 0.6;',
					'{{WRAPPER}} .mega-uae-btn-section .button--isi::before' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--pipaluk:hover::after' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--moema:hover' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--wayra:hover::before' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--ujarak::before' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--winona:hover' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--rayen::before' => 'background: {{VALUE}} !important;',
					// '{{WRAPPER}} .mega-uae-btn-section .button--saqui:hover' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--naira::before' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--quidel::before' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--saqui:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => esc_html__('Border Radius', 'uae'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'	=>	[
					'top' 		=> '35',
					'right' 	=> '35',
					'bottom' 	=> '35',
					'left' 		=> '35',
				],
				'selectors' => [
					'{{WRAPPER}} .mega-uae-btn-section .mega-uae-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'border_style',
			[
				'label' => __( 'Border Style', 'uae' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' 		=> [
		     		'none' 		=> esc_html__('None', 'uae'),
		     		'solid' 	=> esc_html__('Solid', 'uae'),
		     		'dotted' 	=> esc_html__('Dotted', 'uae'),
		     		'dashed' 	=> esc_html__('Dashed', 'uae'),
		     		'double' 	=> esc_html__('Double', 'uae'),
		     		'groove' 	=> esc_html__('Groove', 'uae'),
		     		'ridge' 	=> esc_html__('Ridge', 'uae'),
		     		'outset' 	=> esc_html__('Outset', 'uae'),
				],
				'default' 		=> 'solid',
				'selectors' => [
					'{{WRAPPER}} .mega-uae-btn-section .hvr-fade' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .mega-uae-btn-section .button--shikoba' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .mega-uae-btn-section .button--isi' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .mega-uae-btn-section .button--wayra' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .mega-uae-btn-section .button--ujarak' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .mega-uae-btn-section .button--winona' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .mega-uae-btn-section .button--rayen' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .mega-uae-btn-section .button--quidel' => 'border-style: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'border_width',
			[
				'label' => __( 'Border width (px)', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'	=>	[
					'top' 		=> '2',
					'right' 	=> '2',
					'bottom' 	=> '2',
					'left' 		=> '2',
				],
				'selectors' => [
					'{{WRAPPER}} .mega-uae-btn-section .hvr-fade' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--shikoba' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .button--wapasha::before' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--isi' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--wayra' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--ujarak' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--winona' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--rayen' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--quidel' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'borderclr',
			[
				'label' => __( 'Border Color', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => 'rgb(242, 41, 91)',
				'selectors' => [
					'{{WRAPPER}} .mega-uae-btn-section .hvr-fade' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--antiman::before' => 'border: 2px solid {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--shikoba' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .button--wapasha::before' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--isi' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--pipaluk::before' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--wayra' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--ujarak' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--winona' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--rayen' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--quidel' => 'Background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __( 'Box Shadow', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .mega-uae-btn-section .mega-uae-btn',
			]
		);

		$this->add_control(
			'icon_styling_section',
			[
				'label' => __('Icon Styling', 'uae'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label'      => esc_html__('Icon Size', 'uae'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
		        'range' => [
		            '%' => [
		                'min' => 0,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
					'{{WRAPPER}} .mega-uae-btn-section .mega-uae-btn i' => 'font-size: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'icon_space',
			[
				'label'      => esc_html__('Icon Text Space', 'uae'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
		        'range' => [
		            '%' => [
		                'min' => 0,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
					'{{WRAPPER}} .mega-uae-btn-section .mega-uae-btn .icon__left' => 'padding-right: {{SIZE}}px;',
					'{{WRAPPER}} .mega-uae-btn-section .mega-uae-btn .icon__right' => 'padding-left: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$some_id = rand(5, 500);

		// $html = wp_oembed_get( $settings['ihe_link'] );
		 
		$target = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';

		global $css_path; ?>
		<link rel="stylesheet" href="<?php echo $css_path ?>advanced-buttons.css">
		<?php

		ob_start(); 
		?>

		<!--====== HTML CODING START ========-->

		<?php if ($settings['style']  == 'hvr-fade' || $settings['style']  == 'button--sacnite' || $settings['style']  == 'button--dualshade') { ?>
			<div class="mega-uae-btn-section mega-uae-btn-section-<?php echo $some_id; ?>" style="justify-content: <?php echo $settings['alignment']; ?>; display: flex;">
				<a href="<?php echo $settings['btn_link']['url']; ?>" <?php echo $target.$nofollow; ?> style="color: <?php echo $settings['btnclr']; ?>;" class="mega-uae-btn <?php echo $settings['style']; ?>"> 
					<?php if ($settings['icon_position'] == 'left') { ?>
						<i class="<?php echo $settings['btn_icon']['value']; ?> icon__left"></i>
					<?php } ?>
						<span><?php echo $settings['btn_text']; ?></span>
					<?php if ($settings['icon_position'] == 'right') { ?>
						<i class="<?php echo $settings['btn_icon']['value']; ?> icon__right"></i>
					<?php } ?>
				</a>
			</div>
			<div style="clear: both;"></div>
		<?php } ?>

		<?php if (in_array($settings['style'], array("button--winona", "button--rayen"))) { ?>
			<div class="mega-uae-btn-section mega-uae-btn-section-<?php echo $some_id; ?>" style="justify-content: <?php echo $settings['alignment']; ?>; display: flex;">
				<a href="<?php echo $settings['btn_link']['url']; ?>" <?php echo $target.$nofollow; ?> style="color: <?php echo $settings['btnclr']; ?>;" class="mega-uae-btn <?php echo $settings['style']; ?>" data-text="<?php echo esc_attr($settings['btn_text2'] ); ?>"> 
					<span><?php echo $settings['btn_text']; ?></span>			
				</a>
			</div>
			<div style="clear: both;"></div>
		<?php } ?>

		<?php if (in_array($settings['style'], array("button--ujarak", "button--antiman", "button--shikoba", "button--nuka", "button--wapasha", "button--aylen", "button--isi", "button--pipaluk", "button--moema", "button--wayra", "button--naira", "button--quidel"))) { ?>
			<div class="mega-uae-btn-section mega-uae-btn-section-<?php echo $some_id; ?>" style="justify-content: <?php echo $settings['alignment']; ?>; display: flex;">
				<a href="<?php echo $settings['btn_link']['url']; ?>" <?php echo $target.$nofollow; ?> style="color: <?php echo $settings['btnclr']; ?>;" class="mega-uae-btn <?php echo $settings['style']; ?>" data-text="<?php echo esc_attr($settings['btn_text'] ); ?>">
					<?php if ($settings['icon_position'] == 'left') { ?>
						<i class="<?php echo $settings['btn_icon']['value']; ?> button__icon icon__left"> </i>
					<?php } ?>
						<span><?php echo $settings['btn_text']; ?></span>
					<?php if ($settings['icon_position'] == 'right') { ?>
						<i class="<?php echo $settings['btn_icon']['value']; ?> button__icon icon__right"> </i>
					<?php } ?>		
				</a>
			</div>
			<div style="clear: both;"></div>
		<?php } ?>

		<?php if ($settings['style'] == "button--saqui") { ?>
			<div class="mega-uae-btn-section mega-uae-btn-section-<?php echo $some_id; ?>" style="justify-content: <?php echo $settings['alignment']; ?>; display: flex;">
				<a href="<?php echo $settings['btn_link']['url']; ?>" <?php echo $target.$nofollow; ?> style="color: <?php echo $settings['btnclr']; ?>;" class="mega-uae-btn <?php echo $settings['style']; ?>" data-text="<?php echo esc_attr($settings['btn_text'] ); ?>">
					<?php echo $settings['btn_text']; ?>			
				</a>
			</div>
			<div style="clear: both;"></div>
		<?php } ?>

		<style>
			.mega-uae-btn-section-<?php echo $some_id; ?> .mega-uae-btn:hover {
				color: <?php echo $settings['hvrclr']; ?> !important;
			}
			.mega-uae-btn-section-<?php echo $some_id; ?> .button--winona::after {
				color: <?php echo $settings['hvrclr']; ?> !important;
			}
			.mega-uae-btn-section-<?php echo $some_id; ?> .button--dualshade {
				background-image: linear-gradient(41deg, <?php echo $settings['btnbg'] ?> 0%,<?php echo $settings['bghover'] ?> 100%) !important;
				background: none;
			}
			.mega-uae-btn-section-<?php echo $some_id; ?> .button--dualshade:hover {
				color: <?php echo $settings['btnclr'] ?> !important;
			}
		</style>

		<?php
		echo ob_get_clean();

		/*========== HTML CODING END============*/

	}
}