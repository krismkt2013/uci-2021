<?php
/**
 Plugin Name: Infinite Scroll for Elementor with Ajax
 Description: Infinite Scroll for Elementor with Ajax
 Author: Plugin Devs
 Author URI: https://plugin-devs.com/
 Version: 0.9.2
 License: GPLv2
 License URI: https://www.gnu.org/licenses/gpl-2.0.html
 Text Domain: pd-is
*/

 // Exit if accessed directly.
 if ( ! defined( 'ABSPATH' ) ) { exit; }

 /**
  * Main class for News Ticker
  */
class PD_IS_SLIDER
 {
 	
 	private static $instance;

	public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new PD_IS_SLIDER();
            self::$instance->init();
        }
        return self::$instance;
    }

    //Empty Construct
 	function __construct(){}
 	
 	//initialize Plugin
 	public function init(){
 		$this->defined_constants();
 		$this->include_files();
		add_action( 'elementor/init', array( $this, 'pd_is_create_category') ); // Add a custom category for panel widgets
 	}

 	//Defined all constants for the plugin
 	public function defined_constants(){
 		define( 'PD_IS_PATH', plugin_dir_path( __FILE__ ) );
		define( 'PD_IS_URL', plugin_dir_url( __FILE__ ) ) ;
		define( 'PD_IS_VERSION', '0.9.2' ) ; //Plugin Version
		define( 'PD_IS_MIN_ELEMENTOR_VERSION', '2.0.0' ) ; //MINIMUM ELEMENTOR Plugin Version
		define( 'PD_IS_MIN_PHP_VERSION', '5.4' ) ; //MINIMUM PHP Plugin Version
		define( 'PD_IS_PRO_LINK', 'https://plugin-devs.com/product/elementor-infinite-scroll/' ) ; //Pro Link
 	}

 	//Include all files
 	public function include_files(){

 		require_once( PD_IS_PATH . 'functions.php' );
 		require_once( PD_IS_PATH . 'admin/infinite-scroll-utils.php' );
 		if( is_admin() ){
 			require_once( PD_IS_PATH . 'admin/admin-pages.php' );	
 			require_once( PD_IS_PATH . 'class-plugin-deactivate-feedback.php' );	
 			require_once( PD_IS_PATH . 'support-page/class-support-page.php' );	
 		}
 		require_once( PD_IS_PATH . 'class-ajax.php' );
 	}

 	//Elementor new category register method
 	public function pd_is_create_category() {
	   \Elementor\Plugin::$instance->elements_manager->add_category( 
		   	'plugin-devs-element',
		   	[
		   		'title' => esc_html( 'Plugin Devs Element', 'news-ticker-for-elementor' ),
		   		'icon' => 'fa fa-plug', //default icon
		   	],
		   	2 // position
	   );
	}

 	// prevent the instance from being cloned
    private function __clone(){}

    // prevent from being unserialized
    private function __wakeup(){}
 }

function pd_is_register_function(){
	if( is_admin() ){
		$pd_is_feedback = new PD_IS_Usage_Feedback(
			__FILE__,
			'webbuilders03@gmail.com',
			false,
			true
		);
	}
}
add_action('plugins_loaded', 'pd_is_register_function');
$pd_is = PD_IS_SLIDER::getInstance();


add_action('wp_footer', 'pd_is_display_custom_css');
function pd_is_display_custom_css(){
	$custom_css = get_option( 'pd_is_custom_css' );
	$css ='';
	if ( ! empty( $custom_css ) ) {
		$css .= '<style type="text/css">';
		$css .= '/* Custom CSS */' . "\n";
		$css .= $custom_css . "\n";
		$css .= '</style>';
	}
	echo $css;
}

add_action('wp_footer', 'pd_is_display_custom_js');
function pd_is_display_custom_js(){
	$custom_js = get_option( 'pd_is_custom_js' );
	$js ='';
	if ( ! empty( $custom_js ) ) {
		$js .= '<script>';
		$js .= '/* Custom JS */' . "\n";
		$js .= $custom_js . "\n";
		$js .= '</script>';
	}
	echo $js;
}

/**
 * Submenu filter function. Tested with Wordpress 4.1.1
 * Sort and order submenu positions to match your custom order.
 *
 */
function pd_is_order_submenu( $menu_ord ) {

  global $submenu;

  // Enable the next line to see a specific menu and it's order positions
  //echo '<pre>'; print_r( $submenu['pd-infinite-scroll'] ); echo '</pre>'; exit();

  $arr = array();

  $arr[] = $submenu['pd-infinite-scroll'][1];
  $arr[] = $submenu['pd-infinite-scroll'][2];
  $arr[] = $submenu['pd-infinite-scroll'][5];
  $arr[] = $submenu['pd-infinite-scroll'][4];

  $submenu['pd-infinite-scroll'] = $arr;

  return $menu_ord;

}

// add the filter to wordpress
add_filter( 'custom_menu_order', 'pd_is_order_submenu' );
