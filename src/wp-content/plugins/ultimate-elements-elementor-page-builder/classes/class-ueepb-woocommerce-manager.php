<?php

class UEEPB_WooCommerce_Manager{

	public function __construct(){
		
		add_action('wp_ajax_ueepb_load_woo_single_product', array($this, 'load_woo_single_product'));

        add_action('wp_ajax_ueepb_load_woo_products_list', array($this, 'load_woo_products_list'));
        add_action('wp_ajax_nopriv_ueepb_load_woo_products_list', array($this, 'load_woo_products_list'));

        add_shortcode('ueepb_woocommerce_product_table', array($this, 'woocommerce_product_table'));

        // Add to cart from list
        add_action('wp_ajax_ueepb_woo_ajax_add_to_cart', array($this, 'add_product_to_cart'));
        add_action('wp_ajax_nopriv_ueepb_woo_ajax_add_to_cart', array($this, 'add_product_to_cart'));

        add_shortcode('ueepb_woo_my_orders', array($this, 'my_orders'));        
        add_shortcode('ueepb_woo_my_downloads', array($this, 'my_downloads'));
        add_shortcode('ueepb_woo_my_account', array($this, 'my_account'));
        add_shortcode('ueepb_woo_my_dashboard', array($this, 'my_dashboard'));
        add_shortcode('ueepb_woo_my_profile', array($this, 'my_profile'));

        add_action('wp_ajax_ueepb_woo_profile_orders_paginate', array($this, 'profile_orders_paginate'));
        add_action('wp_ajax_nopriv_ueepb_woo_profile_orders_paginate', array($this, 'profile_orders_paginate'));

        add_action('wp_ajax_ueepb_woo_reviews_by_product', array($this, 'reviews_by_product'));
        add_action('wp_ajax_nopriv_ueepb_woo_reviews_by_product', array($this, 'reviews_by_product'));


        add_action('wp_ajax_ueepb_woo_reviews_paginate', array($this, 'paginate_reviews'));
        add_action('wp_ajax_nopriv_ueepb_woo_reviews_paginate', array($this, 'paginate_reviews'));

        
	}

	public function load_woo_single_product(){
        global $wpdb;
        
        $post_json_results = array();

        $search_text  = isset($_POST['q']) ? sanitize_text_field($_POST['q']) : '';

        $query = "SELECT * FROM $wpdb->posts WHERE $wpdb->posts.post_title like '%".$search_text."%' && $wpdb->posts.post_status='publish'  && $wpdb->posts.post_type='product' order by $wpdb->posts.post_date desc limit 20";
        $result = $wpdb->get_results($query);
        if($result){
            foreach($result as $post_row){
                array_push($post_json_results , array('id' => $post_row->ID, 'name' => $post_row->post_title) ) ;
            }
        }
        echo json_encode(array('items' => $post_json_results ));exit;
    }

    public function woocommerce_product_table($atts,$content){
        global $ueepb;

        
        $atts = shortcode_atts(array(
            'paginate' => 'yes',
            'limit' => 10,
            'orderby' => 'date', //ID', 'name', 'type', 'rand', 'date', 'modified'.
            'order' => 'DESC',
            'tag' => '',
            'category' => '',
            'stock_status' => 'instock',  // outofstock
            'product_list_type' => 'all',
            'message' => '',
            'visibility' => 'all',
            'user_role' => '0'
        ), $atts);

        wp_enqueue_style('ueepb-woo-element-style');
        wp_enqueue_script('ueepb-woo-element-script');

        if($atts['paginate'] == 'yes'){
            $paginate = true;
        }else{
            $paginate = false;
        }

        $args = array(
            'status' => 'publish',
            'paginate' => $paginate, 
            'limit' => $atts['limit'],
            'stock_status' => $atts['stock_status'],
            'orderby' => $atts['orderby'], 
            'order' => $atts['order'],
        );

        if($atts['tag'] != ''){
            $args['tag'] = explode(',',$atts['tag']);
        }

        if($atts['category'] != ''){ 
            $args['category'] = explode(',',$atts['category']);
        }

        

        switch ($atts['product_list_type']) {
            case 'all':
                break;
            
            case 'best_selling':
                $args['meta_key'] = 'total_sales';
                $args['orderby'] = 'meta_value_num';
                break;

            case 'top_rated':
                $args['meta_key'] = '_wc_average_rating';
                $args['orderby'] = 'meta_value_num';
                break;

        }


        $products = wc_get_products( $args );
        
        $content .= '<div class="ueepb-woo-table-container">';
        $content .= '<table class="ueepb-woo-table">';
        $content .= ' <tr class="ueepb-woo-table-row">';
        $content .= '   <th class="ueepb-woo-table-head">'.__('Image','ueepb').'</th>';
        $content .= '   <th class="ueepb-woo-table-head">'.__('Product Name','ueepb').'</th>';
        $content .= '   <th class="ueepb-woo-table-head">'.__('Categories','ueepb').'</th>';
        $content .= '   <th class="ueepb-woo-table-head">'.__('In Stock','ueepb').'</th>';
        $content .= '   <th class="ueepb-woo-table-head">'.__('Product Price','ueepb').'</th>';
        $content .= ' </tr>';
        
        $content .= $this->get_products_table($products,$paginate);
        
        $content .= ' </table>';
        
        if( $products->max_num_pages > 1 ){

            $content .= ' <div class="">';
            $content .= '   <div class="ueepb-woo-table-load-more-panel"><div  data-page-id="1" data-category="'.$atts['category'].'" data-tag="'.$atts['tag'].'" data-stock-status="'.$atts['stock_status'].'" data-limit="'.$atts['limit'].'" data-paginate="'.$atts['paginate'].'"  data-product-list-type="'.$atts['product_list_type'].'" 
             class="ueepb-woo-table-load-more">'.__('Load More Products','ueepb').'</div></div>';
            $content .= ' </div>';
        }
        $content .= ' </div>';


        if($ueepb->private_content->verify_permission($atts,$content)){
            $content = $content;
        }else{
            $content = $atts['message'];
        }
        
        return $content;
    }

    public function get_products_table($products,$paginate){

        $content = '';

        if($paginate){
            $products_list = $products->products;
        }else{
            $products_list = $products;
        }

        foreach ($products_list as $key => $product_object ) {
            $data = $product_object->get_data();

            $product_image = absint($data['image_id']);
            $product_image = wp_get_attachment_image_src($product_image);

            $product_categories = (array) $data['category_ids'];

            $product_categories_display = array();
            foreach ($product_categories as $key => $product_category) {
                $category = get_term_by( 'id', absint( $product_category ), 'product_cat' );
                
                
                $product_categories_display[] = $category->name;
            }

            if(is_array($product_categories_display)){
                $product_categories_display = implode(',', $product_categories_display);
            }else{
                $product_categories_display = '-';
            }

            $product_id = $product_object->get_ID();

            $content .= ' <tr class="ueepb-woo-table-row">';
            $content .= '   <td class="ueepb-woo-table-cell ueepb-woo-table-product-image"><a href="'.get_permalink($product_id).'"><img class="ueepb-woo-table_thumbnail" src="'.$product_image[0].'" /></a>';

            $product           = wc_get_product( $product_id );
            $product_link = get_permalink( $product_id );

            switch ($product->get_type()) {
                case 'simple':
                    $content .= '<div data-product-id="'.$product_id.'" class="ueepb-woo-table-add-to-cart">'.__('Add to Cart','ueepb').'</div><div class="ueepb-woo-table-add-cart-message"></div>';
                    break;

                case 'grouped':
                    $content .= '<div data-product-id="'.$product_id.'" class="ueepb-woo-table-action-link"><a href="'.$product_link.'" target="_blank">'.__('View Products','ueepb').'</a></div>';
                    break;

                case 'variable':
                    $content .= '<div data-product-id="'.$product_id.'" class="ueepb-woo-table-action-link"><a href="'.$product_link.'" target="_blank">'.__('Select Options','ueepb').'</a></div>';
                    break;
                
                default:
                    $content .= '<div data-product-id="'.$product_id.'" class="ueepb-woo-table-add-to-cart">'.__('Add to Cart','ueepb').'</div>';
                    break;
            }
            

            $content .= '</td>';

            $data_stock_status = __('In Stock','ueepb');
            if($data['stock_status'] == 'outofstock'){
                $data_stock_status = __('Out of Stock','ueepb');
            }

            $content .= '   <td class="ueepb-woo-table-cell"><a href="'.get_permalink($product_object->get_ID()).'">'.$data['name'].'</a></td>';            
            $content .= '   <td class="ueepb-woo-table-cell">'.$product_categories_display.'</td>';
            $content .= '   <td class="ueepb-woo-table-cell">'.$data_stock_status.'</td>';
            $content .= '   <td class="ueepb-woo-table-cell">'.$data['price'].'</td>';
            $content .= ' </tr>';
        }

        return $content;
    }


    public function load_woo_products_list(){
        global $wpdb;
        
        $post_json_results = array();
        if(!check_ajax_referer( 'ueepb-front-elements', 'verify_nonce',false )){
            $data = array('error' => true);
            echo wp_send_json($data);exit;
        }

        $page_id  = isset($_POST['page_id']) ? absint($_POST['page_id']) : 1;
        $product_list_type  = isset($_POST['product_list_type']) ? sanitize_text_field($_POST['product_list_type']) : 'all';
        $category  = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
        $tag  = isset($_POST['tag']) ? sanitize_text_field($_POST['tag']) : '';
        $stock_status  = isset($_POST['stock_status']) ? sanitize_text_field($_POST['stock_status']) : 'instock';
        $paginate  = isset($_POST['paginate']) ? sanitize_text_field($_POST['paginate']) : 'yes';
        $limit  = isset($_POST['limit']) ? absint($_POST['limit']) : 10;

        if($paginate == 'yes'){
            $paginated = true;
        }else{
            $paginated = false;
        }


        $args = array(
            'status' => 'publish',
            'paginate' => $paginated, // if removed line 89 should be $products instead of $products->products
            'limit' => $limit,
            'offset' => $page_id * $limit,
            'stock_status' => $stock_status,
        );

        if($tag != ''){
            $args['tag'] = explode(',',$tag);
        }

        if($category != ''){ 
            $args['category'] = explode(',',$category);
        }

        switch ($product_list_type) {
            case 'all':
                break;
            
            case 'best_selling':
                $args['meta_key'] = 'total_sales';
                $args['orderby'] = 'meta_value_num';
                break;

            case 'top_rated':
                $args['meta_key'] = '_wc_average_rating';
                $args['orderby'] = 'meta_value_num';
                break;

        }
        
        $products = wc_get_products( $args );

        $pagination_status = true;
        if($products->max_num_pages == ($page_id + 1 ) ){
            $pagination_status = false;
        }

        $content = $this->get_products_table($products,$paginated);

        echo json_encode(array('status' => 'success', 'pagination_status' => $pagination_status , 'items' => $content ,
          'page_id' => ( $page_id + 1) ));exit;
    }


    
        
    public function add_product_to_cart() {

        if(!check_ajax_referer( 'ueepb-front-elements', 'verify_nonce',false )){
            $data = array('error' => true);
            echo wp_send_json($data);exit;
        }

        $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $quantity = 1;
        
        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status = get_post_status($product_id);
        $variation_id      = 0;
        $variation         = array();

        $product           = wc_get_product( $product_id );
        if ( $product && 'variation' === $product->get_type() ) {
            $variation_id = $product_id;
            $product_id   = $product->get_parent_id();
            $variation    = $product->get_variation_attributes();
        }

        if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation ) && 'publish' === $product_status ) {

            do_action('woocommerce_ajax_added_to_cart', $product_id);

            if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                wc_add_to_cart_message(array($product_id => $quantity), true);
            }

            // WC_AJAX :: get_refreshed_fragments();

            $data = array(
                'success' => true,
                'view_cart_url' => wc_get_cart_url());

            echo wp_send_json($data);
        } else {

            $data = array(
                'error' => true,
                'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

            echo wp_send_json($data);
        }

        wp_die();
    }


    public function my_orders($atts,$content){
        global $ueepb,$ueepb_woo_profile_order_params;

        wp_enqueue_style('ueepb-woo-element-style');
        wp_enqueue_script('ueepb-woo-element-script');

        $current_page    = 1;
        $customer_orders = wc_get_orders(
            apply_filters(
                'woocommerce_my_account_my_orders_query',
                array(
                    'customer' => get_current_user_id(),
                    'page'     => $current_page,
                    'paginate' => true,
                )
            )
        );

        

        $content = '<div class="ueepb-woo-profile-orders">';
       

        $ueepb_woo_profile_order_params = array(
                                            'current_page'    => absint( $current_page ),
                                            'customer_orders' => $customer_orders,
                                            'has_orders'      => 0 < $customer_orders->total,
                                        );

        ob_start();
        $ueepb->template_loader->get_template_part('orders','profile');  

        $content .= ob_get_clean();
        $content .= '</div>';

        return $content;
    }

    public function profile_orders_paginate() {
        global $ueepb,$ueepb_woo_profile_order_params;

        if(!check_ajax_referer( 'ueepb-front-elements', 'verify_nonce',false )){
            $data = array('error' => true);
            echo wp_send_json($data);exit;
        }

        $page_id = isset($_POST['page_id']) ? absint($_POST['page_id']) : 1;
        
        $customer_orders = wc_get_orders(
            apply_filters(
                'woocommerce_my_account_my_orders_query',
                array(
                    'customer' => get_current_user_id(),
                    'page'     => $page_id,
                    'paginate' => true,
                )
            )
        );

        $ueepb_woo_profile_order_params = array(
                                            'current_page'    => absint( $page_id ),
                                            'customer_orders' => $customer_orders,
                                            'has_orders'      => 0 < $customer_orders->total,
                                        );

        ob_start();
        $ueepb->template_loader->get_template_part('orders','profile');
        $content .= ob_get_clean();

        $result = array(
            'content'  => $content,
            'error' => false
        );
        wp_send_json($result);
        wp_die();
    }

    public function my_downloads($atts,$content){
        global $ueepb,$ueepb_woo_profile_order_params;

        wp_enqueue_style('ueepb-woo-element-style');
        wp_enqueue_script('ueepb-woo-element-script');

        ob_start();
        $ueepb->template_loader->get_template_part('downloads','profile');

        $content .= ob_get_clean();

        return $content;

    }

    public function my_account($atts,$content){
        global $ueepb,$ueepb_woo_profile_order_params;

        wp_enqueue_style('ueepb-woo-element-style');
        wp_enqueue_script('ueepb-woo-element-script');

        ob_start();
        $ueepb->template_loader->get_template_part('account-info','profile');

        $content .= ob_get_clean();

        return $content;

    }

    public function my_dashboard($atts,$content){
        global $ueepb,$ueepb_woo_profile_order_params;

        wp_enqueue_style('ueepb-woo-element-style');
        wp_enqueue_script('ueepb-woo-element-script');

        ob_start();
        $ueepb->template_loader->get_template_part('dashboard','profile');

        $content .= ob_get_clean();

        return $content;

    }

    public function my_profile($atts,$content){
        global $ueepb,$ueepb_woo_my_profile_params;

        $atts = shortcode_atts(array(
            'display_header' => 'yes',
            'display_header_image' => 'yes',
            'display_header_name' => 'yes',
            'display_header_logout' => 'yes',            
        ), $atts);

        $ueepb_woo_my_profile_params = $atts;

        wp_enqueue_style('ueepb-woo-element-style');
        wp_enqueue_script('ueepb-woo-element-script');

        ob_start();

        if(is_user_logged_in()){
           $ueepb->template_loader->get_template_part('my','profile'); 
           $content .= ob_get_clean();
       }else{
           $content = do_shortcode('[woocommerce_my_account]');
       }

       return $content;
    }

    public function reviews_by_product() {
        global $ueepb,$wpdb;

        if(!check_ajax_referer( 'ueepb-front-elements', 'verify_nonce',false )){
            $data = array('error' => true);
            echo wp_send_json($data);exit;
        }

        $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
        $limit = isset($_POST['limit']) ? absint($_POST['limit']) : 0;
        
        $sql_total_reviews  = $wpdb->prepare( "SELECT wc.*,wcm.meta_value,wp.post_title,wp.guid FROM {$wpdb->prefix}comments as wc inner join {$wpdb->prefix}commentmeta as wcm on wc.comment_ID=wcm.comment_id  inner join {$wpdb->prefix}posts as wp on wp.ID=wc.comment_post_ID  WHERE wc.comment_type = '%s' and wcm.meta_key='%s' and wc.comment_approved=1 and wp.ID=%d order by wc.comment_date desc ", "review","rating",$product_id );
        $result_total_reviews = $wpdb->get_results($sql_total_reviews);


        $sql_reviews  = $wpdb->prepare( "SELECT wc.*,wcm.meta_value,wp.post_title,wp.guid FROM {$wpdb->prefix}comments as wc inner join {$wpdb->prefix}commentmeta as wcm on wc.comment_ID=wcm.comment_id  inner join {$wpdb->prefix}posts as wp on wp.ID=wc.comment_post_ID  WHERE wc.comment_type = '%s' and wcm.meta_key='%s' and wc.comment_approved=1 and wp.ID=%d order by wc.comment_date desc limit %d   ", "review","rating",$product_id, $limit );
        $result_reviews = $wpdb->get_results($sql_reviews);

        $pagination_status = '0';
        $page_id = $page_id + 1;
        if($result_reviews && $result_total_reviews && count($result_total_reviews) > ($page_id*$limit) ){
            $pagination_status = '1';
            
        }
        

        ob_start();

        if($result_reviews){
            foreach ($result_reviews as $key => $result) {
                ?>
                <div class="ueepb-woo-reviews-list-table-row">
                    <div class="ueepb-woo-reviews-list-table-row-header">
                        <div class="ueepb-woo-reviews-list-product-title"><a href="<?php echo $result->guid; ?>"><?php echo $result->post_title; ?></a></div>
                        <div class="ueepb-woo-reviews-list-product-rating"><?php echo esc_html($result->meta_value); ?></div>
                        <div class="ueepb-clear"></div>
                    </div>
                    <div class="ueepb-woo-reviews-list-table-row-content">
                        <?php echo esc_html($result->comment_content); ?>
                    </div>
                </div>
                <?php
            }
        }

        $content .= ob_get_clean();

        $result = array(
            'content'  => $content,
            'error' => false,
            'pagination_status' => $pagination_status,
            'page_id' => $page_id
        );
        wp_send_json($result);
        wp_die();
    }

    public function paginate_reviews() {
        global $ueepb,$wpdb;

        if(!check_ajax_referer( 'ueepb-front-elements', 'verify_nonce',false )){
            $data = array('error' => true);
            echo wp_send_json($data);exit;
        }

        $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
        $limit = isset($_POST['limit']) ? absint($_POST['limit']) : 0;
        $page_id = isset($_POST['page_id']) ? absint($_POST['page_id']) : 1;
        $offset = ($page_id * $limit);
        
        $product_query_clause = "";
        if($product_id != 0){
            $product_query_clause = " and wp.ID=$product_id ";
        }

        $sql_total_reviews  = $wpdb->prepare( "SELECT wc.*,wcm.meta_value,wp.post_title,wp.guid FROM {$wpdb->prefix}comments as wc inner join {$wpdb->prefix}commentmeta as wcm on wc.comment_ID=wcm.comment_id  inner join {$wpdb->prefix}posts as wp on wp.ID=wc.comment_post_ID  WHERE wc.comment_type = '%s' and wcm.meta_key='%s' and wc.comment_approved=1 $product_query_clause order by wc.comment_date desc ", "review","rating",$product_id);
        $result_total_reviews = $wpdb->get_results($sql_total_reviews);


        $sql_reviews  = $wpdb->prepare( "SELECT wc.*,wcm.meta_value,wp.post_title,wp.guid FROM {$wpdb->prefix}comments as wc inner join {$wpdb->prefix}commentmeta as wcm on wc.comment_ID=wcm.comment_id  inner join {$wpdb->prefix}posts as wp on wp.ID=wc.comment_post_ID  WHERE wc.comment_type = '%s' and wcm.meta_key='%s' and wc.comment_approved=1 $product_query_clause order by wc.comment_date desc limit %d offset %d  ", "review","rating",$limit, $offset );       

        $result_reviews = $wpdb->get_results($sql_reviews);
       
// echo $page_id*$limit;
        $pagination_status = '0';
        $page_id = $page_id + 1;
        if($result_reviews && $result_total_reviews && count($result_total_reviews) > ($page_id*$limit) ){
            $pagination_status = '1';
            
        }
        
        ob_start();

        if($result_reviews){
            foreach ($result_reviews as $key => $result) {
                ?>
                <div class="ueepb-woo-reviews-list-table-row">
                    <div class="ueepb-woo-reviews-list-table-row-header">
                        <div class="ueepb-woo-reviews-list-product-title"><a href="<?php echo $result->guid; ?>"><?php echo $result->post_title; ?></a></div>
                        <div class="ueepb-woo-reviews-list-product-rating"><?php echo esc_html($result->meta_value); ?></div>
                        <div class="ueepb-clear"></div>
                    </div>
                    <div class="ueepb-woo-reviews-list-table-row-content">
                        <?php echo esc_html($result->comment_content); ?>
                    </div>
                </div>
                <?php
            }
        }

        $content .= ob_get_clean();

        $result = array(
            'content'  => $content,
            'error' => false,
            'pagination_status' => $pagination_status,
            'page_id' => $page_id
        );
        wp_send_json($result);
        wp_die();

        
    }
}