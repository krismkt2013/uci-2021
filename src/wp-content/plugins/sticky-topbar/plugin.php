<?php
/*
Plugin Name: Sticky Topbar
Plugin URI: https://wordpress.org/plugins/sticky-topbar

Description: Sticky Topbar adds an area to the top of your website and lets you customize it from the WordPress setting options page.

Author: RainaStudio
Author URI: http://rainastudio.com/

Version: 2.0.0

Text Domain: sticky_topbar

License: GNU General Public License v2.0 (or later)
License URI: http://www.opensource.org/licenses/gpl-license.php
*/

if ( ! defined( 'ABSPATH' ) ){
	exit; // exit if accessed this file directly
}

// Define plugin paths
define( 'sticky_topbar_version', '1.0.0' );
define( 'sticky_topbar_inc', plugin_dir_path( __FILE__ ) . 'inc/' );
define( 'sticky_topbar_css', plugins_url( '/assets/css/', __FILE__ ) );
define( 'sticky_topbar_js', plugins_url( '/assets/scripts/', __FILE__ ) );
define( 'sticky_topbar_img', plugins_url( '/assets/img/', __FILE__ ) );


require_once( plugin_dir_path( __FILE__ ) . 'sticky-topbar.php' );