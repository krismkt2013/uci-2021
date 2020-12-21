<?php

class UEEPB_Form_Manager{

	public function __construct(){
		add_shortcode('ueepb_form_manager', array($this, 'form_manager'));
	}

    public function form_manager($settings,$content){
        global $ueepb,$ueepb_contact_form7_params;

        $display = "";

        if(isset($settings['ueepb_form_type'])){
            switch ($settings['ueepb_form_type']) {
                case 'ninja_forms':
                    $display = $this->ninja_forms($settings,$content);
                    break;
                case 'everest_forms':
                    $display = $this->everest_forms($settings,$content);
                    break;
                case 'formidable_forms':
                    $display = $this->formidable_forms($settings,$content);
                    break;
                default:
                    # code...
                    break;
            }
        }

        return $display;
    } 

	public function everest_forms($settings,$content){
        global $ueepb,$ueepb_params;

        $form_id = isset($settings['form_id']) ? trim($settings['form_id']) : '';
        $display = '';
        if($form_id != ''){

            if($ueepb->private_content->verify_permission($settings,$content)){
                $display = do_shortcode('[everest_form id="'.$settings['form_id'].'" ]');
            }else{
                $display = $settings['message'];
            }
            
        }       

        return $display;
    }  

    public function ninja_forms($settings,$content){
        global $ueepb,$ueepb_params;

        $form_id = isset($settings['form_id']) ? (int) $settings['form_id'] : '0';
        $display = '';
        if($form_id != '0'){
            if($ueepb->private_content->verify_permission($settings,$content)){ 
                $display = do_shortcode('[ninja_form  id="'.$settings['form_id'].'" ]');
            }else{
                $display = $settings['message'];
            }            
        }       

        return $display;
    }  

    public function formidable_forms($settings,$content){
        global $ueepb,$ueepb_params;

        $form_id = isset($settings['form_id']) ? trim($settings['form_id']) : '';
        $display = '';
        if($form_id != ''){

            if($ueepb->private_content->verify_permission($settings,$content)){
                $display = do_shortcode('[formidable id="'.$settings['form_id'].'" ]');
            }else{
                $display = $settings['message'];
            }
            
        }       

        return $display;
    }
}