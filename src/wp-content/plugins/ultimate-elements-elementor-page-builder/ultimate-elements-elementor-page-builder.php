<?php
/*
  Plugin Name: Ultimate Elements - Elementor Page Builder
  Plugin URI: http://wpexpertdeveloper.com/ultimate-elements-elementor-page-builder
  Description: Wide range of UI and feature elements for Elementor page builder.
  Version: 2.0
  Author: Rakhitha Nimesh
  Author URI: http://wpexpertdeveloper.com/
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

function ueepb_load_elements() {
    UEEPB_Elements::get_instance()->init();
}

add_action( 'plugins_loaded', 'ueepb_load_elements' ); 



class UEEPB_Elements {

    private static $instance = null;

    public static function get_instance() {
        if ( ! self::$instance )
            self::$instance = new self;
        return self::$instance;
    }

    public function init(){
        global $ueepb;

    	if ( ! defined( 'UEEPB_PLUGIN_DIR' ) ) {
            define( 'UEEPB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        }

        // Plugin Folder URL
        if ( ! defined( 'UEEPB_PLUGIN_URL' ) ) {
            define( 'UEEPB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
        }

        require_once UEEPB_PLUGIN_DIR.'classes/class-ueepb-template-loader.php';
        require_once UEEPB_PLUGIN_DIR.'classes/class-ueepb-slider-manager.php';
        require_once UEEPB_PLUGIN_DIR.'classes/class-ueepb-menu-manager.php';
        require_once UEEPB_PLUGIN_DIR.'classes/class-ueepb-contact-form7-manager.php';
        require_once UEEPB_PLUGIN_DIR.'classes/class-ueepb-private-content-manager.php';
        require_once UEEPB_PLUGIN_DIR.'classes/class-ueepb-user-manager.php';
        require_once UEEPB_PLUGIN_DIR.'classes/class-ueepb-form-manager.php';
        require_once UEEPB_PLUGIN_DIR.'classes/class-ueepb-woocommerce-manager.php';

        $ueepb = new stdClass;
        $ueepb->template_loader = new UEEPB_Template_Loader();
        $ueepb->slider_manager = new UEEPB_Slider_Manager();
        $ueepb->menu_manager = new UEEPB_Menu_Manager();
        $ueepb->contact_form7 = new UEEPB_Contact_Form7_Manager();
        $ueepb->private_content = new UEEPB_Private_Content_Manager();
        $ueepb->user = new UEEPB_User_Manager();
        $ueepb->forms = new UEEPB_Form_Manager();
        $ueepb->woocommerce = new UEEPB_WooCommerce_Manager();

    	add_action('wp_enqueue_scripts',array( $this,'load_scripts'),9);
        add_action( 'elementor/init', array( $this,'ueepb_add_elementor_category' ) );
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_registered' ) );

        add_action( 'elementor/controls/controls_registered', array( $this, 'register_controls' ) );
        add_action( 'elementor/document/before_save', array( $this, 'elementor_save_data' ) , 10 ,2 );

    }

    public function load_scripts(){
          
        wp_register_style('ueepb-front-style', UEEPB_PLUGIN_URL . 'css/ueepb-front.css');
        wp_enqueue_style( 'ueepb-front-style' );

        wp_register_script('ueepb-front', UEEPB_PLUGIN_URL.'js/ueepb-front.js', array('jquery'));
       
        wp_register_script('ueepb-jssor-slides-script', UEEPB_PLUGIN_URL.'lib/jssor/jssor.slider.mini.js', array('jquery'));
        
        wp_register_script('ueepb-slider-init', UEEPB_PLUGIN_URL.'js/ueepb-slider-init.js', array('jquery'));
       
        wp_register_style('ueepb-viewer-front', UEEPB_PLUGIN_URL . 'css/ueepb-viewer-front.css');        

        wp_register_style('ueepb-image-viewer-style', UEEPB_PLUGIN_URL . 'lib/viewer-master/viewer.css');
        wp_register_script('ueepb-image-viewer-script', UEEPB_PLUGIN_URL.'lib/viewer-master/viewer.js', array('jquery'));


        wp_register_style('ueepb-woo-element-style', UEEPB_PLUGIN_URL . 'css/ueepb-woo-elements.css');
        wp_register_script('ueepb-woo-element-script', UEEPB_PLUGIN_URL.'js/ueepb-woo-elements.js', array('jquery'));

        $custom_js_strings = array(        
            'AdminAjax' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ueepb-front-elements'),
            'messages' => 
                array('add_to_cart' => __('Add to Cart','ueepb'),
                     'processing' => __('Processing...','ueepb'),
                     'failed' => __('Failed','ueepb'),
                     'view_cart' => __('View Cart','ueepb'),
                     'loading' => __('Loading','ueepb'),
                     'load_more' => __('Load More','ueepb'),
                     'next' => __('Next','ueepb'),
                     'previous' => __('Previous','ueepb'),
                     'select_product' => __('Select Product','ueepb'),
                )
        );

        wp_localize_script('ueepb-woo-element-script', 'UEEPB_WOO_ELEMENTS', $custom_js_strings);



        wp_register_style('ueepb-business-style', UEEPB_PLUGIN_URL . 'css/ueepb-business.css');
        wp_register_script('ueepb-business-script', UEEPB_PLUGIN_URL.'js/ueepb-business.js', array('jquery'));


        wp_register_style('ueepb-site-style', UEEPB_PLUGIN_URL . 'css/ueepb-site.css');


        wp_register_script('ueepb-select2-script', UEEPB_PLUGIN_URL.'lib/select2/ueepb-select2.min.js', array('jquery'));

         wp_register_style('ueepb-select2-style', UEEPB_PLUGIN_URL . 'lib/select2/ueepb-select2.min.css');
    }

    public function ueepb_add_elementor_category(){

        \Elementor\Plugin::instance()->elements_manager->add_category(
                'ueepb-media-elements',
                array(
                    'title' => __( 'Ultimate Elements - Media', 'ueepb' ),
                    'icon'  => 'fa fa-plug',
                ),
                1
            );

        \Elementor\Plugin::instance()->elements_manager->add_category(
                 'ueepb-elements',
                 array(
                     'title' => __( 'Ultimate Elements', 'ueepb' ),
                     'icon'  => 'fa fa-plug',
                 ),
                 1
             );

        \Elementor\Plugin::instance()->elements_manager->add_category(
                'ueepb-form-elements',
                array(
                    'title' => __( 'Ultimate Elements - Forms', 'ueepb' ),
                    'icon'  => 'fa fa-plug',
                ),
                1
            );

        \Elementor\Plugin::instance()->elements_manager->add_category(
                'ueepb-business-elements',
                array(
                    'title' => __( 'Ultimate Elements - Business', 'ueepb' ),
                    'icon'  => 'fa fa-plug',
                ),
                1
            );

        \Elementor\Plugin::instance()->elements_manager->add_category(
                'ueepb-site-elements',
                array(
                    'title' => __( 'Ultimate Elements - Site
                        ', 'ueepb' ),
                    'icon'  => 'fa fa-plug',
                ),
                1
            );

        \Elementor\Plugin::instance()->elements_manager->add_category(
                'ueepb-woo-elements',
                array(
                    'title' => __( 'Ultimate Elements - WooCommerce
                        ', 'ueepb' ),
                    'icon'  => 'fa fa-plug',
                ),
                1
            );
        
    }

    public function widgets_registered($widgets_manager) {
        if(defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')){
            
            require_once plugin_dir_path(__FILE__).'/functions.php';

            $widget_files = array('ueepb-image-slider-element.php',
                'ueepb-image-viewer-element.php','ueepb-navigation-menu-element.php'
                ,'forms/ueepb-contact-form7-element.php','ueepb-private-content-element.php'
                ,'forms/ueepb-everest-forms-element.php','forms/ueepb-ninja-forms-element.php'
                ,'forms/ueepb-formidable-forms-element.php','woocommerce/ueepb-woo-product-table-element.php','woocommerce/ueepb-woo-category-list-element.php','woocommerce/ueepb-woo-my-profile-element.php','woocommerce/ueepb-woo-order-tracker-element.php','woocommerce/ueepb-woo-product-reviews-list-element.php','business/ueepb-business-hours-element.php','posts/ueepb-post-title-element.php',
                'site/ueepb-site-title-element.php','site/ueepb-site-tagline-element.php',
                'site/ueepb-site-logo-element.php','site/ueepb-site-links-element.php',

            );

            foreach ($widget_files as $widget_file_item) {
                $widget_file = plugin_dir_path(__FILE__).'widgets/'.$widget_file_item;
                $template_file = locate_template($widget_file);
                if ( !$template_file || !is_readable( $template_file ) ) {
                    $template_file = plugin_dir_path(__FILE__).'widgets/'.$widget_file_item;
                }

                if ( $template_file && is_readable( $template_file ) ) {
                    require_once $template_file;
                }

                
            }

            $widget = new Elementor\Widget_UEEPB_Image_Slider();
            $widgets_manager->register_widget_type( $widget );

            $widget = new Elementor\Widget_UEEPB_Image_Viewer();
            $widgets_manager->register_widget_type( $widget );

            $widget = new Elementor\Widget_UEEPB_Navigation_Menu();
            $widgets_manager->register_widget_type( $widget );

            $widget = new Elementor\Widget_UEEPB_Private_Content();
            $widgets_manager->register_widget_type( $widget );

            

            if ( defined( 'WPCF7_VERSION' ) ) {
                $widget = new Elementor\Widget_UEEPB_Contact_Form7();
                $widgets_manager->register_widget_type( $widget );
            } 

            if(class_exists('Ninja_Forms')){
                $widget = new Elementor\Widget_UEEPB_Ninja_Forms();
                $widgets_manager->register_widget_type( $widget );
            }

            if(class_exists('EverestForms')){
                $widget = new Elementor\Widget_UEEPB_Everest_Forms();
                $widgets_manager->register_widget_type( $widget );
            }             

            if(class_exists('FrmHooksController')){
                $widget = new Elementor\Widget_UEEPB_Formidable_Forms();
                $widgets_manager->register_widget_type( $widget );
            }        

            if(class_exists('WooCommerce')){
                $widget = new Elementor\Widget_UEEPB_WooCommerce_Product_Table();
                $widgets_manager->register_widget_type( $widget );

                $widget = new Elementor\Widget_UEEPB_WooCommerce_My_Profile();
                $widgets_manager->register_widget_type( $widget );

                $widget = new Elementor\Widget_UEEPB_WooCommerce_Category_List();
                $widgets_manager->register_widget_type( $widget );

                $widget = new Elementor\Widget_UEEPB_WooCommerce_Order_Tracker();
                $widgets_manager->register_widget_type( $widget );

                $widget = new Elementor\Widget_UEEPB_WooCommerce_Product_Reviews_List();
                $widgets_manager->register_widget_type( $widget );
            } 

            $widget = new Elementor\Widget_UEEPB_Business_Hours();
            $widgets_manager->register_widget_type( $widget );

            $widget = new Elementor\Widget_UEEPB_Site_Title();
            $widgets_manager->register_widget_type( $widget );

            $widget = new Elementor\Widget_UEEPB_Site_Tagline();
            $widgets_manager->register_widget_type( $widget );

            $widget = new Elementor\Widget_UEEPB_Site_Logo();
            $widgets_manager->register_widget_type( $widget );

            $widget = new Elementor\Widget_UEEPB_Site_Links();
            $widgets_manager->register_widget_type( $widget );
            
        }
    }   

    public function register_controls() {

        $control_files = array('ueepb-select2-control.php' );

        foreach ($control_files as $control_file_item) {
            $control_file = plugin_dir_path(__FILE__).'controls/'.$control_file_item;
            $template_file = locate_template($control_file);
            if ( !$template_file || !is_readable( $template_file ) ) {
                $template_file = plugin_dir_path(__FILE__).'controls/'.$control_file_item;
            }

            if ( $template_file && is_readable( $template_file ) ) {
                require_once $template_file;
            }
        }

        $controls_manager = \Elementor\Plugin::$instance->controls_manager;
        $controls_manager->register_control( 'ueepb_select2', new UEEPB_Select2() );

    } 

    public function elementor_save_data($document,$data) { }

    
}





