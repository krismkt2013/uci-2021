<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Widget_UEEPB_WooCommerce_Product_Reviews_List extends Widget_Base {

	public function get_name() {
		return 'ueepb-woocommerce-product-reviews-list';
	}

	public function get_title() {
		return __( 'WooCommerce Product Reviews List', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-woocommerce ueepb-element-icon';
	}

	public function get_categories() {
		return [ 'ueepb-woo-elements' ];
	}

	public function get_style_depends() {
        return [
            'ueepb-select2-style',
            'ueepb-woo-element-style',
            'ueepb-front'
        ];
    }

    public function get_script_depends() {
        return [
            'ueepb-select2-script',
            'ueepb-woo-element-script'
        ];
    }

	protected function _register_controls() {
		global $ueepb_woo_product,$wp_roles;
		
		$this->start_controls_section(
			'section_ueepb_woo_product_reviews_list',
			[
				'label' => __( 'WooCommerce Product Reviews', 'ueepb' ),
			]
		);

        $this->add_control(
            'ueepb_woo_product_reviews_product_filter',
            [
                'label'          => __( 'Display Product Filter?', 'ueepb' ),
                'type'           => Controls_Manager::SWITCHER,
                'default'        => '1',
                'label_on'       => __( 'Yes', 'ueepb' ),
                'label_off'      => __( 'No', 'ueepb' ),
                'return_value'   => '1',                
            ]
        );

        $this->add_control(
            'ueepb_woo_product_reviews_display_rating',
            [
                'label'          => __( 'Display Ratings?', 'ueepb' ),
                'type'           => Controls_Manager::SWITCHER,
                'default'        => '1',
                'label_on'       => __( 'Yes', 'ueepb' ),
                'label_off'      => __( 'No', 'ueepb' ),
                'return_value'   => '1',                
            ]
        );


		$this->add_control(
			'ueepb_woo_product_reviews_limit',
			[
				'label' => __( 'Reviews Per Page', 'ueepb' ),
				'type'                  => Controls_Manager::NUMBER,
                'label_block'           => false,
                'default'               => 10,
                'frontend_available'    => true,
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'ueepb_woo_product_reviews_search_styles',
            [
                'label'             => __( 'Search Panel Styles', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'ueepb_woo_product_reviews_search_text_color',
            [
                'label'             => __( 'Search Panel : Text Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-reviews-list-header' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_product_reviews_search_bg_color',
            [
                'label'             => __( 'Search Panel : Background Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-reviews-list-header' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'ueepb_woo_product_reviews_styles',
            [
                'label'             => __( 'Review Styles', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'ueepb_woo_product_reviews_product_title_text_color',
            [
                'label'             => __( 'Product Title Bar : Text Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-reviews-list-table-row-header' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .ueepb-woo-reviews-list-table-row-header a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_product_reviews_product_title_bg_color',
            [
                'label'             => __( 'Product Title Bar : Background Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-reviews-list-table-row-header' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_product_reviews_review_text_color',
            [
                'label'             => __( 'Review : Text Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-reviews-list-table-row-content' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_product_reviews_review_bg_color',
            [
                'label'             => __( 'Review : Background Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-reviews-list-table-row-content' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_product_reviews_review_border_color',
            [
                'label'             => __( 'Reviews : Border Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-reviews-list-table-row' => 'border-color: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'ueepb_woo_product_reviews_buttons_styles',
            [
                'label'             => __( 'Button Styles', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'ueepb_woo_product_reviews_buttons_text_color',
            [
                'label'             => __( 'Buttons : Text Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-reviews-list-header-button' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .ueepb-woo-reviews-load-more' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_product_reviews_buttons_bg_color',
            [
                'label'             => __( 'Buttons : Background Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-reviews-list-header-button' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .ueepb-woo-reviews-load-more' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_product_reviews_buttons_border_color',
            [
                'label'             => __( 'Buttons : Border Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-reviews-list-header-button' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .ueepb-woo-reviews-load-more' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'ueepb_product_reviews_fonts',
            [
                'label'             => __( 'Font Styles', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'ueepb_product_reviews_search_typography',
                'label'             => __( 'Product Search Bar Typography', 'ueepb' ),
                'scheme'            => Scheme_Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .ueepb-woo-reviews-list-header',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'ueepb_product_reviews_content_typography',
                'label'             => __( 'Review Typography', 'ueepb' ),
                'scheme'            => Scheme_Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .ueepb-woo-reviews-list-table',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'ueepb_product_reviews_more_btn_typography',
                'label'             => __( 'Load More Button Typography', 'ueepb' ),
                'scheme'            => Scheme_Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .ueepb-woo-table-load-more-panel',
            ]
        );

        $this->end_controls_section();

	}

	protected function render() {
        global $wpdb;

        wp_enqueue_script('ueepb-select2-script');
        wp_enqueue_style('ueepb-select2-style');

		$settings = $this->get_settings();

		$id_int = substr( $this->get_id_int(), 0, 3 );


        $display_product_filter = '0';
		if ( isset($settings['ueepb_woo_product_reviews_product_filter'] ) && $settings['ueepb_woo_product_reviews_product_filter'] == '1' ) {
            $display_product_filter = '1';
		}

        $display_rating = '0';
        if ( isset($settings['ueepb_woo_product_reviews_display_rating'] ) && $settings['ueepb_woo_product_reviews_display_rating'] == '1' ) {
            $display_rating = '1';
        }

        $pagination_limit = 10;
        if ( isset($settings['ueepb_woo_product_reviews_limit'] ) ) {
            $pagination_limit = absint($settings['ueepb_woo_product_reviews_limit']);
        }
        
						
		?>
		<div class="ueepb-woo-panel ueepb-woocommerce-product-reviews-list-panel">
            <?php if($display_product_filter == '1') { ?>
            <div class="ueepb-woo-reviews-list-header">
                <div class="ueepb-woo-reviews-list-header-label"><?php _e('Product','ueepb'); ?></div>
                <div class="ueepb-woo-reviews-list-header-field">
                    <select placeholder="<?php _e('Select Product','ueepb'); ?>" name="ueepb_woo_review_product" class="ueepb-woo-review-product" ></select>

                </div>
                <div data-limit="<?php echo $pagination_limit;?>" class="ueepb-woo-reviews-list-header-button"><?php _e('Search','ueepb'); ?></div>
                <div class="ueepb-clear"></div>
            </div>
            <?php } ?>

            <div class="ueepb-woo-reviews-list-table">
                <?php
                $sql_total_reviews  = $wpdb->prepare( "SELECT wc.*,wcm.meta_value,wp.post_title,wp.guid FROM {$wpdb->prefix}comments as wc inner join {$wpdb->prefix}commentmeta as wcm on wc.comment_ID=wcm.comment_id  inner join {$wpdb->prefix}posts as wp on wp.ID=wc.comment_post_ID
                        WHERE wc.comment_type = '%s' and wcm.meta_key='%s' and wc.comment_approved=1 order by wc.comment_date desc ", "review","rating" );
                $result_total_reviews = $wpdb->get_results($sql_total_reviews);
                


                $sql_reviews  = $wpdb->prepare( "SELECT wc.*,wcm.meta_value,wp.post_title,wp.guid FROM {$wpdb->prefix}comments as wc inner join {$wpdb->prefix}commentmeta as wcm on wc.comment_ID=wcm.comment_id  inner join {$wpdb->prefix}posts as wp on wp.ID=wc.comment_post_ID
                        WHERE wc.comment_type = '%s' and wcm.meta_key='%s' and wc.comment_approved=1 order by wc.comment_date desc LIMIT %d", "review","rating", $pagination_limit );
                // echo $wpdb->last_query;

                $result_reviews = $wpdb->get_results($sql_reviews);

                $pagination_status = '0';
                if($result_reviews && $result_total_reviews && count($result_total_reviews) > count($result_reviews)){
                    $pagination_status = '1';
                }

                if($result_reviews){
                    foreach ($result_reviews as $key => $result) {
                ?>

                    <div class="ueepb-woo-reviews-list-table-row">
                        <div class="ueepb-woo-reviews-list-table-row-header">
                            <div class="ueepb-woo-reviews-list-product-title"><a href="<?php echo $result->guid; ?>"><?php echo $result->post_title; ?></a></div>
                            <?php if($display_rating == '1') { ?>
                            <div class="ueepb-woo-reviews-list-product-rating"><span><?php _e('Rating','ueepb'); ?> - </span><?php echo esc_html($result->meta_value); ?>/5</div>
                            <?php } ?>
                            <div class="ueepb-clear"></div>
                        </div>
                        <div class="ueepb-woo-reviews-list-table-row-content">
                            <?php echo esc_html($result->comment_content); ?>
                        </div>
                    </div>

                <?php
                        }
                    }

                ?>

            </div>

            <?php if($pagination_status){ ?>

                <div class="ueepb-woo-table-load-more-panel"><div  data-page-id="1"    data-limit="<?php echo $pagination_limit; ?>" class="ueepb-woo-reviews-load-more"><?php _e('Load More Reviews','ueepb'); ?></div>
                </div>
            <?php } ?>

		</div>	
		<?php
	}

	
}

