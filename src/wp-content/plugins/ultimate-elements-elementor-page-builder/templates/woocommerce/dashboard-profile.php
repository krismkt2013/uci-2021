<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$customer_id = get_current_user_id();
$customer = get_userdata($customer_id);

?>

<p>
	<?php
	printf(
		/* translators: 1: user display name 2: logout url */
		__( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ),
		'<strong>' . esc_html( $customer->display_name ) . '</strong>',
		esc_url( wp_logout_url( get_permalink() ) )
	);
	?>
</p>

<p>
	<?php
	printf(
		__( 'From your account dashboard you can view your Orders, Downloads and Account Details.', 'woocommerce' )
	);
	?>
</p>

<?php
	do_action( 'woocommerce_account_dashboard' );

	
