<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_Formidable_Forms extends Widget_Base {

	public function get_name() {
		return 'ueepb-formidable-forms';
	}

	public function get_title() {
		return __( 'Formidable Forms', 'ueepb' );
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
		global $ueepb_formidable_forms,$wp_roles,$wpdb;
		
		$this->start_controls_section(
			'section_ueepb_formidable_forms',
			[
				'label' => __( 'Formidable Forms', 'ueepb' ),
			]
		);

		$form_list = array('0' => __( 'Select Form', 'ueepb' ));
		

        $sql_total  = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}frm_forms WHERE status = '%s'  ", "published" );
        $result_total = $wpdb->get_results($sql_total);
        if($result_total){
        	foreach ($result_total as $key => $result) {
        		$form_list[$result->id] = $result->name;
        	}
        }


		$this->add_control(
			'ueepb_formidable_forms_form',
			[
				'label' => __( 'Form Name', 'ueepb' ),
				'type' => Controls_Manager::SELECT2,
				'default' => '0',
				'options' => $form_list,
			]
		);

		$this->add_control(
			'ueepb_formidable_forms_restricted_message',
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
			'ueepb_formidable_forms_visibility',
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
			'ueepb_formidable_forms_user_roles',
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

		if ( ! $settings['ueepb_formidable_forms_form'] ) {
			return;
		}

		$id_int = substr( $this->get_id_int(), 0, 3 );
		$this->add_render_attribute( 'shortcode', 'id_int', $id_int );

		$this->add_render_attribute( 'shortcode', 'form_id', $settings['ueepb_formidable_forms_form'] );


		if ( isset($settings['ueepb_formidable_forms_restricted_message'] ) ) {
			$this->add_render_attribute( 'shortcode', 'message', sanitize_text_field($settings['ueepb_formidable_forms_restricted_message']) );
		}
		if ( isset($settings['ueepb_formidable_forms_visibility'] ) ) {
			$this->add_render_attribute( 'shortcode', 'visibility', sanitize_text_field($settings['ueepb_formidable_forms_visibility']) );
		}
		if ( isset($settings['ueepb_formidable_forms_user_roles'] ) ) {
			$this->add_render_attribute( 'shortcode', 'user_role', sanitize_text_field($settings['ueepb_formidable_forms_user_roles']) );
		}
				
		?>
		<div class="ueepb-form-panel ueepb-formidable-forms-panel">
			<?php
			echo do_shortcode( '[ueepb_form_manager ueepb_form_type="formidable_forms"  ' . $this->get_render_attribute_string( 'shortcode' ) . ']' );
			?>
		</div>
		<?php
	}
}

