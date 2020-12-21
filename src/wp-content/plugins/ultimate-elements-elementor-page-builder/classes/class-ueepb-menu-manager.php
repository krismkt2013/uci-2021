<?php

class UEEPB_Menu_Manager{

	public function __construct(){
		add_shortcode('ueepb_navigation_menu', array($this, 'navigation_menu'));
	}

	public function navigation_menu($menu_settings){
        global $ueepb,$ueepb_menu_params;


        $menu_id = isset($menu_settings['menu_id']) ? (int) $menu_settings['menu_id'] : '0';
        $display = '';
        if($menu_id != '0'){
            $display = wp_nav_menu(
                array(                
                    'menu' => sanitize_text_field($menu_id),
                    'echo' => false
                )
            );
        }       

        return $display;
    }    
}