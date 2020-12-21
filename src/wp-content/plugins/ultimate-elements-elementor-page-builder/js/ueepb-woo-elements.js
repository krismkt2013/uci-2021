jQuery(document).ready(function($) {
    


    $(document).on('click','.ueepb-woo-table-add-to-cart', function(e){
        var woo_add_to_cart_btn = $(this);
        woo_add_to_cart_btn.html(UEEPB_WOO_ELEMENTS.messages.processing);
        var add_to_cart_message = woo_add_to_cart_btn.parent().find('.ueepb-woo-table-add-cart-message');
        
        add_to_cart_message.html('');
        $.post(
            UEEPB_WOO_ELEMENTS.AdminAjax,
            {
                'action': 'ueepb_woo_ajax_add_to_cart',
                'verify_nonce': UEEPB_WOO_ELEMENTS.nonce,
                'product_id':   $(this).attr('data-product-id'),
            },
            function(response){             
                if(!response.error){      
                    woo_add_to_cart_btn.html(UEEPB_WOO_ELEMENTS.messages.add_to_cart); 
                    add_to_cart_message.html('<a target="_blank" href="'+ response.view_cart_url +'">' + UEEPB_WOO_ELEMENTS.messages.view_cart + '</a>');            
                }else{
                    add_to_cart_message.html(UEEPB_WOO_ELEMENTS.messages.failed);
                }      
            },"json"
        );

    });
    
    $(document).on('click','.ueepb-woo-table-load-more', function(e){
    	var woo_load_more_btn = $(this);
        woo_load_more_btn.html(UEEPB_WOO_ELEMENTS.messages.loading);

		$.post(
            UEEPB_WOO_ELEMENTS.AdminAjax,
            {
                'action': 'ueepb_load_woo_products_list',
                'verify_nonce': UEEPB_WOO_ELEMENTS.nonce,
                'page_id':   $(this).attr('data-page-id'),
                'limit':   $(this).attr('data-limit'),
                'stock_status':   $(this).attr('data-stock-status'),
                'category':   $(this).attr('data-category'),
                'tag':   $(this).attr('data-tag'),
                'paginate':   $(this).attr('data-paginate'),     
                'product_list_type':   $(this).attr('data-product-list-type'),             
            },
            function(response){            	
                if(response.status == 'success'){ 
                    woo_load_more_btn.html(UEEPB_WOO_ELEMENTS.messages.load_more);               	
					woo_load_more_btn.closest('.ueepb-woo-table-container').find('.ueepb-woo-table-row').last().after(response.items);
                	woo_load_more_btn.attr('data-page-id',response.page_id);
                	if(!(response.pagination_status) ){
                		woo_load_more_btn.remove();
                	}
                }      
            },"json"
        );
    	// }
    });

    // $('.ueepb-woo-profile-orders').attr('href','#');

    $(document).on('click','.ueepb-woo-profile-orders-next', function(e){ 
        e.preventDefault();
        var woo_order_next_btn = $(this);
        var page_id = woo_order_next_btn.attr('data-next-page');
        woo_order_next_btn.html(UEEPB_WOO_ELEMENTS.messages.loading);
       
        $.post(
            UEEPB_WOO_ELEMENTS.AdminAjax,
            {
                'action': 'ueepb_woo_profile_orders_paginate',
                'verify_nonce': UEEPB_WOO_ELEMENTS.nonce,
                'page_id':   page_id,
            },
            function(response){             
                if(!response.error){      
                    woo_order_next_btn.closest('.ueepb-woo-profile-orders').html(response.content); 
                    woo_order_next_btn.html(UEEPB_WOO_ELEMENTS.messages.next);
                }else{

                }      
            },"json"
        );

    });

    $(document).on('click','.ueepb-woo-profile-orders-prev', function(e){
        e.preventDefault();
        var woo_order_next_btn = $(this);
        var page_id = woo_order_next_btn.attr('data-next-page');
        woo_order_next_btn.html(UEEPB_WOO_ELEMENTS.messages.loading);
       
        $.post(
            UEEPB_WOO_ELEMENTS.AdminAjax,
            {
                'action': 'ueepb_woo_profile_orders_paginate',
                'verify_nonce': UEEPB_WOO_ELEMENTS.nonce,
                'page_id':   page_id,
            },
            function(response){             
                if(!response.error){      
                    woo_order_next_btn.closest('.ueepb-woo-profile-orders').html(response.content); 
                    woo_order_next_btn.html(UEEPB_WOO_ELEMENTS.messages.previous);
                }else{

                }      
            },"json"
        );

    });

    $(document).on('click','.ueepb-my-account-tab-item', function(e){
        e.preventDefault();
        var tab_item = $(this);
        var tab_item_class = tab_item.attr('data-content-tab');
        tab_item.closest('.ueepb-my-account-panel').find('.ueepb-my-account-tab-item').removeClass('ueepb-active-tab');
        tab_item.addClass('ueepb-active-tab');
       
        tab_item.closest('.ueepb-my-account-panel').find('.ueepb-my-account-tab-content-item').hide();
        tab_item.closest('.ueepb-my-account-panel').find('.'+tab_item_class).show();

        
    });


    if($(".ueepb-woo-review-product").length){
        $('.ueepb-woo-review-product').ueepb_select2({
            placeholder: UEEPB_WOO_ELEMENTS.messages.select_product,
            allowClear: true,
            ajax: {
                url: UEEPB_WOO_ELEMENTS.AdminAjax,
                dataType: 'json',
                delay: 250,
                method: "POST",
                data: function (params) {
                  return {
                    q: params.term, // search term
                    action: 'ueepb_load_woo_single_product',
                    verify_nonce: UEEPB_WOO_ELEMENTS.nonce,
                  };
                },
                processResults: function (data, page) {
                  
                  return {
                    results: data.items
                  };
                },
                cache: true
              },
              escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
              minimumInputLength: 1,
              templateResult: ueepb_formatRepo, // omitted for brevity, see the source of this page
              templateSelection: ueepb_formatRepoSelection
        });
    }

    $(document).on('click','.ueepb-woo-reviews-list-header-button', function(e){
        e.preventDefault();
        var woo_review_btn = $(this);
        var product_id = woo_review_btn.closest('.ueepb-woo-reviews-list-header').find('.ueepb-woo-review-product').val();
        var reviews_list_panel = woo_review_btn.closest('.ueepb-woocommerce-product-reviews-list-panel');
        var woo_load_more_btn = reviews_list_panel.find('.ueepb-woo-reviews-load-more')
                    
        woo_review_btn.closest('.ueepb-woocommerce-product-reviews-list-panel').
                    find('.ueepb-woo-reviews-list-table').html("");
        woo_load_more_btn.hide();

        $.post(
            UEEPB_WOO_ELEMENTS.AdminAjax,
            {
                'action': 'ueepb_woo_reviews_by_product',
                'verify_nonce': UEEPB_WOO_ELEMENTS.nonce,
                'product_id':   product_id,
                'limit' : woo_review_btn.attr('data-limit'),
            },
            function(response){             
                if(!response.error){ 
                    reviews_list_panel.find('.ueepb-woo-reviews-list-table').html(response.content); 
                                            
                    if(response.pagination_status == '1'){
                        woo_load_more_btn.attr('data-page-id',response.page_id);  
                        woo_load_more_btn.html(UEEPB_WOO_ELEMENTS.messages.load_more);
                        woo_load_more_btn.show();
                    }else{
                        woo_load_more_btn.hide();
                    } 
                }      
            },"json"
        );

    });


    $(document).on('click','.ueepb-woo-reviews-load-more', function(e){
        var woo_load_more_btn = $(this);
        woo_load_more_btn.html(UEEPB_WOO_ELEMENTS.messages.loading);

        var product_id = woo_load_more_btn.closest('.ueepb-woocommerce-product-reviews-list-panel').find('.ueepb-woo-review-product').val();
        $.post(
            UEEPB_WOO_ELEMENTS.AdminAjax,
            {
                'action': 'ueepb_woo_reviews_paginate',
                'verify_nonce': UEEPB_WOO_ELEMENTS.nonce,
                'page_id':   $(this).attr('data-page-id'),
                'limit':   $(this).attr('data-limit'),
                'product_id':   product_id,
                            
            },
            function(response){             
                if(!response.error){ 
                    var reviews_list_panel = woo_load_more_btn.closest('.ueepb-woocommerce-product-reviews-list-panel');
                    reviews_list_panel.find('.ueepb-woo-reviews-list-table').append(response.content); 
                    if(response.pagination_status == '1'){
                        woo_load_more_btn.attr('data-page-id',response.page_id);  
                        woo_load_more_btn.html(UEEPB_WOO_ELEMENTS.messages.load_more);
                    }else{
                        woo_load_more_btn.hide();
                    }
                                          
                }      
            },"json"
        );
        // }
    });
});
