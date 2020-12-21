<?php

/**
 * Elementor select2 control.
 *
 * A base control for creating select2 control. Displays a select box control
 * based on select2 jQuery plugin @see https://select2.github.io/ .
 * It accepts an array in which the `key` is the value and the `value` is the
 * option name. Set `multiple` to `true` to allow multiple value selection.
 *
 * @since 1.0.0
 */
class UEEPB_Select2 extends \Elementor\Base_Data_Control {

	/**
	 * Get select2 control type.
	 *
	 * Retrieve the control type, in this case `select2`.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'ueepb_select2';
	}

	public function enqueue() {
		// Styles
		wp_register_script('ueepb-select2', UEEPB_PLUGIN_URL.'js/ueepb-select2.js', array('jquery','jquery-elementor-select2'));
		wp_enqueue_script('ueepb-select2');

		$custom_js_strings = array(        
            'AdminAjax' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wppcp-private-admin'),
        );

        wp_localize_script('ueepb-select2', 'UEEPBFront', $custom_js_strings);

		wp_enqueue_style( 'elementor-select2' );

		wp_register_style('ueepb-select2', UEEPB_PLUGIN_URL . 'css/ueepb-front.css');
        wp_enqueue_style('ueepb-select2');
	}

	/**
	 * Get select2 control default settings.
	 *
	 * Retrieve the default settings of the select2 control. Used to return the
	 * default settings while initializing the select2 control.
	 *
	 * @since 1.8.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'options' => [],
			'multiple' => false,
			'select2options' => [],
			'ueepb_class' => ''
		];
	}

	/**
	 * Render select2 control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		// $widget_id = $this->get_id();
		?>
		<div class="elementor-control-field">
			<# if ( data.label ) {#>
				<label for="<?php echo $control_uid; ?>-<?php echo $widget_id; ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>
			
			<div class="elementor-control-input-wrapper ueepb-select2-wrapper {{{ data.ueepb_class }}}">
				<# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
				<select id="<?php echo $control_uid; ?>" class="elementor-select2 ueepb-select2 {{{data.ueepb_class}}}" type="select2" data-placeholder="Please Select" {{ multiple }} data-setting="{{ data.name }}">
					<# _.each( data.options, function( option_title, option_value ) {
						var value = data.controlValue;
						if ( typeof value == 'string' ) {
							var selected = ( option_value === value ) ? 'selected' : '';
						} else if ( null !== value ) {
							var value = _.values( value );
							var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
						}
						#>
					<option {{ selected }} value="{{ option_value }}">{{{ option_title }}}</option>
					<# } ); #>
				</select>
				
			</div>
			</div>
			</div>
		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
