<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Widget_Base;
use \Elementor\Repeater;
use \Elementor\Group_Control_Background;

class Elementor_uae_filter_gallery extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'filter-gallery';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Filterable Gallery', 'uae' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fas fa-border-all';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'ultimate-addons' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		

		$this->start_controls_section(
			'image_section',
			[
				'label' => __( 'Filterable Gallery', 'uae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
            'columns',
            [
                'label' => __('Columns', 'uae'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'prefix_class' => 'elementor-grid%s-',
                'frontend_available' => true,
            ]
        );

        $this->add_responsive_control(
			'img_height',
			[
				'label' => __( 'Image Height [px]', 'uae' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
			]
		);
		
		$this->add_control(
			'hover_effect',
			[
				'label' => __( 'Hover Effect', 'uae' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' 		=> [
		     		'ih_item_fade_effect' 		=> esc_html__('Fade In', 'uae'),
		     		'ih_item_slide_up' 			=> esc_html__('Slide Up', 'uae'),
		     		'ih_item_zoom_in_pro' 			=> esc_html__('Zoom In (Pro)', 'uae'),
		     		'ih_item_card_effect_pro' 		=> esc_html__('Card Style (Pro)', 'uae'),
				],
				'default' 		=> 'ih_item_fade_effect',
			]
		);

		$this->add_control(
			'link_icon',
			[
				'label' => __( 'Link Icon', 'uae' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
                    'value' => 'fas fa-link',
                    'library' => 'fa-solid',
                ],
			]
		);

		$this->add_control(
			'popup_icon',
			[
				'label' => __( 'Lightbox Icon', 'uae' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
                    'value' => 'fas fa-search-plus',
                    'library' => 'fa-solid',
                ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'filter_section',
			[
				'label' => __( 'Filterable Controls', 'uae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'disable_item',
			[
				'label' => __( 'Enable Filter', 'uae' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'all_label',
			[
				'label' => __( 'Gallery All Label', 'uae' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'ALL',
				'condition' => [ 
					'disable_item' => 'yes',
				], 
			]
		);

		$this->add_control(
			'filter_cat',
			[
				'label' => __( 'Categories Name', 'uae' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'gallery, innovation, brand',
				'description' => 'write all categories name seprated with comma e.g gallery, innovation, brand',
				'condition' => [ 
					'disable_item' => 'yes',
				], 
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'filter_list',
			[
				'label' => __( 'Filterable List', 'uae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'list_items',
            [
                'label' => __('List Items', 'uae'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                	[
			            'label' => __('Control Name', 'uae'),
                        'name' => 'controlname',
			            'type' => \Elementor\Controls_Manager::TEXT,
			            'default' => __('gallery', 'uae'),
			            'label_block' 	=> true,
			            'description' => __('Use the gallery control name from Filterable Controls. Separate multiple items with comma (e.g. gallery, innovation, web design)', 'uae'),
			        ],
	        
                    [
                        'name' => 'itemname',
                        'label' => __('Item Name', 'uae'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __('Item Title', 'uae'),
                        'label_block' 	=> true,
                    ],

					[
                        'name' => 'content',
						'label' => esc_html__( 'Item Content', 'uae' ),
						'type' => \Elementor\Controls_Manager::WYSIWYG,
					],

                    [
                        'name' => 'image_id',
						'label' => __( 'Choose Image', 'elementor' ),
						'type' => \Elementor\Controls_Manager::MEDIA,
						'dynamic' => [
							'active' => true,
						],
						'default' => [
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						],
					],

					[
						'label' => __('Link To', 'uae'),
                    	'name' => 'caption_url',
						'type' => \Elementor\Controls_Manager::URL,
						'placeholder' => __('https://your-link.com', 'uae'),
						'show_external' => true,
						'default' => [
							'url' => '',
							'is_external' => false,
							'nofollow' => false,
						],
					],

					
					[
						'label' => __( 'Lightbox Button', 'uae' ),
                    	'name' => 'popup',
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' 		=> [
				     		'disable' 		=> esc_html__('Disable', 'uae'),
				     		'image' 		=> esc_html__('LightBox', 'uae'),
				     		'video' 		=> esc_html__('Video Gallery', 'uae'),
						],
						'default' 		=> 'disable',
					],

					[
                        'label' => __('Video Link', 'uae'),
                        'name' => 'video_url',
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __('https://www.youtube.com/watch?v=WV9x1lyR6BQ', 'uae'),
                        'label_block' 	=> true,
                        'condition' => [
							'popup' => 'video',
						],
                    ],

                ],
                'title_field' => '{{{ itemname }}}',
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'uae_section_pro',
			[
				'label' => __( '<span style="color: #f54;">Go Premium for More Features</span>', 'uae' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'asdasdsadasasdsaf',
            [
                'label' => __( 'Unlock more possibilities', 'uae' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
					'1' => [
						'title' => __( '', 'uae' ),
						'icon' => 'fa fa-unlock-alt',
					],
				],
				'default' => '1',
                'description' => 'Get the <a style="color: #f54; text-decoration: underline;" href="https://genialsouls.com/mega-addons-for-elementor-pro/" target="_blank">Pro version</a> for more stunning elements and customization options.'
            ]
        );
		
		$this->end_controls_section();

		$this->start_controls_section(
			'categ_styles', 
			[
				'label'        => esc_html__('Category Control Styles', 'uae' ),
				'tab'           => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'categ_padding',
			[
				'label' => __( 'Padding', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_ul li.control' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'categ_margin',
			[
				'label' => __( 'Margin', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_ul li.control' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'uae' ),
				'selector' => '{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_ul li.control',
			]
		);

		$this->add_responsive_control(
			'categ_radius',
			[
				'label' => __( 'Border Radius', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_ul li.control' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'categ_menu_typography',
				'label' => __('Typography', 'uae'),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_ul li.control',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'categ_textclr',
			[
				'label' => __( 'Text Color', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_ul li.control' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'categ_textbg',
			[
				'label' => __( 'Background Color', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_ul li.control' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'categ_activeclr',
			[
				'label' => __( 'Active Text Color', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_ul .mixitup-control-active' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'categ_activebg',
			[
				'label' => __( 'Active Background', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_ul .mixitup-control-active' => 'background: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item_hover_styles', 
			[
				'label'        => esc_html__('Item Hover Styles', 'uae' ),
				'tab'           => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'caption_bg',
			[
				'label' => __( 'Background Color', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default'	=>	'rgba(29,161,245,0.7)',
				'input_type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_wrapper .info' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => __( 'Content Padding', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'label' => __( 'Margin', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .ih_item_fade_effect' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .maw_portfolioGallery_container .ih_item_slide_up' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .maw_portfolioGallery_container .ih_item_zoom_in' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .maw_portfolioGallery_container .ih_item_card_effect' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'title_typography_heading',
			[
				'label' => __('Title Typography', 'uae'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'alignment',
			[
				'label' => __( 'Title Alignment', 'uae' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'uae' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'uae' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'uae' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .info h3.filter_gal_title' => 'text-align: {{VALUE}} !important;',
					'{{WRAPPER}} .maw_portfolioGallery_container .card_details h3.filter_gal_title' => 'text-align: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'title_hover_effect_clr',
			[
				'label' => __( 'Title Color', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default'	=>	'#fff',
				'input_type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .info h3.filter_gal_title' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .maw_portfolioGallery_container .card_details h3.filter_gal_title' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __('Typography', 'uae'),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .maw_portfolioGallery_wrapper .info h3.filter_gal_title, 
								{{WRAPPER}} .maw_portfolioGallery_wrapper .card_details h3.filter_gal_title',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_typography_heading',
			[
				'label' => __('Content Typography', 'uae'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_hover_effect_clr',
			[
				'label' => __( 'Content Color', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default'	=>	'#fff',
				'input_type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .info .filter_gal_content *' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .maw_portfolioGallery_container .card_details .filter_gal_content *' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __('Typography', 'uae'),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .maw_portfolioGallery_container .info .filter_gal_content *',
				'selector' => '{{WRAPPER}} .maw_portfolioGallery_container .card_details .filter_gal_content *',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'icon_tab_styles', 
			[
				'label'        => esc_html__('Icon Styling', 'uae' ),
				'tab'           => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_width',
			[
				'label' => __( 'Width/Height [px]', 'uae' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default'	=>	'50',
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_wrapper .portfolio_icon' => 'width: {{SIZE}}px;',
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_wrapper .portfolio_icon' => 'height: {{SIZE}}px;',
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_wrapper .portfolio_icon' => 'line-height: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' 		=> 	'icon_size',
				'label'      => esc_html__('Icon Size (px)', 'uae'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
		        'range' => [
		            '%' => [
		                'min' => 0,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_wrapper .portfolio_icon' => 'font-size: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'iconclr',
			[
				'label' => __( 'Icon Color', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default'	=>	'#fff',
				'input_type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_wrapper .portfolio_icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iconbg',
			[
				'label' => __( 'Icon Background', 'uae' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default'	=>	'#ff622a',
				'input_type' => 'color',
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_wrapper .portfolio_icon' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_margin',
			[
				'label' => __( 'Icon Margin', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_wrapper .portfolio_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'label' => __( 'Border', 'uae' ),
				'selector' => '{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_wrapper .portfolio_icon',
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label' => __( 'Border Radius [px]', 'uae' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .maw_portfolioGallery_container .maw_portfolioGallery_wrapper .portfolio_icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$element_id = $this->get_id();
		$some_id = rand(5, 500);

		ob_start(); 
		?>

		<!--====== HTML CODING START ========-->

		<div class="maw_portfolioGallery_container">
			<div class="controls">
	            <ul class="maw_portfolioGallery_ul" style="">
	            	<?php if ($settings['all_label'] != "") { ?>
	            		<li class="control" data-filter="all">
	            			<?php echo $settings['all_label'] ?>
	            		</li>
	            	<?php }
					if ($settings['filter_cat'] != "") {
						$filterCategory = array_map('trim', explode(',', $settings['filter_cat']));
						foreach ($filterCategory as $categ) {
							$categremovespace = str_replace(' ', '', $categ); ?>
							<li class="control" data-filter=".maw-fg-<?php echo $categremovespace ?>">
								<?php echo $categ ?>
							</li>
						<?php }
					} ?>
	            </ul>
	        </div>

			<div class="maw_portfolioGallery_wrapper maw_portfolioGallery_wrapper<?php echo $some_id ?>">
				<?php foreach ($settings['list_items'] as $list_items) { ?>
					<?php $controlremovespace = str_replace(' ', '', $list_items['controlname']); ?>
			    	<div class="mix maw-fg-<?php echo $controlremovespace; ?>">
			    		<div class="maw_portfolioGallery_ihe">
				        	<div class="<?php echo $settings['hover_effect'] ?>" style="height: <?php echo $settings['img_height']; ?>px;">
							    <div class="a-tag">
							      <div class="img" style="display: flex;">
							      	<img src="<?php echo esc_url($list_items['image_id']['url']); ?>" style="height: <?php echo $settings['img_height']; ?>px; max-width: 100%;">
							      </div>
							      <div class="info">
								    <div style="display:table;width:100%;height:100%;">
							    		<div style="display: table-cell !important;vertical-align: middle !important;">
							    			<h3 class="filter_gal_title">
							    				<?php echo $list_items['itemname']; ?>
							    			</h3>
							    			<div class="filter_gal_content">
							      				<?php echo $list_items['content']; ?>
							      			</div>
											<?php if ($list_items['popup'] == 'image') { ?>
												<a href="<?php echo esc_url($list_items['image_id']['url']); ?>" class="ihe-fancybox" data-fancybox="images" style="">
							      					<i class="<?php echo $settings['popup_icon']['value']; ?> portfolio_icon" style=""></i>
												</a>
											<?php } ?>								
							      			<?php if ($list_items['popup'] == 'video' && $list_items['video_url'] != '') { ?>
												<a href="<?php echo $list_items['video_url']; ?>" class="ihe-fancybox" data-fancybox="images" style="">
							      					<i class="<?php echo $settings['popup_icon']['value']; ?> portfolio_icon" style=""></i>
												</a>
											<?php } ?>
							      			
							      			<?php if ($list_items['caption_url']['url'] != '') { ?>
							      				<a href="<?php echo $list_items['caption_url']['url']; ?>" target="_self">
							      					<i class="<?php echo $settings['link_icon']['value']; ?> portfolio_icon" style=""></i>
							      				</a>
							      			<?php } ?>
							      		</div>
							      	</div>
							      </div>
							    </div>
							</div>
			        	</div>
			        </div>
				<?php } ?>
			</div>
		</div>
		<style>
			.maw_portfolioGallery_wrapper<?php echo $some_id ?> .mix {
			    width: calc(100%/<?php echo $settings['columns']; ?> - (((<?php echo $settings['columns']; ?> - 1) * 1rem) / <?php echo $settings['columns']; ?>)) !important;
			}
			@media screen and (max-width: 961px) {
			    .maw_portfolioGallery_wrapper<?php echo $some_id ?> .mix {
			        width: calc(100%/<?php echo $settings['columns_tablet']; ?> - (((<?php echo $settings['columns_tablet']; ?> - 1) * 1rem) / <?php echo $settings['columns_tablet']; ?>)) !important;
			    }
			}
			@media screen and (max-width: 480px) {
			    .maw_portfolioGallery_wrapper<?php echo $some_id ?> .mix {
			        width: calc(100%/<?php echo $settings['columns_mobile']; ?> - (((<?php echo $settings['columns_mobile']; ?> - 1) * 1rem) / <?php echo $settings['columns_mobile']; ?>)) !important;
			    }
			}
		</style>

		
		<?php
		echo ob_get_clean();

		/*========== HTML CODING END============*/

	}
}