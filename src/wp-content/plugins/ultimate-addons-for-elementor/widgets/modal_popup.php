<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

use Elementor\Utils;

class Elementor_uae_modal_popup extends \Elementor\Widget_Base {

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
		return 'modalpopup';
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
		return __( 'Modal Popup', 'uae' );
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
		return 'fa fa-columns';
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
		// wp_enqueue_style( 'uae-modal-popup', plugins_url( '../css/modal_popup.css' , __FILE__ ));
		// wp_enqueue_script( 'bpopup-js', plugins_url( '../js/bpopup.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'General', 'uae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'modal_anim',
			[
				'label'      => esc_html__('Popup Animation', 'uae'),
				'type'       => \Elementor\Controls_Manager::ANIMATION,
			]
		);

		$this->add_control(
			'modal_posi',
			[
				'label'      => esc_html__('Modal position from top', 'uae'),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'		=>	'60',
				'size_units' => ['px'],
			]
		);

		$this->add_control(
			'modal_width',
			[
				'label'      => esc_html__('Popup Width', 'uae'),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'		=>	'600',
				'size_units' => ['px'],
			]
		);

		$this->add_control(
			'bodybg',
			[
				'label' => __( 'Body Background', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default'		=>	'#6EC1E4',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'button_section',
			[
				'label' => __( 'Button Setting', 'uae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'btn_icon',
			[
				'label' => __( 'Button Icon', 'uae' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
						'value' => 'fas fa-play',
						'library' => 'fa-solid',
					],
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Choose Effects', 'uae' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' 		=> [
		     		'hvr-fade' 			=> esc_html__('Fade', 'uae'),
		     		'button--winona' 	=> esc_html__('Winona', 'uae'),
		     		'button--pro' 	=> esc_html__('Rayen (Pro)', 'uae'),
		     		'button--pro' 	=> esc_html__('Moema (Pro)', 'uae'),
		     		'button--pro' 	=> esc_html__('Ujarak (Pro)', 'uae'),
				],
				'default' 		=> 'hvr-fade',
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label' => __( 'Button Text', 'uae' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default'	=>	'Modal Popup',
			]
		);

		$this->add_control(
			'btn_text2',
			[
				'label' => __( 'Button Secondary Text', 'uae' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Go!',
				'condition' => [
					'style' => ['button--winona', 'button--rayen', 'button--saqui']
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
				'default'	=>	[
					'top' 		=> '12',
					'right' 	=> '35',
					'bottom' 	=> '12',
					'left' 		=> '35',
				],
				'selectors' => [
					'{{WRAPPER}} .mega-uae-btn-section .model-popup-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .mega-uae-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
				'default' => '#D51D1D',
				'selectors' => [
					'{{WRAPPER}} .mega-uae-btn-section .button--moema' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--ujarak' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--winona' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .button--rayen' => 'background: {{VALUE}};',
					'{{WRAPPER}} .mega-uae-btn-section .hvr-fade' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hvrclr',
			[
				'label'      => esc_html__('Hover Text Color', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#D51D1D',
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
					'{{WRAPPER}} .mega-uae-btn-section .button--moema:hover' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--ujarak::before' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--winona:hover' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--rayen::before' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .hvr-fade:hover' => 'background: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => esc_html__('Border Radius', 'uae'),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'size_units' => ['px'],
				'default' => '35',
			]
		);

		$this->add_control(
			'borderclr',
			[
				'label' => __( 'Border Color', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#D51D1D',
				'selectors' => [
					'{{WRAPPER}} .mega-uae-btn-section .button--ujarak' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--winona' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--rayen' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .hvr-fade' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_width',
			[
				'label' => __( 'Border width (px)', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mega-uae-btn-section .button--ujarak' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--winona' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .button--rayen' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .mega-uae-btn-section .hvr-fade' 		=> 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'	=>	[
					'top' 		=> '2',
					'right' 	=> '2',
					'bottom' 	=> '2',
					'left' 		=> '2',
				],
			]
		);

		$this->add_control(
			'border_style',
			[
				'label' => __( 'Border Style', 'uae' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' 		=> [
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
					'{{WRAPPER}} .mega-uae-btn-section .button--shikoba' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .mega-uae-btn-section .button--isi' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .mega-uae-btn-section .button--wayra' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .mega-uae-btn-section .button--ujarak' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .mega-uae-btn-section .button--winona' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .mega-uae-btn-section .button--rayen' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .mega-uae-btn-section .button--quidel' => 'border-style: {{VALUE}}',
					'{{WRAPPER}} .mega-uae-btn-section .hvr-fade' 		=> 'border-style: {{VALUE}}',
				],
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
			'title_stying', 
			[
				'label'         => esc_html__('Modal Title', 'uae' ),
				'tab'           => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'modal_text',
			[
				'label' => __( 'Title', 'uae' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default'		=>	'Image Gallery',
			]
		);

		$this->add_control(
			'title_size',
			[
				'label'      => esc_html__('Title Font Size', 'uae'),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'		=>	'19',
				'size_units' => ['px'],
			]
		);

		$this->add_responsive_control(
			'title_align',
			[
				'label' => __( 'Title Alignment', 'uae' ),
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
					'right' => [
						'title' => __( 'Right', 'uae' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
			]
		);

		$this->add_control(
			'title_clr',
			[
				'label' => __( 'Title Color', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
			]
		);

		$this->add_control(
			'title_bg',
			[
				'label' => __( 'Title Background', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#047899',
			]
		);

		$this->add_control(
			'title_line',
			[
				'label' => __( 'Border Color', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#4054b2',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'popup_stying', 
			[
				'label'         => esc_html__('Popup Content', 'uae' ),
				'tab'           => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'popup_bg',
			[
				'label' => __( 'Modal Background', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
			]
		);

		$this->add_control(
			'content_padding',
			[
				'label' 		=> __( 'Content Padding', 'uae' ),
				'type' 			=> \Elementor\Controls_Manager::TEXT,
				'default'		=>	'10px 10px 10px 10px',
				'label_block' 	=> true,
				'description' => esc_html__( 'top right bottom left', 'uae' ),
			]
		);

		$this->add_control(
			'content',
			[
				'label' => esc_html__( 'Popup Content', 'uae' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'description' => esc_html__( 'You can also use shortcode', 'uae' ),
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

		global $css_path; ?>
		<link rel="stylesheet" href="<?php echo $css_path ?>modal_popup.css">
		<?php

		ob_start(); 
		?>

		<!--====== HTML CODING START ========-->

		<div class="modal-popup-box" data-bodybg="<?php echo $settings['bodybg']; ?>" style="justify-content: <?php echo $settings['alignment']; ?>; display: flex;">
			<?php if (in_array($settings['style'], array("button--winona", "button--rayen", "hvr-fade"))) { ?>
				<div class="mega-uae-btn-section mega-uae-btn-section-<?php echo $some_id; ?>" style="justify-content: <?php echo $settings['alignment']; ?>; display: flex;">
					<button style="border-radius: <?php echo $settings['border_radius']; ?>px; color: <?php echo $settings['btnclr']; ?>;" class="model-popup-btn popup-<?php echo $some_id; ?> mega-uae-btn <?php echo $settings['style']; ?>" data-id="popup-<?php echo $some_id; ?>" data-text="<?php echo esc_attr($settings['btn_text2'] ); ?>"> 
						<span><i class="<?php echo $settings['btn_icon']['value']; ?>" style="padding-right: 5px;"> </i> <?php echo $settings['btn_text']; ?></span>	
					</button>
				</div>
				<div style="clear: both;"></div>
			<?php } ?>

			<?php if (in_array($settings['style'], array("button--ujarak", "button--moema"))) { ?>
				<div class="mega-uae-btn-section mega-uae-btn-section-<?php echo $some_id; ?>" style="justify-content: <?php echo $settings['alignment']; ?>; display: flex;">
					<button style="border-radius: <?php echo $settings['border_radius']; ?>px; color: <?php echo $settings['btnclr']; ?>;" class="model-popup-btn popup-<?php echo $some_id; ?> mega-uae-btn <?php echo $settings['style']; ?>" data-id="popup-<?php echo $some_id; ?>" data-text="<?php echo esc_attr($settings['btn_text'] ); ?>">
						<i class="<?php echo $settings['btn_icon']['value']; ?>" style="padding-right: 5px;"> </i> 
						<span><?php echo $settings['btn_text']; ?></span>
					</button>
				</div>
				<div style="clear: both;"></div>
			<?php } ?>

			<div class="mega-model-popup <?php echo $settings['modal_anim']; ?> animated" id="popup-<?php echo $some_id; ?>" style="position:fixed;display: none; margin-top: <?php echo $settings['modal_posi']; ?>px; width: 95%;max-width: <?php echo $settings['modal_width']; ?>px; background: <?php echo $settings['popup_bg']; ?>;">
				<span class="b-close"><span><img src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/cross.png"></span></span>
			    <div class="model-popup-container">
			    	<p style="border-bottom: 1px solid <?php echo $settings['title_line']; ?>; text-align: <?php echo $settings['title_align']; ?>; color: <?php echo $settings['title_clr']; ?>; background: <?php echo $settings['title_bg']; ?>; font-size: <?php echo $settings['title_size']; ?>px; margin: 0px; padding: 5px 20px;">
			    		<?php echo $settings['modal_text']; ?>
			    	</p>
			      <span style="padding: <?php echo $settings['content_padding'] ?>; display: block;">
			      	<?php echo $settings['content']; ?>
			      </span>
			    </div>
			</div>
		</div>
		<style>
			.mega-uae-btn-section-<?php echo $some_id; ?> .mega-uae-btn:hover {
				color: <?php echo $settings['hvrclr']; ?> !important;
			}
			.mega-uae-btn-section-<?php echo $some_id; ?> .button--winona::after {
				color: <?php echo $settings['hvrclr']; ?> !important;
			}
		</style>

		<?php  
		echo ob_get_clean();

		/*========== HTML CODING END============*/

	}
}