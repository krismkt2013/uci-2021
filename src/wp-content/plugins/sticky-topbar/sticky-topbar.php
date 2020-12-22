<?php
/**
 *
 * @package Sticky Topbar
 * @author RainaStudio
 * @version 2.0.0
 */
 
// Include Admin UX
include( sticky_topbar_inc . 'admin.php');

// Include Color Picker Assets
add_action( 'admin_enqueue_scripts', 'stopbar_color_picker' );
function stopbar_color_picker( $hook ) {
 
    if( is_admin() ) { 
     
        // Add the color picker css file       
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_style( 'sticky_topbar_admin_css', sticky_topbar_css . 'admin.css' );
         
        // Include our custom jQuery file with WordPress Color Picker dependency
		wp_enqueue_script( 'app-topbar-js', sticky_topbar_js . 'admin.js', array( 'wp-color-picker' ), false, true );
		
    }
}

add_action( 'wp_enqueue_scripts', 'stopbar_front_scripts' );
function stopbar_front_scripts() {

	wp_enqueue_script('front-topbar-js', sticky_topbar_js . 'front.js', array(), '1.0.8', true );
	wp_enqueue_script('cookie-topbar-js', sticky_topbar_js . 'jquery.cookie.js', array(), '1.0.8', true );
}


// Hook function to 'init'
add_action( 'init', 'stopbar_init_setup', 15 );
function stopbar_init_setup() {

	// Remove topbar if checkbox on
	$topbar = get_option( 'topbar_show_on', 'stopbar-options-settings-group');

	if ( $topbar == 1 ) {

		// Register 'topbar' at wp_footer
		add_action( 'wp_footer', 'stopbar_at_wpfooter' );
		//add_action( 'wp_body_open', 'topbar_at_wpfooter' );

		function stopbar_at_wpfooter() {

			$topbartext	 	= get_option( 'studio_player_topbar_text', 'stopbar-options-settings-group');
			$topbarurl	 	= get_option( 'studio_player_topbar_url', 'stopbar-options-settings-group');
			$facebookurl 	= get_option( 'sticky_topbar_facebook', 'stopbar-options-settings-group');
			$twitterurl		= get_option( 'sticky_topbar_twitter', 'stopbar-options-settings-group');
			$linkedinurl	= get_option( 'sticky_topbar_linkedIn', 'stopbar-options-settings-group');
			$pinteresturl	= get_option( 'sticky_topbar_pinterest', 'stopbar-options-settings-group');
			$instagramurl	= get_option( 'sticky_topbar_instagram', 'stopbar-options-settings-group');
			$youtubeurl		= get_option( 'sticky_topbar_youtube', 'stopbar-options-settings-group');
			$dribbbleurl	= get_option( 'sticky_topbar_dribbble', 'stopbar-options-settings-group');
			$mediumurl		= get_option( 'sticky_topbar_medium', 'stopbar-options-settings-group');
			$tumblrurl		= get_option( 'sticky_topbar_tumblr', 'stopbar-options-settings-group');
			$vimeourl		= get_option( 'sticky_topbar_vimeo', 'stopbar-options-settings-group');
			$bgcolor		= get_option( 'sticky_topbar_bg', 'stopbar-options-settings-group');
			$bbgcolor		= get_option( 'sticky_topbar_bbg', 
			'stopbar-options-settings-group');
			$tcolor		= get_option( 'sticky_topbar_tcolor', 
			'stopbar-options-settings-group');
			$tccolor		= get_option( 'sticky_topbar_tc', 'stopbar-options-settings-group');
			$cellno			= get_option( 'sticky_topbar_cell', 'stopbar-options-settings-group');
			$all_social_var = array( $facebookurl, $twitterurl, $linkedinurl, $pinteresturl, $instagramurl, $youtubeurl, $dribbbleurl, $mediumurl, $tumblrurl, $vimeourl, $cellno );
			$filled = array_filter($all_social_var);

			$font_size = get_option( 'sticky_topbar_font_size', 'stopbar-options-settings-group');
			$t_height = get_option( 'sticky_topbar_height', 'stopbar-options-settings-group');

			$hide_social = get_option( 'sticky_topbar_social_off', 'stopbar-options-settings-group');
			$hide_social_on_mob = get_option( 'sticky_topbar_social_hide_on_mob', 'stopbar-options-settings-group');
			$mth = get_option( 'sticky_cd_mth', 'st-options-settings-group');
			$yer = get_option( 'sticky_cd_yer', 'st-options-settings-group');
			$hr = get_option( 'sticky_cd_time_hr', 'st-options-settings-group');
			$min = get_option( 'sticky_cd_time_min', 'st-options-settings-group');
			$sec = get_option( 'sticky_cd_time_sec', 'st-options-settings-group');
			$date = get_option( 'sticky_cd_date', 'st-options-settings-group');

			$all_cd_var = array( $mth, $yer, $hr, $min, $sec, $date);
			$filled_cd = array_filter($all_cd_var);

			$hide_countdown = get_option( 'topbar_countdown_off', 'st-options-settings-group');

			?><div class="topbar">
					<div class="wrap"><?php
							if ( $hide_countdown == 1 )  {
								// do nothing
							} else { ?>
							<div class="count_down">
								<div class="screen-reader-text stick_cdate"><?php echo "$mth $date, $yer $hr:$min:$sec"?></div>
								<div id="DateCountdown" class="counter">
									<div class="pr days">
										<span class="days">00</span><small>Days</small>
									</div>
									<div class="pr hrs">
										<span class="hrs">00</span><small>Hours</small>
									</div>
									<div class="pr min">
										<span class="min">00</span><small>Minutes</small>
									</div>
									<div class="pr sec">
										<span class="sec">00</span><small>Seconds</small>
									</div>
								</div>
							</div>
							<?php }
						?>
						<div class="promo-topbar">
							<?php if (!empty($topbartext)) {
								
								echo '<p>'. $topbartext .'</p>';

							} else {?>
								
								<p>Go to Genesis > <a href="<?php echo admin_url() . 'admin.php?page=topbar-options'; ?>" target="_blank">Sticky Topbar</a> to set information</p>
							
							<?php } ?>

							<?php if (!empty($topbarurl)) {?>
							<a class="button promo" href="<?php echo get_option('studio_player_topbar_url'); ?>" style="background-color:<?php echo $bbgcolor; ?>;color:<?php echo $tccolor; ?>"><?php echo get_option('studio_player_topbar_btn_text'); ?></a><?php } ?>

						</div>
					<?php if ( $hide_social == 1 ) {
						// do nothing
					} else {
						 if (!empty($filled)) { ?>
						<div class="social-icons">
							<?php if (!empty($facebookurl)) {?>
								<a href="<?php echo $facebookurl; ?>" target="_blank" class="sm-icons facebook"><i class="fa fa-facebook"></i></a> <?php } ?>
							<?php if (!empty($twitterurl)) {?>
								<a href="<?php echo $twitterurl; ?>" target="_blank" class="sm-icons twitter"><i class="fa fa-twitter"></i></a> <?php } ?>
							<?php if (!empty($linkedinurl)) {?>
								<a href="<?php echo $linkedinurl; ?>" target="_blank" class="sm-icons linkedin"><i class="fa fa-linkedin"></i></a> <?php } ?>
							<?php if (!empty($pinteresturl)) {?>
								<a href="<?php echo $pinteresturl; ?>" target="_blank" class="sm-icons pinterest"><i class="fa fa-pinterest"></i></a> <?php } ?>
							<?php if (!empty($instagramurl)) {?>
								<a href="<?php echo $instagramurl; ?>" target="_blank" class="sm-icons instagram"><i class="fa fa-instagram"></i></a> <?php } ?>
							<?php if (!empty($youtubeurl)) {?>
								<a href="<?php echo $youtubeurl; ?>" target="_blank" class="sm-icons youtube"><i class="fa fa-youtube"></i></a> <?php } ?>
							<?php if (!empty($dribbbleurl)) {?>
								<a href="<?php echo $dribbbleurl; ?>" target="_blank" class="sm-icons dribbble"><i class="fa fa-dribbble"></i></a> <?php } ?>
							<?php if (!empty($googleplusurl)) {?>
								<a href="<?php echo $googleplusurl; ?>" target="_blank" class="sm-icons googleplus"><i class="fa fa-google-plus"></i></a> <?php } ?>
							<?php if (!empty($mediumurl)) {?>
								<a href="<?php echo $mediumurl; ?>" target="_blank" class="sm-icons medium"><i class="fa fa-medium"></i></a> <?php } ?>
							<?php if (!empty($tumblrurl)) {?>
								<a href="<?php echo $tumblrurl; ?>" target="_blank" class="sm-icons tumblr"><i class="fa fa-tumblr"></i></a> <?php } ?>
							<?php if (!empty($vimeourl)) {?>
								<a href="<?php echo $vimeourl; ?>" target="_blank" class="sm-icons vimeo"><i class="fa fa-vimeo"></i></a> <?php } ?>
							<?php if (!empty($cellno)) {?>
								<a href="tel:<?php echo $cellno; ?>" target="_blank" class="cell"><i class="fa fa-mobile"></i> <?php echo $cellno; ?></a> <?php } ?>
						</div><?php } } ?>
						<div class="hide_switch" id="on_off">
							<i class="fa fa-times-circle" aria-hidden="true"></i>
						</div>
					</div>
				<?php require_once( plugin_dir_path( __FILE__ ) . 'inc/css.php' ); ?>
				</div><?php

		}

	} else {

		remove_action( 'wp_footer', 'stopbar_at_wpfooter' );

	}

	
	// Call plugin's scripts & stylesheet
	add_action( 'wp_enqueue_scripts', 'stopbar_scripts' );
	function stopbar_scripts() {
		if ( !is_admin() ) {
		
			wp_enqueue_style( 'app-topbar-css', sticky_topbar_css . 'style.css' );
			wp_enqueue_style( 'app-topbar-fontawesome-css', sticky_topbar_css . 'font-awesome.css' );
		
		}
	}

	function stopbar_admin_msg() {
	
		// Check required fields
		if ( is_admin() ) {
			echo '<div class="notice notice-info is-dismissible"><p><b>Sticky Topbar</b> is ready. Leave us a honest feedback to improve the plugin in next release. <a class="button button-primary" href="https://wordpress.org/support/plugin/sticky-topbar/reviews/#new-post" target="_blank">Yes, take me there →</a></p></div>';
		}
	}
	
	add_action( 'admin_notices', 'stopbar_admin_msg' );
	
}