<?php

if ( ! class_exists( 'BravePop_Element_Form' ) ) {
   

   class BravePop_Element_Form {

      function __construct($data=null, $popupID=null, $stepIndex, $elementIndex, $device='desktop', $goalItem=false) {
         $this->data = $data;
         $this->popupID = $popupID;
         $this->stepIndex =  $stepIndex;
         $this->elementIndex = $elementIndex;
         $this->device = $device;
         $this->nolabel = $this->has_noLabel();
         $this->ratingStyles = '';
         $this->hasDate = false;
         $this->totalSteps = 0;
         $this->changesFormHeight = false;
         $this->recaptcha = false;
         $this->formHeightData = array(isset($data->height) ? $data->height : '');
         $this->wrappedSteps = 1;
         $this->goalItem = $goalItem;
         $this->buttonGroupStyles = '';
         //Check if Fields has date or steps
         $this->has_dateOrSteps();
         if($this->totalSteps > 0){ $this->totalSteps = $this->totalSteps+1;}
         //error_log('Total Steps: '.$this->totalSteps);

         if($this->hasDate){
            add_action( 'wp_footer', array( $this, 'enqueue_date_js' ), 10 );
         }
         if(!empty($this->data->formData->settings->action->recaptcha)){
            $currentSettings = get_option('_bravepopup_settings');
            $currentIntegrations = $currentSettings && isset($currentSettings['integrations']) ? $currentSettings['integrations'] : array() ;
            $reCAPTCHA_site_key = isset($currentIntegrations['recaptcha']->api)  ? $currentIntegrations['recaptcha']->api  : '';
            $this->recaptcha = $reCAPTCHA_site_key;
            add_action( 'wp_footer', array( $this, 'enqueue_recaptcha_js' ), 10 );
         }

      }

      public function has_dateOrSteps() { 
         if(isset($this->data->formData->fields)){
            foreach ($this->data->formData->fields as $index => $field) {
               if(isset($field->type) && $field->type === 'step' && ($index !== 0 && $index !== count($this->data->formData->fields) - 1)){ 
                  $this->totalSteps = $this->totalSteps+1; 
               }
               if(isset($field->type) && $field->type === 'date'){ $this->hasDate = true; }
            }
         }
      }

      public function has_noLabel() { 
         $noLabel = false;
         if(isset($this->data->formData->fields)){
            foreach ($this->data->formData->fields as $index => $field) {
               if((isset($field->label) && !$field->label) || !isset($field->label)){ $noLabel = true; }
            }
         }
         return $noLabel;
      }

      public function enqueue_date_js( $hook ) {
         wp_enqueue_script( 'brave_pikaday_js', BRAVEPOP_PLUGIN_PATH . 'assets/frontend/pikaday.min.js' ,'','',true);
         wp_enqueue_script( 'brave_pikaday_init', BRAVEPOP_PLUGIN_PATH . 'assets/frontend/formdate.js' ,'','',true);
      }

      public function enqueue_recaptcha_js( $hook ) {
         if($this->recaptcha){
            wp_enqueue_script( 'brave_recaptcha_js', 'https://www.google.com/recaptcha/api.js?render='.$this->recaptcha ,'','',true);
         }
      }

      public function render_js() { ?>
         <script>
            document.addEventListener("DOMContentLoaded", function(event) {


               <?php 
               $fieldSettings = new stdClass();
               $theFormFields = isset($this->data->formData->fields) ? $this->data->formData->fields : null;
               $totalQuizQuestions = 0;
               if($theFormFields){
                  foreach ($theFormFields as $key => $value) {
                           $fieldID = $value->id;
                           $fieldSettings->$fieldID = new stdClass();
                           $fieldSettings->$fieldID->type = isset($value->type) ? $value->type : '';
                           $fieldSettings->$fieldID->required = isset($value->required) ? $value->required : false;
                           $fieldSettings->$fieldID->validation = isset($value->validation) ? $value->validation : '';
                           if(isset($this->data->formData->settings->options->type) && $this->data->formData->settings->options->type === 'quiz' && isset($value->options)){
                              $theOptions = array(); $highestOptionPoint = 0;
                              foreach ($value->options as $key => $optField) {
                                 $option = new stdClass();
                                 $option->label = isset($optField->label) ? esc_attr($optField->label): '';
                                 $option->value = isset($optField->value) ? esc_attr($optField->value): '';
                                 $option->score = isset($optField->score) ? intval($optField->score): 0;
                                 $option->correct = !empty($optField->correct) ? true : false;
                                 $theOptions[] = $option;
                                 if(isset($optField->score) && $optField->score > $highestOptionPoint){
                                    $highestOptionPoint = $optField->score;
                                 }
                              }
                              $fieldSettings->$fieldID->options = $theOptions;
                              $fieldSettings->$fieldID->topScore = $highestOptionPoint;
                              $totalQuizQuestions = $totalQuizQuestions+1;
                           }
                           if(isset($value->multi)){ $fieldSettings->$fieldID->multi = true; }
                  }
               }

               ?>
               brave_popup_formData['<?php print_r(esc_attr($this->data->id)); ?>'] = {
                  formID: '<?php print_r(esc_attr($this->data->id)); ?>',
                  popupID: '<?php print_r(esc_attr($this->popupID)); ?>',
                  stepID: '<?php print_r(esc_attr($this->stepIndex)); ?>',
                  device: '<?php print_r(esc_attr($this->device)); ?>',
                  fields: '<?php print_r(json_encode($fieldSettings)); ?>',
                  track: '<?php print_r(json_encode(isset($this->data->formData->settings->action->track) ? $this->data->formData->settings->action->track : null)); ?>',
                  changesFormHeight: <?php print_r(json_encode($this->changesFormHeight)); ?>,
                  heightData: <?php print_r(json_encode($this->formHeightData)); ?>,
                  goal: <?php print_r(json_encode($this->goalItem)); ?>,
                  recaptcha: <?php print_r(json_encode(!empty($this->recaptcha) ? $this->recaptcha : false )); ?>,
                  totalSteps: <?php print_r($this->totalSteps) ?>,
                  quiz: <?php print_r(json_encode(isset($this->data->formData->settings->options->type) && $this->data->formData->settings->options->type === 'quiz' ? true : false)); ?>,
                  quizScoring: <?php print_r(json_encode(isset($this->data->formData->settings->options->scoring) ? $this->data->formData->settings->options->scoring : 'points')); ?>,
                  totalQuestions: <?php print_r($totalQuizQuestions); ?>,
                  totalScore: <?php print_r(0); ?>,
                  totalCorrect: <?php print_r(0); ?>,
               }
               document.querySelector("#<?php print_r('brave_form_'.esc_attr($this->data->id)).'';?>").addEventListener("submit", function(event){  brave_submit_form(event, brave_popup_formData['<?php print_r(esc_attr($this->data->id)); ?>'] );  });
               <?php if($this->hasDate){  
                  //echo '//Load Date init Call';
               }?>

            });
         </script>

      <?php }

      
      public function render_css() { 

         $formStyle = isset($this->data->formData->settings->style) ? $this->data->formData->settings->style : null;
         $buttonStyle = isset($this->data->formData->settings->button) ? $this->data->formData->settings->button : null;
         $theFormFields = isset($this->data->formData->fields) ? $this->data->formData->fields : array();

         //Form
         $fontSize = bravepop_generate_style_props(isset($formStyle->fontSize) ? $formStyle->fontSize : 12, 'font-size');
         $fontFamily = isset($formStyle->fontFamily) && $formStyle->fontFamily !=='None' ?  'font-family: '.$formStyle->fontFamily.';' : 'font-family: Arial;';
         $fontColor = bravepop_generate_style_props(isset($formStyle->fontColor) ? $formStyle->fontColor : '', 'color', '107, 107, 107', '1');
         
         $successFontSize = bravepop_generate_style_props(isset($formStyle->successFontSize) ? $formStyle->successFontSize : 13, 'font-size');
         $successFontColor = bravepop_generate_style_props(isset($formStyle->successFontColor) ? $formStyle->successFontColor : '', 'color', '107, 107, 107', '1');
         $progressBGColor =  !empty($this->data->formData->settings->options->progress) ? bravepop_generate_style_props(isset($formStyle->progressColor) ? $formStyle->progressColor : '', 'background-color', '109,120,216', '1'):'';
         $progressColor =  !empty($this->data->formData->settings->options->progress) ? bravepop_generate_style_props(isset($formStyle->progressColor) ? $formStyle->progressColor : '', 'color', '109,120,216', '1'):'';
         $progressBorder =  !empty($this->data->formData->settings->options->progress) ? bravepop_generate_style_props(isset($formStyle->progressColor) ? $formStyle->progressColor : '', 'border-color', '109,120,216', '1'):'';

         //Labels
         $labelColor = bravepop_generate_style_props(isset($formStyle->labelColor) ? $formStyle->labelColor : '', 'color', '68,68,68', '1');
         $labelBold = isset($formStyle->boldLabel) && $formStyle->boldLabel === true ?  'font-weight:bold;':'';
         $labelSize = bravepop_generate_style_props(isset($formStyle->labelSize) ? $formStyle->labelSize : 12, 'font-size');

         

         //Fields
         $borderColor = bravepop_generate_style_props(isset($formStyle->borderColor) ? $formStyle->borderColor : '', 'border-color', '221,221,221', '1');
         $inputBgColor = bravepop_generate_style_props(isset($formStyle->inputBgColor) ? $formStyle->inputBgColor : '', 'background-color', '255, 255, 255', '1');
         $inputFontColor = bravepop_generate_style_props(isset($formStyle->inputFontColor) ? $formStyle->inputFontColor : '', 'color', '51,51,51', '1');
         $inputFontSize = bravepop_generate_style_props(isset($formStyle->inputFontSize) ? $formStyle->inputFontSize : 12, 'font-size');
         $borderRadius = isset($formStyle->borderRadius) ?  'border-radius: '.$formStyle->borderRadius.'px;' : '';
         $borderSize = isset($formStyle->borderSize) ?  'border-width: '.$formStyle->borderSize.'px;' : 'border-width: 1px;';
         $spacing = isset($formStyle->spacing) ?  'margin: '.((isset($formStyle->spacing) ? $formStyle->spacing : 15)/2).'px 0px;' : 'margin: 7.5px 0px;';
         $lineHeight = isset($formStyle->lineHeight) ? 'line-height: '.$formStyle->lineHeight.'px;':'line-height: 18px;';
         $fielsdWidth = isset($formStyle->inline) && $formStyle->inline ?  'width: '.(100/count($theFormFields)).'%;' : '';
         $innerSpacing = isset($formStyle->innerSpacing) ?  'padding: '.$formStyle->innerSpacing.'px;' : 'padding: 12px;';

         //Button
         $buttonFont = isset($buttonStyle->fontFamily) && $buttonStyle->fontFamily !=='None'  ?  'font-family: '.$buttonStyle->fontFamily.';' : 'font-family: Arial;';
         $buttonWidth =  !empty($buttonStyle->fullwidth) || !empty($formStyle->inline) ?  'width: 100%;' : '';
         $buttonHeight =  isset($buttonStyle->height) ?  'height: '.$buttonStyle->height.'px;' : '';
         $buttonBold =  isset($buttonStyle->bold) && $buttonStyle->bold === true ?  'font-weight: bold;' : '';
         $buttonAlign =  isset($buttonStyle->align) && ($buttonStyle->align ==='left' || $buttonStyle->align ==='right') ? 'float: '.$buttonStyle->align.';' : '';
         $buttonRadius =  isset($buttonStyle->borderRadius) ?  'border-radius: '.$buttonStyle->borderRadius.'px;' : '';
         $buttonBgColor = bravepop_generate_style_props(isset($buttonStyle->bgColor) ? $buttonStyle->bgColor : '', 'background-color', '76,194,145', '1');
         $buttonFontColor = bravepop_generate_style_props(isset($buttonStyle->fontColor) ? $buttonStyle->fontColor : '', 'color', '255, 255, 255', '1');
         $buttonFontSize = bravepop_generate_style_props(isset($buttonStyle->fontSize) ? $buttonStyle->fontSize : 13, 'font-size');
         $stepLineHeight =  isset($buttonStyle->height) ?  'line-height: '.$buttonStyle->height.'px;' : 'line-height: 40px;';
         $selectonColor = bravepop_generate_style_props(isset($buttonStyle->bgColor) ? $buttonStyle->bgColor : '', 'color', '255, 255, 255', '1');
         $buttonBorderSize = isset($buttonStyle->borderSize) ?  'border-width: '.$buttonStyle->borderSize.'px;' : 'border-width: 0px;';
         $buttonBorderColor = bravepop_generate_style_props(isset($buttonStyle->borderColor) ? $buttonStyle->borderColor : '', 'border-color', '0,0,0', '1');

         
         $iconColor = bravepop_generate_style_props(isset($buttonStyle->iconColor) ? $buttonStyle->iconColor : '', 'fill', '255, 255, 255', '1');
         $iconSize = isset($buttonStyle->icon) && isset($buttonStyle->fontSize) ? 'font-size: '.(($buttonStyle->fontSize * 85)/100).'px' : '';

         $imageSelectColor = isset($buttonStyle->bgColor->rgb) ? $buttonStyle->bgColor->rgb : '76, 194, 145';

         //buttonIconStyle = { color: button.icon && button.iconColor && button.iconColor.rgb ? `rgba(${button.iconColor.rgb}, 1)` : null, marginRight: '8px'}

         $elementLabelStyle = '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .braveform_label { '. $labelSize . $fontFamily . $labelColor . $labelBold .'}';

         $elementInnerStyle = '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .brave_element__styler, #brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .brave_form_fields .formfield__checkbox_label{ '. $fontSize . $fontFamily . $fontColor . '}';

         $elementInputStyle = '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' input, #brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' textarea, #brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' select{ 
         '. $innerSpacing . $inputBgColor . $inputFontColor . $inputFontSize . $borderSize . $borderColor . $borderRadius . $fontFamily.' border-style: solid;}';

         $elementFieldSelctionStyle = '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' input[type="checkbox"]:checked:before, #brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' input[type="radio"]:checked:before{ '. $selectonColor . '}';
         
         $elementFieldsStyle = '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .brave_form_field { '. $spacing . $lineHeight. $fielsdWidth .'}';
         
         $elementButtonStyle = '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .brave_form_button button{ '. $fontFamily .$buttonWidth . $buttonHeight . $buttonRadius . $buttonBgColor . $buttonFontColor . $buttonFontSize . $buttonAlign. $buttonBold.$buttonFont.$buttonBorderSize. $buttonBorderColor.'}';
         $elementStepButtonStyle = '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .brave_form_field--step .brave_form_stepNext{ '. $fontFamily .$buttonWidth . $buttonHeight . $buttonRadius . $buttonBgColor . $buttonFontColor . $buttonFontSize . $stepLineHeight. $buttonAlign.'}';
         
         $elementIconSize = isset($buttonStyle->icon) && $buttonStyle->icon ? '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .brave_element-icon{ '.$iconSize. '}' : '';
         $elementIconColor = isset($buttonStyle->icon) && $buttonStyle->icon ? '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .brave_icon svg{ '.$iconColor. '}' : '';

         $elementImageSelect = '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .formfield__inner__image--selected img{ border-color: rgba('.$imageSelectColor.', 1);}';
         $elementImageSelectIcon = '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .formfield__inner__image__selection{ border-color: rgba('.$imageSelectColor.', 1) transparent transparent transparent;}';
         
         $formSuccessStyle = !empty($successFontSize) || !empty($successFontColor) ?'#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .brave_form_custom_content{ '. $successFontSize .$successFontColor.'}' : '';
         $progressColorStyle = $progressBGColor ?  '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .bravepopupform_theProgressbar__bar{ '. $progressBGColor.'}' : '';
         $progressColorStyle .= $progressColor ?  '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .bravepopupform_theProgressbar_progress{ '. $progressColor.'}' : '';
         $progressColorStyle .= $progressBorder ?  '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .braveformBolt{ '. $progressBorder.' margin-right: calc('.($this->totalSteps > 2 ? round(100 / ($this->totalSteps - 1)) : 50).'% - 22px);}' : '';

         $formInlineFieldWrap = !empty($formStyle->inline) ? '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .brave_form_fields{width: calc(100% - '.(isset($formStyle->buttonWidth) ? $formStyle->buttonWidth : 100).'px)}' :''; //brave_form_fields
         $formInlineFieldButtonWrap = !empty($formStyle->inline) ? '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .brave_form_button{width: '.(isset($formStyle->buttonWidth) ? $formStyle->buttonWidth : 100).'px;}' :''; //brave_form_fields

         $formCheckboxBordered = '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' .brave_form_field--checkbox_borderd .formfield__inner__checkbox label{'. $borderSize . $borderColor . $borderRadius .'}';

         $hideGaptchaBadge = !empty($this->data->formData->settings->action->recaptcha) ? '.grecaptcha-badge{visibility: hidden}' : '';

         return  $elementInnerStyle . $elementInputStyle .$elementFieldsStyle .$elementLabelStyle. $formInlineFieldWrap.$formInlineFieldButtonWrap. $elementFieldSelctionStyle . $elementButtonStyle.$elementStepButtonStyle .$elementIconSize . $elementIconColor. $elementImageSelect.$elementImageSelectIcon.$formCheckboxBordered.$formSuccessStyle.$hideGaptchaBadge.$progressColorStyle.$this->ratingStyles.$this->buttonGroupStyles;

      }

      protected function renderInput($field){
         $requiredStar = isset($field->required) && $field->required === true ? '*' : '';
         $firstlabel = isset($field->label) ? $field->label : '';
         $secondLabel = isset($field->secondLabel) ? $field->secondLabel: '';
         $placeholder = isset($field->placeholder) ? $field->placeholder.$requiredStar: '';
         $secondPlaceholder = isset($field->secondPlaceholder) ? $field->secondPlaceholder.$requiredStar: '';
         $firstname= $field->id;
         $secondname= $field->id;
         $validation =isset($field->validation) && $field->validation ? $field->validation : 'text';
         $current_user = bravepop_getCurrentUser();
         $loggedin_user_email = !empty($current_user['email']) ? $current_user['email'] : '';
         $loggedin_user_fullname = !empty($current_user['name']) ? $current_user['name'] : '';
         $newsletter_name_field = !empty($this->data->formData->settings->action->newsletter) && !empty($this->data->formData->settings->action->newsletter->nameField) ? $this->data->formData->settings->action->newsletter->nameField : '';

         $fieldHTML = '<div id="brave_form_field'.$field->id.'" class="brave_form_field brave_form_field--input">';
            if(isset($field->validation) && $field->validation === 'name'){
               $firstNameLabel = $firstlabel? '<label class="braveform_label">'.$firstlabel.$requiredStar.'</label>' : '';
               $secondNameLabel = $secondLabel ? '<label class="braveform_label">'.$secondLabel.$requiredStar.'</label>' : '';
               $fieldHTML .= '<div class="formfield__inner__firstname">'.$firstNameLabel.'<div class="brave_form_field_error brave_form_field_error--firstname"></div><input type="text" placeholder="'.esc_attr($placeholder).'" name="'.esc_attr($firstname).'[]" /></div>';
               $fieldHTML .= '<div class="formfield__inner__lastname">'.$secondNameLabel.'<div class="brave_form_field_error brave_form_field_error--lastname"></div><input type="text" placeholder="'.esc_attr($secondPlaceholder).'" name="'.esc_attr($secondname).'[]" /></div>';

            }else{
               $fieldHTML .= $firstlabel ? '<label class="braveform_label">'.$field->label.$requiredStar.'</label>' : '';
               $fieldHTML .= '<div class="brave_form_field_error"></div>';
               if(isset($field->validation) && $field->validation === 'email'){
                  $fieldHTML .= '<input type="email" placeholder="'.esc_attr($placeholder).'"  name="'.esc_attr($firstname).'" '.($loggedin_user_email ? 'value="'.$loggedin_user_email.'"' : '').' />';
               }else{
                  $fieldHTML .= '<input type="text" placeholder="'.esc_attr($placeholder).'"  name="'.esc_attr($firstname).'" '.($loggedin_user_fullname && $newsletter_name_field === $field->id ? 'value="'.$loggedin_user_fullname.'"' : '').' />';
               }
               
            }
         $fieldHTML .= '</div>';

        return  $fieldHTML;
      }

      protected function renderTextarea($field){
         $requiredStar = isset($field->required) && $field->required === true ? '*' : '';
         $label = isset($field->label) ? $field->label : '';
         $height = isset($field->minHeight) ? $field->minHeight.'px' : '100px';
         $placeholder = isset($field->placeholder) && $field->placeholder ? $field->placeholder.$requiredStar: '';
         $fieldName= $field->id;
         $validation =isset($field->validation) && $field->validation ? $field->validation : 'text';

         $fieldHTML = '<div id="brave_form_field'.$field->id.'" class="brave_form_field brave_form_field--textarea">';
            $fieldHTML .= $label ? '<label class="braveform_label">'.$field->label.$requiredStar.'</label>' : '';
            $fieldHTML .= '<div class="brave_form_field_error"></div>';
            $fieldHTML .= '<textarea placeholder="'.esc_attr($placeholder).'" name="'.esc_attr($fieldName).'" style="height:'.esc_attr($height).'" ></textarea>';
         $fieldHTML .= '</div>';

        return  $fieldHTML;
      }

      protected function renderCustomLabel($field){
         $label = isset($field->label) ? html_entity_decode($field->label) : '';
         $color = bravepop_generate_style_props(isset($field->color) ? $field->color : '', 'color', '51, 51, 51', '1');
         $fontSize = isset($field->fontSize) ? (Int)$field->fontSize: 16;
         $lineHeight = ($fontSize + ($fontSize/2));
         $fontWeight = isset($field->bold) && $field->bold === true ? 'font-weight:bold;' : '';
         $fieldStyle = 'style="'.$color.' font-size:'.$fontSize.'px; line-height: '.$lineHeight.'px;'.$fontWeight.'"'; 

         $fieldHTML = '<div id="brave_form_field'.$field->id.'" class="brave_form_field brave_form_field--customLabel">';
            $fieldHTML .= '<div '.$fieldStyle.' >'.$label.'</div>';
         $fieldHTML .= '</div>';

        return  $fieldHTML;
      }

      protected function renderCustomMedia($field){
         $label = isset($field->label) ? $field->label : '';
         $mediaType = isset($field->mediaType) ? $field->mediaType : 'image';
         $mediaURL = isset($field->url) ? $field->url : '';

         $fieldHTML = '<div id="brave_form_field'.$field->id.'" class="brave_form_field brave_form_field--media">';
            $fieldHTML .= $label ? '<label class="braveform_label">'.$field->label.'</label>' : '';
            $fieldHTML .= '<div class="brave_form_field_mediaWrap">';
            $fieldHTML .= $mediaURL && $mediaType === 'image' ? '<img src="'.$mediaURL.'" />' : '';
            $fieldHTML .= $mediaURL && $mediaType === 'video' ? ' <video width="100%" controls="true"><source src="'.$mediaURL.'"></source></video>' : '';
            $fieldHTML .= '</div>';
         $fieldHTML .= '</div>';

        return  $fieldHTML;
      }

      protected function renderButtons($field){
         $label = isset($field->label) ? $field->label : '';
         $requiredStar = isset($field->required) && $field->required === true ? '*' : '';
         $gotoNextStep = !empty($field->step) ? 'true' : 'false';
         $color = bravepop_generate_style_props(isset($field->color) ? $field->color : '', 'color', '255, 255, 255', '1');
         $background = bravepop_generate_style_props(isset($field->background) ? $field->background : '', 'background-color', '51, 51, 51', '1');
         $fontSize = isset($field->fontSize) ? (Int)$field->fontSize: 14;
         $roundness = isset($field->roundness) ? (Int)$field->roundness: 4;
         $height = isset($field->height) ? (Int)$field->height: 12;
         //$stepData = str_replace('"','\'',json_encode(array('formID'=> $this->data->id, 'totalSteps'=> $this->totalSteps, 'goto'=> $this->wrappedSteps )));
         $stepData = !empty($field->step) && $this->totalSteps > 0 ? ', \''.$this->data->id.'\', '.$this->totalSteps.', '.$this->wrappedSteps.'' :'';

         $this->buttonGroupStyles .= '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' #brave_form_field'.$field->id.' .brave_form_field__buttonGroup{ padding: '.$height.'px 0px; font-size: '.$fontSize.'px;'.$color.$background.';border-radius: '.$roundness.'px;}';

         $fieldHTML = '<div id="brave_form_field'.$field->id.'" class="brave_form_field brave_form_field--buttons">';
         $fieldHTML .= $label ? '<label class="braveform_label">'.$field->label.$requiredStar.'</label>' : '';
         $fieldHTML .= '<div class="brave_form_field_error"></div>';
            $fieldHTML .= '<div class="brave_form_field__buttons">';
               if($field->options && is_array($field->options)){
                  foreach ($field->options as $index => $option) {
                     $optionLabel = !empty($option->label) ? $option->label : ''; $optionValue = !empty($option->value) ? $option->value : (!empty($option->label) ? $option->label : ''); 
                     $fieldHTML .= '<div class="brave_form_field__buttonGroup" onclick="brave_select_form_ButtonGroup(\''.$field->id.'\', \''.$index.'\', '.$gotoNextStep.' '.$stepData.');" id="brave_form_field'.$field->id.'_opt-'.$index.'">'.$optionLabel.'<input name="'.esc_attr($field->id).'" type="radio" value="'.esc_attr($optionValue).'" /></div>';
                  }
               }
            $fieldHTML .= '</div>';
         $fieldHTML .= '</div>';

        return  $fieldHTML;
      }

      protected function renderDate($field){
         $requiredStar = isset($field->required) && $field->required === true ? '*' : '';
         $label = isset($field->label) ? $field->label : '';
         $placeholder = isset($field->placeholder) ? $field->placeholder.$requiredStar: '';
         $startDate = isset($field->startDate) && $field->startDate ? 'data-startdate="'.$field->startDate.'"' : '';
         $endDate = isset($field->endDate) && $field->endDate ? 'data-enddate="'.$field->endDate.'"' : '';
         $fieldName= $field->id;

         $fieldHTML = '<div id="brave_form_field'.$field->id.'" class="brave_form_field brave_form_field--date" '.$startDate.' '.$endDate.'>';
            $fieldHTML .= $label ? '<label class="braveform_label">'.$field->label.$requiredStar.'</label>' : '';
            $fieldHTML .= '<div class="brave_form_field_error"></div>';
            $fieldHTML .= '<input type="text" placeholder="'.esc_attr($placeholder).'" name="'.$fieldName.'" autoComplete="off" />';
         $fieldHTML .= '</div>';

        return  $fieldHTML;
      }

      protected function renderSelect($field){
         $requiredStar = isset($field->required) && $field->required === true ? '*' : '';
         $label = isset($field->label) ? $field->label : '';
         $multi = isset($field->multi) && $field->multi === true ? 'multiple' : '';
         $defaultText = isset($field->defaultText) ? $field->defaultText : 'Select an Option...';
         $fieldName= isset($field->multi) && $field->multi? 'name="'.$field->id.'[]"' : 'name="'.$field->id.'"';
         $dropdownType = isset($field->dropdownType) ?  $field->dropdownType : 'custom';
         $selectedCountry = isset($field->country) ?  $field->country : false;

         $fieldHTML = '<div id="brave_form_field'.$field->id.'" class="brave_form_field brave_form_field--select">';
            $fieldHTML .= $label ? '<label class="braveform_label">'.$field->label.$requiredStar.'</label>' : '';
            $fieldHTML .= '<div class="brave_form_field_error"></div>';
            $fieldHTML .= '<select '.$multi.' '.$fieldName.'>';
            $fieldHTML .= '<option value="none">'.$defaultText.'</option>';

            if($dropdownType === 'custom'){
               foreach ($field->options as $index => $option) {
                  $optionLabel = !empty($option->label) ? $option->label : ''; $optionValue = !empty($option->value) ? $option->value : ''; 
                  $fieldHTML .= '<option value="'.esc_attr($optionValue).'">'.$optionLabel.'</option>';
               }
            }else{
               if($dropdownType === 'country' || $dropdownType === 'city' || $dropdownType === 'state'){
                  $fieldHTML .= bravepopup_get_country_fields($dropdownType, $selectedCountry);
               }

            }

            $fieldHTML .= '</select>';
         $fieldHTML .= '</div>';

        return  $fieldHTML;
      }

      protected function renderCheckbox($field){
         $requiredStar = isset($field->required) && $field->required === true ? '*' : '';
         $label = isset($field->label) ? html_entity_decode($field->label) : '';
         $inline = isset($field->inline) ? $field->inline : false;
         $bordered = isset($field->border) ? $field->border : false;

         $fieldName= $field->id;
         $fieldHTML = '<div id="brave_form_field'.$field->id.'" class="brave_form_field brave_form_field--checkbox '.($inline ? 'brave_form_field--checkbox_inline' : '').' '.($bordered ? ' brave_form_field--checkbox_borderd' : '').'">';
         $fieldHTML .= $label ? '<label class="braveform_label">'.$field->label.$requiredStar.'</label>' : '';
         $fieldHTML .= '<div class="brave_form_field_error"></div>';
         foreach ($field->options as $index => $option) {
            $optionLabel = !empty($option->label) ? html_entity_decode($option->label) : ''; $optionValue = !empty($option->value) ? $option->value : '';  $optionValue = $optionValue ? $optionValue : esc_attr($option->label);
            $fieldHTML .= '<div class="formfield__inner__checkbox"><label><input name="'.esc_attr($fieldName).'[]" type="checkbox" value="'.esc_attr($optionValue).'" /><span class="formfield__checkbox_label">'.$optionLabel.'</span></label></div>';
         }

         $fieldHTML .= '</div>';

        return  $fieldHTML;
      }

      protected function renderImageSelect($field){
         $requiredStar = isset($field->required) && $field->required === true ? '*' : '';
         $label = isset($field->label) ? $field->label : '';
         $fieldName= $field->id;
         $multi = isset($field->multi) ? $field->multi : false;
         $imageCount =  isset($field->imageCount) ? $field->imageCount : 2;
         $imageWidthStyle = 'style="width:'.((100/$imageCount) - 3).'%;"';
         $fieldHTML = '<div id="brave_form_field'.$field->id.'" class="brave_form_field brave_form_field--image">';
         $fieldHTML .= $label ? '<label class="braveform_label">'.$field->label.$requiredStar.'</label>' : '';
         $fieldHTML .= '<div class="brave_form_field_error"></div>';
         $fieldHTML .= '<div class="brave_form_field__imgWrap">';
         foreach ($field->options as $index => $option) {
            $optionLabel = !empty($option->label) ? $option->label : ''; $optionValue = !empty($option->value) ? $option->value : '';   $optionValue = $optionValue ? $optionValue : esc_attr($option->label);
            $fieldHTML .= '<div id="brave_form_field'.$field->id.'_opt-'.$index.'" class="formfield__inner__image'.($index === 0 ?' formfield__inner__image--selected':'').'" onclick="brave_select_imageField(\''.$field->id.'\', \''.$index.'\', '.json_encode($multi).');" '.$imageWidthStyle.'>';
            $fieldHTML .= '<div class="formfield__inner__image__selection">'.bravepop_renderIcon('check', '#fff').'</div>';
            $fieldHTML .= isset($option->image) && $option->image ? '<div class="formfield__inner__image_img"><img class="brave_element__form_imageselect brave_element_img_item skip-lazy no-lazyload" src="'.bravepop_get_preloader().'" data-lazy="'.$option->image.'" alt="'.$label.'" /></div>' : '<div class="formfield__inner__image_fake"></div>';
            $fieldHTML .= $multi ? '<input name="'.esc_attr($fieldName).'[]" type="checkbox" value="'.esc_attr($optionValue).'" '.($index === 0 ?'checked':'').' /><span>'.$optionLabel.'</span>' : '<input name="'.esc_attr($fieldName).'" type="radio" value="'.esc_attr($optionValue).'" '.($index === 0 ?'checked':'').' /><span>'.$optionLabel.'</span>';
            $fieldHTML .= '</div>';
         }

         $fieldHTML .= '</div></div>';

        return  $fieldHTML;
      }

      protected function renderRadio($field){
         $requiredStar = isset($field->required) && $field->required === true ? '*' : '';
         $label = isset($field->label) ? html_entity_decode($field->label) : '';
         $fieldName= isset($field->label) ? $field->id : $this->data->id;
         $inline = isset($field->inline) ? $field->inline : false;
         $bordered = isset($field->border) ? $field->border : false;

         $fieldHTML = '<div id="brave_form_field'.$field->id.'" class="brave_form_field brave_form_field--radio '.($inline ? 'brave_form_field--radio_inline' : '').' '.($bordered ? ' brave_form_field--checkbox_borderd' : '').'">';
         $fieldHTML .= '<div class="brave_form_field_error"></div>';
         $fieldHTML .= $label ? '<label class="braveform_label">'.$field->label.$requiredStar.'</label>' : '';
         foreach ($field->options as $index => $option) {
            $optionLabel = !empty($option->label) ? html_entity_decode($option->label) : ''; $optionValue = !empty($option->value) ? $option->value : ''; $optionValue = $optionValue ? $optionValue : esc_attr($option->label);
            $fieldHTML .= '<div class="formfield__inner__checkbox"><label><input name="'.esc_attr($fieldName).'" type="radio" value="'.esc_attr($optionValue).'" /><span class="formfield__checkbox_label">'.$optionLabel.'</span></label></div>';
         }

         $fieldHTML .= '</div>';

        return  $fieldHTML;
      }


      protected function renderRating($field){
         $requiredStar = isset($field->required) && $field->required === true ? '*' : '';
         $label = isset($field->label) ? $field->label : '';
         $fieldName= $field->id;
         $ratingType = isset($field->ratingType) ? $field->ratingType : 'star';
         $tenItems = isset($field->tenItems) ? $field->tenItems : false;
         $ratingSize = isset($field->ratingSize) ? $field->ratingSize : 20;
         $ratingColor = isset($field->ratingColor->hex) ? $field->ratingColor->hex : '#cccccc';
         $ratingTxtColor = isset($field->ratingTxtColor->hex) ? $field->ratingTxtColor->hex : '#ffffff';
         $ratingFillColor = isset($field->ratingFillColor->hex) ? $field->ratingFillColor->hex : '#EFBA25';
         $itemCount = $tenItems ? 10 : 5;

         if($ratingType === 'smiley'){
            $this->ratingStyles .= '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' #brave_form_field'.$field->id.' .formfield__inner__ratings_smiley{ width: '.$ratingSize.'px; height: '.$ratingSize.'px;}';
            $this->ratingStyles .= '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' #brave_form_field'.$field->id.' .formfield__inner__ratings--selected svg circle{ stroke: '.$ratingFillColor.';}';
         }
         if($ratingType === 'number'){
            $this->ratingStyles .= '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' #brave_form_field'.$field->id.' .formfield__inner__ratings_number{ font-size: '.$ratingSize.'px; line-height: '.$ratingSize.'px; background: '.$ratingColor.';color: '.$ratingTxtColor.';}';
            $this->ratingStyles .= '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' #brave_form_field'.$field->id.' .formfield__inner__ratings--hovered, #brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' #brave_form_field'.$field->id.' .formfield__inner__ratings--selected{ background: '.$ratingFillColor.'}';
         }
         if($ratingType === 'star'){
            $this->ratingStyles .= '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' #brave_form_field'.$field->id.' .formfield__inner__ratings_star{ width: '.$ratingSize.'px;}';
            $this->ratingStyles .= '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' #brave_form_field'.$field->id.' .formfield__inner__ratings--selected svg path{ fill: '.$ratingFillColor.'}';
            $this->ratingStyles .= '#brave_popup_'.$this->popupID.'__step__'.$this->stepIndex.' #brave_element-'.$this->data->id.' #brave_form_field'.$field->id.' .formfield__inner__ratings--hovered svg path{ fill: '.$ratingFillColor.'}';
         }

         $fieldHTML = '<div id="brave_form_field'.$field->id.'" class="brave_form_field brave_form_field--rating" data-ratingtype="'.$ratingType.'" data-rated="false">';
         $fieldHTML .= $label ? '<label class="braveform_label">'.$field->label.$requiredStar.'</label>' : '';
         $fieldHTML .= '<div class="brave_form_field_error"></div>';

         if($ratingType === 'star' || $ratingType === 'number'){
            $numRatingSize = 'normal'; if($ratingSize > 28){  $numRatingSize = 'large';  } if($ratingSize < 16){  $numRatingSize = 'small';  }
            //$numStyle = $ratingSize ? 'style="font-size: '.$ratingSize.'px;"' : '';
            $fieldHTML .= '<div class="brave_form_ratings_wrap brave_form_ratings_wrap--'.$ratingType.'" onmouseleave="brave_form_rating_unhover(\''.$field->id.'\',)">';
            for ($index = 1; $index <= $itemCount; $index++) {
               $item = $ratingType === 'number'? '<span>'.$index.'</span>' : bravepop_renderIcon('star', $ratingColor);
               $fieldHTML .= '<div class="formfield__inner__ratings_'.$ratingType.' formfield__inner__ratings_'.$ratingType.'--'.$numRatingSize.'" onclick="brave_form_rate(\''.$field->id.'\','.$index.')" onmouseenter="brave_form_rating_hover(\''.$field->id.'\','.$index.')"><label>'.$item.'<input name="'.$fieldName.'" type="radio" value="'.$index.'" /></label></div>';
            }
            $fieldHTML .= '</div>';
         }else if( $ratingType === 'smiley'){
            $fieldHTML .= '<div class="brave_form_ratings_wrap">';
            $fieldHTML .= '<div class="formfield__inner__ratings_smiley" onclick="brave_form_rate(\''.$field->id.'\',1, true)">'.bravepop_renderIcon('smiley1').'<input name="'.esc_attr($fieldName).'" type="radio" value="1" /></div>';
            $fieldHTML .= '<div class="formfield__inner__ratings_smiley" onclick="brave_form_rate(\''.$field->id.'\',2, true)">'.bravepop_renderIcon('smiley2').'<input name="'.esc_attr($fieldName).'" type="radio" value="2" /></div>';
            $fieldHTML .= '<div class="formfield__inner__ratings_smiley" onclick="brave_form_rate(\''.$field->id.'\',3, true)">'.bravepop_renderIcon('smiley3').'<input name="'.esc_attr($fieldName).'" type="radio" value="3" /></div>';
            $fieldHTML .= '<div class="formfield__inner__ratings_smiley" onclick="brave_form_rate(\''.$field->id.'\',4, true)">'.bravepop_renderIcon('smiley4').'<input name="'.esc_attr($fieldName).'" type="radio" value="4" /></div>';
            $fieldHTML .= '<div class="formfield__inner__ratings_smiley" onclick="brave_form_rate(\''.$field->id.'\',5, true)">'.bravepop_renderIcon('smiley5').'<input name="'.esc_attr($fieldName).'" type="radio" value="5" /></div>';
            $fieldHTML .= '</div>';
         }
         $fieldHTML .= '</div>';

        return  $fieldHTML;
      }

      protected function renderStep($field, $index){
         if($index === 0){ return; }
         $totalFields = isset($this->data->formData->fields) ? count($this->data->formData->fields) : 0;
         if($index === ($totalFields - 1)){ return; }
         //$this->totalSteps = $this->totalSteps+1;
         $hideStepBack = isset($this->data->formData->settings->options->hideStepBack) ? true : false;
         $formStyle = isset($this->data->formData->settings->style) ? $this->data->formData->settings->style : null;
         $fontColor = bravepop_generate_style_props(isset($formStyle->fontColor) ? $formStyle->fontColor : '', 'color', '107, 107, 107', '1');
         $buttonStyle = isset($this->data->formData->settings->button) ? $this->data->formData->settings->button : null;
         $buttonFull = isset($buttonStyle->fullwidth) && $buttonStyle->fullwidth ? true : false;
         $buttonIconColor = isset($buttonStyle->fontColor) && isset($buttonStyle->fontColor->rgb) ? 'rgb('.$buttonStyle->fontColor->rgb.')' : '#fff';
         $stepColor = $buttonFull ? (isset($buttonStyle->fontColor) && isset($buttonStyle->fontColor->rgb) ? 'rgb('.$buttonStyle->fontColor->rgb.')' :'#fff' ) : (isset($formStyle->fontColor)&& isset($formStyle->fontColor->rgb) ? 'rgb('.$formStyle->fontColor->rgb.')' : '#fff');
         $buttonAlign =  isset($buttonStyle->align) ?  $buttonStyle->align : 'right';
         $stepButtonRight = $buttonAlign==='left' ? 'brave_form_stepBack--right': '';

         $label = isset($field->label) ? $field->label : '';
         $arrow = isset($field->arrow) && $field->arrow === true ? ' &rarr;' : '';
         $changeHeight = isset($field->changeHeight) && $field->changeHeight === true ? true : false; 
         if($changeHeight && $this->changesFormHeight === false){  $this->changesFormHeight = true; }
         $formHeight = isset($this->data->height) ? $this->data->height : '';
         $newHeight = isset($field->height) && $field->height && $changeHeight === true ? $field->height : false;
         $this->formHeightData[$this->wrappedSteps] = $changeHeight ? (Int)$newHeight : (Int)$formHeight  ;

         $fieldHTML = '<div id="brave_form_field'.$field->id.'" class="brave_form_field brave_form_field--step" data-steps="'.$this->wrappedSteps.'">';
         $fieldHTML .= ($this->wrappedSteps > 1 && !$hideStepBack) ? '<a class="brave_form_stepBack '.$stepButtonRight.'" onclick="brave_form_goBack(\''.$this->data->id.'\', '.$this->totalSteps.')">'.bravepop_renderIcon('arrow-left', $stepColor).'</a>':'';
         $fieldHTML .= '<a class="brave_form_stepNext" onclick="brave_form_gotoStep(\''.$this->data->id.'\', '.$this->totalSteps.', '.($this->wrappedSteps).')">'.$label.$arrow.' </a></div>';
         if($this->totalSteps > 1){
            $fieldHTML .= '</div><div class="brave_form_fields_step brave_form_fields_step'.$this->wrappedSteps.'">';
         }
         $this->wrappedSteps = $this->wrappedSteps + 1;
        return  $fieldHTML;
      }

      protected function renderButton($button){
         $hideStepBack = isset($this->data->formData->settings->options->hideStepBack) ? true : false;
         $buttonText = isset($button->buttonText) ? $button->buttonText : '';
         $formStyle = isset($this->data->formData->settings->style) ? $this->data->formData->settings->style : null;
         $fontColor = bravepop_generate_style_props(isset($formStyle->fontColor) ? $formStyle->fontColor : '', 'color', '107, 107, 107', '1');
         //$buttonIcon = isset($button->icon) ? $this->buttonIcon : '';
         $buttonStyle = isset($this->data->formData->settings->button) ? $this->data->formData->settings->button : null;
         $buttonIconColor = isset($buttonStyle->fontColor) && isset($buttonStyle->iconColor->rgb) ? 'rgb('.$buttonStyle->iconColor->rgb.')' : '#fff';
         $buttonFull = isset($buttonStyle->fullwidth) && $buttonStyle->fullwidth ? 'brave_form_button--full' : '';
         $stepColor = $buttonFull ? (isset($buttonStyle->fontColor) && isset($buttonStyle->fontColor->rgb) ? 'rgb('.$buttonStyle->fontColor->rgb.')' :'#fff' ) : (isset($formStyle->fontColor)&& isset($formStyle->fontColor->rgb) ? 'rgb('.$formStyle->fontColor->rgb.')' : '#fff');
         $buttonAlign =  isset($buttonStyle->align) ?  $buttonStyle->align : 'right';
         $stepButtonRight = $buttonAlign==='left' ? 'brave_form_stepBack--right': '';

         $stepHideClass = $this->totalSteps > 0 ? 'brave_form_button--hide' : '';
         $loadingIcon = '<span id="brave_form_loading_'.$this->data->id.'" class="brave_form_loading">'.bravepop_renderIcon('reload', $buttonIconColor).'</span>';

         $stepBackButton = ($this->wrappedSteps > 1 && !$hideStepBack) ? '<a class="brave_form_stepBack '.$stepButtonRight.'" onclick="brave_form_goBack(\''.$this->data->id.'\', '.$this->totalSteps.')">'.bravepop_renderIcon('arrow-left', $stepColor).'</a>':'';

         $iconHTML = '';
         if(isset($this->data->formData->settings->button->icon->body)){
            $iconHTML = '<span class="brave_element-icon"><svg viewBox="0 0 '.$this->data->formData->settings->button->icon->width.' '.$this->data->formData->settings->button->icon->height.'" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">'.str_replace('currentColor', $buttonIconColor ,$this->data->formData->settings->button->icon->body).'</svg></span>';
         }

         return '<div class="brave_form_button '.$buttonFull.' '.$stepHideClass.'">'.$stepBackButton.'<button>'.$loadingIcon.$iconHTML.$buttonText.'</button></div>';
      }

      protected function renderFields(){
         if(!isset($this->data->formData->fields)){  return ''; }
         $fieldsHTML = '<div class="brave_form_fields" data-step="0">';
         if($this->totalSteps > 0){   $fieldsHTML .= '<div class="brave_form_fields_step brave_form_fields_step0 brave_form_fields_step--show">';  }
         foreach ($this->data->formData->fields as $index => $field) {
            if(isset($field->type)){
               switch ($field->type) {
                  case 'input':
                     $fieldsHTML .=  $this->renderInput($field);
                     break;
                  case 'textarea':
                     $fieldsHTML .=   $this->renderTextarea($field);
                     break;
                  case 'checkbox':
                     $fieldsHTML .=   $this->renderCheckbox($field);
                     break;
                  case 'image':
                     $fieldsHTML .=   $this->renderImageSelect($field);
                     break;
                  case 'radio':
                     $fieldsHTML .=   $this->renderRadio($field);
                     break;
                  case 'date':
                     $fieldsHTML .=  $this->renderDate($field);
                     break;
                  case 'select':
                     $fieldsHTML .=  $this->renderSelect($field);
                     break;
                  case 'rating':
                     $fieldsHTML .=  $this->renderRating($field);
                     break;
                  case 'label':
                     $fieldsHTML .=  $this->renderCustomLabel($field);
                     break;
                  case 'media':
                     $fieldsHTML .=  $this->renderCustomMedia($field);
                     break;
                  case 'buttons':
                     $fieldsHTML .=  $this->renderButtons($field);
                     break;
                  case 'step':
                     $fieldsHTML .=  $this->renderStep($field, $index);
                     break;
                  default:
                     $fieldsHTML .='';
                     break;
               }
            }
            
         }

         $fieldsHTML .= wp_nonce_field( 'brave-ajax-form-nonce', 'brave_form_security'.$this->data->id );
         if($this->totalSteps > 0){   $fieldsHTML .= '</div>';  }
         $fieldsHTML .= '</div>';
         //if($this->totalSteps > 0){  $fieldsHTML .= '<a class="brave_form_stepBack brave_form_stepBack--hide" onclick="brave_form_goBack(\''.$this->data->id.'\', '.$this->totalSteps.')">'.bravepop_renderIcon('arrow-left', '#fff').'</a>';}
         $fieldsHTML .= $this->renderButton(isset($this->data->formData->settings->button) ? $this->data->formData->settings->button : '');
         
         return $fieldsHTML;
      }

      protected function renderProgressbar(){
         if(empty($this->data->formData->settings->options->progress)){ return '';}
         $progressStyle = $this->data->formData->settings->options->progress;
         
         $progressHTML = ' <div id="'.$this->data->id.'__form_progress" class="bravepopupform_theProgressbar bravepopupform_theProgressbar--'.$progressStyle.'" data-style="'.$progressStyle.'">';
            $progressHTML .= '<div class="bravepopupform_theProgressbar__barWrap">';
               $progressHTML .= $progressStyle === 'style1' ? '<span class="bravepopupform_theProgressbar_progress">'.(round((1/$this->totalSteps)*100)).'%</span>':'';
               if($progressStyle === 'style2'){
                  $progressHTML .= '<div class="bravepopupform_theProgressbar__bolts">';
                     for ($i=0; $i < $this->totalSteps ; $i++) { 
                        $progressHTML .= '<i class="braveformBolt"></i>';
                     }
                  $progressHTML .= '</div>';
               }
               $progressHTML .= '<div class="bravepopupform_theProgressbar__bar" style="width: '.($progressStyle === 'style2' ? 0 : ((1/$this->totalSteps)*100)).'%"></div>';

            $progressHTML .= '</div>';
         if($progressStyle === 'style1'){
            $progressHTML .= '<span class="bravepopupform_theProgressbar_steps">1/'.($this->totalSteps).'</span>';
         }

         $progressHTML .= '</div>';

         return $progressHTML;
      }


      public function render( ) { 
         $formStyle = isset($this->data->formData->settings->style) ? $this->data->formData->settings->style : null;
         $underlineClass = isset($formStyle->underline) && $formStyle->underline === true ? 'brave_form_form--underline' : '';
         $inlineClass = isset($formStyle->inline) && $formStyle->inline === true ? 'brave_form_form--inline' : '';
         $hasDateClass = $this->hasDate ? 'brave_form_form--hasDate' : '';
         $nolabelClass = $this->nolabel ? 'brave_form_form--noLabel' : '';
         $cookiesToCheck = function_exists('bravepop_newsletter_cookie_conditions') && !empty($this->data->formData->settings->action->newsletter->advancedSettings->conditional) && isset($this->data->formData->settings->action->newsletter->advancedSettings->conditions) ? bravepop_newsletter_cookie_conditions($this->data->formData->settings->action->newsletter->advancedSettings->conditions) : '' ;

         return '<div id="brave_element-'.$this->data->id.'" class="brave_element brave_element--form">
                  <div class="brave_element__wrap">
                     <div class="brave_element__styler">
                        <div class="brave_element__inner">
                           <div class="brave_element__form_inner">
                           '.$this->renderProgressbar().'
                              <form id="brave_form_'.$this->data->id.'" class="brave_form_form '.$underlineClass.' '.$hasDateClass.' '.$inlineClass.' '.$nolabelClass.'" method="post" data-cookies="'.$cookiesToCheck.'">
                                 <div class="brave_form_overlay"></div>'
                                 .$this->renderFields().
                              '</form>
                              <div id="brave_form_custom_content'.$this->data->id.'" class="brave_form_custom_content"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>';
      }


   }


}
?>