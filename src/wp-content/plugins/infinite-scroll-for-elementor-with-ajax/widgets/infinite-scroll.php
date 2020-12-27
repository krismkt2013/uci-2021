<?php
namespace PD_IS\AJAX_LOAD_MORE;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
/**
 * Elementor Post Slider Slider Widget.
 *
 * Main widget that create the Post Slider widget
 *
 * @since 1.0.0
*/
class PD_IS_WIDGET extends \Elementor\Widget_Base
{

	/**
	 * Get widget name
	 *
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'pd-is';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve the widget title.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html( 'Infinite Scroll', 'post-slider-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fas fa-spinner fa-spin';
	}

	/**
	 * Retrieve the widget category.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_categories() {
		return [ 'plugin-devs-element' ];
	}

	/**
	 * Enqueue Style Dependency
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string style Dependencies.
	 */
	public function get_style_depends()
    {
        return [
            'font-awesome-5-all',
            'font-awesome-4-shim',
        ];
    }

    /**
	 * Enqueue Script Dependency
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string script Dependencies.
	 */
    public function get_script_depends()
    {
        return [
            'font-awesome-4-shim'
        ];
    }

	/**
	 * Retrieve the widget category.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'query_configuration',
			[
				'label' => esc_html( 'Query', 'post-slider-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$post_types = pd_is_get_post_types();
		$this->add_control(
			'post_types',
			[
				'label' => esc_html__( 'Post Types', 'post-slider-for-elementor' ),
				'placeholder' => esc_html__( 'Choose Post Types', 'post-slider-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => 'post',
				'options' => $post_types,
			]
		);

		$taxonomies_args = array(
		    'name' => 'category',
		);
		$taxonomies = get_taxonomies($taxonomies_args, 'objects');
		foreach ($taxonomies as $taxonomy => $object) {
            if (!isset($object->object_type[0]) || !in_array($object->object_type[0], array_keys($post_types))) {
                continue;
            }

            $this->add_control(
                $taxonomy . '_ids',
                [
                    'label' => $object->label,
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'object_type' => $taxonomy,
                    'options' => wp_list_pluck(get_terms($taxonomy), 'name', 'term_id'),
                    'condition' => [
                        'post_types' => $object->object_type,
                    ],
                ]
            );
        }

        $this->add_control(
			'posts_per_page',
			[
				'label' => esc_html__( 'Limit', 'post-slider-for-elementor' ),
				'placeholder' => esc_html__( 'Default is 3', 'post-slider-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -1,
				'default' => 3,
			]
		);

		$this->add_control(
			'more_feature_one',
			[
				'label' => __( '<strong>Need More Options:</strong>', 'news-ticker-for-elementor' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'label_block' => false,
				'separator'	=> 'before',
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 12px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="'.PD_IS_PRO_LINK.'" target="_blank" >Buy Pro</a>', 'plugin-domain' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item_configuration',
			[
				'label' => esc_html( 'Item Configurtion', 'post-slider-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'template_style',
			[
				'label' => esc_html__( 'Template Style', 'post-slider-for-elementor' ),
				'placeholder' => esc_html__( 'Choose Template from Here', 'post-slider-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' => 'default',
				'options' => [
					'default'  => esc_html__( 'Default', 'post-slider-for-elementor' ),
					// 'style-2'  => esc_html__( 'Template 2', 'post-slider-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'display_image',
			[
				'label' => esc_html__( 'Show Image', 'post-slider-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'post-slider-for-elementor' ),
				'label_off' => esc_html__( 'No', 'post-slider-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail_size',
				'default' => 'medium',
				'condition' => [
					'display_image'	=>	'yes',
				]
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label' => __( 'Read More:', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Read More', 'post-slider-for-elementor'),
				// 'label_block' => true,
				// 'description'	=>	'Change Read More Text from Here',
			]
		);

		$this->add_control(
			'more_feature_two',
			[
				'label' => __( '<strong>Need More Options:</strong>', 'news-ticker-for-elementor' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'label_block' => false,
				'separator'	=> 'before',
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 12px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="'.PD_IS_PRO_LINK.'" target="_blank" >Buy Pro</a>', 'plugin-domain' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style_section',
			[
				'label' => esc_html( 'Title Style', 'post-slider-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'title_link_tabs'
		);

		$this->start_controls_tab(
			'title_link_normal_tab',
			[
				'label' => __( 'Normal', 'plugin-name' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'post-slider-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pd_is_title a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_link_hover_tab',
			[
				'label' => __( 'Hover', 'plugin-name' ),
			]
		);
		$this->add_control(
			'title_hover_color',
			[
				'label' => __( 'Hover Color', 'post-slider-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pd_is_title a:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'more_feature_three',
			[
				'label' => __( '<strong>Need More Options:</strong>', 'news-ticker-for-elementor' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'label_block' => false,
				'separator'	=> 'before',
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 12px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="'.PD_IS_PRO_LINK.'" target="_blank" >Buy Pro</a>', 'plugin-domain' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_style_section',
			[
				'label' => esc_html( 'Content Style', 'post-slider-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Color', 'post-slider-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pd_is_description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'content_background',
				'label' => __( 'Background', 'plugin-domain' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pd_is_content',
			]
		);

		$this->add_control(
			'more_feature_four',
			[
				'label' => __( '<strong>Need More Options:</strong>', 'news-ticker-for-elementor' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'label_block' => false,
				'separator'	=> 'before',
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 12px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="'.PD_IS_PRO_LINK.'" target="_blank" >Buy Pro</a>', 'plugin-domain' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'read_more_style_section',
			[
				'label' => esc_html( 'Read More Style', 'post-slider-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'read_more_style_tabs'
		);

		$this->start_controls_tab(
			'read_more_normal_tab',
			[
				'label' => __( 'Normal', 'plugin-name' ),
			]
		);

		$this->add_control(
			'read_more_color',
			[
				'label' => __( 'Color', 'post-slider-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pd_is_readmore_link' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'read_more_border',
				'label' => __( 'Border', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .pd_is_readmore_link',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'read_more_background',
				'label' => __( 'Background', 'plugin-domain' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pd_is_readmore_link',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'read_more_hover_tab',
			[
				'label' => __( 'Hover', 'plugin-name' ),
			]
		);

		$this->add_control(
			'read_more_hover_color',
			[
				'label' => __( 'Color', 'post-slider-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pd_is_readmore_link:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'read_more_hover_border',
				'label' => __( 'Border', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .pd_is_readmore_link:hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'read_more_hover_background',
				'label' => __( 'Background', 'plugin-domain' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pd_is_readmore_link:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'more_feature_five',
			[
				'label' => __( '<strong>Need More Options:</strong>', 'news-ticker-for-elementor' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'label_block' => false,
				'separator'	=> 'before',
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 12px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="'.PD_IS_PRO_LINK.'" target="_blank" >Buy Pro</a>', 'plugin-domain' ),
			]
		);

		$this->end_controls_section();


		// Arrow Style
		$this->start_controls_section(
			'nav_arrow_style_section',
			[
				'label' => esc_html( 'Load More Style', 'post-slider-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->start_controls_tabs(
			'nav_arrow_style_tabs'
		);

		$this->start_controls_tab(
			'nav_arrow_normal_tab',
			[
				'label' => __( 'Normal', 'plugin-name' ),
			]
		);

		/*$this->add_control(
			'nav_arrow_width',
			[
				'label' => __( 'Width', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pd_is_loadmore_btn' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'nav_arrow_height',
			[
				'label' => __( 'Height', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pd_is_loadmore_btn' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);*/

		$this->add_control(
			'load_more_btn_color',
			[
				'label' => __( 'Color', 'post-slider-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pd_is_loadmore_btn' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'load_more_btn_border',
				'label' => __( 'Border', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .pd_is_loadmore_btn',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'load_more_btn_background',
				'label' => __( 'Background', 'plugin-domain' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pd_is_loadmore_btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'nav_arrow_hover_tab',
			[
				'label' => __( 'Hover', 'plugin-name' ),
			]
		);

		$this->add_control(
			'load_more_btn_hover_color',
			[
				'label' => __( 'Color', 'post-slider-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pd_is_loadmore_btn:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'load_more_btn_border_hover',
				'label' => __( 'Border', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .pd_is_loadmore_btn:hover',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'load_more_btn_hover_background',
				'label' => __( 'Background', 'plugin-domain' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pd_is_loadmore_btn:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'more_feature_six',
			[
				'label' => __( '<strong>Need More Options:</strong>', 'news-ticker-for-elementor' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'label_block' => false,
				'separator'	=> 'before',
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 12px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="'.PD_IS_PRO_LINK.'" target="_blank" >Buy Pro</a>', 'plugin-domain' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'others_style_section',
			[
				'label' => esc_html( 'Others Style', 'post-slider-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'full_content_box_shadow',
				'label' => __( 'Box Shadow', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .pd_is_single_item',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'label' => __( 'Image Box Shadow', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .pd_is_thumbnail img',
			]
		);

		$this->add_control(
			'more_feature_seven',
			[
				'label' => __( '<strong>Need More Options:</strong>', 'news-ticker-for-elementor' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'label_block' => false,
				'separator'	=> 'before',
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 12px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="'.PD_IS_PRO_LINK.'" target="_blank" >Buy Pro</a>', 'plugin-domain' ),
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$element_id = 'pd_is'.$this->get_id();
		$settings_args = [];

		$template_style = $settings['template_style'];
		
		$columns_per_row = 3;
		$read_more_text = isset($settings['read_more_text']) && $settings['read_more_text'] ? $settings['read_more_text'] : 'Load More';


		$args = array();

		$args['post_type'] = $settings['post_types'];
		$args['post_status'] = 'publish';

		if( isset($settings['posts_per_page']) && intval($settings['posts_per_page']) > 0 ){
			$args['posts_per_page'] = $settings['posts_per_page'];
		}

		if( isset($settings['posts_per_page']) && intval($settings['posts_per_page']) == -1 ){
			$args['posts_per_page'] = $settings['posts_per_page'];
		}

        
        $tax_query = [];
        if( $args['post_type'] && $args['post_type'] != 'none' ){
	        if( $args['post_type'] !== 'page' ) {
	            $args['tax_query'] = [];
	            $taxonomies = get_object_taxonomies($settings['post_types'], 'objects');

	            foreach ($taxonomies as $object) {
	            	if( $object->name == 'category' ){
		                $setting_key = $object->name . '_ids';
		                
		                $settings_args[$object->name . '_ids'] = $settings[$setting_key];

		                if (!empty($settings[$setting_key])) {
		                    $args['tax_query'][] = [
		                        'taxonomy' => $object->name,
		                        'field' => 'term_id',
		                        'terms' => $settings[$setting_key],
		                    ];
		                }
	                }
	            }

	            if (!empty($args['tax_query'])) {
	                $args['tax_query']['relation'] = 'AND';
	            }
	        }


	        /*$slick_attr = '{';
	        $responsive_slider_control = isset($settings['slider_responsive_control']) && !empty(isset($settings['slider_responsive_control'])) ? $settings['slider_responsive_control'] : array();
	        if( !empty($responsive_slider_control) ){
	        	$slick_attr .= '"responsive": [';
	        	foreach ($responsive_slider_control as $rsc_index => $rsc_item) {
	        		$slick_attr .= '{
						"breakpoint": '.$rsc_item['breakpoint_size'].',
				        "settings": {
				        	"slidesToShow": '.$rsc_item['columns_per_row'].',
				        	"slidesToScroll": '.$rsc_item['slides_to_scroll'].',
				        	"rows": '.$rsc_item['rows_to_show'].',
							"slidesPerRow": '.$rsc_item['rows_per_group'].'
				        }';
				    if( $rsc_index == (count($responsive_slider_control) - 1) ){
				    	$slick_attr .= '}';	
				    }else{
	        			$slick_attr .= '},';
				    }
	        	}
	        	$slick_attr .= ']';
	        }
	        $slick_attr .= '}';*/
	        $column_type = 'default';
	        $column_type_class='pd-is-column-type-default';
	        $tax_query = json_encode($args['tax_query']);

$settings_args['template_style'] = $template_style;
$settings_args['read_more_text'] = $read_more_text;
$settings_args['post_types'] = $this->get_settings_for_display( 'post_types' );
$settings_args['posts_per_page'] = $this->get_settings_for_display( 'posts_per_page' );
$settings_args['thumbnail_size_size'] = $this->get_settings_for_display( 'thumbnail_size_size' );
$settings_args['thumbnail_size_custom_dimension'] = $this->get_settings_for_display( 'thumbnail_size_custom_dimension' );
$settings_args['display_image'] = $this->get_settings_for_display( 'display_image' );
$settings_args['id'] = $element_id;
// echo $this->get_settings_for_display( 'thumbnail_size_size' ); //die();
// print_r($settings_args);
	        echo '<div
	        		class="pd-is-container '.$column_type_class.'"
	        		id="wbel_pd_is_'.esc_attr($element_id).'"
	        		data-post_types="'.$settings['post_types'].'"
	        		data-tax_query="'.esc_attr($tax_query).'"
	        		data-posts_per_page="'.esc_attr($settings['posts_per_page']).'"
	        		data-settings="'.esc_attr(json_encode($settings_args)).'"
	        	>';
			        echo '<div
			        		class="wbel_pd_is_wrapper wbel_pd_is_'.$template_style.'"
			        	>';
			        $post_query = new \WP_Query($args);
			        if( $post_query->have_posts() ){
			        	$count=0;
						while( $post_query->have_posts() ){
							$post_query->the_post();
							$count++;
							$thumbnail_id = get_post_thumbnail_id();
							require( PD_IS_PATH . 'templates/style-1/template.php' );
						}
						wp_reset_postdata();
					}
					echo "</div>";
				// echo 'found_posts '.$post_query->post_count;
				if( $post_query->post_count < $post_query->found_posts ){
			
		?>
					<div class="pd-is-load-btn">
						<a class="pd_is_loadmore_btn" href="#">
							<!-- <span class="pd_is_load_icon"><?php \Elementor\Icons_Manager::render_icon( $settings['load_more_arrow_icon'], [ 'aria-hidden' => 'true' ] ); ?></span> -->
							<span class="pd_is_loading_icon pd-is-d-none">
								<i class='fas fa-spinner fa-spin'></i>
							</span>
							<span class="pd-is-load-more-text">Load More</span>
						</a>
					</div>
		<?php
				}
			echo "</div>";

		}

	}


}
