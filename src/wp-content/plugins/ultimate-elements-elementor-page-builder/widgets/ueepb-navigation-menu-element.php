<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_Navigation_Menu extends Widget_Base {

	public function get_name() {
		return 'ueepb-navigation-menu';
	}

	public function get_title() {
		return __( 'Navigation Menu', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-nav-menu ueepb-element-icon';
	}

	public function get_style_depends() {
        return [
            'ueepb-front'
        ];
    }

	public function get_categories() {
		return [ 'ueepb-elements' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_ueepb_menu',
			[
				'label' => __( 'Navigation Menu', 'ueepb' ),
			]
		);

		$menu_list = array('0' => __( 'Select Menu', 'ueepb' ));
		$menus = wp_get_nav_menus();
		foreach ($menus as $key => $menu_obj) {
			$menu_list[$menu_obj->term_id] = $menu_obj->name;
		}


		$this->add_control(
			'ueepb_menu',
			[
				'label' => __( 'Menu Name', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $menu_list,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		if ( ! $settings['ueepb_menu'] ) {
			return;
		}

		$id_int = substr( $this->get_id_int(), 0, 3 );
		$this->add_render_attribute( 'shortcode', 'id_int', $id_int );

		$this->add_render_attribute( 'shortcode', 'menu_id', $settings['ueepb_menu'] );
				
		?>
		<div class="ueepb-navigation-menu">
			<?php
			echo do_shortcode( '[ueepb_navigation_menu ' . $this->get_render_attribute_string( 'shortcode' ) . ']' );
			?>
		</div>
		<?php
	}
}

