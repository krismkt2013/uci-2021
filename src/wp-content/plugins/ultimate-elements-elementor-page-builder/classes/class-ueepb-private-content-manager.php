<?php

class UEEPB_Private_Content_Manager{

	public function __construct(){
		add_shortcode('ueepb_private_content', array($this, 'private_content'));
	}

	public function private_content($settings,$content){
        global $ueepb,$ueepb_private_content_params;


        $message = isset($settings['message']) ? $settings['message'] : '';
        $visibility = isset($settings['visibility']) ? $settings['visibility'] : 'all';
        $user_role = isset($settings['user_role']) ? $settings['user_role'] : '0';
// echo $visibility;exit;
        $display = '';
        switch ($visibility) {
            case 'all':
                $display = $content; 
                break;

            case 'guests':
                if(is_user_logged_in()){
                    $display = $message;
                }else{
                    $display = $content; 
                }
                break;

            case 'members':
                if(!is_user_logged_in()){
                    $display = $message;
                }else{
                    $display = $content; 
                }
                break;

            case 'user_roles':
                $user_roles = $ueepb->user->get_user_roles_by_id(get_current_user_id())
                ;
                
                $role_matched = false;
                foreach ($user_roles as $key => $role) {
                    if($user_role == $role){
                        $role_matched = true;
                    }
                }

                if($role_matched){
                    $display = $content; 
                }else{
                    $display = $message; 
                }
                break;
        }    

        return $display;
    }

    public function verify_permission($settings,$content){
        global $ueepb,$ueepb_private_content_params;


        $message = isset($settings['message']) ? $settings['message'] : '';
        $visibility = isset($settings['visibility']) ? $settings['visibility'] : 'all';
        $user_role = isset($settings['user_role']) ? $settings['user_role'] : '0';

        $status = false;
        switch ($visibility) {
            case 'all':
                $status = true;
                break;

            case 'guests':
                if(!is_user_logged_in()){
                    $status = true;
                }
                break;

            case 'members':
                if(is_user_logged_in()){
                    $status = true;
                }
                break;

            case 'user_roles':
                $user_roles = $ueepb->user->get_user_roles_by_id(get_current_user_id())
                ;
                
                $role_matched = false;
                foreach ($user_roles as $key => $role) {
                    if($user_role == $role){
                        $role_matched = true;
                    }
                }

                if($role_matched){
                    $status = true; 
                }
                break;
        }    
        
        return $status;
    }    
}