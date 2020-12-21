<?php
global $ueepb_woo_my_profile_params;

$customer_id = get_current_user_id();
$customer = get_userdata($customer_id);


?>

<div class="ueepb-my-account-panel">

	<?php if($ueepb_woo_my_profile_params['display_header'] == 'yes') { ?> 
		<div class="ueepb-my-account-header">
			<?php if($ueepb_woo_my_profile_params['display_header_image'] == 'yes') { ?> 
			<div class="ueepb-my-account-header-image">
				<img src="<?php echo esc_url( get_avatar_url( $customer_id , array('size'=> 128) ) ); ?>" />
			</div>
			<?php } ?>

			<?php if($ueepb_woo_my_profile_params['display_header_name'] == 'yes') { ?> 
			<div class="ueepb-my-account-header-fields">
				<div class="ueepb-my-account-header-field"><?php echo esc_html( $customer->display_name ); ?></div>
			</div>
			<?php } ?>

			<?php if($ueepb_woo_my_profile_params['display_header_logout'] == 'yes') { ?> 
			<div class="ueepb-my-account-header-logout">
				<div class="ueepb-my-account-header-logout-btn"><a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>"><?php _e('Logout','ueepb'); ?></a></div>
			</div>
			<?php } ?>
		</div>
	<?php } ?>
	<div class="ueepb-my-account-tabs">
		<div data-content-tab="ueepb-my-account-dashboard-content" class="ueepb-active-tab ueepb-my-account-tab-item"><?php _e('Dashboard','ueepb'); ?></div>
		<div data-content-tab="ueepb-my-account-orders-content" class="ueepb-my-account-tab-item"><?php _e('Orders','ueepb'); ?></div>
		<div data-content-tab="ueepb-my-account-downloads-content" class="ueepb-my-account-tab-item"><?php _e('Downloads','ueepb'); ?></div>
		<div data-content-tab="ueepb-my-account-profile-content" class="ueepb-my-account-tab-item"><?php _e('Account','ueepb'); ?></div>
		<div class="ueepb-clear"></div>
	</div>

	<div class="ueepb-my-account-tab-content">
		<div class="ueepb-my-account-dashboard-content ueepb-my-account-tab-content-item" >
		  <?php echo do_shortcode('[ueepb_woo_my_dashboard]'); ?>
		</div>
		<div class="ueepb-my-account-orders-content ueepb-my-account-tab-content-item" >
		  <?php echo do_shortcode('[ueepb_woo_my_orders]'); ?>
		</div>
		<div class="ueepb-my-account-downloads-content ueepb-my-account-tab-content-item" >
		  <?php echo do_shortcode('[ueepb_woo_my_downloads]'); ?>
		</div>
		<div class="ueepb-my-account-profile-content ueepb-my-account-tab-content-item" >
		  <?php echo do_shortcode('[ueepb_woo_my_account]'); ?>
		</div>
	</div>
</div>