<?php

class UEEPB_Contact_Form7_Manager{

	public function __construct(){
		add_shortcode('ueepb_contact_form7', array($this, 'contact_form7'));
	}

	public function contact_form7($settings){
        global $ueepb,$ueepb_contact_form7_params;

        $form_id = isset($settings['form_id']) ? (int) $settings['form_id'] : '0';
        $display = '';
        if($form_id != '0'){
            $display = do_shortcode('[contact-form-7 id="'.$settings['form_id'].'" ]');
        }       

        return $display;
    }    
}