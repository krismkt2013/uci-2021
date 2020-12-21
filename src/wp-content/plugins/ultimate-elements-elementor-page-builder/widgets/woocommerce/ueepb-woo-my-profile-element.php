<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_WooCommerce_My_Profile extends Widget_Base {

	public function get_name() {
		return 'ueepb-woocommerce-my-profile';
	}

	public function get_title() {
		return __( 'WooCommerce My Profile', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-woocommerce ueepb-element-icon';
	}

	public function get_categories() {
		return [ 'ueepb-woo-elements' ];
	}

	public function get_style_depends() {
        return [
            'ueepb-woo-element-style',
            'ueepb-front'
        ];
    }

    public function get_script_depends() {
        return [
            'ueepb-woo-element-script'
        ];
    }

	protected function _register_controls() {
		global $ueepb_woo_product,$wp_roles;
		
		$this->start_controls_section(
			'section_ueepb_woo_my_profile',
			[
				'label' => __( 'WooCommerce My Account', 'ueepb' ),
			]
		);

		$this->add_control(
			'ueepb_woo_my_profile_header',
			[
				'label' => __( 'Display Header', 'ueepb' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'ueepb_woo_my_profile_header_image',
			[
				'label' => __( 'Display Header Image', 'ueepb' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'ueepb_woo_my_profile_header_name',
			[
				'label' => __( 'Display Header Name', 'ueepb' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'ueepb_woo_my_profile_header_logout',
			[
				'label' => __( 'Display Header Logout', 'ueepb' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		

		$this->end_controls_section();



		$this->start_controls_section(
            'ueepb_woo_my_profile_colors',
            [
                'label'             => __( 'Profile Colors', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
            'ueepb_woo_my_profile_border_color',
            [
                'label'             => __( 'Border Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-my-account-panel' => 'border:1px solid {{VALUE}}',
                    '{{WRAPPER}} .ueepb-my-account-header-image img' => 'outline:1px solid {{VALUE}}',
                    '{{WRAPPER}} .ueepb-my-account-tabs' => 'border-top:1px solid {{VALUE}};border-bottom:1px solid {{VALUE}}',
                    '{{WRAPPER}} .ueepb-my-account-header-logout-btn a' => 'border:1px solid {{VALUE}}',
                    '{{WRAPPER}} .ueepb-my-account-tab-item' => 'border-right:1px solid {{VALUE}}',
                    
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_my_profile_header_bg_color',
            [
                'label'             => __( 'Header : Background Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-my-account-header' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_my_profile_tab_bg_color',
            [
                'label'             => __( 'Tab : Background Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-my-account-tab-item' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_my_profile_tab_hover_color',
            [
                'label'             => __( 'Tab : Hover Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-my-account-tab-item:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_my_profile_tab_active_color',
            [
                'label'             => __( 'Tab : Active Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-active-tab' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_my_profile_tab_text_color',
            [
                'label'             => __( 'Tab : Text Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-my-account-tab-item' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_my_profile_logout_bg_color',
            [
                'label'             => __( 'Logout : Background Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-my-account-header-logout-btn a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_my_profile_logout_text_color',
            [
                'label'             => __( 'Logout : Text Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-my-account-header-logout-btn a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		$id_int = substr( $this->get_id_int(), 0, 3 );
		$this->add_render_attribute( 'shortcode', 'id_int', $id_int );


		if ( isset($settings['ueepb_woo_my_profile_header'] ) ) {
			$this->add_render_attribute( 'shortcode', 'display_header', sanitize_text_field($settings['ueepb_woo_my_profile_header']) );
		}
		if ( isset($settings['ueepb_woo_my_profile_header_image'] ) ) {
			$this->add_render_attribute( 'shortcode', 'display_header_image', sanitize_text_field($settings['ueepb_woo_my_profile_header_image']) );
		}
		if ( isset($settings['ueepb_woo_my_profile_header_name'] ) ) {
			$this->add_render_attribute( 'shortcode', 'display_header_name', sanitize_text_field($settings['ueepb_woo_my_profile_header_name']) );
		}
		if ( isset($settings['ueepb_woo_my_profile_header_logout'] ) ) {
			$this->add_render_attribute( 'shortcode', 'display_header_logout', sanitize_text_field($settings['ueepb_woo_my_profile_header_logout']) );
		}
				
		?>
		<div class="ueepb-woo-panel ueepb-woo-my-account-panel">
			<?php
			echo do_shortcode( '[ueepb_woo_my_profile ' . $this->get_render_attribute_string( 'shortcode' ) . ']' );
			?>
		</div>	
		<?php
	}
	
}

