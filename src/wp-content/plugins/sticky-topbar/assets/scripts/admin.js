/**
 *
 * @package Sticky Topbar
 * @author RainaStudio
 * @version 2.0.0
 */
(function( $ ) {
 
  // Add Color Picker to all inputs that have 'color-field' class
  $(function() {
      $('.bg-color-field').wpColorPicker();
  });

  // Toggle
  $(function() {
      var toggle_elm = $(".sticky_topbar_toggle");
      var toggle_elm_ct = $(".sticky_topbar_toggle_content");
      if (!toggle_elm.hasClass("toggle_content_active")){
          toggle_elm_ct.hide();
      }
  });

  $('.sticky_topbar_toggle_title').on( 'click', function event(e) {
      e && e.preventDefault && e.preventDefault();

      var title = jQuery(this),
        element = title.closest(".sticky_topbar_toggle"),
        content = element.find(".sticky_topbar_toggle_content");

      element.hasClass("toggle_content_active") ? content.slideUp({
        duration: 300,
        complete: function() {
          element.removeClass("toggle_content_active")
        }
      }) : content.slideDown({
        duration: 300,
        complete: function() {
          element.addClass("toggle_content_active")
        }
      })
  });

  // Remove 30, 31 date if val not associate
  // $(function(){
  //   var smonth = $(".sticky_cd_mth option");
  //   var sday = $(".sticky_cd_date")
  //   var hday1 = $(".sticky_cd_date").val("30");
  //   var hday2 = $(".sticky_cd_date")

  //   if(smonth.val("Feb")){
  //     hday1.hide();
  //   }

  // });
     
})( jQuery );
