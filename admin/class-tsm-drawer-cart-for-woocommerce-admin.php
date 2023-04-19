<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/christos-tsm
 * @since      1.0.0
 *
 * @package    Tsm_Drawer_Cart_For_Woocommerce
 * @subpackage Tsm_Drawer_Cart_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tsm_Drawer_Cart_For_Woocommerce
 * @subpackage Tsm_Drawer_Cart_For_Woocommerce/admin
 * @author     Christos Tsamis <christosgsd@gmail.com>
 */
class Tsm_Drawer_Cart_For_Woocommerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tsm_Drawer_Cart_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tsm_Drawer_Cart_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/tsm-drawer-cart-for-woocommerce-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tsm_Drawer_Cart_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tsm_Drawer_Cart_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/tsm-drawer-cart-for-woocommerce-admin.js', array('jquery'), $this->version, false);
	}

	/**
	 * Check if WooCommerce is active
	 * 
	 * @since 1.0.0
	 */
	function check_woocommerce_active() {
		if (!class_exists('WooCommerce')) {
			add_action('admin_notices', function () {
				echo '<div class="notice notice-error">';
				echo '<p>';
				_e('<strong>TSM Drawer Cart for WooCommerce</strong> requires WooCommerce to be activated in order to run properly. Please activate WooCommerce before using the Plugin.', 'tsm-drawer-cart-for-woocommerce');
				echo '</p>';
				echo '</div>';
			});
		}
	}

	/**
	 * Create settings page for the plugin
	 */
	public function add_settings_page() {
		add_menu_page(
			__('TSM Drawer Cart for WooCommerce', 'tsm-drawer-cart-for-woocommerce'), // Page title
			__('TSM Drawer Cart', 'tsm-drawer-cart-for-woocommerce'), // Menu title
			'manage_options', // Capability
			'tsm-drawer-cart-for-woocommerce', // Menu slug
			array($this, 'display_settings_page'), // Callback function
			'dashicons-cart', // Icon URL (dashicons are built-in icons in WordPress, but you can also use your own icon here)
			81 // Position (81 will place it below the "Settings" menu item)
		);
	}

	/**
	 * Register the settings for the settings page
	 */
	public function init_settings() {
		// Register a new setting
		register_setting(
			'tsm-drawer-cart-for-woocommerce', // Option group
			'tsm_drawer_cart_options' // Option name
		);

		// Add a new section
		add_settings_section(
			'tsm_drawer_cart_general', // Section ID
			__('General Settings', 'tsm-drawer-cart-for-woocommerce'), // Section title
			null, // Optional callback function
			'tsm-drawer-cart-for-woocommerce' // Page
		);

		// Add a new field to the section
		add_settings_field(
			'tsm_drawer_cart_icon_color', // Field ID
			__('Icon Color', 'tsm-drawer-cart-for-woocommerce'), // Field title
			array($this, 'icon_color_field'), // Callback function
			'tsm-drawer-cart-for-woocommerce', // Page
			'tsm_drawer_cart_general' // Section ID
		);
		// Add a new field to the section
		add_settings_field(
			'tsm_drawer_cart_background_color', // Field ID
			__('Icon Background Color', 'tsm-drawer-cart-for-woocommerce'), // Field title
			array($this, 'icon_background_color_field'), // Callback function
			'tsm-drawer-cart-for-woocommerce', // Page
			'tsm_drawer_cart_general' // Section ID
		);
	}

	public function icon_color_field() {
		$options = get_option('tsm_drawer_cart_options');
		$icon_color = isset($options['icon_color']) ? $options['icon_color'] : '#fff';
		echo '<input type="color" name="tsm_drawer_cart_options[icon_color]" value="' . esc_attr($icon_color) . ' ">';
	}

	public function icon_background_color_field() {
		$options = get_option('tsm_drawer_cart_options');
		$background_color = isset($options['background_color']) ? $options['background_color'] : '#f76e6e';
		echo '<input type="color" name="tsm_drawer_cart_options[background_color]" value="' . esc_attr($background_color) . ' ">';
	}

	/**
	 * File to render the settings page
	 */
	public function display_settings_page() {
		include_once 'partials/tsm-drawer-cart-for-woocommerce-admin-display.php';
	}
}
