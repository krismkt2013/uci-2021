<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * UAE Base Class
 *
 * All functionality pertaining to core functionality of the Ultimate Addons For Elementor plugin.
 *
 * @package WordPress
 * @subpackage UAE
 * @author qsheeraz
 * @since 1.0
 *
 */

class MA_Elementor {
	public $version;
	private $file;

	private $plugin_url;
	private $assets_url;
	private $plugin_path;

	const MINIMUM_PHP_VERSION = '7.0';	

	public $mae;
	
	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct ( $file ) {
		$this->version = '';
		$this->file = $file;
		$this->prefix = 'uae_';

		/* Plugin URL/path settings. */
		$this->plugin_url = str_replace( '/classes', '', plugins_url( plugin_basename( dirname( __FILE__ ) ) ) );
		$this->plugin_path = str_replace( 'classes', '', plugin_dir_path( __FILE__ ));
		$this->assets_url = $this->plugin_url . '/assets';

		
	} // End __construct()

	/**
	 * init function.
	 *
	 * @access public
	 * @return void
	 */
	public function init () {
		add_action( 'init', array( $this, 'load_localisation' ) );

		// Register Widget Styles
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'uae_front_enqueue_styles' ] );
		// Register Widget Scripts
		// add_action( 'elementor/frontend/after_register_scripts', [ $this, 'uae_front_enqueue_scripts' ] );

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}


		add_action('admin_menu', array($this, 'uae_register_admin_menu'));
		add_action('wp_ajax_uae_save_data', array($this, 'uae_saving_data' ));
		add_action('admin_enqueue_scripts', array($this, 'uae_admin_script'));


		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		//add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );		

		add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );
		// Run this on activation.
		register_activation_hook( $this->file, array( $this, 'activation' ) );
	} // End init()

	function uae_admin_script($slug) {
		//wp_enqueue_style( 'uae_admin_css', plugin_dir_url( __FILE__ ) . '/lib/style.css' );
		if ($slug == 'toplevel_page_mega-addons-elementor') {
			wp_enqueue_style( 'uae_admin_style', plugin_dir_url( __FILE__ ) . '../lib/admin.css' );
			wp_enqueue_script( 'uae_admin_js', plugin_dir_url( __FILE__ ) . '../lib/admin.js', array('jquery', 'jquery-ui-core'));
		}
	}

	public function uae_front_enqueue_styles() {
		wp_enqueue_style( 'font_awesome_5', plugins_url( '../../elementor/assets/lib/font-awesome/css/fontawesome.min.css', __FILE__ ) );
		wp_enqueue_style( 'font_awesome_solid', plugins_url( '../../elementor/assets/lib/font-awesome/css/solid.min.css', __FILE__ ) );
		wp_enqueue_style( 'font_awesome_regular', plugins_url( '../../elementor/assets/lib/font-awesome/css/regular.min.css', __FILE__ ) );
		wp_enqueue_style( 'font_awesome_brand', plugins_url( '../../elementor/assets/lib/font-awesome/css/brands.min.css', __FILE__ ) );
		wp_enqueue_style( 'custom-style', plugins_url( '../css/style.css', __FILE__ ) );
	}
	

	/**
	 * Print array
	 *
	 * Print array in readable format.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function pa( $arr ) {

		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'uae' ),
			'<strong>' . esc_html__( 'Mega Addons for Elementor', 'uae' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'uae' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
	
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'uae' ),
			'<strong>' . esc_html__( 'Mega Addons for Elementor', 'uae' ) . '</strong>',
			'<strong><a href="https://elementor.com/?ref=14615">' . esc_html__( 'Elementor Page Builder', 'uae' ) . '</a></strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	function add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'ultimate-addons',
			[
				'title' => __( 'Mega Addons', 'uae' ),
				'icon' => 'fa fa-plug',
			]
		);
	}

	function uae_saving_data() {
		if (isset($_REQUEST)) {
			update_option( 'uae_save_data', $_REQUEST );
		}
	}

	function uae_register_admin_menu() {
		add_menu_page( 'Mega Addons', 'Mega Addons', 'manage_options', 'mega-addons-elementor', array($this, 'uae_addons'), 'dashicons-lightbulb');
	}

	function uae_addons() {
		$saved_options = get_option('uae_save_data');
	?>
		
	<div class="addons-admin-wrap">
		<h1 class="title">Mega Addons For Elementor</h1>
		<h3>Welcome! You are about to begin with the most powerful addon for elementor that add in many advanced features developed with love.</h3>
		<br>
		<h3 style="font-weight: 100;">Enable/Disable Element</h3>
		<div class="mega-addons-version">
			<div class="dashicons-before dashicons-lightbulb"></div>
			<p>Version 1.6</p>
		</div>
		<?php include 'includes/settings.php'; ?>
	</div>


	<?php }

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {

		// Include Widget files
		$saved_options = get_option('uae_save_data');
		if (isset($saved_options['adv_carousel'])) {
			wp_enqueue_script( 'slick-js', plugins_url( '../js/slick.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
			wp_enqueue_script( 'custom-tm-js', plugins_url( '../js/front/custom-tm.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
			require_once( $this->plugin_path . '/widgets/advanced-carousel.php' );
		}
		if (isset($saved_options['banner'])) {require_once( $this->plugin_path . '/widgets/info-banner.php' );}
		if (isset($saved_options['ihe'])) {require_once( $this->plugin_path . '/widgets/ihover.php' );}
		if (isset($saved_options['price_table'])) {require_once( $this->plugin_path . '/widgets/price-table.php' );}
		if (isset($saved_options['team_prof'])) {require_once( $this->plugin_path . '/widgets/memeber_profile.php' );}
		if (isset($saved_options['interactive_banner'])) {require_once( $this->plugin_path . '/widgets/interactive-banner.php' );}
		if (isset($saved_options['info_box'])) {require_once( $this->plugin_path . '/widgets/info-box.php' );}
		if (isset($saved_options['creative_link'])) {
			require_once( $this->plugin_path . '/widgets/creative-link.php' );
		}
		if (isset($saved_options['counter'])) {
			require_once( $this->plugin_path . '/widgets/stat-counter.php' );
		}
		if (isset($saved_options['popup'])) {
			wp_enqueue_script( 'bpopup-js', plugins_url( '../js/bpopup.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
			wp_enqueue_script( 'custom-bpopup-js', plugins_url( '../js/front/custom_bpopup.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
			require_once( $this->plugin_path . '/widgets/modal_popup.php' );
		}
		if (isset($saved_options['advance_btn'])) {require_once( $this->plugin_path . '/widgets/advanced-btn.php' );}
		if (isset($saved_options['timeline'])) {
			wp_enqueue_style( 'timeline-css', plugins_url( '../css/timeline.css' , __FILE__ ));
			wp_enqueue_script( 'timeline-js', plugins_url( '../js/timeline.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
			wp_enqueue_script( 'animtimeline-js', plugins_url( '../js/animtimeline.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
			require_once( $this->plugin_path . '/widgets/timeline.php' );
		}
		if (isset($saved_options['countdown'])) {
			wp_enqueue_script( 'custom-countdown-js', plugins_url( '../js/front/countdown.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
			require_once( $this->plugin_path . '/widgets/countdown.php' );
		}
		if (isset($saved_options['flip_box'])) {require_once( $this->plugin_path . '/widgets/flip-box.php' );}
		if (isset($saved_options['info_list'])) {require_once( $this->plugin_path . '/widgets/info-list.php' );}
		if (isset($saved_options['highlight_box'])) {require_once( $this->plugin_path . '/widgets/hightlight-box.php' );}
		if (isset($saved_options['accordion'])) {
			wp_enqueue_script( 'accordion-js', plugins_url( '../js/front/accordion.js' , __FILE__ ), array('jquery', 'jquery-ui-accordion'));
			require_once( $this->plugin_path . '/widgets/accordion.php' );
		}
		if (isset($saved_options['info_circle'])) {
			wp_enqueue_script( 'info-circle-js', plugins_url( '../js/info-circle.js' , __FILE__ ), array('jquery', 'jquery-ui-core'));
			require_once( $this->plugin_path . '/widgets/info-circle.php' );
		}
		if (isset($saved_options['heading'])) {require_once( $this->plugin_path . '/widgets/heading.php' );}
		if (isset($saved_options['dual_btn'])) {require_once( $this->plugin_path . '/widgets/dual-btn.php' );}

		if (isset($saved_options['filter_gallery'])) {
			wp_enqueue_style( 'filter-gallery-css', plugins_url( '../css/filterablegallery.css' , __FILE__ ));
			wp_enqueue_style( 'fancybox-css', plugins_url( '../css/jquery.fancybox.min.css' , __FILE__ ));
			wp_enqueue_script( 'fancybox-js', plugins_url( '../js/jquery.fancybox.min.js' , __FILE__ ), array('jquery'));
			wp_enqueue_script( 'mixitup-min-js', plugins_url( '../js/mixitup.min.js' , __FILE__ ));
			wp_enqueue_script( 'custom-mixitup-js', plugins_url( '../js/front/custommixitup.js' , __FILE__ ));
			require_once( $this->plugin_path . '/widgets/filtergallery.php' );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_filter_gallery() );
		}

		if (isset($saved_options['whatsapp_chat'])) {
			wp_enqueue_style( 'whatsapp-css', plugins_url( '../css/whatsappchat.css' , __FILE__ ));
			require_once( $this->plugin_path . '/widgets/whatsappchat.php' );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_whatsapp_chat() );
		}
		

		// Register widget
		if (isset($saved_options['adv_carousel'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_advanced_carousel() );}
		if (isset($saved_options['banner'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_info_banner() );}
		if (isset($saved_options['ihe'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_ihover_Widget() );}
		if (isset($saved_options['price_table'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_price_table() );}
		if (isset($saved_options['team_prof'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_memeber_prof() );}
		if (isset($saved_options['interactive_banner'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_interactive_banner() );}
		if (isset($saved_options['info_box'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_info_box() );}
		if (isset($saved_options['creative_link'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_creative_link() );}
		if (isset($saved_options['counter'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_stat_counter() );}
		if (isset($saved_options['popup'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_modal_popup() );}
		if (isset($saved_options['advance_btn'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_advanced_btn() );}
		if (isset($saved_options['timeline'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_timeline() );}
		if (isset($saved_options['countdown'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_countdown() );}
		if (isset($saved_options['flip_box'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_flip_box() );}
		if (isset($saved_options['info_list'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_info_list() );}
		if (isset($saved_options['highlight_box'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_hightlight_box() );}
		if (isset($saved_options['accordion'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_accordion() );}
		if (isset($saved_options['info_circle'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_info_circle() );}
		if (isset($saved_options['heading'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_headings() );}
		if (isset($saved_options['dual_btn'])) {\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_dual_btn() );}
		// \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_uae_post_grid() );

		

	}

	/**
	 * Init Controls
	 *
	 * Include controls files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_controls() {

		// Include Control files
		require_once( __DIR__ . '/controls/test-control.php' );

		// Register control
		\Elementor\Plugin::$instance->controls_manager->register_control( 'control-type-', new \Test_Control() );

	}

	/**
	 * load_localisation function.
	 *
	 * @access public
	 * @return void
	 */
	public function load_localisation () {
		$lang_dir = trailingslashit( str_replace( 'classes', 'lang', plugin_basename( dirname(__FILE__) ) ) );
		load_plugin_textdomain( 'uae', false, $lang_dir );
	} // End load_localisation()

	/**
	 * activation function.
	 *
	 * @access public
	 * @return void
	 */
	public function activation () {
		$this->register_plugin_version();

		if ( !get_option( 'uae_save_data' ) ) {
		$vc_default_options =  array(
			 'banner' 			=> 'on',
			 'ihe' 				=> 'on',
			 'price_table' 		=> 'on',
			 'info_box' 		=> 'on',
			 'advance_btn' 		=> 'on',
			 'team_prof' 		=> 'on',
			 'counter' 			=> 'on',
			 'flip_box' 		=> 'on',
			 'timeline' 		=> 'on',
			 'countdown' 		=> 'on',
			 'creative_link' 	=> 'on',
			 'popup' 			=> 'on',
			 'interactive_banner' => 'on',
			 'info_list' 		=> 'on',
			 'adv_carousel' 	=> 'on',
			 'heading' 			=> 'on',
			 'highlight_box' 	=> 'on',
			 'accordion' 		=> 'on',
			 'info_circle' 		=> 'on',
			 'dual_btn' 		=> 'on',
			 'filter_gallery' 	=> 'on',
			 'whatsapp_chat' 	=> 'on',
			);

			update_option( 'uae_save_data', $vc_default_options);
		}




	} // End activation()

	/**
	 * register_plugin_version function.
	 *
	 * @access public
	 * @return void
	 */
	public function register_plugin_version () {
		if ( $this->version != '' ) {
			update_option( 'ma_elementor' . '-version', $this->version );
		}
	} // End register_plugin_version()
} // End Class
?>