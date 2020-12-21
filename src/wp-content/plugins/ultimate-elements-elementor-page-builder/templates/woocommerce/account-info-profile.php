<?php

$customer_id = get_current_user_id();
$customer = get_userdata($customer_id);


$billing_address = wc_get_account_formatted_address( 'billing' );
$shipping_address = wc_get_account_formatted_address( 'shipping' );
?>


<div class="ueepb-form-field-panel">
	<div class="ueepb-form-field-row">
		<div class="ueepb-form-field-label"><?php _e('First Name','ueepb'); ?> : </div>
		<div class="ueepb-form-field-value"><?php echo get_user_meta($customer_id,'first_name',true); ?></div>
	</div>
	<div class="ueepb-clear"></div>
	<div class="ueepb-form-field-row">
		<div class="ueepb-form-field-label"><?php _e('Last Name','ueepb'); ?> : </div>
		<div class="ueepb-form-field-value"><?php echo get_user_meta($customer_id,'last_name',true); ?></div>
	</div>
	<div class="ueepb-clear"></div>
	<div class="ueepb-form-field-row">
		<div class="ueepb-form-field-label"><?php _e('Display Name','ueepb'); ?> : </div>
		<div class="ueepb-form-field-value"><?php echo $customer->data->display_name; ?></div>
	</div>
	<div class="ueepb-clear"></div>
	<div class="ueepb-form-field-row">
		<div class="ueepb-form-field-label"><?php _e('Email','ueepb'); ?> : </div>
		<div class="ueepb-form-field-value"><?php echo $customer->data->user_email; ?></div>
	</div>
	<div class="ueepb-clear"></div>
	<div class="ueepb-form-field-row">
		<div class="ueepb-form-field-label"><?php _e('Billing Address','ueepb'); ?> : </div>
		<div class="ueepb-form-field-value"><?php echo $billing_address; ?></div>
	</div>
	<div class="ueepb-clear"></div>
	<div class="ueepb-form-field-row">
		<div class="ueepb-form-field-label"><?php _e('Shipping Address','ueepb'); ?> : </div>
		<div class="ueepb-form-field-value"><?php echo $shipping_address; ?></div>
	</div>
	<div class="ueepb-clear"></div>
</div>