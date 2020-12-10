<?php

add_action('wp_ajax_bravepop_form_submission', 'bravepop_form_submission', 0);
add_action('wp_ajax_nopriv_bravepop_form_submission', 'bravepop_form_submission');

function bravepop_form_submission(){

   if(!isset($_POST['popupID']) || !isset($_POST['stepID'])  || !isset($_POST['device'])  || !isset($_POST['formID'])  || !isset($_POST['formData']) ){ wp_die(); }
   
   // First check the nonce, if it fails the function will break
   $securityPassed = check_ajax_referer('brave-ajax-form-nonce', 'security', false);
   if($securityPassed === false) {
      print_r(json_encode(array('sent'=>false, 'message'=>__('Error Sending! Please reload the page and try again.', 'bravepop'))));
      wp_die();
   }


   // Nonce is checked, get the POST data and sign user on
   $popupID = sanitize_text_field(wp_unslash($_POST['popupID']));
   $popupStep = sanitize_text_field(wp_unslash($_POST['stepID']));
   $popupDevice = sanitize_text_field(wp_unslash($_POST['device']));
   $elementID = sanitize_text_field(wp_unslash($_POST['formID']));
   $newsletterCookieConditions = isset($_POST['cookieConditions']) ? json_decode(stripslashes($_POST['cookieConditions'])) : false;
   $formData = json_decode(stripslashes($_POST['formData']));
   $userQuizData = isset($_POST['quizData']) ? json_decode(stripslashes($_POST['quizData'])) : new stdClass();
   //error_log('userQuizData: '. json_encode($userQuizData));
   //Fetch Form Settings
   $popupData = json_decode(get_post_meta($popupID, 'popup_data', true));

   if(isset($_POST['brave_previewID']) && function_exists('bravepop_demo_form_popup_data')){
      $previewPopupData = bravepop_demo_form_popup_data($_POST['brave_previewID']);
      if($previewPopupData){
         $popupData = json_decode($previewPopupData);
      }
   }
   
   //Incorporate Field Settings with Given Value
   $popupContent =  isset($popupData->steps[$popupStep]->$popupDevice->content) ? $popupData->steps[$popupStep]->$popupDevice->content : array();
   $fieldSettings = new stdClass();
   $actionSettings = new stdClass();
   $formOptions = new stdClass();

   foreach ($popupContent as $key => $element) {
      if($element->id === $elementID){
         if(isset($element->formData->settings->action)){   $actionSettings = $element->formData->settings->action;    }
         if(isset($element->formData->settings->options)){   $formOptions = $element->formData->settings->options;    }
         if(isset($element->formData->fields)){ 
            
            foreach ($element->formData->fields as $key => $field) {
               $fieldID = $field->id;
               $fieldSettings->$fieldID  = $field;
               $fieldKey = isset($field->uid) ? $field->uid : '';
               $fieldKey2 = isset($field->uidl) ? $field->uidl : '';
               
                  foreach ((array)$formData as $fID => $fVal) {
                     
                     if($fID === $fieldID){

                        $fieldSettings->$fieldID->value = $fVal;
   
                        //Assign shortcode Values
                        if($fieldKey){
                           if(isset($fVal) && is_string($fVal)){
                              $fieldSettings->$fieldID->$fieldKey = strip_tags($fVal);
                           }  
      
                           if(isset($fVal) && is_array($fVal)){
                              $arrayVal = implode(", ", $fVal);
                              $fieldSettings->$fieldID->$fieldKey = strip_tags($arrayVal);
                           }
      
                           if(isset($fVal) && is_array($fVal) && $field->type === 'input' && $field->validation === 'name'){
                              $firstname = isset($fVal[0]) ? strip_tags($fVal[0]) : '';
                              $lastname = isset($fVal[1]) ? strip_tags($fVal[1]) : '';
                              $fieldSettings->$fieldID->$fieldKey = $firstname;
                              if($fieldKey2){
                                 $fieldSettings->$fieldID->$fieldKey2 = $lastname;
                              }
                           }
                        }
                        /////END////

                     }
                  }
               
               

            }
         }
         
      }
   }

   //error_log(json_encode($fieldSettings));

   //Validatation: Check if Required Fields are empty or not.
   foreach ((array)$fieldSettings as $key => $field) {
      if(isset($field->required) && $field->required === true){
         if(isset($field->type) && $field->type !== 'step'){ 
            if((!isset($field->value) || !$field->value) ){
               print_r(json_encode(array('sent'=>false, 'id' => $key, 'type'=> 'required', 'message' => __('Required.', 'bravepop'))));
               wp_die();
            }
            if(isset($field->value) && $field->type ==='select'  && $field->value === 'none'){
               print_r(json_encode(array('sent'=>false, 'id' => $key, 'type'=> 'required', 'message' => __('Required.', 'bravepop'))));
               wp_die();
            }
            if((!isset($field->value) || !$field->value)  && isset($field->validation) && $field->validation === 'name'){
               if(!$field->value[0] || !$field->value[1]){
                  print_r(json_encode(array('sent'=>false, 'id' => $key, 'type'=> 'required', 'message' => __('Required.', 'bravepop'), 'firstname'=> !$field->value[0] ? true : false, 'lastname'=>  !$field->value[1] ? true : false)));
                  wp_die();
               }
            }
         }
      }
   }

   //error_log('NO ERRORS! CONTINUING....');

   //Get Currently Logged in User Data.
   $current_user = bravepop_getCurrentUser();
   $visitor_country = bravepopup_getvisitorCountry();
   $visitor_ip = bravepop_getVisitorIP();


   $userData = array('ip'=> $visitor_ip, 'country'=> $visitor_country, 'ID' => get_current_user_id());
   do_action( 'bravepop_user_submitted_form', $popupID, $elementID, $fieldSettings, $userData);

   //SEND EMAIL TO ADMINS
   if($actionSettings && isset($actionSettings->recieveEmail) && isset($actionSettings->recieveEmail->enable) && $actionSettings->recieveEmail->enable === true){
      if(isset($actionSettings->recieveEmail->emails) && isset($actionSettings->recieveEmail->subject)){
         $custom =  isset($actionSettings->recieveEmail->custom) && $actionSettings->recieveEmail->custom === true ? true : false; 
         $sendto =  $actionSettings->recieveEmail->emails;
         $subject = wp_iso_descrambler(bravepop_replace_emailShortcodes($actionSettings->recieveEmail->subject, $fieldSettings, $userQuizData));
         $headers = array(
            'Content-Type: text/plain;',
            'From: '.wp_iso_descrambler(get_bloginfo('name')).' <'.(get_bloginfo('admin_email')).'>',
         );
         //$headers .= 'Content-Type: text/plain; From: "'.wp_iso_descrambler(get_bloginfo('name')).'" <'.(get_bloginfo('admin_email')).'>';

         $replyTo = '';

         if($custom && isset($actionSettings->recieveEmail->message) ){
            //User Template Message
            $message = bravepop_replace_emailShortcodes($actionSettings->recieveEmail->message, $fieldSettings, $userQuizData);
            $formattedMsg = json_encode($message);
            $theMessage =  str_replace('\n', '\r\n',  $formattedMsg);
            $theMessage = json_decode($theMessage);
         }else{
            //Auto Generated Message
            $theMessage  = "\r\n";
            foreach ((array)$fieldSettings as $key => $field) {
               $defaultKey = isset($field->label) ? $field->label : ''; 
               $defaultKey = !$defaultKey && isset($field->placeholder) ? $field->placeholder : $defaultKey;

               $fieldKey = isset($field->uid) ? $field->uid : $defaultKey;
               $fieldValue = isset($field->value) && is_string($field->value) && $field->value ? strip_tags($field->value) : '';
               $fieldValue = isset($field->value) && is_array($field->value) && $field->value ? strip_tags(implode(", ", $field->value)) : $fieldValue;
               
               if(isset($field->value) && is_array($field->value) && $field->type === 'input' && $field->validation === 'name'){
                  $defaultKey2 = isset($field->secondLabel) ? $field->secondLabel : ''; 
                  $defaultKey2 = !$defaultKey && isset($field->secondPlaceholder) ? $field->secondPlaceholder : $defaultKey2;

                  $fieldKey2 = isset($field->uidl) ? $field->uidl : $defaultKey2;
                  $lastname = isset($field->value[1]) && $field->value[1] ? $field->value[1] : '';
                  $theMessage .= $fieldKey.": ".$fieldValue."\r\n";
                  $theMessage .= $fieldKey2.": ".$lastname."";
                  $theMessage .= "\r\n\r\n";
               }else{
                  if($field->type !== 'step' && $field->type !== 'media'){
                     $newline = $field->type === 'textarea' ? "\r\n" : ""; 
                     $theMessage .= $fieldKey.": ".$newline.$fieldValue."";
                     $theMessage .= "\r\n\r\n";
                  }
                  if(!$replyTo && $field->type === 'input' && $field->validation === 'email' && filter_var($fieldValue, FILTER_VALIDATE_EMAIL)){
                     $replyTo = $fieldValue;
                  }
               }
            }
         }

         if(!empty($actionSettings->recieveEmail->userdata)){
            $user_name = '';
            if(!empty($current_user['name']) && !empty($current_user['username'])){
               $user_name = ': '.$current_user['name'].' ('.$current_user['username'].')';
            }else if(empty($current_user['name']) && !empty($current_user['username'])){
               $user_name = ': '.$current_user['username'];
            }
            $user_type = (!empty($current_user['username']) ?  __('Registered User', 'bravepop') : __('a Visitor ', 'bravepop'));
            $user_country = ($visitor_country ? 'from '.$visitor_country : ' ').($visitor_ip ? ', ip: '. $visitor_ip .'' : '');
            $theMessage .= "------------------------------------------------------------------------------------------------------------------------\r\n";
            $theMessage .= __('Form Submitted by ', 'bravepop').$user_type.$user_name.$user_country ; 
         }

         if($replyTo){ $headers[] = 'Reply-To: <'.$replyTo.'>'; }

         wp_mail( $sendto, $subject, $theMessage, $headers);

      }
   }


   //SEND EMAIL TO USERS
   if($actionSettings && isset($actionSettings->sendEmail) && isset($actionSettings->sendEmail->enable) && $actionSettings->sendEmail->enable === true){
      $emailAddress = '';
      foreach ((array)$fieldSettings as $key => $field) {
         if(!$emailAddress && isset($field->type) && isset($field->validation) && isset($field->value) && $field->type ==='input' && $field->validation ==='email' && $field->value){
            $emailAddress = $field->value;
         }
      }

      if($emailAddress){
         $sendto =  $emailAddress;
         $subject = wp_iso_descrambler(bravepop_replace_emailShortcodes($actionSettings->sendEmail->subject, $fieldSettings, $userQuizData));
         $contentType = isset($actionSettings->sendEmail->type) && ($actionSettings->sendEmail->type ==='advanced' || $actionSettings->sendEmail->type ==='html') ? 'html' : 'plain';
         $fromName = !empty($actionSettings->sendEmail->emailfromname) ? $actionSettings->sendEmail->emailfromname : wp_iso_descrambler(get_bloginfo('name'));
         //By default WP Emails are sent from wordpress@mysite.com because if email domain and the server domain dont match they go to spam. 
         //But Brave overrides this with info@mysite.com for professional appearance, if the admin email does not contain mysite.com  
         $sitedomain = wp_parse_url( network_home_url(), PHP_URL_HOST ); if ( 'www.' === substr( $sitedomain, 0, 4 ) ) { $sitedomain = substr( $sitedomain, 4 ); } //wp-includes/pluggable.php#L182
         $fromEmail = 'info@' . $sitedomain; $adminEmail = get_bloginfo('admin_email');
         if((strpos($adminEmail, $sitedomain) !== false) || (strpos($sitedomain, 'localhost') !== false)){
            $fromEmail = $adminEmail;
         }

         $headers = array(
            'Content-Type: text/'.$contentType.';',
            'From: '.$fromName.' <'.(!empty($actionSettings->sendEmail->emailfrom) ? $actionSettings->sendEmail->emailfrom : $fromEmail).'>',
            'Reply-To: '.$fromName.' <'.(!empty($actionSettings->sendEmail->emailreplyto) ? $actionSettings->sendEmail->emailreplyto : $adminEmail ).'>',
         );

         $messageRaw = isset($actionSettings->sendEmail->message) ? $actionSettings->sendEmail->message : '';
         if(isset($actionSettings->sendEmail->type) && $actionSettings->sendEmail->type === 'advanced' && isset($actionSettings->sendEmail->advancedText) ){ 
             $messageRaw = $actionSettings->sendEmail->advancedText;
         }
         if(isset($actionSettings->sendEmail->type) && $actionSettings->sendEmail->type === 'html' && isset($actionSettings->sendEmail->html) ){ 
            $messageRaw = $actionSettings->sendEmail->html;
         }
         $message = bravepop_replace_emailShortcodes($messageRaw, $fieldSettings, $userQuizData);
         if($contentType === 'html'){
            $theMessage = html_entity_decode($message); 
         }else{
            $formattedMsg = json_encode($message);
            $theMessage =  str_replace('\n', '\r\n',  $formattedMsg);
            $theMessage = json_decode($theMessage);
         }
         wp_mail( $sendto, $subject, $theMessage, $headers);
      }
   }

   //Add to Newsletter
   if($actionSettings && isset($actionSettings->newsletter) && isset($actionSettings->newsletter->enable) && $actionSettings->newsletter->enable === true){
      $type = isset($actionSettings->newsletter->enable) ? $actionSettings->newsletter->type : '';
      $listID = isset($actionSettings->newsletter->listID) ? $actionSettings->newsletter->listID : '';
      $emailField = isset($actionSettings->newsletter->emailField) ? $actionSettings->newsletter->emailField : '';
      $nameField = isset($actionSettings->newsletter->nameField) ? $actionSettings->newsletter->nameField : '';
      $phoneField = isset($actionSettings->newsletter->phoneField) ? $actionSettings->newsletter->phoneField : '';
      $customFields = array(); $tags = array();
      //error_log($type .' '. $listID .' '. $emailField);

      if(!empty($actionSettings->newsletter->advanced)){
         $listID = !empty($actionSettings->newsletter->advancedSettings->defaultList) ? $actionSettings->newsletter->advancedSettings->defaultList : '';
         $tags = !empty($actionSettings->newsletter->advancedSettings->defaultTags) ? $actionSettings->newsletter->advancedSettings->defaultTags : array();   
      }

      //error_log(json_encode($actionSettings->newsletter));
      if($type && ($type==='zohocrm' || $listID || !empty($actionSettings->newsletter->advanced)) && $emailField){
         $emailValue = '';
         $nameValue = '';
         $phoneValue = '';
         //Get the Email and Name values from the FORM
         foreach ((array)$fieldSettings as $key => $field) {
            if($emailField && isset($field->id) && $field->id === $emailField){
               $emailValue = $field->value;
            }
            if($emailField && isset($field->id) && $field->id === $nameField){
               $nameValue = $field->value;
            }
            if($emailField && isset($field->id) && $field->id === $phoneField){
               $phoneValue = $field->value;
            }
         }

         //Conditional Subscription
         if(!empty($actionSettings->newsletter->advanced) && function_exists('bravepop_get_conditional_list')){
            if( !empty($actionSettings->newsletter->advancedSettings->conditional) && !empty($actionSettings->newsletter->advancedSettings->conditions)){
               $defaultList = !empty($actionSettings->newsletter->advancedSettings->defaultList) ? $actionSettings->newsletter->advancedSettings->defaultList : '';
               $defaultTags = !empty($actionSettings->newsletter->advancedSettings->defaultTags) ? $actionSettings->newsletter->advancedSettings->defaultTags : array();   
               $matchedLisTags = bravepop_get_conditional_list($defaultList, $defaultTags, $fieldSettings, $actionSettings->newsletter->advancedSettings->conditions, $newsletterCookieConditions, isset($formOptions->type) && $formOptions->type === 'quiz' ? $userQuizData : false);
               if(!empty($matchedLisTags)){
                  $listID = isset($matchedLisTags['list']) ? $matchedLisTags['list'] : $listID;
                  $tags = isset($matchedLisTags['tags']) ? $matchedLisTags['tags'] : $tags;
               }
            }
         }

         //Custom Fields
         if(!empty($actionSettings->newsletter->advanced) && function_exists('bravepop_get_newsletter_customFields') && !empty($actionSettings->newsletter->advancedSettings->fields)){
            $customFields = bravepop_get_newsletter_customFields($fieldSettings, $actionSettings->newsletter->advancedSettings->fields, isset($formOptions->type) && $formOptions->type === 'quiz' ? $userQuizData : false);
         }

         //If the name field is empty and the user is logged in, get the current users name
         //if(!empty($current_user['name']) && empty($nameValue)){  $nameValue = $current_user['name'];  }
         
         //Finaly Add the User to Newsletter
         if(function_exists('bravepop_add_to_newsletter')){
            $subScriptionSuccess = bravepop_add_to_newsletter('form', $type, $emailValue, $listID, $nameValue, $phoneValue, $customFields, $tags);
            if(!$subScriptionSuccess){
               $emailSent = bravepop_subscription_failed_notificaion($popupID, get_option('admin_email'), $type, $nameValue, $emailValue);
            }
         }


       }

   }

   
   //Send to Zapier/Integromat
   if($actionSettings && isset($actionSettings->webhook) && isset($actionSettings->webhook->enable)  && isset($actionSettings->webhook->url) && $actionSettings->webhook->enable === true && $actionSettings->webhook->url){
      //error_log('PUSH to WebHook');
      $webhook = new BravePop_Webhook();
      $webhook->post($actionSettings->webhook->url, $actionSettings->webhook->type, $fieldSettings, $current_user, $visitor_country, $visitor_ip);
   }

   //FINALLY SEND RESPONSE TO USER-------------------------------------
      $response = array('sent'=> true);
      // Show Custom Message
      if($actionSettings && isset($actionSettings->primaryAction) && $actionSettings->primaryAction === 'content' && isset($actionSettings->primaryActionData->content)){
         $response['primaryAction'] = 'content';
         $response['contentMessage'] = nl2br(bravepop_replace_emailShortcodes(html_entity_decode($actionSettings->primaryActionData->content), $fieldSettings, $userQuizData));
         if(isset($actionSettings->primaryActionData->download) && isset($actionSettings->primaryActionData->downloadURL)){
            $response['download'] = true;
            $response['downloadURL'] = $actionSettings->primaryActionData->downloadURL;
         }
         if(!empty($actionSettings->primaryActionData->autoclose) && isset($actionSettings->primaryActionData->autoclosetime)){
            $response['autoclose'] = true;
            $response['autoclosetime'] = $actionSettings->primaryActionData->autoclosetime;
         }
      }
      // Open Another Popup
      if($actionSettings && isset($actionSettings->primaryAction) && $actionSettings->primaryAction === 'popup' && isset($actionSettings->primaryActionData->popup)){
         $response['primaryAction'] = 'popup';
         $response['popupID'] = $actionSettings->primaryActionData->popup;
      }

      // Go to Another Step
      if($actionSettings && isset($actionSettings->primaryAction) && $actionSettings->primaryAction === 'step' && isset($actionSettings->primaryActionData->step)){
         $response['primaryAction'] = 'step';
         $response['step'] = $actionSettings->primaryActionData->step;
         if(!empty($actionSettings->primaryActionData->conditionalStep) && isset($actionSettings->primaryActionData->stepConditions) && function_exists('bravepop_get_conditional_redirection_data')){
            $response['step'] = bravepop_get_conditional_redirection_data('step',$actionSettings->primaryActionData->step, $actionSettings->primaryActionData->stepConditions, $fieldSettings, $userQuizData);
         }
      }

      // Redirect User
      if($actionSettings && isset($actionSettings->primaryAction) && $actionSettings->primaryAction === 'redirect' && isset($actionSettings->primaryActionData->redirect)){
         $response['primaryAction'] = 'redirect';
         $response['redirectURL'] = bravepop_replace_emailShortcodes($actionSettings->primaryActionData->redirect, $fieldSettings, $userQuizData);
         $response['redirectAfter'] = isset($actionSettings->primaryActionData->redirectAfter) ? $actionSettings->primaryActionData->redirectAfter : '';
         $response['redirectMessage'] = isset($actionSettings->primaryActionData->redirectMessage) ? nl2br(bravepop_replace_emailShortcodes(html_entity_decode($actionSettings->primaryActionData->redirectMessage), $fieldSettings, $userQuizData)) : '';
         if(!empty($actionSettings->primaryActionData->conditionalRedirect) && isset($actionSettings->primaryActionData->redirectConditions) && function_exists('bravepop_get_conditional_redirection_data')){
            $response['redirectURL'] = bravepop_get_conditional_redirection_data('redirect',$actionSettings->primaryActionData->redirect, $actionSettings->primaryActionData->redirectConditions, $fieldSettings, $userQuizData);
         }
      }

      print_r(json_encode($response));

      wp_die();
}


add_action('wp_ajax_bravepopup_validate_recaptcha', 'bravepopup_validate_recaptcha', 0);
add_action('wp_ajax_nopriv_bravepopup_validate_recaptcha', 'bravepopup_validate_recaptcha');

function bravepopup_validate_recaptcha(){
   if(!isset($_POST['token']) ){ wp_die(); }

   $securityPassed = check_ajax_referer('brave-ajax-form-nonce', 'security', false);

   if($securityPassed === false) {
      print_r(json_encode(false));
      wp_die();
   }else{
      $currentSettings = get_option('_bravepopup_settings');
      $currentIntegrations = $currentSettings && isset($currentSettings['integrations']) ? $currentSettings['integrations'] : array() ;
      $reCAPTCHA_secret = isset($currentIntegrations['recaptcha']->secret)  ? $currentIntegrations['recaptcha']->secret  : '';
      $response = $_POST['token']; $user_ip = bravepop_getVisitorIP();
      $args = array(
         'method' => 'POST',
         'body' => array('secret'=> $reCAPTCHA_secret, 'response'=> $_POST['token'], 'remoteip'=> bravepop_getVisitorIP() )
         //'body'=> `secret=${reCAPTCHA_secret}&response=${response}&remoteip=${user_ip}`
      );

      $fieldsResponse = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', $args );

      if( !is_wp_error( $fieldsResponse ) ) {
         $response_body = json_decode( $fieldsResponse['body'] );

         if ( !empty( $response_body->success ) && $response_body->score > 0.4 ) {
            print_r(json_encode(true));
            wp_die();
         }else{
            print_r(json_encode(false));
            wp_die();
         }
      }else{
         print_r(json_encode(false));
         wp_die();
      }
   }
   wp_die();
}


function bravepop_replace_emailShortcodes($message, $fieldValues, $userQuizData=false){
   $finalMessage = $message;
   //error_log(json_encode($userQuizData));
   if($userQuizData && isset($userQuizData->availableScore)){
      $finalMessage = str_replace('[available_score]', $userQuizData->availableScore, $finalMessage);
   }
   if($userQuizData && isset($userQuizData->userScore)){
      $finalMessage = str_replace('[total_score]', $userQuizData->userScore, $finalMessage);
   }
   if($userQuizData && isset($userQuizData->userCorrect)){
      $finalMessage = str_replace('[total_correct_answers]', $userQuizData->userCorrect, $finalMessage);
   }
   if($userQuizData && isset($userQuizData->totalQuestions)){
      $finalMessage = str_replace('[total_questions]', $userQuizData->totalQuestions, $finalMessage);
   }

   if($userQuizData && (strpos($finalMessage, '[brave_quizcondition') !== false)){
      $finalMessage =  str_replace('[brave_quizcondition', '[brave_quizcondition score="'.$userQuizData->userScore.'" correct="'.$userQuizData->userCorrect.'" type="'.(isset($userQuizData->scoring) ? $userQuizData->scoring : 'points').'"', $finalMessage);
      $finalMessage = do_shortcode($finalMessage);
   }

   if($fieldValues){
      $regex = "/\[(.*?)\]/";
      preg_match_all($regex, $message, $matches);
      for ($i=0; $i < count($matches[1]) ; $i++) { 
         $match = $matches[1][$i];
         $newvalue = bravepop_get_emailShortcode_value($match, $fieldValues);
         $finalMessage = str_replace($matches[0][$i], $newvalue, $finalMessage);
      }
   }

   return $finalMessage ;
}

function bravepop_get_emailShortcode_value($key, $fieldValues){
   $fieldKey = str_replace(array( '[', ']' ), '', $key);
   $fieldValue = '';
   foreach ($fieldValues as $key => $field) {
      if(isset($field->$fieldKey)){
         $fieldValue = $field->$fieldKey;
      }
   }
   return $fieldValue;
}