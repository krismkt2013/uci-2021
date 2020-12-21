<?php
/**
 * Plugin Settings
 * AnWP Post Grid :: Settings.
 *
 * @since   0.7.1
 * @package AnWP_Post_Grid
 */

/**
 * AnWP_Post_Grid :: Settings class.
 *
 * @since 0.7.1
 */
class AnWP_Post_Grid_Settings {

	/**
	 * Parent plugin class.
	 *
	 * @var AnWP_Post_Grid
	 */
	protected $plugin = null;

	/**
	 * Constructor.
	 *
	 * @param AnWP_Post_Grid $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {

		$this->plugin = $plugin;

		// Init Hooks
		$this->hooks();
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since 0.7.1
	 */
	public function hooks() {
		add_action( 'admin_init', [ $this, 'register_settings' ] );

		/*
		|--------------------------------------------------------------------
		| Add Category colorpicker.
		| Based on - https://wordpress.stackexchange.com/questions/112866/adding-colorpicker-field-to-category/113041#113041
		|--------------------------------------------------------------------
		*/
		add_action( 'category_add_form_fields', [ $this, 'category_colorpicker_add_term_page' ] );
		add_action( 'category_edit_form_fields', [ $this, 'category_colorpicker_edit_term_page' ] );

		add_action( 'created_category', [ $this, 'save_category_colorpicker' ] );
		add_action( 'edited_category', [ $this, 'save_category_colorpicker' ] );

		add_action( 'admin_enqueue_scripts', [ $this, 'category_colorpicker_enqueue' ] );
		add_action( 'admin_print_scripts', [ $this, 'colorpicker_init_inline' ], 20 );

		// Modifies columns in Admin tables
		add_action( 'manage_category_custom_column', [ $this, 'columns_display' ], 10, 3 );
		add_filter( 'manage_edit-category_columns', [ $this, 'columns' ] );
	}

	/**
	 * Add new colorpicker field to "Add new Category" screen
	 *
	 * @return void
	 * @since 0.7.1
	 */
	public function category_colorpicker_add_term_page() {

		if ( 'no' === self::get_value( 'show_category_color' ) ) {
			return;
		}
		?>
		<div class="form-field term-colorpicker-wrap">
			<label for="anwp-pg-term-colorpicker"><?php echo esc_html__( 'Category Color to use in AnWP Post Grid widgets', 'anwp-post-grid' ); ?></label>
			<input name="_anwp_pg_category_color" value="" class="anwp-pg-colorpicker" id="anwp-pg-term-colorpicker"/>
			<p><small><?php echo esc_html__( 'If you don\'t need this field, hide it in the AnWP Post Grid plugin Settings.', 'anwp-post-grid' ); ?></small></p>
		</div>
		<?php
	}

	/**
	 * Add new colorpicker field to "Edit Category" screen
	 *
	 * @param WP_Term $term
	 *
	 * @return void
	 * @since 0.7.1
	 */
	public function category_colorpicker_edit_term_page( $term ) {

		if ( 'no' === self::get_value( 'show_category_color' ) ) {
			return;
		}

		$color = get_term_meta( $term->term_id, '_anwp_pg_category_color', true );
		$color = empty( $color ) ? '' : "#{$color}";
		?>
		<tr class="form-field term-colorpicker-wrap">
			<th scope="row">
				<label for="anwp-pg-term-colorpicker"><?php echo esc_html__( 'Category Color to use in AnWP Post Grid widgets', 'anwp-post-grid' ); ?></label>
			</th>
			<td>
				<input name="_anwp_pg_category_color" value="<?php echo esc_html( $color ); ?>" class="anwp-pg-colorpicker" id="anwp-pg-term-colorpicker"/>
				<p><small><?php echo esc_html__( 'If you don\'t need this field, hide it in the AnWP Post Grid plugin Settings.', 'anwp-post-grid' ); ?></small></p>
			</td>
		</tr>
		<?php
	}

	/**
	 * Print javascript to initialize the colorpicker
	 *
	 * @return void
	 * @since 0.7.1
	 */
	public function colorpicker_init_inline() {

		if ( 'no' === self::get_value( 'show_category_color' ) ) {
			return;
		}

		$current_screen = get_current_screen();

		if ( null !== $current_screen && 'edit-category' !== $current_screen->id ) {
			return;
		}
		?>
		<script>
			jQuery( document ).ready( function( $ ) {
				$( '.anwp-pg-colorpicker' ).wpColorPicker();
			} ); // End Document Ready JQuery
		</script>
		<?php
	}

	/**
	 * Save category color
	 *
	 * @param Integer $term_id
	 *
	 * @return void
	 * @since 0.7.1
	 */
	public function save_category_colorpicker( $term_id ) {

		if ( 'no' === self::get_value( 'show_category_color' ) ) {
			return;
		}

		// Save term color if possible
		if ( isset( $_POST['_anwp_pg_category_color'] ) && ! empty( $_POST['_anwp_pg_category_color'] ) ) {
			update_term_meta( $term_id, '_anwp_pg_category_color', sanitize_hex_color_no_hash( $_POST['_anwp_pg_category_color'] ) );
		} else {
			delete_term_meta( $term_id, '_anwp_pg_category_color' );
		}
	}

	/**
	 * Enqueue colorpicker styles and scripts.
	 *
	 * @return void
	 * @since 0.7.1
	 */
	public function category_colorpicker_enqueue() {

		if ( 'no' === self::get_value( 'show_category_color' ) ) {
			return;
		}

		$current_screen = get_current_screen();

		if ( null !== $current_screen && 'edit-category' !== $current_screen->id ) {
			return;
		}

		// Colorpicker Scripts
		wp_enqueue_script( 'wp-color-picker' );

		// Colorpicker Styles
		wp_enqueue_style( 'wp-color-picker' );
	}

	/**
	 * Registers admin columns to display.
	 *
	 * @param  array $columns Array of registered column names/labels.
	 *
	 * @return array          Modified array.
	 * @since  0.7.1
	 */
	public function columns( $columns ) {

		if ( 'no' === self::get_value( 'show_category_color' ) ) {
			return $columns;
		}

		// add Color column
		$columns['anwp_pg_category_color'] = esc_html__( 'Color', 'anwp-post-grid' );

		return $columns;
	}

	/**
	 * Handles admin column display.
	 *
	 * @param array   $column   Column currently being rendered.
	 * @param integer $term_id  ID of post to display column for.
	 *
	 * @since  0.7.1
	 */
	public function columns_display( $deprecated, $column, $term_id ) {

		if ( 'anwp_pg_category_color' === $column && 'no' !== self::get_value( 'show_category_color' ) ) {
			$category_color = get_term_meta( $term_id, '_anwp_pg_category_color', true );
			echo '<span style="display: inline-block; background-color: #' . esc_attr( $category_color ) . '; width: 30px; height: 20px; border: 1px solid #ccc;"></span>';
		}
	}

	/**
	 * Register plugin settings
	 *
	 * @since  0.7.1
	 */
	public function register_settings() {
		register_setting( 'anwp_pg_plugin_settings', 'anwp_pg_plugin_settings', [ 'sanitize_callback' => [ $this, 'sanitize_options' ] ] );
		add_settings_section( 'anwp_pg_general', '', [ $this, 'section_general_callback' ], 'anwp_pg_settings' );

		add_settings_field( 'show_category_color', esc_html__( 'Show Category Color Option', 'anwp-post-grid' ), [ $this, 'category_color_field' ], 'anwp_pg_settings', 'anwp_pg_general' );
	}

	/**
	 * Render section description
	 *
	 * @since  0.7.1
	 */
	public function section_general_callback() {
		?>
		<div class="alert alert-info mb-4 p-2">
			<span class="dashicons dashicons-book"></span>
			<?php echo esc_html__( 'Documentation', 'anwp-post-grid' ); ?>:
			<a href="https://anwppro.userecho.com/en/knowledge-bases/51/articles/1053-plugin-settings" target="_blank"><?php echo esc_html__( 'Plugin Settings', 'anwp-post-grid' ); ?></a>
		</div>
		<?php
	}

	/**
	 * Category color field
	 *
	 * @since  0.7.1
	 */
	public function category_color_field() {
		$current_value = self::get_value( 'show_category_color', 'yes' );
		?>
		<select class="regular" name="anwp_pg_plugin_settings[show_category_color]" id="anwp_pg_plugin_settings[show_category_color]">
			<option value="yes" <?php selected( $current_value, 'yes' ); ?>><?php esc_html_e( 'Yes' ); ?></option>
			<option value="no" <?php selected( $current_value, 'no' ); ?>><?php esc_html_e( 'No' ); ?></option>
		</select>
		<?php
	}

	/**
	 * Wrapper function around get_option.
	 *
	 * @param string $key     Options array key
	 * @param mixed  $default Optional default value
	 *
	 * @return mixed           Option value
	 * @since  0.7.1
	 *
	 */
	public static function get_value( $key = '', $default = false ) {

		$options = get_option( 'anwp_pg_plugin_settings', $default );

		if ( ! empty( $options ) && is_array( $options ) && array_key_exists( $key, $options ) && false !== $options[ $key ] ) {
			return $options[ $key ];
		}

		return $default;
	}

	/**
	 * Sanitize plugin options.
	 *
	 * @param $options
	 *
	 * @return array
	 */
	public function sanitize_options( $options ) {

		$options['show_category_color'] = in_array( $options['show_category_color'], [ 'yes', 'no' ], true ) ? $options['show_category_color'] : 'yes';

		return $options;
	}
}
