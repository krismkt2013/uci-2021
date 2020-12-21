<?php
/**
 * Settings page for AnWP_Post_Grid
 *
 * @link       https://anwp.pro
 * @since      0.7.1
 *
 * @package    AnWP_Post_Grid
 * @subpackage AnWP_Post_Grid/admin/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'anwp-post-grid' ) );
}
?>
<div class="about-wrap anwp-pg-wrap">
	<div class="postbox">
		<div class="inside">
			<h2 class="text-left mb-3"><?php echo esc_html__( 'AnWP Post Grid Settings', 'anwp-post-grid' ); ?></h2>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'anwp_pg_plugin_settings' );
				do_settings_sections( 'anwp_pg_settings' );
				?>
				<div class="mt-3">
					<input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>"/>
				</div>
			</form>
		</div>
	</div>
</div>
