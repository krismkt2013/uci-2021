<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_WooCommerce_Product_Table extends Widget_Base {

	public function get_name() {
		return 'ueepb-woocommerce-product-table';
	}

	public function get_title() {
		return __( 'WooCommerce Product Table', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-woocommerce ueepb-element-icon';
	}

	
    public function get_categories() {
        return [ 'ueepb-woo-elements' ];
    }

    public function get_style_depends() {
        return [
            'ueepb-woo-element-style'
        ];
    }

    public function get_script_depends() {
        return [
            'ueepb-woo-element-script'
        ];
    }

	protected function _register_controls() {
		global $ueepb_woo_product,$wp_roles;
		
		$this->start_controls_section(
			'section_ueepb_woo_product',
			[
				'label' => __( 'WooCommerce Product Table', 'ueepb' ),
			]
		);

		$product_list_types = array('all' => __( 'All Products', 'ueepb' ), 'best_selling' => __( 'Best Selling Products', 'ueepb' ), 'top_rated' => __( 'Top Rated Products', 'ueepb' ) , 'featured' => __( 'Featured Products', 'ueepb' ) );		

		$this->add_control(
			'ueepb_woo_product_table_product_list_type',
			[
				'label' => __( 'Product List Type', 'ueepb' ),
				'type' => Controls_Manager::SELECT2,
				'default' => 'all',
				'options' => $product_list_types,
			]
		);

		$category_list = array('0' => __( 'All Categories', 'ueepb' ));		
		$product_categories = get_terms(array('taxonomy'   => "product_cat"));
		if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ){
		    foreach ( $product_categories as $product_category ) {
		    	$category_list[$product_category->slug] = $product_category->name;
		    }
		}

		$this->add_control(
			'ueepb_woo_product_table_category',
			[
				'label' => __( 'Product Category', 'ueepb' ),
				'type' => Controls_Manager::SELECT2,
				'default' => '0',
				'options' => $category_list,
			]
		);

		$tags_list = array('0' => __( 'All Tags', 'ueepb' ));		
		$product_tags = get_terms(array('taxonomy'   => "product_tag"));
		if ( ! empty( $product_tags ) && ! is_wp_error( $product_tags ) ){
		    foreach ( $product_tags as $product_tag ) {
		    	$tags_list[$product_tag->slug] = $product_tag->name;
		    }
		}

		$this->add_control(
			'ueepb_woo_product_table_tag',
			[
				'label' => __( 'Product Tag', 'ueepb' ),
				'type' => Controls_Manager::SELECT2,
				'default' => '0',
				'options' => $tags_list,
			]
		);


		$this->add_control(
			'ueepb_woo_product_table_stock_status',
			[
				'label' => __( 'Stock Status', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'instock',
				'options' => array('instock' => __( 'In Stock', 'ueepb' ),
								'outofstock' => __( 'Out of Stock', 'ueepb' )),
			]
		);

		$this->add_control(
			'ueepb_woo_product_table_orderby',
			[
				'label' => __( 'Order By', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array('ID' => __( 'ID', 'ueepb' ),
								'date' => __( 'Date', 'ueepb' )
								,'name' => __( 'Name', 'ueepb' )
								,'type' => __( 'Type', 'ueepb' )
								,'rand' => __( 'Random', 'ueepb' )
								,'modified' => __( 'Modified Date', 'ueepb' )),
			]
		);

		$this->add_control(
			'ueepb_woo_product_table_order',
			[
				'label' => __( 'Order', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => array('desc' => __( 'Descending', 'ueepb' ),
								'asc' => __( 'Ascending', 'ueepb' )),
			]
		);

		$this->add_control(
			'ueepb_woo_product_table_limit',
			[
				'label'       => __( 'Limit', 'ueepb' ),
				'type'        => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'ueepb_woo_product_table_pagination',
			[
				'label' => __( 'Pagination', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => array('yes' => __( 'Enabled', 'ueepb' ),
								'no' => __( 'Disabled', 'ueepb' )),
			]
		);

		$this->add_control(
			'ueepb_woo_product_table_restricted_message',
			[
				'label' => __( 'Restricted Message', 'ueepb' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
			]
		);

		$visibility_type = array('all' => __('All Users','ueepb'),
			'guests' => __('Guests','ueepb'), 'members' => __('Members','ueepb'),
			'user_roles' => __('User Roles','ueepb'));

		$this->add_control(
			'ueepb_woo_product_table_visibility',
			[
				'label' => __( 'Visibility', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => $visibility_type,
			]
		);

		$user_roles = array('0' => __( 'Select User Role', 'ueepb' ) );

		foreach( $wp_roles->role_names as $role => $name ) {
            $user_roles[$role] = $name;
        }

		$this->add_control(
			'ueepb_woo_product_table_user_roles',
			[
				'label' => __( 'User Roles', 'ueepb' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $user_roles,
			]
		);

		$this->end_controls_section();



		$this->start_controls_section(
            'ueepb_woo_product_table_colors',
            [
                'label'             => __( 'Table Colors', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
            'ueepb_woo_product_table_heading_bg',
            [
                'label'             => __( 'Heading - Background Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-table-head' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_product_table_heading_hover_bg',
            [
                'label'             => __( 'Heading - Background Color on Hover', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-table-head:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );


        $this->add_control(
            'ueepb_woo_product_table_odd_rows_bg',
            [
                'label'             => __( 'Odd Rows - Background Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-table-row:nth-child(odd) .ueepb-woo-table-cell' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        

        $this->add_control(
            'ueepb_woo_product_table_even_rows_bg',
            [
                'label'             => __( 'Even Rows - Background Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-table-row:nth-child(even) .ueepb-woo-table-cell' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_product_table_rows_hover_bg',
            [
                'label'             => __( 'Rows - Background Color on Hover', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-table-row:hover .ueepb-woo-table-cell' => 'background-color: {{VALUE}}',
                ],
            ]
        );


        // Header, Text, Border
        $this->add_control(
            'ueepb_woo_product_table_header_text_color',
            [
                'label'             => __( 'Header Text Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-table-head' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_product_table_text_color',
            [
                'label'             => __( 'Text Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-table-cell' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_product_table_link_color',
            [
                'label'             => __( 'Link Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-table-cell a' => 'color : {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_product_table_border_color',
            [
                'label'             => __( 'Border Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-table-row:last-child .ueepb-woo-table-cell' => 'border-bottom: 1px solid {{VALUE}}',
                    '{{WRAPPER}} .ueepb-woo-table-cell' => 'border-top: 1px solid {{VALUE}}',
                    '{{WRAPPER}} .ueepb-woo-table-cell' => 'border-left: 1px solid {{VALUE}}',
                    '{{WRAPPER}} .ueepb-woo-table-head' => 'border-top: 1px solid {{VALUE}}',
                    '{{WRAPPER}} .ueepb-woo-table-head' => 'border-left: 1px solid {{VALUE}}',
                    '{{WRAPPER}} .ueepb-woo-table-head:last-child' => 'border-right: 1px solid {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

       
        $this->start_controls_section(
            'ueepb_woo_product_table_more_styles',
            [
                'label'             => __( 'Load More Button Styles', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'ueepb_woo_product_table_more_btn_color',
            [
                'label'             => __( 'Text Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-table-load-more' => 'color : {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_product_table_more_btn_bg_color',
            [
                'label'             => __( 'Background Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-table-load-more' => 'background-color : {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
			'ueepb_woo_product_table_more_btn_padding',
			[
				'label'             => __( 'Padding', 'ueepb' ),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => [ 'px', '%' ],
				'default'           => [
                    'top'       => '15',
                    'right'     => '15',
                    'bottom'    => '15',
                    'left'      => '15',
                    'unit'      => 'px',
                    'isLinked'  => false,
                ],
				'selectors'         => [
					'{{WRAPPER}} .ueepb-woo-table-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator'         => 'before',
			]
		);

		$this->add_responsive_control(
			'ueepb_woo_product_table_more_btn_margin',
			[
				'label'             => __( 'Margin', 'ueepb' ),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => [ 'px', '%' ],
				'default'           => [
                    'top'       => '10',
                    'right'     => '10',
                    'bottom'    => '10',
                    'left'      => '10',
                    'unit'      => 'px',
                    'isLinked'  => false,
                ],
				'selectors'         => [
					'{{WRAPPER}} .ueepb-woo-table-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator'         => 'before',
			]
		);


        $this->end_controls_section();


        $this->start_controls_section(
            'ueepb_woo_product_table_add_cart_styles',
            [
                'label'             => __( 'Add to Cart Button Styles', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'ueepb_woo_product_table_add_cart_btn_color',
            [
                'label'             => __( 'Text Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#fff',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-table-add-to-cart' => 'color : {{VALUE}}',
                    '{{WRAPPER}} .ueepb-woo-table-action-link a' => 'color : {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_woo_product_table_add_cart_btn_bg_color',
            [
                'label'             => __( 'Background Color', 'ueepb' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#e04a4a',
                'selectors'         => [
                    '{{WRAPPER}} .ueepb-woo-table-add-to-cart' => 'background-color : {{VALUE}}',
                    '{{WRAPPER}} .ueepb-woo-table-action-link' => 'background-color : {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
			'ueepb_woo_product_table_add_cart_btn_padding',
			[
				'label'             => __( 'Padding', 'ueepb' ),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => [ 'px', '%' ],
				'default'           => [
                    'top'       => '5',
                    'right'     => '5',
                    'bottom'    => '5',
                    'left'      => '5',
                    'unit'      => 'px',
                    'isLinked'  => false,
                ],
				'selectors'         => [
					'{{WRAPPER}} .ueepb-woo-table-add-to-cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ueepb-woo-table-action-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator'         => 'before',
			]
		);

		$this->add_responsive_control(
			'ueepb_woo_product_table_add_cart_btn_margin',
			[
				'label'             => __( 'Margin', 'ueepb' ),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => [ 'px', '%' ],
				'default'           => [
                    'top'       => '5',
                    'right'     => '0',
                    'bottom'    => '5',
                    'left'      => '0',
                    'unit'      => 'px',
                    'isLinked'  => false,
                ],
				'selectors'         => [
					'{{WRAPPER}} .ueepb-woo-table-add-to-cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ueepb-woo-table-action-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					
				],
                'separator'         => 'before',
			]
		);


        $this->end_controls_section();

        $this->start_controls_section(
            'ueepb_woo_product_table_fonts',
            [
                'label'             => __( 'Font Styles', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'ueepb_woo_product_table_header_typography',
                'label'             => __( 'Header Typography', 'ueepb' ),
                'scheme'            => Scheme_Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .ueepb-woo-table-head',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'ueepb_woo_product_table_content_typography',
                'label'             => __( 'Content Typography', 'ueepb' ),
                'scheme'            => Scheme_Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .ueepb-woo-table-cell',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'ueepb_woo_product_table_load_more_typography',
                'label'             => __( 'Load More Button Typography', 'ueepb' ),
                'scheme'            => Scheme_Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .ueepb-woo-table-cell',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'ueepb_woo_product_table_add_cart_typography',
                'label'             => __( 'Add to Cart Button Typography', 'ueepb' ),
                'scheme'            => Scheme_Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .ueepb-woo-table-cell',
            ]
        );

        $this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		$id_int = substr( $this->get_id_int(), 0, 3 );
		$this->add_render_attribute( 'shortcode', 'id_int', $id_int );

		if ( isset($settings['ueepb_woo_product_table_product_list_type'] ) ) {
			$this->add_render_attribute( 'shortcode', 'product_list_type', sanitize_text_field($settings['ueepb_woo_product_table_product_list_type']) );
		}

		if ( isset($settings['ueepb_woo_product_table_category'] ) && $settings['ueepb_woo_product_table_category'] != '0' ) {
			$this->add_render_attribute( 'shortcode', 'category', sanitize_text_field($settings['ueepb_woo_product_table_category']) );
		}
		if ( isset($settings['ueepb_woo_product_table_tag'] ) && $settings['ueepb_woo_product_table_tag'] != '0' ) {
			$this->add_render_attribute( 'shortcode', 'tag', sanitize_text_field($settings['ueepb_woo_product_table_tag']) );
		}
		if ( isset($settings['ueepb_woo_product_table_stock_status'] )  ) {
			$this->add_render_attribute( 'shortcode', 'stock_status', sanitize_text_field($settings['ueepb_woo_product_table_stock_status']) );
		}

		if ( isset($settings['ueepb_woo_product_table_pagination'] ) ) {
			$this->add_render_attribute( 'shortcode', 'paginate', sanitize_text_field($settings['ueepb_woo_product_table_pagination']) );
		}
		if ( isset($settings['ueepb_woo_product_table_limit'] ) ) {
			if($settings['ueepb_woo_product_table_limit'] == ''){
				$settings['ueepb_woo_product_table_limit'] = 10;
			}
			$this->add_render_attribute( 'shortcode', 'limit', absint($settings['ueepb_woo_product_table_limit']) );
		}
		if ( isset($settings['ueepb_woo_product_table_order'] ) ) {
			$this->add_render_attribute( 'shortcode', 'order', sanitize_text_field($settings['ueepb_woo_product_table_order']) );
		}
		if ( isset($settings['ueepb_woo_product_table_orderby'] ) ) {
			$this->add_render_attribute( 'shortcode', 'orderby', sanitize_text_field($settings['ueepb_woo_product_table_orderby']) );
		}




		if ( isset($settings['ueepb_woo_product_table_restricted_message'] ) ) {
			$this->add_render_attribute( 'shortcode', 'message', sanitize_text_field($settings['ueepb_woo_product_table_restricted_message']) );
		}
		if ( isset($settings['ueepb_woo_product_table_visibility'] ) ) {
			$this->add_render_attribute( 'shortcode', 'visibility', sanitize_text_field($settings['ueepb_woo_product_table_visibility']) );
		}
		if ( isset($settings['ueepb_woo_product_table_user_roles'] ) ) {
			$this->add_render_attribute( 'shortcode', 'user_role', sanitize_text_field($settings['ueepb_woo_product_table_user_roles']) );
		}
				
		?>
		<div class="ueepb-woo-panel ueepb-woo-product-table-panel">
			<?php
			echo do_shortcode( '[ueepb_woocommerce_product_table  ' . $this->get_render_attribute_string( 'shortcode' ) . ']' );
			?>
		</div>
		<?php
	}
}

