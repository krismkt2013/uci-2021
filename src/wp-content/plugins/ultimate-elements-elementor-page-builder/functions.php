<?php

function ueepb_transitions_list($key){

	$transitions_list = array(
		'fade' 				=> '{$Duration:1200,$Opacity:2}',
		'fade_in_t' 		=> '{$Duration:1200,y:0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2}',
		'fade_in_b' 		=> '{$Duration:1200,y:-0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2}',				
		'fade_fly_in_t' => '{$Duration:1200,y:0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2,$Outside:true}',
		'fade_fly_in_b' => '{$Duration:1200,y:-0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:2,$Outside:true}',
		'zoom_plus_in_t' => '{$Duration:1000,y:4,$Zoom:11,$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2}',
		'zoom_plus_in_b' => '{$Duration:1000,y:-4,$Zoom:11,$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2}',
		'zoom_minus_in_t' => '{$Duration:1200,y:0.6,$Zoom:1,$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2}',
		'zoom_minus_in_b' => '{$Duration:1200,y:-0.6,$Zoom:1,$Easing:{$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad},$Opacity:2}',
		'rotate_v_double_plus_in' => '{$Duration:1200,x:-1,y:2,$Rows:2,$Zoom:11,$Rotate:1,$Assembly:2049,$ChessMode:{$Row:15},$Easing:{$Left:$JssorEasing$.$EaseInCubic,$Top:$JssorEasing$.$EaseInCubic,$Zoom:$JssorEasing$.$EaseInCubic,$Opacity:$JssorEasing$.$EaseOutQuad,$Rotate:$JssorEasing$.$EaseInCubic},$Opacity:2,$Round:{$Rotate:0.8}}'
		
	);

	$transitions_list = apply_filters('ueepb_transition_params_list',$transitions_list);

	if(isset($transitions_list[$key])){
		return $transitions_list[$key];
	}else{
		return $transitions_list['fade'];
	}
}



function ueepb_transitions(){
	$transitions_list = array(
		'fade' 				=> __('Fade','ueepb'),
		'fade_in_t' 		=> __('Fade In Top','ueepb'),
		'fade_in_b' 		=> __('Fade In Bottom','ueepb'),				
		'fade_fly_in_t' => __('Fade Fly In Top','ueepb'),
		'fade_fly_in_b' => __('Fade Fly In Bottom','ueepb'),
		'zoom_plus_in_t' => __('Zoom Plus Top','ueepb'),
		'zoom_plus_in_b' => __('Zoom Plus Bottom','ueepb'),
		'zoom_minus_in_t' => __('Zoom Minus In Top','ueepb'),
		'zoom_minus_in_b' => __('Zoom Minus In Bottom','ueepb'),
		'rotate_v_double_plus_in' => __('Rotate Vertical Double Plus In','ueepb')
	);

	$transitions_list = apply_filters('ueepb_transitions_list',$transitions_list);

	return $transitions_list;
}


