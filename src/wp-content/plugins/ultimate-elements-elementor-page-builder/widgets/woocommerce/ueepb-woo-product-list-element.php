<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_WooCommerce_Product_List extends Widget_Base {

	public function get_name() {
		return 'ueepb-woocommerce-product-list';
	}

	public function get_title() {
		return __( 'WooCommerce Product List', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-woocommerce ueepb-element-icon';
	}

	public function get_style_depends() {
        return [
            'ueepb-woo-element-style',
            'ueepb-front'
        ];
    }

	public function get_categories() {
		return [ 'ueepb-woo-elements' ];
	}

	protected function _register_controls() {
		global $ueepb_woo_product,$wp_roles;
		
		$this->start_controls_section(
			'section_ueepb_woo_product',
			[
				'label' => __( 'WooCommerce Product List', 'ueepb' ),
			]
		);

		$form_list = array('0' => __( 'Select Form', 'ueepb' ));
		$forms = evf()->form->get( '', array( 'order' => 'DESC' ) );
	    foreach ( $forms as $form ) {
	    	$form_list[$form->ID] = $form->post_title;
	    }


		$this->add_control(
			'ueepb_form',
			[
				'label' => __( 'Form Name', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $form_list,
			]
		);

		$this->add_control(
			'ueepb_woo_product_restricted_message',
			[
				'label' => __( 'Form Restricted Message', 'ueepb' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
			]
		);

		$visibility_type = array('all' => __('All Users','ueepb'),
			'guests' => __('Guests','ueepb'), 'members' => __('Members','ueepb'),
			'user_roles' => __('User Roles','ueepb'));

		$this->add_control(
			'ueepb_woo_product_visibility',
			[
				'label' => __( 'Form Visibility', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => $visibility_type,
			]
		);

		$user_roles = array('0' => __( 'Select User Role', 'ueepb' ) );

		foreach( $wp_roles->role_names as $role => $name ) {
            $user_roles[$role] = $name;
        }

		$this->add_control(
			'ueepb_woo_product_user_roles',
			[
				'label' => __( 'User Roles', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $user_roles,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		if ( ! $settings['ueepb_form'] ) {
			return;
		}

		$id_int = substr( $this->get_id_int(), 0, 3 );
		$this->add_render_attribute( 'shortcode', 'id_int', $id_int );

		$this->add_render_attribute( 'shortcode', 'form_id', $settings['ueepb_form'] );


		if ( isset($settings['ueepb_woo_product_restricted_message'] ) ) {
			$this->add_render_attribute( 'shortcode', 'message', sanitize_text_field($settings['ueepb_woo_product_restricted_message']) );
		}
		if ( isset($settings['ueepb_woo_product_visibility'] ) ) {
			$this->add_render_attribute( 'shortcode', 'visibility', sanitize_text_field($settings['ueepb_woo_product_visibility']) );
		}
		if ( isset($settings['ueepb_woo_product_user_roles'] ) ) {
			$this->add_render_attribute( 'shortcode', 'user_role', sanitize_text_field($settings['ueepb_woo_product_user_roles']) );
		}
				
		?>
		<div class="ueepb-form-panel ueepb-everest-forms-panel">
			<?php
			echo do_shortcode( '[ueepb_woo_product ueepb_form_type="everest_forms"  ' . $this->get_render_attribute_string( 'shortcode' ) . ']' );
			?>
		</div>
		<?php
	}
}

