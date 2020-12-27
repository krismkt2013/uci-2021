'use strict';
(function ($) {
	jQuery(window).on('elementor/frontend/init', function(){
		elementorFrontend.hooks.addAction('frontend/element_ready/pd-is.default', function ($scope, $) {
			var elem_container = $scope.parent('.pd-is-container');
			var elem = $scope.find('.wbel_pd_is_wrapper');

			var is_masonary = 0;
			if( $scope.find('.pd-is-column-type-masonary').length > 0 ){
				is_masonary = 1;
			}
			
			if( is_masonary == 1 ){
				var pd_is_packery = elem.packery({
					  // options
					  itemSelector: '.pd_is_item',
					  gutter: 0
					});
				pd_is_packery.imagesLoaded().progress( function() {
				  pd_is_packery.packery();
				});
			}

			var is_ajax_called = 0;

// '.pd-is-container'
			jQuery(document).on('pd_elem_is_triggered', function(e, __this){
				// console.log('reached');
				is_ajax_called = 1;
				var _this = jQuery(__this);
				console.log(_this);
				var args = _this.data('settings');
				var offset = _this.find('.pd_is_item').length;
				args['offset'] = offset;
				jQuery.ajax({
					// fas fa-spinner fa-spin
					url: pd_is_ajax_object.ajax_url,
					type: 'post',
					data : {
						'action': 'pd_is_load_posts',
						'args' : args,
					},
					beforeSend: function(){
						// _this.find('.fas').addClass('fa-spin');
						// _this.find('.pd_is_load_icon').addClass('pd-is-d-none');
						_this.find('.pd_is_loading_icon').removeClass('pd-is-d-none');
						_this.find('.pd-is-load-more-text').text('Loading');
					},
					complete: function(xhr,status){
						// console.log(xhr.responseText);
						if(_this.find('.pd_is_reach_limit').length > 0){
							_this.find('.pd-is-load-btn').remove();
						}
						// _this.find('.pd-is-load-more-text').text('Load More');
						// _this.find('.pd_is_load_icon').removeClass('pd-is-d-none');
						_this.find('.pd_is_loading_icon').addClass('pd-is-d-none');

						if( is_masonary == 1 ){
							var $container = $scope.find('.wbel_pd_is_wrapper').packery();
							var $html = $( xhr.responseText );
							$container.append( $html );
							$container.packery( 'appended', $html );
							$container.imagesLoaded().progress( function() {
						        $container.packery();
						    });
						}else{
							_this.find('.wbel_pd_is_wrapper').append(xhr.responseText);
						}

						if(_this.find('.wbel_pd_is_wrapper').find('.pd_is_reach_limit').length > 0){
							_this.find('.pd-is-load-btn').addClass('pd-is-d-none');
						}
						is_ajax_called = 0;
					}
				})
			});

			jQuery(window).on('scroll',function(){
				var element_bottom = $('.pd-is-container').innerHeight() + $('.pd-is-container').offset().top- window.innerHeight;
				// console.log('window scrollTop '+$(this).scrollTop());
				// console.log('elementoBottom  '+ element_bottom);
				// console.log('innerHeight  '+ $('.pd-is-container').innerHeight());
				// console.log('Top  '+ $('.pd-is-container').offset().top);
				if ($(this).scrollTop() >= element_bottom ) {
					if( is_ajax_called == 0 ){
						jQuery(document).trigger('pd_elem_is_triggered',$('.pd-is-container'));
					}
				}
			});


		});
	});
})(jQuery);