<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_WooCommerce_Category_List extends Widget_Base {

	public function get_name() {
		return 'ueepb-woocommerce-category-list';
	}

	public function get_title() {
		return __( 'WooCommerce Category List', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-woocommerce ueepb-element-icon';
	}

	public function get_categories() {
		return [ 'ueepb-woo-elements' ];
	}

	public function get_style_depends() {
        return [
            'ueepb-woo-element-style',
            'ueepb-front'
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
			'section_ueepb_woo_cat_list',
			[
				'label' => __( 'WooCommerce Category List', 'ueepb' ),
			]
		);

    $this->add_control(
            'ueepb_woo_cat_list_hide_empty',
            [
                'label'          => __( 'Hide Empty', 'ueepb' ),
                'type'           => Controls_Manager::SWITCHER,
                'default'        => '1',
                'label_on'       => __( 'Yes', 'ueepb' ),
                'label_off'      => __( 'No', 'ueepb' ),
                'return_value'   => '1',                
            ]
        );


		$this->add_control(
			'ueepb_woo_cat_list_columns',
			[
				'label' => __( 'Columns', 'ueepb' ),
				'type'                  => Controls_Manager::NUMBER,
                'label_block'           => false,
                'default'               => 4,
                'frontend_available'    => true,
			]
		);

    $this->add_control(
        'ueepb_woo_cat_list_limit',
        [
            'label' => __( 'Category Limit', 'ueepb' ),
            'type'                  => Controls_Manager::NUMBER,
            'label_block'           => false,
            'default'               => -1,
            'frontend_available'    => true,
        ]
    );

    $this->add_control(
      'ueepb_woo_cat_list_orderby',
      [
        'label' => __( 'Order By', 'ueepb' ),
        'type' => Controls_Manager::SELECT,
        'default' => 'name',
        'options' => ['name' => __('Name','ueepb'),'id' => __('ID','ueepb'),
                    'slug' => __('Slug','ueepb'),'menu_order' => __('Menu Order','ueepb')],
      ]
    );

    $this->add_control(
      'ueepb_woo_cat_list_order',
      [
        'label' => __( 'Order', 'ueepb' ),
        'type' => Controls_Manager::SELECT,
        'default' => 'asc',
        // 'class' => 'ueepb_woo_cat_list_order',
        'options' => ['asc' => __('Ascending','ueepb'),'desc' => __('Descending','ueepb')],
      ]
    );

		$this->end_controls_section();

    
	}

	protected function render() {
		$settings = $this->get_settings();

		$id_int = substr( $this->get_id_int(), 0, 3 );
		$this->add_render_attribute( 'shortcode', 'id_int', $id_int );

    wp_enqueue_style('ueepb-woo-element-style');
    wp_enqueue_script('ueepb-woo-element-script');

		if ( isset($settings['ueepb_woo_cat_list_columns'] ) ) {
			$this->add_render_attribute( 'shortcode', 'columns', sanitize_text_field($settings['ueepb_woo_cat_list_columns']) );
		}

    if ( isset($settings['ueepb_woo_cat_list_limit'] ) ) {
        $this->add_render_attribute( 'shortcode', 'limit', sanitize_text_field($settings['ueepb_woo_cat_list_limit']) );
    }

    if ( isset($settings['ueepb_woo_cat_list_hide_empty'] ) ) {
        $this->add_render_attribute( 'shortcode', 'hide_empty', sanitize_text_field($settings['ueepb_woo_cat_list_hide_empty']) );
    }
    if ( isset($settings['ueepb_woo_cat_list_order'] ) ) {
        $this->add_render_attribute( 'shortcode', 'order', sanitize_text_field($settings['ueepb_woo_cat_list_order']) );
    }
    if ( isset($settings['ueepb_woo_cat_list_orderby'] ) ) {
        $this->add_render_attribute( 'shortcode', 'orderby', sanitize_text_field($settings['ueepb_woo_cat_list_orderby']) );
    }
        
						
		?>
		<div class="ueepb-woo-panel ueepb-woocommerce-category-list-panel">
			<?php
            echo do_shortcode( '[product_categories ' . $this->get_render_attribute_string( 'shortcode' ) . ']' );
            // https://github.com/elementor/elementor/issues/3337
			?>

		</div>	
		<?php
	}

	
}

