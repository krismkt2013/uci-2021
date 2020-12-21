<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Widget_Base;
use \Elementor\Utils;


class Elementor_uae_whatsapp_chat extends \Elementor\Widget_Base {

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
		return 'uae-whatsapp-chat';
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
		return __( 'WhatsApp Chat', 'uae' );
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
		return 'fab fa-whatsapp';
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

		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'General', 'uae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'style',
			[
	            'label' => __('Choose Style', 'uae'),
	            'type' => \Elementor\Controls_Manager::SELECT,
	            'options' 		=> [
		     		'default' 		=> esc_html__('Simple Button', 'uae'),
		     		'glow' 			=> esc_html__('Glow Button', 'uae'),
		     		'icon' 				=> esc_html__('Button With Icon [Pro]', 'uae'),
		     		'image' 				=> esc_html__('Button With Image [Pro]', 'uae'),
		     		'lign' 				=> esc_html__('Multiple Chat LightBox [Pro]', 'uae'),
				],
				'description' => __('when choosing "Glow" or "Multiple Chat" style then create only one Item from Chat List.', 'uae'),
				'default' 		=> 'default',
				
			]
        );

		$this->add_control(
			'btn_text',
			[
				'label' => __( 'Button Text', 'uae' ),
				'type' => \Elementor\Controls_Manager::TEXT,
            	'default' => __('Start a Conversation', 'uae'),
            	'label_block' 	=> true,
			]
		);

		$this->add_control(
			'btn_phone_number',
			[
				'label' => __( 'WhatsApp Phone Number', 'uae' ),
				'type' => \Elementor\Controls_Manager::TEXT,
            	'default' => __('+50235473364', 'uae'),
			]
		);
		$this->add_control(
			'btn_wa_text',
			[
				'label' => __( 'WhatsApp Text', 'uae' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
            	'default' => __('Hello, I have visit Shortcode and I need help from you. Here is link https://addons.topdigitaltrends.net', 'uae'),
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label' => __( 'Button Padding', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'style' => 'default',
				]
			]
		);

		$this->add_control(
			'btn_wa_width',
			[
				'label'      => esc_html__('Button Width', 'uae'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
		        'range' => [
		            'px' => [
		                'min' => 50,
		                'max' => 200,
		            ],
		        ],
		        'default' => [
					'unit' => 'px',
					'size' => 70,
				],
				'condition' => [
					'style' => 'glow',
				]
		        
			]
		);

		$this->add_responsive_control(
			'btn_radius',
			[
				'label' => __( 'Border Radius', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-1' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'style' => 'default',
				]
			]
		);

		$this->add_control(
			'icon_styling_section',
			[
				'label' => __('Color Styling', 'uae'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'eael_creative_button_tabs' );

        $this->start_controls_tab( 'normal', ['label' => esc_html__( 'Normal', 'essential-addons-for-elementor-lite' )] );

        $this->add_control(
			'btnclr',
			[
				'label'      => esc_html__('Text Color', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-1' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-2' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_control(
			'btnbg',
			[
				'label'      => esc_html__('Button Background', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#2db742',
				'selectors' => [
					'{{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-1' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-2' => 'background: {{VALUE}} !important;',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab( 'eael_creative_button_hover', ['label' => esc_html__( 'Hover', 'essential-addons-for-elementor-lite' )] );

        $this->add_control(
		'btn_hover_clr',
			[
				'label'      => esc_html__('Text Color', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-1:hover' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-2:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

        $this->add_control(
			'btn_hover_bg',
			[
				'label'      => esc_html__('Button Background', 'uae'),
				'type'       => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#249235',
				'selectors' => [
					'{{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-1:hover' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-2:hover' => 'background: {{VALUE}} !important;',
				],
			]
		);

        $this->end_controls_tab();

		$this->end_controls_section();

		$this->start_controls_section(
			'typography_section',
			[
				'label' => __( 'Typography', 'uae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label'      => esc_html__('Icon Size (px)', 'uae'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
		        'range' => [
		            '%' => [
		                'min' => 0,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
					'{{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-1 .uae-whatsapp-icon' => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-2 .uae-whatsapp-icon' => 'font-size: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __('Button Text', 'uae'),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-1, {{WRAPPER}} .uae_whatsapp_wrap .wa_btn_tooltip_txt',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __( 'Box Shadow', 'plugin-domain' ),
				'selector' => 
					'{{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-1, {{WRAPPER}} .uae_whatsapp_wrap .uae-whatsapp-link-2',
			]
		);

		$this->add_control(
			'mbl_visible',
			[
	            'label' => __('Show On Mobile', 'uae'),
	            'type' => \Elementor\Controls_Manager::SELECT,
	            'options' 		=> [
		     		'show' 			=> esc_html__('Show', 'uae'),
		     		'hide' 			=> esc_html__('Hide', 'uae'),
				],
				'separator' 		=> 'before',
				'default' 		=> 'show',
				
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
		$element_id = $this->get_id();
		$some_id = rand(5, 500);
		
		ob_start(); 
		?>

		<!--====== HTML CODING START ========-->

		<?php $hex = $settings['btnbg']; list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x"); ?>
		<?php $hexOn = $settings['btn_hover_bg']; list($R, $G, $B) = sscanf($hexOn, "#%02x%02x%02x"); ?>
		<div class="uae_whatsapp_wrap uae_whatsapp_wrap_<?php echo $some_id; ?>">
			<?php if ($settings['style'] == 'default') { ?>
	            <a class="uae-whatsapp-link-1 elementor-animation" href="https://web.whatsapp.com/send?phone=<?php echo $settings['btn_phone_number']; ?>&text=<?php echo $settings['btn_wa_text']; ?>" target="_blank">
	                <span class="uae-whatsapp-text"><?php echo $settings['btn_text']; ?></span>
	                <i class="uae-whatsapp-icon fab fa-whatsapp" aria-hidden="true" style="margin-left: 5px;"></i>
	            </a>
	        <?php }

	        if ($settings['style'] == 'glow') { ?>
	            <a class="uae-whatsapp-link-2 elementor-animation uae_wa_btn_popup" href="https://web.whatsapp.com/send?phone=<?php echo $settings['btn_phone_number']; ?>&text=<?php echo $settings['btn_wa_text']; ?>" target="_blank"
	            style="width: <?php echo $settings['btn_wa_width']['size'] . $settings['btn_wa_width']['unit']; ?>; height: <?php echo $settings['btn_wa_width']['size'] . $settings['btn_wa_width']['unit']; ?>;">
	                <div class="wa_btn_tooltip_txt">
	                    <?php echo $settings['btn_text']; ?>
	                </div>
	                <span><i class="uae-whatsapp-icon fab fa-whatsapp" aria-hidden="true"></i></span>
	            </a>
	        <?php } ?>
        </div>

        <?php if ($settings['mbl_visible'] == 'hide') { ?>
        	<style>
        		@media only screen and (max-width: 767px) {
					.uae_whatsapp_wrap_<?php echo $some_id; ?>.uae_whatsapp_wrap {
						display: none; !important;" ?>
					}
				}
        	</style>
		<?php } ?>
		<?php if ($settings['style'] == 'glow') { ?>
        	<style>
				.uae_whatsapp_wrap_<?php echo $some_id; ?> .uae-whatsapp-link-2::before, 
				.uae_whatsapp_wrap_<?php echo $some_id; ?> .uae-whatsapp-link-2::after {
					<?php echo "border: 5px solid rgba($r, $g, $b, 0.5) !important;" ?>
				}
				.uae_whatsapp_wrap_<?php echo $some_id; ?> .uae-whatsapp-link-2:hover::before,  
				.uae_whatsapp_wrap_<?php echo $some_id; ?> .uae-whatsapp-link-2:hover::after {
					<?php echo "border: 5px solid rgba($R, $G, $B, 0.5) !important;" ?>
				}
        	</style>
		<?php } ?>
		
		<?php
		echo ob_get_clean();

		/*========== HTML CODING END============*/

	}

}
