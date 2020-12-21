<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_Private_Content extends Widget_Base {

	public function get_name() {
		return 'ueepb-private-content';
	}

	public function get_title() {
		return __( 'Private Content', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-lock ueepb-element-icon';
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
		global $wp_roles;

		$this->start_controls_section(
			'section_ueepb_private_content',
			[
				'label' => __( 'Private Content', 'ueepb' ),
			]
		);

		$this->add_control(
			'ueepb_private_content',
			[
				'label' => __( 'Private Content', 'ueepb' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => '',
			]
		);

		$this->add_control(
			'ueepb_private_content_restricted_message',
			[
				'label' => __( 'Content Restricted Message', 'ueepb' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
			]
		);

		$visibility_type = array('all' => __('All Users','ueepb'),
			'guests' => __('Guests','ueepb'), 'members' => __('Members','ueepb'),
			'user_roles' => __('User Roles','ueepb'));

		$this->add_control(
			'ueepb_private_content_visibility',
			[
				'label' => __( 'Content Visibility', 'ueepb' ),
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
			'ueepb_private_content_user_roles',
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

		if ( ! $settings['ueepb_private_content_visibility'] ) {
			return;
		}

		$id_int = substr( $this->get_id_int(), 0, 3 );
		$this->add_render_attribute( 'shortcode', 'id_int', $id_int );

		if ( isset($settings['ueepb_private_content_restricted_message'] ) ) {
			$this->add_render_attribute( 'shortcode', 'message', sanitize_text_field($settings['ueepb_private_content_restricted_message']) );
		}
		if ( isset($settings['ueepb_private_content_visibility'] ) ) {
			$this->add_render_attribute( 'shortcode', 'visibility', sanitize_text_field($settings['ueepb_private_content_visibility']) );
		}
		if ( isset($settings['ueepb_private_content_user_roles'] ) ) {
			$this->add_render_attribute( 'shortcode', 'user_role', sanitize_text_field($settings['ueepb_private_content_user_roles']) );
		}
		
		?>
		<div class="ueepb-private-content">
			<?php
			echo do_shortcode( '[ueepb_private_content ' . $this->get_render_attribute_string( 'shortcode' ) . ']'.wp_kses_post($settings['ueepb_private_content']).'[/ueepb_private_content]' );
			?>
		</div>
		<?php
	}
}

