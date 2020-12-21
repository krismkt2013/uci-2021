<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

use Elementor\Utils;

class Elementor_uae_accordion extends \Elementor\Widget_Base {

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
		return 'uae-accordion';
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
		return __( 'Accordion', 'uae' );
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
		return 'fa fa-plus-square';
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
		// wp_enqueue_style( 'accordion-css', plugins_url( '../css/accordion.css' , __FILE__ ));
		// wp_enqueue_script( 'accordion-js', plugins_url( '../js/front/accordion.js' , __FILE__ ), array('jquery', 'jquery-ui-accordion'));
		
		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'Accordion', 'uae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title',
			[
				'label' => __( 'Title', 'uae' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				// 'separator' => 'before',
				'default' => 'Accordion Title',
				'description'	=>	'Click here to <a href="https://elementor.topdigitaltrends.net/accordion/" target="_blank">See Demo</a>',
			]
		);

		$repeater->add_control(
			'titlebg',
			[
				'label'      => esc_html__('Title Background', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
			]
		);

		$repeater->add_control(
			'borderclr',
			[
				'label'      => esc_html__('Border Color', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
			]
		);

		$repeater->add_control(
			'desc_heading',
			[
				'label' => __('Description Section', 'uae'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'descbg',
			[
				'label'      => esc_html__('Description Background', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
			]
		);

		$repeater->add_control(
			'borderclr2',
			[
				'label'      => esc_html__('Border Color', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
			]
		);

		$repeater->add_control(
			'content',
			[
				'label' => esc_html__( 'Description', 'uae' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
			]
		);

		$this->add_control(
			'list_items',
			[
				'label' => __( 'Repeater List', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'theme' => __( 'left', 'plugin-domain' ),
						'list_content' => __( 'Item content. Click the edit button to change this text.', 'plugin-domain' ),
					],
				],
				'title_field' => '{{{ title }}}',
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
			'accordions', 
			[
				'label'        => esc_html__('Title', 'uae' ),
				'tab'           => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'titleclr',
			[
				'label'      => esc_html__('Title Color', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				'label' => __('Typography', 'uae'),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .mega-accordion .ac-style',
			]
		);

		$this->add_responsive_control(
			'margin_tab',
			[
				'label' => __( 'Margin', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mega-accordion .ac-style' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'border_width',
			[
				'label' => __( 'Border Width', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mega-accordion .ac-style' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label' => __( 'Padding', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mega-accordion .ac-style' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
			
		$this->end_controls_section();

		$this->start_controls_section(
			'desc', 
			[
				'label'         => esc_html__('Description', 'uae' ),
				'tab'           => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography2',
				'label' => __('Typography', 'uae'),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .mega-accordion .mega-panel > *',
			]
		);

		$this->add_responsive_control(
			'desc_padding',
			[
				'label' => __( 'Padding', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mega-accordion .mega-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'border_width2',
			[
				'label' => __( 'Border Width', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mega-accordion .mega-panel' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'acco_setting', 
			[
				'label'        => esc_html__('Settings', 'uae' ),
				'tab'           => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'theme',
			[
				'label' => __( 'Theme', 'uae' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' 		=> [
		     		'accordion_theme_0' 		=> esc_html__('Default', 'uae'),
		     		'accordion_theme_1' 		=> esc_html__('Design 1', 'uae'),
		     		'accordion_theme_2' 		=> esc_html__('Design 2', 'uae'),
		     		'asd'					 		=> esc_html__('Design 3 (Pro)', 'uae'),
		     		'asdsa'					 		=> esc_html__('Design 4 (Pro)', 'uae'),
		     		'fsa'					 		=> esc_html__('Design 5 (Pro)', 'uae'),
		     		'fsad'					 		=> esc_html__('Design 6 (Pro)', 'uae'),
		     		'gsa'					 		=> esc_html__('Design 7 (Pro)', 'uae'),
				],
				'description' 		=> '<a href="https://genialsouls.com/mega-addons-for-elementor-pro/" target="_blank">Only available in Pro version</a>',
				'default' 		=> 'accordion_theme_0',
			]
		);

		$this->add_control(
			'themebg',
			[
				'label'      => esc_html__('Theme Color', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'condition' => [
					'theme' => ['accordion_theme_1', 'accordion_theme_2', 'accordion_theme_3', 'accordion_theme_4', 'accordion_theme_5', 'accordion_theme_6', 'accordion_theme_7']
				],
				'selectors' => [
					'{{WRAPPER}} .accordion_theme_1 span.ui-accordion-header-icon' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .accordion_theme_2 span.ui-accordion-header-icon' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .accordion_theme_2 span.ui-accordion-header-icon:after' => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'{{WRAPPER}} .accordion_theme_3 span.ui-accordion-header-icon' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .accordion_theme_3 span.ui-accordion-header-icon:after' => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'{{WRAPPER}} .accordion_theme_4 span.ui-accordion-header-icon' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .accordion_theme_4 span.ui-accordion-header-icon:after' => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'{{WRAPPER}} .accordion_theme_5 span.ui-accordion-header-icon' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .accordion_theme_5 span.ui-accordion-header-icon:after' => 'border-color: {{VALUE}} transparent transparent transparent !important;',
					'{{WRAPPER}} .accordion_theme_6 span.ui-accordion-header-icon' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .accordion_theme_6 span.ui-accordion-header-icon:after' => 'border-color: transparent transparent transparent {{VALUE}} !important;',
					'{{WRAPPER}} .accordion_theme_7 span.ui-accordion-header-icon' => 'background: {{VALUE}} !important;',
				],
			]
		);


		$this->add_control(
			'active',
			[
				'label' => __( 'Tab Open/Close', 'uae' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' 		=> [
		     		'false' 		=> esc_html__('Close', 'uae'),
		     		'0' 			=> esc_html__('Open', 'uae'),
				],
				'default' 		=> 'false',
			]
		);

		$this->add_control(
			'animate',
			[
				'label'      => esc_html__('Animation Speed', 'uae'),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'description'	=>	'in millisecond',
				'size_units' => ['ms'],
				'default'		=>	'350',
			]
		);

		$this->add_control(
			'event',
			[
				'label' => __( 'Event', 'uae' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'description'	=>	'tab open on',
				'options' 		=> [
		     		'click' 		=> esc_html__('Click', 'uae'),
		     		'mouseover' 	=> esc_html__('Mouseover', 'uae'),
				],
				'default' 		=> 'click',
			]
		);

		$this->add_control(
			'titlemargin',
			[
				'label'      	=> esc_html__('Margin', 'uae'),
				'type'       	=> \Elementor\Controls_Manager::NUMBER,
				'description'	=>	'gap between accordion list',
				'size_units' 	=> ['px'],
				'default'		=>	'0',
			]
		);

		$this->add_control(
			'activetabclr',
			[
				'label'      => esc_html__('Active Tab Text Color', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .ui-state-active' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .ui-widget-content .ui-state-active' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .ui-widget-header .ui-state-active' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .ui-accordion-header:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'activetabbg',
			[
				'label'      => esc_html__('Active Tab Background', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .ui-state-active' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .ui-widget-content .ui-state-active' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .ui-widget-header .ui-state-active' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .ui-accordion-header:hover' => 'background: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Default Icon', 'uae' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
						'value' => 'fas fa-plus',
						'library' => 'fa-solid',
					],
			]
		);

		$this->add_control(
			'activeicon',
			[
				'label' => __( 'Active Icon', 'uae' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
						'value' => 'fas fa-minus',
						'library' => 'fa-solid',
					],
			]
		);

		$this->add_control(
			'iconsize',
			[
				'label'      => esc_html__('Icon Size [px]', 'uae'),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'size_units' => ['px'],
				'default'		=>	'15',
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
		<link rel="stylesheet" href="<?php echo $css_path ?>accordion.css">
		<?php

		ob_start(); 
		?>

		<!--====== HTML CODING START ========-->

		<div class="mega-accordion mae_accordion<?php echo $some_id; ?> <?php echo $settings['theme']; ?>" data-active="<?php echo $settings['active']; ?>" data-anim="<?php echo $settings['animate']; ?>" data-event="<?php echo $settings['event']; ?>" data-closeicons="<?php echo $settings['icon']['value']; ?>" data-activeicons="<?php echo $settings['activeicon']['value']; ?>">
			<?php foreach ($settings['list_items'] as $list_items) { ?>
				<h5 class="ac-style" style="margin-top: <?php echo $settings['titlemargin']; ?>px; border-style: solid; border-color: <?php echo $list_items['borderclr']; ?>; color: <?php echo $settings['titleclr']; ?>; background: <?php echo $list_items['titlebg']; ?>;">
					<?php echo $list_items['title']; ?>
				</h5>
				<div class="mega-panel" style="margin-bottom: <?php echo $settings['titlemargin']; ?>px; background: <?php echo $list_items['descbg']; ?>; border-width: <?php echo $borderwidth2; ?>; border-style: solid; border-color: <?php echo $list_items['borderclr2']; ?>;">
				  <?php echo $list_items['content']; ?>
				</div>
			<?php } ?>
		</div>

		<style>
			.mae_accordion<?php echo $some_id; ?> .ac-style .ui-accordion-header-icon {
				font-size: <?php echo $settings['iconsize']; ?>px;
			}
		</style>

		<?php  
		echo ob_get_clean();

		/*========== HTML CODING END============*/

	}
}