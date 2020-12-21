<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_WooCommerce_Order_Tracker extends Widget_Base {

	public function get_name() {
		return 'ueepb-woocommerce-order-tracker';
	}

	public function get_title() {
		return __( 'WooCommerce Order Tracker', 'ueepb' );
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
	}

	protected function render() {
		$settings = $this->get_settings();

		$id_int = substr( $this->get_id_int(), 0, 3 );
		$this->add_render_attribute( 'shortcode', 'id_int', $id_int );
        
						
		?>
		<div class="ueepb-woo-panel ueepb-woocommerce-order-tracker-panel">
			<?php
            echo do_shortcode( '[woocommerce_order_tracking]' );
			?>
		</div>	
		<?php
	}

	
}

