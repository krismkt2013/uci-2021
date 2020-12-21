jQuery(document).ready(function   ($) {

  var jssor_SlideshowTransitions = [UEEPB_Slider.transition_effect];


  var jssor_options = {
    $AutoPlay: UEEPB_Slider.options,
    //UEEPB_Slider.additional_options,
    $SlideshowOptions: {
      $Class: $JssorSlideshowRunner$,
      $Transitions: jssor_SlideshowTransitions,
      $TransitionsOrder: 1
    },
    $ArrowNavigatorOptions: {
      $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
      $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
      $AutoCenter: 0,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
      $Steps: 1 
    }
    
  };
//console.log(jssor_options);

  var jssor_slider = new $JssorSlider$('<?php echo "ueepb-slider-container-'+UEEPB_Slider.post_id, jssor_options);
  
  function ueepb_responsive_ScaleSlider() {
      //console.log($('#<?php echo "ueepb-slider-container-'+UEEPB_Slider.post_id));
      var parentWidth = $('#<?php echo "ueepb-slider-container-'+UEEPB_Slider.post_id).parent().width();
      if (parentWidth) {
          jssor_slider.$ScaleWidth(parentWidth);
      }
      else
          window.setTimeout(ueepb_responsive_ScaleSlider, 30);
  }
  //Scale slider after document ready
  ueepb_responsive_ScaleSlider();
                                  
  //Scale slider while window load/resize/orientationchange.
  $(window).bind("load", ueepb_responsive_ScaleSlider);
  $(window).bind("resize", ueepb_responsive_ScaleSlider);
  $(window).bind("orientationchange", ueepb_responsive_ScaleSlider);
});