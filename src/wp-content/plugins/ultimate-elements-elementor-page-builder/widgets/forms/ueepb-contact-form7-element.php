<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_Contact_Form7 extends Widget_Base {

	public function get_name() {
		return 'ueepb-contact-form7';
	}

	public function get_title() {
		return __( 'Contact Form 7', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal ueepb-element-icon';
	}

	public function get_style_depends() {
        return [
            'ueepb-front'
        ];
    }

	public function get_categories() {
		return [ 'ueepb-form-elements' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_ueepb_contact_form7',
			[
				'label' => __( 'Contact Form 7', 'ueepb' ),
			]
		);

		$form_list = array('0' => __( 'Select Form', 'ueepb' ));
		$forms = get_posts(array(
	        'post_type'     => 'wpcf7_contact_form',
	        'posts_per_page'   => -1
	    ));

	    foreach ( $forms as $form ) {
	    	$form_list[$form->ID] = $form->post_title;
	    }


		$this->add_control(
			'ueepb_contact_form7_form',
			[
				'label' => __( 'Form Name', 'ueepb' ),
				'type' => Controls_Manager::SELECT2,
				'default' => '0',
				'options' => $form_list,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		if ( ! $settings['ueepb_contact_form7_form'] ) {
			return;
		}

		$id_int = substr( $this->get_id_int(), 0, 3 );
		$this->add_render_attribute( 'shortcode', 'id_int', $id_int );

		$this->add_render_attribute( 'shortcode', 'form_id', $settings['ueepb_contact_form7_form'] );
				
		?>
		<div class="ueepb-navigation-menu">
			<?php
			echo do_shortcode( '[ueepb_contact_form7 ' . $this->get_render_attribute_string( 'shortcode' ) . ']' );
			?>
		</div>
		<?php
	}
}

