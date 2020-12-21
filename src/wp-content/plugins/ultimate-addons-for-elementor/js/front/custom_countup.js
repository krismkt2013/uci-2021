jQuery(document).ready(function($) {
  jQuery('.messive-wrapper-counter').each(function(index, el) {
    var delay = ($(this).data('delay') != '') ? $(this).data('delay') : '10';
    var time = ($(this).data('time') != '') ? $(this).data('time') : '1000';
    jQuery(this).find('.main-counter').counterUp({
          delay: parseInt(delay),
          time: parseInt(time)
      });
  });
});